<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
    <div style="display:inline-flex;align-items:center;gap:12px;">
        <img src="data:image/png;base64,{{ config('mail.logo_base64') }}"
             alt="AgriPredict AI"
             style="width:48px;height:48px;border-radius:10px;object-fit:cover;">
        <span style="font-size:22px;font-weight:800;color:#10b981;letter-spacing:-0.5px;">
            AgriPredict AI
        </span>
    </div>
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{!! $slot !!}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
    Si vous avez du mal à cliquer sur le bouton, copiez et collez le lien ci-dessous dans votre navigateur :
    {!! $subcopy !!}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
    © {{ date('Y') }} <strong>AgriPredict AI</strong> · Prévision de rendement agricole par IA · Bénin<br>
    <span style="font-size:11px;color:#9ca3af;">MONTCHO Lysias & TCHEOUBI Osiax</span>
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>