# Laravel Attestation System with QR Code Verification

## 1. Project Setup
1. Create a new Laravel project:
   ```bash
   composer create-project laravel/laravel attestation-system
   cd attestation-system
   ```
2. Configure `.env`:
   - Set DB connection (MySQL recommended).
   - Run:
     ```bash
     php artisan storage:link
     ```
3. Install dependencies:
   ```bash
   composer require simplesoftwareio/simple-qrcode
   composer require barryvdh/laravel-dompdf
   ```

---

## 2. Database Migration
1. Create migration:
   ```bash
   php artisan make:migration create_attestations_table
   ```
2. Add columns:
   ```php
   Schema::create('attestations', function (Blueprint $table) {
       $table->id();
       $table->string('transaction_number');
       $table->string('payment_id');
       $table->decimal('total_payment', 8, 2);
       $table->date('transaction_date');
       $table->string('document_type');
       $table->string('applicant_name');
       $table->string('email');
       $table->string('phone');
       $table->string('verifier_name');
       $table->string('verification_status');
       $table->dateTime('verification_datetime');
       $table->string('original_document_path');
       $table->string('attested_document_path');
       $table->timestamps();
   });
   ```
3. Migrate:
   ```bash
   php artisan migrate
   ```

---

## 3. Model & Controller
1. Create model:
   ```bash
   php artisan make:model Attestation -m
   ```
2. Create controller:
   ```bash
   php artisan make:controller AttestationController
   ```

---

## 4. Routes
In `routes/web.php`:
```php
Route::get('/attestations/create', [AttestationController::class, 'create'])->name('attestations.create');
Route::post('/attestations', [AttestationController::class, 'store'])->name('attestations.store');
Route::get('/attestations/{id}', [AttestationController::class, 'show'])->name('attestations.show');
Route::get('/verify/{id}', [AttestationController::class, 'verify'])->name('attestations.verify');
// PDF generation has been removed
```

---

## 5. Form for Data Entry
`resources/views/attestations/create.blade.php`:
- Inputs for transaction details, applicant info, verifier info.
- File inputs for original and attested PDFs.

---

## 6. Store Method in Controller
```php
public function store(Request $request)
{
    $validated = $request->validate([
        'transaction_number' => 'required',
        'payment_id' => 'required',
        'total_payment' => 'required|numeric',
        'transaction_date' => 'required|date',
        'document_type' => 'required',
        'applicant_name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'verifier_name' => 'required',
        'verification_status' => 'required',
        'verification_datetime' => 'required|date',
        'original_document' => 'required|file|mimes:pdf',
        'attested_document' => 'required|file|mimes:pdf'
    ]);

    $originalPath = $request->file('original_document')->store('documents/original', 'public');
    $attestedPath = $request->file('attested_document')->store('documents/attested', 'public');

    $attestation = Attestation::create(array_merge($validated, [
        'original_document_path' => $originalPath,
        'attested_document_path' => $attestedPath
    ]));

    return redirect()->route('attestations.show', $attestation->id);
}
```

---

## 7. QR Code Generation
```php
use SimpleSoftwareIO\QrCode\Facades\QrCode;

$qrUrl = route('attestations.verify', $attestation->id);
$qrcodeImage = QrCode::format('png')->size(200)->generate($qrUrl);
Storage::put("qrcodes/{$attestation->id}.png", $qrcodeImage);
```

---

## 8. Verification Page
```php
public function verify($id)
{
    $attestation = Attestation::findOrFail($id);
    return view('attestations.verify', compact('attestation'));
}
```
`resources/views/attestations/verify.blade.php`:
- Show all DB fields.
- Show link to download/view attested PDF.

---

## 9. PDF Generation
```php
// PDF generation removed

public function generateFinalPdf($id)
{
    $attestation = Attestation::findOrFail($id);
    // removed
}
```

---

## 10. PDF Blade Template
`resources/views/attestations/pdf.blade.php`:
```html
<!DOCTYPE html>
<html>
<body style="position: relative;">
    <embed src="{{ storage_path('app/public/'.$attestation->attested_document_path) }}" 
           type="application/pdf" width="100%" height="70%">
    <div style="position: absolute; bottom: 50px; right: 50px; text-align: right;">
        <p>{{ $attestation->applicant_name }}</p>
        <p>{{ $attestation->email }}</p>
        <p>{{ $attestation->phone }}</p>
        <img src="{{ public_path('storage/qrcodes/'.$attestation->id.'.png') }}" width="120">
    </div>
</body>
</html>
```

---

## 11. Workflow Summary
1. User fills in form with details + uploads PDFs.
2. Data saved to DB, files saved to `/storage/app/public/`.
3. QR code generated pointing to verification URL.
4. Final PDF generated with:
   - Top 2/3: Uploaded attested document.
   - Bottom right: Applicant info + QR code.
5. Scanning QR shows verification page with details.
