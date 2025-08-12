<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttestationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
            return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/attestations', [AttestationController::class, 'index'])->name('attestations.index');
    Route::get('/attestations/{id}/edit', [AttestationController::class, 'edit'])->name('attestations.edit');
    Route::put('/attestations/{id}', [AttestationController::class, 'update'])->name('attestations.update');
    Route::get('/attestations/create', [AttestationController::class, 'create'])->name('attestations.create');
    Route::post('/attestations', [AttestationController::class, 'store'])->name('attestations.store');
    Route::get('/attestations/{id}', [AttestationController::class, 'show'])->name('attestations.show');
    // API-like HTML responses (no PDFs) for modal consumption
    Route::get('/attestations/{id}/content/original', [AttestationController::class, 'apiOriginalHtml'])->name('attestations.content.original');
    Route::get('/attestations/{id}/content/attested', [AttestationController::class, 'apiAttestedHtml'])->name('attestations.content.attested');
    // Attested preview/print (A4) view with download button
    Route::get('/attestations/{id}/attested/preview', [AttestationController::class, 'printAttested'])->name('attestations.print-attested');
    Route::delete('/attestations/{id}', [AttestationController::class, 'destroy'])->name('attestations.destroy');
});


// Public verify route for QR code scan, using a hash for security
Route::get('/verify/{hash}', [AttestationController::class, 'verify'])->name('attestations.verify');
// Public endpoints to fetch rendered HTML content for modal consumption (by hash)
Route::get('/verify/{hash}/content/original', [AttestationController::class, 'apiOriginalHtmlByHash'])->name('attestations.verify.content.original');
Route::get('/verify/{hash}/content/attested', [AttestationController::class, 'apiAttestedHtmlByHash'])->name('attestations.verify.content.attested');

// QR bridge route to support URLs like /User/#/page/preview/{token}
Route::get('/User/', function () {
    return view('attestations.qr-bridge');
})->name('attestations.qrbridge');

// Ensure auth routes are loaded
require __DIR__.'/auth.php';
