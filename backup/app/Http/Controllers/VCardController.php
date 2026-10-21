<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receipt;
use Illuminate\Support\Facades\Response;

class VCardController extends Controller
{
    // public function download($id)
    // {
    //     $receipt = Receipt::findOrFail($id);

    //     $vcard = "BEGIN:VCARD\n";
    //     $vcard .= "VERSION:3.0\n";
    //     $vcard .= "FN:{$receipt->name}\n";
    //     $vcard .= "TITLE:{$receipt->designation}\n";
    //     $vcard .= "ORG:{$receipt->company}\n";
    //     $vcard .= "TEL;TYPE=CELL:{$receipt->phone}\n";
    //     $vcard .= "TEL;TYPE=WORK:{$receipt->office_phone}\n";
    //     $vcard .= "EMAIL:{$receipt->email}\n";
    //     $vcard .= "URL:{$receipt->website}\n";
    //     $vcard .= "ADR:;;{$receipt->address}\n";

    //     // Separate social links
    //     if (!empty($receipt->facebook)) {
    //         $vcard .= "X-SOCIALPROFILE;type=facebook:{$receipt->facebook}\n";
    //     }
    //     if (!empty($receipt->instagram)) {
    //         $vcard .= "X-SOCIALPROFILE;type=instagram:{$receipt->instagram}\n";
    //     }

    //     $vcard .= "END:VCARD\n";

    //     $fileName = 'vcard_' . strtolower(str_replace(' ', '_', $receipt->name)) . '.vcf';

    //     return Response::make($vcard, 200, [
    //         'Content-Type' => 'text/vcard',
    //         'Content-Disposition' => "attachment; filename={$fileName}",
    //     ]);
    // }
    public function download($id)
{
    $isIOS = preg_match('/iPhone|iPad|iPod/i', request()->header('User-Agent'));

    $receipt = Receipt::findOrFail($id);
    $ua = request()->header('User-Agent');
    $isIOS = preg_match('/iPhone|iPad|iPod/i', $ua);

    $vcard = "BEGIN:VCARD\n";
    $vcard .= "VERSION:3.0\n";

    // ----- Name (CRITICAL for iOS)
    $nameParts = explode(' ', trim($receipt->name), 2);
    $lastName  = $nameParts[1] ?? '';
    $firstName = $nameParts[0] ?? '';

    $vcard .= "N:{$lastName};{$firstName};;;\n";
    $vcard .= "FN:{$receipt->name}\n";

    // ----- Company & Title (ORDER MATTERS)
    if ($receipt->company) {
        $vcard .= "ORG:{$receipt->company}\n";
    }

    if ($receipt->designation) {
        $vcard .= "TITLE:{$receipt->designation}\n";
    }

    // ----- Phones
    if ($receipt->phone) {
        $vcard .= "TEL;TYPE=CELL:{$receipt->phone}\n";
    }

    if ($receipt->office_phone) {
        $vcard .= "TEL;TYPE=WORK:{$receipt->office_phone}\n";
    }

    // ----- Email
    if ($receipt->email) {
        $vcard .= "EMAIL;TYPE=INTERNET:{$receipt->email}\n";
    }

    // ----- Website
    if ($receipt->website) {
        $vcard .= "URL:{$receipt->website}\n";
    }

    // ----- Address (Structured for iOS)
    if ($receipt->address) {
        $vcard .= "ADR;TYPE=WORK:;;{$receipt->address};;;;\n";
    }

    // ----- Social Profiles
    if ($receipt->facebook) {
        $vcard .= "X-SOCIALPROFILE;type=facebook:{$receipt->facebook}\n";
    }

    if ($receipt->instagram) {
        $vcard .= "X-SOCIALPROFILE;type=instagram:{$receipt->instagram}\n";
    }

    $vcard .= "END:VCARD\n";

    $fileName = 'vcard_' . strtolower(str_replace(' ', '_', $receipt->name)) . '.vcf';

    return response($vcard)
        ->header('Content-Type', 'text/x-vcard; charset=utf-8')
        ->header('Content-Disposition', "attachment; filename={$fileName}");
}

}
