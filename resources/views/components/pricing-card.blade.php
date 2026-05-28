@props(['title', 'price', 'description', 'bullets' => [], 'highlighted' => false, 'cta' => 'Neem contact op'])

<article class="{{ $highlighted ? 'pricing-featured text-white border-blue-800 ring-2 ring-blue-600' : 'bg-white border-stone-200 text-slate-900' }} rounded-xl border p-7 flex flex-col relative overflow-hidden">

    @if($highlighted)
    <div class="absolute top-4 right-4">
        <span class="text-[0.6rem] font-bold px-2 py-0.5 bg-blue-600 text-white rounded-full uppercase tracking-wider">Populair</span>
    </div>
    @endif

    <h3 class="font-serif text-lg font-medium {{ $highlighted ? 'text-white' : 'text-slate-900' }}">{{ $title }}</h3>
    <div class="mt-5 mb-1">
        <span class="text-3xl font-bold tracking-tight {{ $highlighted ? 'text-white' : 'text-slate-900' }}">{{ $price }}</span>
    </div>
    <p class="text-sm leading-relaxed {{ $highlighted ? 'text-blue-200' : 'text-slate-500' }}">{{ $description }}</p>

    @if(count($bullets))
    <ul class="mt-6 space-y-2.5 flex-1" role="list">
        @foreach($bullets as $bullet)
        <li class="flex items-start gap-2.5 text-sm {{ $highlighted ? 'text-blue-100' : 'text-slate-600' }}">
            <svg class="mt-0.5 w-4 h-4 shrink-0 {{ $highlighted ? 'text-blue-400' : 'text-blue-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            {{ $bullet }}
        </li>
        @endforeach
    </ul>
    @else
    <div class="flex-1"></div>
    @endif

    <a href="{{ route('contact') }}"
       class="mt-7 inline-flex justify-center items-center gap-2 px-5 py-2.5 text-sm font-semibold rounded-lg transition-colors duration-200 cursor-pointer {{ $highlighted ? 'bg-blue-500 text-white hover:bg-blue-400 border border-blue-400' : 'bg-slate-900 text-white hover:bg-blue-800' }}">
        {{ $cta }}
    </a>
</article>
