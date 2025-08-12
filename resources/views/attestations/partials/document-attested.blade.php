@php
    $attachments = $attachments ?? [];
    $footerLabel = ' ';
    $footerInnerBgUrl = null;
    if (\Illuminate\Support\Facades\Storage::disk('public')->exists('footer-bg-image.png')) {
        $footerInnerBgUrl = asset('storage/footer-bg-image.png');
    }
    $hasMultiple = is_array($attachments) && count($attachments) > 1;
@endphp

<style>
    .attested-preview-page { background:#fff; margin: 0 0 0px 0; border: 1px solid #eee; }
    .attested-preview-top { width:100%; display:block; }
    .attested-preview-top img { display: block; width: 100%; height: auto; object-fit: contain; max-height: 135vh; }
    .attested-preview-top embed { display:block; width:100%; height:70vh; border:0; }
    .attested-preview-footer { position: relative; width:100%; height: 400px; 0px 40px 10px 0px; margin-bottom: 10px; box-sizing: border-box; }
    .attested-preview-footer-bg { position: absolute; left: 0; right: 0; top: 0; height: 400px; background-repeat: no-repeat; background-position: bottom center; background-size: 100% 405px; pointer-events: none; }
    .attested-preview-footer-inner { position: relative; height: 100%; display:flex; flex-direction: row; align-items:flex-end; justify-content: space-between; gap: 24px; }
    .attested-preview-footer-left { flex: 0 1 auto; display:flex; align-items:center; gap:12px; color:#6c757d; font-weight:600; }
    .attested-preview-qr { width: 117px; height: 117px; }         
    .attested-preview-footer-right { flex: 1 1 auto; display:flex; flex-direction: column; align-items:flex-end; gap: 17px; margin-right: 10px;}
    .attested-preview-qrrow { display:flex; align-items:center; justify-content:flex-end; gap: 16px; }
    .attested-preview-qrtext { direction: rtl; text-align: right; font-weight: 700; line-height: 1.6; font-family: serif; font-size: 19.2184px; margin-top: 14px;}
    .attested-preview-qrtext small { font-weight: 600; }
    @media (max-width: 768px) {
        /* Force desktop layout on mobile */
        .attested-preview-footer-inner { flex-direction: row !important; align-items: flex-end !important; }
        .attested-preview-footer-right { justify-content: flex-end !important; }
    }
    /* Make info table responsive */
    .attested-preview-footer-right table { max-width: 100%; width: 420px; }

    /* Scale whole desktop canvas down on small screens to keep identical layout */
    .attested-desktop-scale { width: 1347px; transform-origin: top left; }
    @media (max-width: 1347px) { .attested-desktop-scale { zoom: 0.95; transform: scale(0.95); } }
    @media (max-width: 1200px) { .attested-desktop-scale { zoom: 0.90; transform: scale(0.90); } }
    @media (max-width: 1024px) { .attested-desktop-scale { zoom: 0.80; transform: scale(0.80); } }
    @media (max-width: 900px)  { .attested-desktop-scale { zoom: 0.75; transform: scale(0.75); } }
    @media (max-width: 768px)  { .attested-desktop-scale { zoom: 0.65; transform: scale(0.65); } }
    @media (max-width: 640px)  { .attested-desktop-scale { zoom: 0.58; transform: scale(0.58); } }
    @media (max-width: 520px)  { .attested-desktop-scale { zoom: 0.52; transform: scale(0.52); } }
    @media (max-width: 480px)  { .attested-desktop-scale { zoom: 0.73; transform: scale(0.48); } }
    @media (max-width: 420px)  { .attested-desktop-scale { zoom: 0.64; transform: scale(0.44); } }
    @media (max-width: 380px)  { .attested-desktop-scale { zoom: 0.60; transform: scale(0.40); } }
</style>

<div>
    @forelse($attachments as $idx => $file)
        <div class="attested-preview-page">
            <div class="attested-preview-top">
                @if(\Illuminate\Support\Str::endsWith(strtolower($file), ['.pdf']))
                    <embed src="{{ asset('storage/' . $file) }}" type="application/pdf"></embed>
                @else
                    <img src="{{ asset('storage/' . $file) }}" alt="Document {{ $idx + 1 }}" />
                @endif
            </div>
            <div class="attested-preview-footer">
                @if($footerInnerBgUrl)
                    <div class="attested-preview-footer-bg" style="background-image:url('{{ $footerInnerBgUrl }}');"></div>
                @endif
                <div class="attested-preview-footer-inner">
                    <div class="attested-preview-footer-left">                        
                        <span>{{ $footerLabel }}</span>
                    </div>
                    <div class="attested-preview-footer-right">
                        <div>
                        @include('attestations.partials.info-box', [
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
                        </div>
                        <div class="attested-preview-qrrow">
                            <div class="attested-preview-qrtext">
                                <div>بالرقم تصدیق : <strong>{{ $attestation->transaction_number }}</strong></div>
                                <span role="presentation" dir="rtl" style="font-size: 19.2184px; font-family: serif; transform: scaleX(1.04086);">تم إنجاز المعاملة إلكترونیا و للتأكد من صحة المعاملة یمكنك مسح الباركود
                                    (QR Code)
                                </span>
                            </div>
                            @php
                                $token = urlencode(base64_encode($attestation->hash));
                                $qrUrl = url('/User/#/page/preview/'.$token);
                            @endphp
                            <img class="attested-preview-qr" style="padding: 10px; background-color: #ffffffa8; border-radius: 5px;" src="data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(90)->margin(0)->generate($qrUrl)) }}" alt="QR Code" /> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($hasMultiple && $idx < count($attachments) - 1)
            <div style="height: 24px; background: #f7f7f7;"></div>
        @endif
    @empty
        <div style="padding: 24px; color: #b00020;">No documents to display.</div>
    @endforelse
</div>


