<?php
namespace App\Http\Controllers;
use App\Helpers\PdfTemplateHelper;
use Illuminate\Http\Request;
use App\Models\Attestation;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class AttestationController extends Controller
{
  
    public function update(Request $request, $id)
    {
        $attestation = Attestation::findOrFail($id);
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
            'verificationDate' => 'required|date',
            'verificationTime' => 'required',
            'original_document.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            'approver_name' => 'nullable|string|max:255',
        ]);

        // Combine date and time into a single datetime string with seconds
        $verification_datetime = $validated['verificationDate'] . ' ' . $validated['verificationTime'];

        $originalPaths = [];
        // Keep existing files
        if ($attestation->original_document_path) {
            $existing = @json_decode($attestation->original_document_path, true);
            if (!$existing) $existing = [$attestation->original_document_path];
            $originalPaths = $existing;
        }
            // removed duplicate namespace
        if ($request->hasFile('original_document')) {
            foreach ($request->file('original_document') as $file) {
                if ($file) {
                    $originalPaths[] = $file->store('documents/original', 'public');
                }
            }
        }
        $original_document_path = count($originalPaths) > 1 ? json_encode($originalPaths) : ($originalPaths[0] ?? null);

        $attestation->update([
            'transaction_number' => $validated['transaction_number'],
            'payment_id' => $validated['payment_id'],
            'total_payment' => $validated['total_payment'],
            'transaction_date' => $validated['transaction_date'],
            'document_type' => $validated['document_type'],
            'applicant_name' => $validated['applicant_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'verifier_name' => $validated['verifier_name'],
            'verification_status' => $validated['verification_status'],
            'verification_datetime' => $verification_datetime,
            'approver_name' => $validated['approver_name'] ?? null,
            'original_document_path' => $original_document_path,
        ]);

        return redirect()->route('attestations.show', $attestation->id)
            ->with('success', 'Attestation updated successfully!');
    }

    // ...existing code...
    // Edit an attestation
    public function edit($id)
    {
        $attestation = Attestation::findOrFail($id);
        return view('attestations.edit', compact('attestation'));
    }
    // List all attestations
    public function index()
    {
        $attestations = Attestation::orderByDesc('id')->get();
        return view('attestations.index', compact('attestations'));
    }
    // Show the attestation creation form
    public function create()
    {
        return view('attestations.create');
    }

    // Store a new attestation
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
            'verificationDate' => 'required|date',
            'verificationTime' => 'required',
            'original_document.*' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            'approver_name' => 'nullable|string|max:255',
        ]);

        // Combine date and time into a single datetime string with seconds
        $verification_datetime = $validated['verificationDate'] . ' ' . $validated['verificationTime'];

        $originalPaths = [];
        if ($request->hasFile('original_document')) {
            foreach ($request->file('original_document') as $file) {
                $originalPaths[] = $file->store('documents/original', 'public');
            }
        }

        // Store as JSON if multiple files, or string if single
        $original_document_path = count($originalPaths) > 1 ? json_encode($originalPaths) : ($originalPaths[0] ?? null);

        $attestation = Attestation::create([
            'transaction_number' => $validated['transaction_number'],
            'payment_id' => $validated['payment_id'],
            'total_payment' => $validated['total_payment'],
            'transaction_date' => $validated['transaction_date'],
            'document_type' => $validated['document_type'],
            'applicant_name' => $validated['applicant_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'verifier_name' => $validated['verifier_name'],
            'verification_status' => $validated['verification_status'],
            'verification_datetime' => $verification_datetime,
            'approver_name' => $validated['approver_name'] ?? null,
            'original_document_path' => $original_document_path,
        ]);

        return redirect()->route('attestations.show', $attestation->id)
            ->with('success', 'Attestation submitted successfully!');
    }

    // Show attestation result (for authenticated user)
    public function show($id)
    {
        $attestation = Attestation::findOrFail($id);
        return view('attestations.show', compact('attestation'));
    }

    // Public verify page by hash (for QR code scan)
    public function verify($hash)
    {
        $attestation = Attestation::where('hash', $hash)->firstOrFail();
        return view('attestations.show', compact('attestation'));
    }

    // Return JSON with rendered HTML of original documents (no PDFs)
    public function apiOriginalHtml($id)
    {
        $attestation = Attestation::findOrFail($id);
        $attachments = json_decode($attestation->original_document_path, true);
        if (!is_array($attachments) || empty($attachments)) {
            $attachments = $attestation->original_document_path ? [$attestation->original_document_path] : [];
        }
        $html = view('attestations.partials.document-original', [
            'attachments' => $attachments,
            'attestation' => $attestation,
        ])->render();
        return response()->json(['html' => $html]);
    }

    // Return JSON with rendered HTML of attested content (info box + originals)
    public function apiAttestedHtml($id)
    {
        $attestation = Attestation::findOrFail($id);
        $attachments = json_decode($attestation->original_document_path, true);
        if (!is_array($attachments) || empty($attachments)) {
            $attachments = $attestation->original_document_path ? [$attestation->original_document_path] : [];
        }
        $html = view('attestations.partials.document-attested', [
            'attachments' => $attachments,
            'attestation' => $attestation,
        ])->render();
        return response()->json(['html' => $html]);
    }

    // Generate attested PDF (original embedded in blank PDF with user info at bottom)
    public function generateFinalPdf($id)
    {
        $attestation = Attestation::findOrFail($id);
        $originals = json_decode($attestation->original_document_path, true);
        if (!$originals) {
            $originals = [$attestation->original_document_path];
        }
        // Generate QR code image
        $qrUrl = route('attestations.verify', $attestation->hash);
        $qrImage = QrCode::format('png')->size(120)->generate($qrUrl);
        $qrPath = storage_path('app/public/qrcodes/' . $attestation->id . '.png');
        Storage::disk('public')->put('qrcodes/' . $attestation->id . '.png', $qrImage);

    $template = storage_path('app/public/template/Embade-original-Document.pdf');
        $infoBox = [
            'verify_no' => $attestation->id,
            'verifier' => $attestation->verifier_name,
            'name' => $attestation->applicant_name,
            'document' => $attestation->document_type,
            'date' => $attestation->verification_datetime,
            'approver' => $attestation->verifier_name,
            'email' => $attestation->email,
            'phone' => $attestation->phone,
        ];
        $output = \App\Helpers\PdfTemplateHelper::generateWithTemplate(
            array_map(function($f) { return storage_path('app/public/' . $f); }, $originals),
            $template,
            $qrPath,
            $infoBox
        );
        return response()->file($output, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="attested_document.pdf"'
        ]);
    }
}
