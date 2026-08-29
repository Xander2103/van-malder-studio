@props(['project'])

@php
$art = $project['art'] ?? 'darts';
$artClass = match($art) {
    'studio'   => 'project-art-studio',
    'darts'    => 'project-art-darts',
    'cards'    => 'project-art-cards',
    'strategy' => 'project-art-strategy',
    'ball'     => 'project-art-ball',
    default    => 'project-art-darts',
};
@endphp

<article class="bg-slate-800 rounded-xl border border-slate-700 overflow-hidden hover:border-slate-600 hover:shadow-lg hover:shadow-black/20 transition-all duration-300 flex flex-col group cursor-pointer">

    {{-- CSS art header --}}
    <div class="project-art {{ $artClass }} dot-pattern h-44 relative overflow-hidden" aria-hidden="true">

        @if($art === 'studio')
        {{-- Browser window frame lines -- web dev feel --}}
        <div class="absolute inset-4 rounded-lg border border-blue-500/20 bg-blue-900/10">
            <div class="h-6 border-b border-blue-500/20 flex items-center px-2.5 gap-1.5">
                <div class="w-2 h-2 rounded-full bg-blue-800/50"></div>
                <div class="w-2 h-2 rounded-full bg-blue-700/40"></div>
                <div class="w-2 h-2 rounded-full bg-blue-600/30"></div>
                <div class="ml-2 flex-1 h-1.5 rounded-full bg-blue-800/30 max-w-20"></div>
            </div>
            <div class="p-3 space-y-1.5">
                <div class="h-1.5 rounded-full bg-blue-600/25 w-3/4"></div>
                <div class="h-1.5 rounded-full bg-blue-600/15 w-1/2"></div>
                <div class="h-1.5 rounded-full bg-blue-600/20 w-2/3"></div>
            </div>
        </div>
        {{-- code-like dots --}}
        <div class="absolute bottom-5 left-5 flex gap-1.5">
            <span class="text-[0.55rem] font-mono text-blue-500/50">&lt;/&gt;</span>
        </div>
        @endif

        @if($art === 'darts')
        {{-- Concentric rings — dartboard feel --}}
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="absolute w-40 h-40 rounded-full border border-red-800/30"></div>
            <div class="absolute w-28 h-28 rounded-full border border-red-700/40"></div>
            <div class="absolute w-16 h-16 rounded-full border border-red-600/50"></div>
            <div class="absolute w-6 h-6 rounded-full bg-red-800/60 border border-red-500/40"></div>
        </div>
        {{-- diagonal lines --}}
        <div class="absolute top-0 right-0 w-24 h-px bg-red-700/20 transform rotate-45 translate-y-10 translate-x-4"></div>
        <div class="absolute top-0 right-0 w-32 h-px bg-red-700/15 transform rotate-45 translate-y-16 translate-x-4"></div>
        @endif

        @if($art === 'cards')
        {{-- Overlapping card shapes --}}
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="absolute w-20 h-28 rounded-lg border border-teal-400/25 bg-teal-400/5 transform -rotate-12 translate-x-10"></div>
            <div class="absolute w-20 h-28 rounded-lg border border-teal-300/30 bg-teal-300/8 transform -rotate-5 translate-x-3"></div>
            <div class="absolute w-20 h-28 rounded-lg border border-teal-200/35 bg-white/5 transform rotate-2 -translate-x-4"></div>
        </div>
        {{-- accent dot --}}
        <div class="absolute top-5 left-6 w-2 h-2 rounded-full bg-teal-500/40"></div>
        <div class="absolute top-5 left-11 w-2 h-2 rounded-full bg-teal-500/25"></div>
        <div class="absolute top-5 left-16 w-2 h-2 rounded-full bg-teal-500/15"></div>
        @endif

        @if($art === 'strategy')
        {{-- Hexagonal / chain-link shapes --}}
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="absolute w-10 h-10 rounded-full border-2 border-amber-600/40 -translate-x-10"></div>
            <div class="absolute w-3 h-px bg-amber-600/30 -translate-x-5"></div>
            <div class="absolute w-10 h-10 rounded-full border-2 border-amber-500/50"></div>
            <div class="absolute w-3 h-px bg-amber-600/30 translate-x-5"></div>
            <div class="absolute w-10 h-10 rounded-full border-2 border-amber-600/40 translate-x-10"></div>
        </div>
        {{-- Grid lines --}}
        <div class="absolute inset-0 opacity-10">
            <div class="h-full" style="background-image: linear-gradient(rgba(217,119,6,0.3) 1px, transparent 1px), linear-gradient(90deg, rgba(217,119,6,0.3) 1px, transparent 1px); background-size: 24px 24px;"></div>
        </div>
        @endif

        @if($art === 'ball')
        {{-- Pitch lines + ball marker — football prediction feel --}}
        <div class="absolute inset-4 rounded-lg border border-emerald-400/20"></div>
        <div class="absolute top-4 bottom-4 left-1/2 w-px bg-emerald-400/20"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="absolute w-16 h-16 rounded-full border border-emerald-400/25"></div>
        </div>
        <div class="absolute top-9 right-12 w-8 h-8 rounded-full border-2 border-emerald-300/60"></div>
        <div class="absolute top-[3.1rem] right-[3.9rem] w-2.5 h-2.5 rounded-full bg-white/80"></div>
        <div class="absolute bottom-6 left-6 flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400/60"></span>
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400/35"></span>
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400/20"></span>
        </div>
        @endif

        {{-- Status badge overlay --}}
        <div class="absolute top-3 right-3">
            <span class="text-[0.6rem] font-semibold px-2 py-0.5 rounded-full border {{ $project['status'] === 'Afgewerkt' ? 'bg-emerald-900/60 border-emerald-600/40 text-emerald-300' : 'bg-slate-800/80 border-slate-600/40 text-slate-400' }}">
                {{ $project['status'] }}
            </span>
        </div>
    </div>

    {{-- Content --}}
    <div class="p-5 flex flex-col flex-1">
        <div class="flex items-center gap-2 mb-2 flex-wrap">
            <span class="text-[0.65rem] font-semibold text-slate-500 uppercase tracking-widest">{{ $project['type'] }}</span>
            @if(!empty($project['label']))
            <span class="text-[0.6rem] font-medium px-2 py-0.5 bg-slate-700/50 text-slate-400 border border-slate-600/40 rounded-full">{{ $project['label'] }}</span>
            @endif
        </div>
        <h3 class="font-serif text-lg font-medium text-white leading-snug group-hover:text-blue-300 transition-colors duration-200">{{ $project['title'] }}</h3>
        <p class="mt-2 text-sm text-slate-400 leading-relaxed flex-1">{{ $project['short'] }}</p>
        <div class="mt-4 flex flex-wrap gap-1.5">
            @foreach($project['technologies'] as $tech)
            <span class="text-[0.65rem] font-medium px-2 py-0.5 bg-slate-700/60 text-slate-400 border border-slate-600/50 rounded-full">{{ $tech }}</span>
            @endforeach
        </div>
    </div>
</article>
