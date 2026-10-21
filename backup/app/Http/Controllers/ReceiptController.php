<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Receipt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Response;

use Illuminate\Support\Facades\Artisan;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use SimpleSoftwareIO\QrCode\Generator;


class ReceiptController extends Controller
{   
    public function index() {
        $receiptCount = Receipt::count();
        $todayReceiptCount = Receipt::whereDate('created_at', Carbon::today())->count();
       // $totalAmount = Receipt::sum('total_amount');
      //  $todayTotalAmount = Receipt::whereDate('created_at', Carbon::today())->sum('total_amount');
        $todayReceipts = Receipt::whereDate('created_at', Carbon::today())->get();

        return view('dashboard', compact('receiptCount', 'todayReceiptCount', 'todayReceipts'));
    }
    public function showForm()
    {
        return view('receipt.form');
    }

    public function saveReceipt(Request $request)
    { //dd($request);
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'office_phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'website' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        // Save the receipt
        $receipt = Receipt::create($request->all());
        return response()->json([
            'receipt' => view('receipt.partials.receipt', compact('receipt'))->render(),
        ]);
    }
    public function showReceipt($id)
    {
        $receipt = Receipt::findOrFail($id);
        $qrCode = QrCode::size(135)->generate(url('/scan/' . $receipt->id)); // Generate QR Code

        return view('receipt.show', compact('receipt', 'qrCode'));
    }

    public function receiptDetail($id)
    {
        $receipt = Receipt::findOrFail($id);
        $qrCode = url('/scan/' . $receipt->id); // Generate QR Code
        $data['qrimage'] = 'data:image/png;base64,' . base64_encode(
            \QrCode::format('png')
                ->merge('qr-logo.png', 0.3, true)
                ->size(135)
                ->errorCorrection('H')
                ->generate($qrCode)
        );
        
            return view('receipt.receipt-detail', compact('receipt', 'data','id'));
    }

    public function allReceipts()
    {
        $receipts = Receipt::orderBy('created_at', 'desc')->get();
        return view('receipt.all-receipts', compact('receipts'));
    }
    public function deleteReceipt($id)
    {
        $receipt = Receipt::findOrFail($id);
        $receipt->delete();

        return response()->json(['success' => 'Receipt deleted successfully']);
    }
    public function editReceipt($id)
    {
        $receipt = Receipt::findOrFail($id);
        return view('receipt.edit-receipt', compact('receipt'));
    }
    public function updateReceipt(Request $request, $id)
    { //dd($request->all());
        $request->validate([
        'name' => 'required|string|max:255',
        'designation' => 'nullable|string|max:255',
        'company' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:20',
        'office_phone' => 'nullable|string|max:20',
        'email' => 'nullable|email',
        'website' => 'nullable|string|max:255',
        'facebook' => 'nullable|string|max:255',
        'instagram' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:500',   
    ]);
       // dd($request->all()); 
        $receipt = Receipt::findOrFail($id);
        $receipt->update($request->all());

        return redirect()->route('all-receipts')->with('success', 'Receipt updated successfully!');
    }

    
        

}