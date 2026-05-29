<!DOCTYPE html>
<html lang="nl" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studio Intro | Van Malder Studio</title>
    <meta name="description" content="Een visuele showcase van Van Malder Studio — design, code en interactie samengebracht.">
    <meta name="robots" content="noindex">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Staggered letter animation for the headline */
        .letter-in {
            display: inline-block;
            opacity: 0;
            transform: translateY(28px);
            animation: introFadeUp 0.7s ease both;
        }
    </style>
</head>
<body class="intro-scene w-full min-h-screen overflow-x-hidden" style="font-family:'Inter',sans-serif;">

    {{-- Skip to main content --}}
    <a href="#intro-content"
       class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:px-4 focus:py-2 focus:bg-white focus:text-slate-900 focus:rounded-lg focus:text-sm focus:font-medium">
        Sla animatie over
    </a>

    {{-- ── Woven background layers ── --}}
    <div class="fixed inset-0 pointer-events-none" aria-hidden="true">
        <div class="intro-dots-sm absolute inset-0"></div>
        <div class="intro-dots-lg absolute inset-0"></div>
        <div class="intro-orb intro-orb-1"></div>
        <div class="intro-orb intro-orb-2"></div>
        <div class="intro-orb intro-orb-3"></div>
        <div class="intro-vignette"></div>
    </div>

    {{-- ── Interactive particle canvas ── --}}
    <canvas id="woven-canvas"
            class="fixed inset-0 pointer-events-none"
            aria-hidden="true"
            style="z-index:1; opacity: 0.6;"></canvas>

    {{-- ── Top bar: back link ── --}}
    <header class="fixed top-0 inset-x-0 z-30 p-6 flex justify-between items-center">
        <a href="{{ route('showcase') }}"
           class="intro-fade intro-fade-1 inline-flex items-center gap-2 text-sm font-medium text-slate-400 hover:text-white transition-colors duration-200">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
            </svg>
            Showcase
        </a>
        <a href="{{ route('home') }}"
           class="intro-fade intro-fade-1 text-sm font-medium text-slate-500 hover:text-white transition-colors duration-200">
            Van Malder Studio
        </a>
    </header>

    {{-- ── Main content ── --}}
    <main id="intro-content"
          class="relative z-10 min-h-screen flex flex-col items-center justify-center px-6 py-24 text-center">

        {{-- Eyebrow --}}
        <p class="intro-fade intro-fade-2 text-[0.65rem] font-semibold text-slate-500 uppercase tracking-[0.25em] mb-6">
            Van Malder Studio · Web &amp; Digital
        </p>

        {{-- Headline with staggered letter animation --}}
        <h1 class="font-serif text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-medium text-white leading-[1.1] tracking-tight"
            id="intro-headline"
            aria-label="Van Malder Studio">
            @php
                $words = ['Van', 'Malder', 'Studio'];
                $delay = 0.35;
            @endphp
            @foreach($words as $wi => $word)
            <span class="inline-block {{ $wi < count($words)-1 ? 'mr-[0.2em]' : '' }}">
                @foreach(str_split($word) as $ci => $char)
                <span class="letter-in" style="animation-delay:{{ number_format($delay, 2) }}s">{{ $char }}</span>
                @php $delay += 0.045; @endphp
                @endforeach
            </span>
            @endforeach
        </h1>

        {{-- Tagline --}}
        <p class="intro-fade intro-fade-3 mt-8 max-w-md text-base md:text-lg text-slate-400 leading-relaxed">
            Design, code en interactie samengebracht in een korte visuele showcase.
        </p>

        {{-- Sub-line --}}
        <p class="intro-fade intro-fade-4 mt-3 text-sm text-slate-600">
            Websites, apps en digitale oplossingen voor zelfstandigen en lokale bedrijven.
        </p>

        {{-- CTAs --}}
        <div class="intro-fade intro-fade-5 mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ route('home') }}"
               class="inline-flex items-center gap-2 px-6 py-3 text-sm font-semibold bg-white text-slate-900 rounded-full hover:bg-stone-100 transition-colors duration-200 cursor-pointer shadow-sm">
                Ga naar de website
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <a href="{{ route('contact') }}"
               class="inline-flex items-center px-6 py-3 text-sm font-semibold text-slate-300 border border-slate-700 rounded-full hover:border-slate-500 hover:text-white transition-colors duration-200 cursor-pointer backdrop-blur-sm">
                Bespreek je project
            </a>
        </div>

    </main>

    {{-- ── Bottom scroll hint ── --}}
    <div class="fixed bottom-6 left-1/2 -translate-x-1/2 z-10 intro-fade intro-fade-5 flex flex-col items-center gap-1.5" aria-hidden="true">
        <div class="w-px h-8 bg-gradient-to-b from-transparent to-slate-600 animate-pulse"></div>
    </div>

</body>
</html>
