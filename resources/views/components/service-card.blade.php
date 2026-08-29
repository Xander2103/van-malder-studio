@props(['service', 'number' => null])

<article class="service-card bg-white rounded-xl border border-stone-200 p-6 flex flex-col">
    @if($number)
    <span class="text-[0.65rem] font-bold text-stone-300 tabular-nums mb-4 tracking-wider" aria-hidden="true">
        0{{ $number }}
    </span>
    @endif
    <h3 class="font-serif text-lg font-medium text-slate-900 leading-snug">{{ $service['title'] }}</h3>
    <p class="mt-2 text-sm text-slate-500 leading-relaxed flex-1">{{ $service['short'] }}</p>
    <a href="{{ Route::has((app()->getLocale() ?: 'nl') . '.services') ? route((app()->getLocale() ?: 'nl') . '.services') : route('services') }}#{{ $service['slug'] }}"
       class="mt-5 inline-flex items-center text-sm font-semibold text-blue-700 hover:text-blue-900 transition-colors duration-200 group cursor-pointer">
        Meer info
        <svg class="ml-1.5 w-3.5 h-3.5 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
    </a>
</article>
