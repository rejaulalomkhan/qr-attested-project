<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attested Document Preview</title>
    <link rel="stylesheet" href="{{ asset('assets/result-view.css') }}">
    <style>
        .toolbar { position: sticky; top: 0; z-index: 100; display: flex; justify-content: space-between; align-items: center; gap: 12px; padding: 12px 16px; background: #ffffff; border-bottom: 1px solid #e5e7eb; }
        .toolbar .title { font-weight: 700; color: #1f2937; }
        .toolbar .btn { display: inline-flex; align-items: center; gap: 8px; padding: 8px 14px; border-radius: 6px; border: 1px solid #d1d5db; background: #fff; color: #111827; cursor: pointer; text-decoration: none; font-weight: 600; }
        .toolbar .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; border: none; }
        .toolbar .btn:hover { filter: brightness(0.96); }

        .preview-container { padding: 16px; }
        .attested-canvas { margin: 0 auto; }

        /* Print styles */
        @media print {
            .no-print { display: none !important; }
            @page { size: A4 portrait; margin: 10mm; }
            html, body { width: 210mm; }
            .attested-canvas { width: 190mm !important; }
            .attested-desktop-scale { width: 190mm !important; transform: none !important; zoom: 1 !important; }
            .attested-preview-page { page-break-after: always; }
            .attested-preview-page:last-child { page-break-after: auto; }
            .attested-preview-top img, .attested-preview-top embed { width: 100% !important; height: auto !important; max-height: 230mm; }
        }
    </style>
</head>
<body>
    <div class="toolbar no-print">
        <div class="title">Attested preview — {{ $attestation->transaction_number }}</div>
        <div>
            <button type="button" class="btn btn-primary" onclick="window.print()" title="Download as PDF">Download PDF</button>
            <a class="btn" href="{{ url()->previous() }}" title="Back">Back</a>
        </div>
    </div>

    <div class="preview-container">
        <div class="attested-canvas attested-desktop-scale">
            @php
                $attachments = json_decode($attestation->original_document_path, true);
                if (!is_array($attachments) || empty($attachments)) {
                    $attachments = $attestation->original_document_path ? [$attestation->original_document_path] : [];
                }
            @endphp
            @include('attestations.partials.document-attested', [
                'attachments' => $attachments,
                'attestation' => $attestation,
            ])
        </div>
    </div>
</body>
</html>


