<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receipt;
use Illuminate\Support\Facades\Response;

class VCardController extends Controller
{
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
        
        $vcard = "BEGIN:VCARD\n";
        $vcard .= "VERSION:3.0\n";
        $vcard .= "FN:{$receipt->name}\n";
        $vcard .= "TITLE:{$receipt->designation}\n";
        $vcard .= "ORG:" . ($receipt->organization->name ?? '') . "\n";
        $vcard .= "TEL;TYPE=CELL:{$receipt->phone}\n";
        
        if (!empty($receipt->phone2)) {
            $vcard .= "TEL;TYPE=CELL:{$receipt->phone2}\n";
        }
        
        $officeNumber = $receipt->organizationAddress->office_number ?? ($receipt->organization->office_number ?? '');
        $vcard .= "TEL;TYPE=WORK:{$officeNumber}\n";
        $vcard .= "EMAIL:{$receipt->email}\n";
        $vcard .= "URL:" . ($receipt->organization->website ?? '') . "\n";
        $officeAddress = $receipt->organizationAddress->office_address ?? ($receipt->organization->office_address ?? '');
        $vcard .= "ADR:;;{$officeAddress}\n";

        // Add Profile Picture if exists
        if ($receipt->profile_picture && file_exists(public_path('uploads/receipts/' . $receipt->profile_picture))) {
            $path = public_path('uploads/receipts/' . $receipt->profile_picture);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = base64_encode($data);
            $vcard .= "PHOTO;TYPE=" . strtoupper($type) . ";ENCODING=b:" . $base64 . "\n";
        }

        // Separate social links
        if ($receipt->organization && !empty($receipt->organization->facebook)) {
            $vcard .= "X-SOCIALPROFILE;type=facebook:{$receipt->organization->facebook}\n";
        }
        if ($receipt->organization && !empty($receipt->organization->instagram)) {
            $vcard .= "X-SOCIALPROFILE;type=instagram:{$receipt->organization->instagram}\n";
        }

        $vcard .= "END:VCARD\n";

        $fileName = 'vcard_' . strtolower(str_replace(' ', '_', $receipt->name)) . '.vcf';

        return Response::make($vcard, 200, [
            'Content-Type' => 'text/vcard',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ]);
    }
}
