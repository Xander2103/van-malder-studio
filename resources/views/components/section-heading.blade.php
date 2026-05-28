@props(['eyebrow' => null, 'title', 'description' => null, 'centered' => false, 'dark' => false])

<div class="{{ $centered ? 'text-center' : '' }}">
    @if($eyebrow)
    <p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest mb-3 {{ $dark ? 'text-amber-400' : 'text-amber-700' }}">
        @if(!$centered)
        <span class="w-4 h-px bg-current inline-block" aria-hidden="true"></span>
        @endif
        {{ $eyebrow }}
    </p>
    @endif
    <h2 class="font-serif text-3xl md:text-4xl font-medium leading-tight {{ $dark ? 'text-white' : 'text-slate-900' }}">{{ $title }}</h2>
    @if($description)
    <p class="mt-4 text-base leading-relaxed {{ $centered ? 'max-w-2xl mx-auto' : 'max-w-2xl' }} {{ $dark ? 'text-slate-400' : 'text-slate-500' }}">{{ $description }}</p>
    @endif
</div>
