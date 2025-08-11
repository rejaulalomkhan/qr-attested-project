@php
    $attachments = $attachments ?? [];
@endphp
<div style="position: relative; min-height: 100%; background: #fff;">
    @forelse($attachments as $idx => $file)
        <div style="min-height: 70vh; width: 100%; margin: 0 0 30px 0;">
            {{-- <div style="font-weight: bold; margin: 12px 0; padding: 0 12px;">Document {{ $idx + 1 }}</div> --}}
            @if(\Illuminate\Support\Str::endsWith(strtolower($file), ['.pdf']))
                <embed src="{{ asset('storage/' . $file) }}" type="application/pdf" width="100%" height="600px">
            @else
                <img src="{{ asset('storage/' . $file) }}" style="display:block; width:100%; height:auto; max-height:200vh; object-fit:contain;" alt="Original Document">
            @endif
        </div>
        @if(count($attachments) > 1 && !$loop->last)
            <div style="height: 24px; background: #f7f7f7;"></div>
        @endif
    @empty
        <div style="padding: 24px; color: #b00020;">No original documents available.</div>
    @endforelse
</div>


