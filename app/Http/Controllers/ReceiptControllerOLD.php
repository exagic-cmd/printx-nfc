<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Receipt;
use App\Models\Organization;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Response;

use Illuminate\Support\Facades\Artisan;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use SimpleSoftwareIO\QrCode\Generator;


class ReceiptController extends Controller
{   
    public function index() {
        if (Auth::guard('organization')->check()) {
            $orgId = Auth::guard('organization')->id();
            $receiptCount = Receipt::where('organization_id', $orgId)->count();
            $todayReceiptCount = Receipt::where('organization_id', $orgId)->whereDate('created_at', Carbon::today())->count();
            $todayReceipts = Receipt::with('organization')->where('organization_id', $orgId)->whereDate('created_at', Carbon::today())->get();
        } else {
            $receiptCount = Receipt::count();
            $todayReceiptCount = Receipt::whereDate('created_at', Carbon::today())->count();
            $todayReceipts = Receipt::with('organization')->whereDate('created_at', Carbon::today())->get();
        }

        return view('dashboard', compact('receiptCount', 'todayReceiptCount', 'todayReceipts'));
    }

    public function showForm()
    {
        if (Auth::guard('organization')->check()) {
            $organizations = Organization::where('id', Auth::guard('organization')->id())->get();
        } else {
            $organizations = Organization::all();
        }
        return view('receipt.form', compact('organizations'));
    }

    public function saveReceipt(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'phone2' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'organization_address_id' => 'required|exists:organization_address,id',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if (!Auth::guard('organization')->check()) {
            $rules['organization_id'] = 'required|exists:organizations,id';
        }

        $validated = $request->validate($rules);

        $data = $request->except('profile_picture');

        if (Auth::guard('organization')->check()) {
            $data['organization_id'] = Auth::guard('organization')->id();
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $profilePicture = $request->file('profile_picture');
            $fileName = time() . '_' . uniqid() . '.' . $profilePicture->getClientOriginalExtension();
            $profilePicture->move(public_path('uploads/receipts'), $fileName);
            $data['profile_picture'] = $fileName;
        }

        Receipt::create($data);

        return response()->json(['message' => 'Receipt submitted successfully!']);
    }

    public function showReceipt($id)
    {
        $receipt = Receipt::with(['organization', 'organizationAddress'])->findOrFail($id);
        
        if (Auth::guard('organization')->check() && $receipt->organization_id != Auth::guard('organization')->id()) {
            abort(403);
        }

        return view('receipt.show', compact('receipt'));
    }

    public function receiptDetail($id)
    {
        $receipt = Receipt::findOrFail($id);
        
        if (Auth::guard('organization')->check() && $receipt->organization_id != Auth::guard('organization')->id()) {
            abort(403);
        }

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
        if (Auth::guard('organization')->check()) {
            $receipts = Receipt::with(['organization', 'organizationAddress'])
                ->where('organization_id', Auth::guard('organization')->id())
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $receipts = Receipt::with(['organization', 'organizationAddress'])->orderBy('id', 'desc')->get();
        }
        return view('receipt.all-receipts', compact('receipts'));
    }

    public function deleteReceipt($id)
    {    
        $receipt = Receipt::findOrFail($id);
        
        if (Auth::guard('organization')->check() && $receipt->organization_id != Auth::guard('organization')->id()) {
            abort(403);
        }

        $receipt->delete();
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
            'success' => 'Receipt deleted successfully!',
            'redirect' => url('receipt/all-receipts')
            ]);
        }

        return redirect()->to('receipt/all-receipts')->with('success', 'Receipt deleted successfully!');
    }

    public function editReceipt($id)
    {
        $record = Receipt::findOrFail($id);
        
        if (Auth::guard('organization')->check()) {
            if ($record->organization_id != Auth::guard('organization')->id()) {
                abort(403);
            }
            $organizations = Organization::where('id', Auth::guard('organization')->id())->get();
        } else {
            $organizations = Organization::all();
        }
        
        return view('receipt.edit-receipt', compact('record', 'organizations'));
    }

    public function updateReceipt(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'phone2' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
            'organization_address_id' => 'required|exists:organization_address,id',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if (!Auth::guard('organization')->check()) {
            $rules['organization_id'] = 'required|exists:organizations,id';
        }

        $request->validate($rules);

        $record = Receipt::findOrFail($id);

        if (Auth::guard('organization')->check() && $record->organization_id != Auth::guard('organization')->id()) {
            abort(403);
        }

        $data = $request->except('profile_picture');

        if (Auth::guard('organization')->check()) {
            $data['organization_id'] = Auth::guard('organization')->id();
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($record->profile_picture && file_exists(public_path('uploads/receipts/' . $record->profile_picture))) {
                unlink(public_path('uploads/receipts/' . $record->profile_picture));
            }
            
            $profilePicture = $request->file('profile_picture');
            $fileName = time() . '_' . uniqid() . '.' . $profilePicture->getClientOriginalExtension();
            $profilePicture->move(public_path('uploads/receipts'), $fileName);
            $data['profile_picture'] = $fileName;
        }

        $record->update($data);

        return response()->json(['message' => 'Record updated successfully']);
    }

    
        

}