<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use Illuminate\Support\Facades\Response;

class VCardController extends Controller
{
    /** Longest edge, in pixels, of the photo embedded in the card. */
    private const PHOTO_MAX_EDGE = 256;

    /** JPEG quality used when re-encoding the embedded photo. */
    private const PHOTO_QUALITY = 82;

    public function download($id)
    {
        if (is_numeric($id)) {
            return redirect()->route('vcard.download', Receipt::encodeId($id));
        }

        $decodedId = Receipt::decodeId($id);
        if (!$decodedId) {
            abort(404);
        }

        $receipt = Receipt::with(['organization', 'organizationAddress'])->findOrFail($decodedId);
        $fullName = trim(preg_replace('/\s+/', ' ', (string) $receipt->name));
        [$firstName, $lastName] = $this->splitName($fullName);

        $lines = [];
        $lines[] = 'BEGIN:VCARD';
        $lines[] = 'VERSION:3.0';
        // N (structured name) is what iOS uses to fill the first/last name fields.
        // Without it the contact card opens with an empty name.
        $lines[] = 'N:' . $this->esc($lastName) . ';' . $this->esc($firstName) . ';;;';
        $lines[] = 'FN:' . $this->esc($fullName);

        if (!empty($receipt->designation)) {
            $lines[] = 'TITLE:' . $this->esc($receipt->designation);
        }
        if (!empty($receipt->organization?->name)) {
            $lines[] = 'ORG:' . $this->esc($receipt->organization->name);
        }
        if (!empty($receipt->phone)) {
            $lines[] = 'TEL;TYPE=CELL,VOICE:' . $this->esc($receipt->phone);
        }
        if (!empty($receipt->phone2)) {
            $lines[] = 'TEL;TYPE=CELL,VOICE:' . $this->esc($receipt->phone2);
        }

        $officeNumber = $receipt->organizationAddress?->office_number ?? $receipt->organization?->office_number;
        if (!empty($officeNumber)) {
            $lines[] = 'TEL;TYPE=WORK,VOICE:' . $this->esc($officeNumber);
        }
        if (!empty($receipt->email)) {
            $lines[] = 'EMAIL;TYPE=INTERNET,WORK:' . $this->esc($receipt->email);
        }
        if (!empty($receipt->organization?->website)) {
            $lines[] = 'URL:' . $this->esc($receipt->organization->website);
        }

        $officeAddress = $receipt->organizationAddress?->office_address ?? $receipt->organization?->office_address;
        if (!empty($officeAddress)) {
            // ADR has 7 components: po-box;ext;street;locality;region;postal;country
            $lines[] = 'ADR;TYPE=WORK:;;' . $this->esc($officeAddress) . ';;;;';
        }

        // Add Profile Picture if exists
        if ($receipt->profile_picture && file_exists(public_path('uploads/receipts/' . $receipt->profile_picture))) {
            $jpeg = $this->photoPayload(public_path('uploads/receipts/' . $receipt->profile_picture));
            if ($jpeg !== null) {
                $lines[] = 'PHOTO;ENCODING=b;TYPE=JPEG:' . base64_encode($jpeg);
            }
        }

        // Separate social links
        if (!empty($receipt->organization?->facebook)) {
            $lines[] = 'X-SOCIALPROFILE;TYPE=facebook:' . $this->esc($receipt->organization->facebook);
        }
        if (!empty($receipt->organization?->instagram)) {
            $lines[] = 'X-SOCIALPROFILE;TYPE=instagram:' . $this->esc($receipt->organization->instagram);
        }

        $lines[] = 'END:VCARD';

        // vCard requires CRLF line endings, and long lines (the photo) must be folded.
        $vcard = '';
        foreach ($lines as $line) {
            // Gmail's importer can append folded photo data to the preceding address field.
            $vcard .= (strpos($line, 'PHOTO;') === 0 ? $line : $this->fold($line)) . "\r\n";
        }

        $slug = strtolower(preg_replace('/[^A-Za-z0-9]+/', '_', $fullName)) ?: 'contact';
        $fileName = 'vcard_' . trim($slug, '_') . '.vcf';

        return Response::make($vcard, 200, [
            'Content-Type' => 'text/vcard; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    /**
     * Split a display name into [given, family]. The last word is taken as the
     * family name, which matches the bulk of the names in this system
     * ("Muhammad Nasir Javed" -> Javed). Lowercase nobiliary particles are
     * pulled along with it ("Jaco Van Der Walt" -> Van Der Walt).
     */
    private function splitName($fullName)
    {
        if ($fullName === '') {
            return ['', ''];
        }

        $parts = explode(' ', $fullName);
        if (count($parts) === 1) {
            return [$parts[0], ''];
        }

        $particles = ['van', 'von', 'der', 'den', 'de', 'del', 'della', 'di', 'da', 'du', 'la', 'le', 'bin', 'ibn', 'al', 'el', 'abu', 'st', 'mac', 'mc'];

        $family = [array_pop($parts)];
        while ($parts && in_array(strtolower(rtrim(end($parts), '.')), $particles, true)) {
            array_unshift($family, array_pop($parts));
        }

        // Never leave the given name empty (e.g. a name that is all particles).
        if (!$parts) {
            return [array_shift($family), implode(' ', $family)];
        }

        return [implode(' ', $parts), implode(' ', $family)];
    }

    /**
     * Escape the characters that are structural in a vCard value.
     */
    private function esc($value)
    {
        return str_replace(
            ["\\", "\r\n", "\n", "\r", ';', ','],
            ['\\\\', '\n', '\n', '\n', '\;', '\,'],
            trim((string) $value)
        );
    }

    /**
     * Normalise a profile picture into a small, clean baseline JPEG for embedding.
     *
     * The type is taken from the file's contents, not its extension, because
     * uploads arrive as .jfif, .jpe, .JPG and sometimes with an extension that
     * does not match the bytes. Re-encoding also strips ICC/EXIF metadata --
     * a colour profile alone can add tens of KB of base64 to the card -- and
     * caps the size so the vCard stays small enough for phones to import.
     *
     * Returns null for formats vCard cannot carry (e.g. SVG, WebP) or if the
     * file cannot be decoded, in which case the photo is simply omitted.
     */
    private function photoPayload($path)
    {
        $info = @getimagesize($path);
        if ($info === false) {
            return null;
        }

        switch ($info[2]) {
            case IMAGETYPE_JPEG:
                $src = @imagecreatefromjpeg($path);
                break;
            case IMAGETYPE_PNG:
                $src = @imagecreatefrompng($path);
                break;
            case IMAGETYPE_GIF:
                $src = @imagecreatefromgif($path);
                break;
            default:
                return null;
        }

        if (!$src) {
            return null;
        }

        $width = imagesx($src);
        $height = imagesy($src);
        $scale = min(1, self::PHOTO_MAX_EDGE / max($width, $height));
        $newWidth = max(1, (int) round($width * $scale));
        $newHeight = max(1, (int) round($height * $scale));

        $dst = imagecreatetruecolor($newWidth, $newHeight);
        // Contact photos have no alpha channel, so flatten onto white.
        imagefill($dst, 0, 0, imagecolorallocate($dst, 255, 255, 255));
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagedestroy($src);

        ob_start();
        imagejpeg($dst, null, self::PHOTO_QUALITY);
        $jpeg = ob_get_clean();
        imagedestroy($dst);

        return $jpeg !== '' ? $jpeg : null;
    }

    /**
     * Fold lines at 75 octets; continuation lines begin with a single space.
     */
    private function fold($line)
    {
        if (strlen($line) <= 75) {
            return $line;
        }

        $out = substr($line, 0, 75);
        $rest = substr($line, 75);
        foreach (str_split($rest, 74) as $chunk) {
            $out .= "\r\n " . $chunk;
        }

        return $out;
    }
}
