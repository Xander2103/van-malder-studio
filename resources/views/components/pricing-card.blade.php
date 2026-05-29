@props(['title', 'price', 'description', 'bullets' => [], 'highlighted' => false, 'cta' => null])

<article class="{{ $highlighted
    ? 'pricing-featured text-white border-slate-700 shadow-sm'
    : 'bg-white border-stone-200 text-slate-900 shadow-sm'
}} rounded-xl border p-7 flex flex-col relative overflow-hidden">

    @if($highlighted)
    <div class="absolute top-4 right-4">
        <span class="text-[0.6rem] font-medium px-2 py-0.5 bg-white/8 text-slate-400 rounded-full uppercase tracking-wider border border-white/10">
            {{ __('site.pricing.popular') }}
        </span>
    </div>
    @endif

    <h3 class="font-serif text-lg font-medium {{ $highlighted ? 'text-white' : 'text-slate-900' }}">{{ $title }}</h3>

    <div class="mt-4 mb-1 flex items-baseline gap-1">
        <span class="text-xl font-semibold tracking-tight {{ $highlighted ? 'text-slate-100' : 'text-slate-700' }}">{{ $price }}</span>
    </div>
    <p class="text-sm leading-relaxed {{ $highlighted ? 'text-slate-400' : 'text-slate-500' }}">{{ $description }}</p>

    @if(count($bullets))
    <ul class="mt-5 space-y-2.5 flex-1" role="list">
        @foreach($bullets as $bullet)
        <li class="flex items-start gap-2.5 text-sm {{ $highlighted ? 'text-slate-400' : 'text-slate-600' }}">
            <svg class="mt-0.5 w-3.5 h-3.5 shrink-0 {{ $highlighted ? 'text-slate-600' : 'text-stone-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            {{ $bullet }}
        </li>
        @endforeach
    </ul>
    @else
    <div class="flex-1"></div>
    @endif

    @if($cta)
    @php
        $loc = app()->getLocale() ?: 'nl';
        $ctaHref = \Illuminate\Support\Facades\Route::has($loc . '.contact') ? route($loc . '.contact') : route('contact');
    @endphp
    <a href="{{ $ctaHref }}"
       class="mt-6 inline-flex justify-center items-center gap-2 px-5 py-2.5 text-sm font-medium rounded-lg transition-colors duration-200 cursor-pointer
              {{ $highlighted
                 ? 'bg-white/10 text-slate-100 border border-white/15 hover:bg-white/15'
                 : 'bg-slate-900 text-white hover:bg-slate-800 border border-transparent' }}">
        {{ $cta }}
    </a>
    @endif
</article>
