<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Attested Document</title>
    <style>
        body { margin: 0; padding: 0; }
        .footer {
            position: absolute;
            bottom: 40px;
            right: 40px;
            left: 40px;
            text-align: right;
            font-size: 14px;
        }
        .footer img { margin-top: 10px; }
    </style>
</head>
<body style="position: relative; min-height: 100vh;">
    {{-- Embed all original documents one by one --}}
    @php
        $attachments = is_array($originalPath) ? $originalPath : (is_string($originalPath) ? json_decode($originalPath, true) : []);
        if (!is_array($attachments) || empty($attachments)) {
            $attachments = $originalPath ? [$originalPath] : [];
        }
    @endphp
    @foreach($attachments as $idx => $file)
        <div style="height: 70vh; width: 100%; margin-bottom: 30px;">
            <div style="font-weight: bold; margin-bottom: 8px;">Document {{ $idx + 1 }}</div>
            @if(Str::endsWith($file, ['.pdf']))
                <embed src="{{ asset('storage/' . $file) }}" type="application/pdf" width="100%" height="100%">
            @else
                <img src="{{ asset('storage/' . $file) }}" style="max-width:100%; max-height:100%;">
            @endif
        </div>
    @endforeach
    <div class="footer" style="display:flex;justify-content:flex-end;align-items:flex-end;gap:24px;">
    @include('attestations/partials/info-box', [
            'info' => [
                'verify_no' => $attestation->transaction_number,
                'verifier' => $attestation->verifier_name,
                'verify_at' => $attestation->verification_status,
                'name' => $attestation->applicant_name,
                'document' => $attestation->document_type,
                'date' => \Carbon\Carbon::parse($attestation->verification_datetime)->format('Y-m-d H:i:s'),
                'approver' => $attestation->approver_name ?? '-',
            ]
        ])
        <img src="data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(70)->margin(0)->generate(route('attestations.verify', $attestation->hash))) }}" width="70" style="margin-left:12px;">
    </div>
</body>
</html>
