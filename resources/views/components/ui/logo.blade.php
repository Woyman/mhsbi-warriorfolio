@if ($link !== false && $link)
<a class="cursor-pointer transition-all duration-300 hover:opacity-50 active:opacity-10" href="{{ $link }}">
    @endif
    {{-- Logo --}}
    @if (($logo ?? null) || ($logoDark ?? null))
    <x-curator-glider :media="$logo"
        class="{{ $logoSize ? $logoSize : 'max-w-11' }} {{ $logoDark ? 'dark:hidden' : '' }} block object-contain" />
    <x-curator-glider :media="$logoDark"
        class="{{ $logoSize ? $logoSize : 'max-w-11' }} hidden object-contain dark:block" />
    @else
    {{-- Site name from Settings → Application Name when no logo is set --}}
    <h3
        class="block font-semibold tracking-tight text-saturn-600 dark:text-white {{ $size ?? 'text-lg max-w-[min(100%,24rem)]' }}">
        {{ $siteName }}
    </h3>
    @endif
    @if ($link !== false && $link)
</a>
@endif
