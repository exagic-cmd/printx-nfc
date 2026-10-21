<?php

use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\ReceiptController;
use App\Models\Receipt;
use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\VCardController;


Route::middleware(['auth:web,organization'])->group(function () {
    Route::get('/', [ReceiptController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [ReceiptController::class, 'index']); // Match RouteServiceProvider::HOME

    Route::get('/receipt/form', [ReceiptController::class, 'showForm'])->name('receipt.form');
    Route::post('/receipt/save', [ReceiptController::class, 'saveReceipt'])->name('receipt.save');

    Route::get('receipt/all-receipts', [ReceiptController::class, 'allReceipts'])->name('all-receipts');

    Route::get('/record/{id}', [ReceiptController::class, 'showReceipt'])->name('receipt.show');

    Route::delete('/receipt/{id}/delete', [ReceiptController::class, 'deleteReceipt'])->name('receipt.delete');

    Route::get('/receipt/{id}/edit', [ReceiptController::class, 'editReceipt'])->name('receipt.edit');
    Route::put('/receipt/{id}', [ReceiptController::class, 'updateReceipt'])->name('receipt.update');

    Route::get('/organization/profile', [OrganizationController::class, 'profile'])->name('organization.profile');
    Route::put('/organization/profile', [OrganizationController::class, 'updateProfile'])->name('organization.profile.update');

   

    // Only Admin (web guard) can access organization management
    Route::middleware(['auth:web'])->group(function () {
        Route::resource('organizations', OrganizationController::class);
    });
    Route::get('/organization/{id}/addresses', [OrganizationController::class, 'getAddresses'])->name('organization.addresses');
});
 
require __DIR__.'/auth.php';
Route::get('/record/{id}', [ReceiptController::class, 'showReceipt'])->name('receipt.show');
 Route::get('/download-vcard/{id}', [VCardController::class, 'download'])->name('vcard.download');
