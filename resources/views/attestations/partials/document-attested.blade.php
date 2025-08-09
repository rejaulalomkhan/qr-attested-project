@php
    $attachments = $attachments ?? [];
    $footerLabel = 'Blockchain Verified';
@endphp

<style>
    .attested-preview-page { background:#fff; margin: 0 0 28px 0; border: 1px solid #eee; }
    .attested-preview-top { width:100%; display:block; }
    .attested-preview-top img { display:block; width:100%; height:auto; object-fit:contain; max-height:70vh; }
    .attested-preview-top embed { display:block; width:100%; height:70vh; border:0; }
    .attested-preview-footer { position: relative; width:100%; min-height: 180px; background: var(--footer-fallback, linear-gradient(180deg, #fff 0%, #f7f7f7 100%)); background-size: cover; background-repeat:no-repeat; background-position:center; padding: 16px; box-sizing: border-box; }
    .attested-preview-footer-inner { display:flex; flex-direction: row; align-items:flex-end; gap: 24px; }
    .attested-preview-footer-left { flex: 1 1 auto; display:flex; align-items:flex-end; gap:12px; color:#6c757d; font-weight:600; }
    .attested-preview-qr { width: 90px; height: 90px; }
    .attested-preview-footer-right { flex: 0 0 auto; display:flex; justify-content:flex-end; }
    @media (max-width: 768px) {
        .attested-preview-footer-inner { flex-direction: column-reverse; align-items: stretch; }
        .attested-preview-footer-right { justify-content: stretch; }
    }
    /* Make info table responsive */
    .attested-preview-footer-right table { max-width: 100%; width: 420px; }
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
            <div class="attested-preview-footer" style="--footer-fallback: linear-gradient(180deg,#ffffff 0%,#f5f5f5 100%); @isset($footerBgUrl) background-image:url('{{ $footerBgUrl }}'); @endisset">
                <div class="attested-preview-footer-inner">
                    <div class="attested-preview-footer-left">
                        {{-- <img class="attested-preview-qr" src="data:image/png;base64,{{ $qrData }}" alt="QR Code" /> --}}
                        <img class="attested-preview-qr" src="{{ asset('storage/qrdemo.png') }}" alt="QR Code" />
                        <span>{{ $footerLabel }}</span>
                    </div>
                    <div class="attested-preview-footer-right">
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
                </div>
            </div>
        </div>
    @empty
        <div style="padding: 24px; color: #b00020;">No documents to display.</div>
    @endforelse
</div>


