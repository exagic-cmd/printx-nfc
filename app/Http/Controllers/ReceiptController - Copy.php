<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Receipt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;



use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ReceiptController extends Controller
{   
    public function index() {
        $receiptCount = Receipt::count();
        $todayReceiptCount = Receipt::whereDate('created_at', Carbon::today())->count();
        $totalAmount = Receipt::sum('total_amount');
        $todayTotalAmount = Receipt::whereDate('created_at', Carbon::today())->sum('total_amount');
        $todayReceipts = Receipt::whereDate('created_at', Carbon::today())->get();

        return view('dashboard', compact('receiptCount', 'todayReceiptCount', 'totalAmount', 'todayTotalAmount', 'todayReceipts'));
    }
    public function showForm()
    {
        return view('receipt.form');
    }

    public function saveReceipt(Request $request)
    {
        $request->validate([
            'gate' => 'required|string',
            'trn' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'receipt_number' => 'required|string',
            'owner_name' => 'required|string',
            'vehicle_number' => 'required|string',
            'total_amount' => 'required|string',
            'research_support' => 'required|string',
            'collection_fee' => 'required|string',
            'vat' => 'required|string',
            'user_name' => 'required|string',
            'entity' => 'required|string',
            'refno' => 'required|string',
            'appno' => 'required|string',
        ]);

        // Save the receipt
        $receipt = Receipt::create($request->all());
        $receiptUrl = url('/scan/' . $receipt->id); // Generate QR Code URL

$data['qrimage'] = 'data:image/png;base64,' . base64_encode(
    \QrCode::format('png')
        ->merge('qr-logo.png', 0.5, true)
        ->size(100)
        ->errorCorrection('H')
        ->generate($receiptUrl)
);

return response()->json([
    'receipt' => view('receipt.partials.receipt', compact('receipt', 'data'))->render(),
]);
        // Generate the QR code with the receipt link
        // $receiptUrl = url('/scan/' . $receipt->id);// Same page with query param

        // $data['qrimage'] =  \QrCode::format('png')
        //     ->merge('fav-tahseel.png', 0.5, true)
        //     ->size(100)
        //     ->errorCorrection('H')
        //     ->generate($receiptUrl);


       // $qrCode = QrCode::size(100)->generate($receiptUrl);
        //  return response()->json([
        //     'receipt' => view('receipt.partials.receipt', compact('receipt', 'data'))->render(),
        // ]);
    }
    public function showReceipt($id)
    {
        $receipt = Receipt::findOrFail($id);
        $qrCode = QrCode::size(100)->generate(url('/scan/' . $receipt->id)); // Generate QR Code

        return view('receipt.show', compact('receipt', 'qrCode'));
    }

    public function receiptDetail($id)
    {
        $receipt = Receipt::findOrFail($id);
        return view('receipt.receipt-detail', compact('receipt'));
    }

    public function receiptPDF($id)
    {
        $receipt = Receipt::findOrFail($id);
        $qrCode = QrCode::size(100)->generate(url('/file/' . $receipt->id)); // Generate QR Code

        return view('receipt.pdf-receipt', compact('receipt', 'qrCode'));
    }

    public function allReceipts()
    {
        $receipts = Receipt::all(); // Fetch all receipts from the database
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
        'gate' => 'required|string',
        'trn' => 'required|string',
        'date' => 'required|date',
        'time' => 'required',
        'receipt_number' => 'required|string',
        'owner_name' => 'required|string',
        'vehicle_number' => 'required|string',
        'total_amount' => 'required|string',
        'research_support' => 'required|string',
        'collection_fee' => 'required|string',
        'vat' => 'required|string',
        'user_name' => 'required|string',        
        'entity' => 'required|string',
        'refno' => 'required|string',
        'appno' => 'required|string',
    ]);
       // dd($request->all()); 
        $receipt = Receipt::findOrFail($id);
        $receipt->update($request->all());

        return redirect()->route('all-receipts')->with('success', 'Receipt updated successfully!');
    }
    public function generatePDF($id)
    {
        $receipt = Receipt::findOrFail($id); // Fetch receipt details
        $qrCode = '<img src="data:image/png;base64,' . base64_encode(QrCode::format('png')->size(100)->generate($receipt->receipt_number)) . '">'; 

        $pdf = Pdf::loadView('receipt_pdf', compact('receipt', 'qrCode'));
        return $pdf->stream('receipt.pdf'); // Shows PDF preview
    }


}