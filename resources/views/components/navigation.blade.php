@php
    $links = [
        ['route' => 'services',       'label' => 'Diensten'],
        ['route' => 'projects.index', 'label' => 'Projecten'],
        ['route' => 'process',        'label' => 'Werkwijze'],
        ['route' => 'pricing',        'label' => 'Prijzen'],
        ['route' => 'about',          'label' => 'Over mij'],
    ];
@endphp
<header class="fixed top-0 inset-x-0 z-50 bg-stone-50/95 backdrop-blur-md border-b border-stone-200/80">
    <nav class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between" aria-label="Hoofdnavigatie">
        <a href="{{ route('home') }}"
           class="font-serif text-[1.05rem] font-medium text-slate-900 tracking-tight hover:text-blue-700 transition-colors duration-200"
           aria-label="{{ config('studio.brand_name') }} — homepage">
            Van Malder Studio
        </a>

        {{-- Desktop nav --}}
        <ul class="hidden md:flex items-center gap-6" role="list">
            @foreach($links as $link)
            <li>
                <a href="{{ route($link['route']) }}"
                   class="text-sm font-medium transition-colors duration-200 {{ request()->routeIs($link['route']) ? 'text-slate-900' : 'text-slate-500 hover:text-slate-800' }}">
                    {{ $link['label'] }}
                </a>
            </li>
            @endforeach
        </ul>

        <div class="hidden md:flex items-center gap-3">
            <a href="{{ route('contact') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold bg-slate-900 text-white rounded-lg hover:bg-blue-800 transition-colors duration-200 cursor-pointer shadow-sm">
                Contact
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        {{-- Mobile hamburger --}}
        <button id="nav-toggle"
                type="button"
                class="md:hidden p-2 rounded-md text-slate-500 hover:text-slate-900 hover:bg-stone-100 transition-colors duration-200 cursor-pointer"
                aria-controls="mobile-menu"
                aria-expanded="false"
                aria-label="Menu openen">
            <svg id="icon-open" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg id="icon-close" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </nav>

    {{-- Mobile menu --}}
    <div id="mobile-menu" class="hidden md:hidden border-t border-stone-200 bg-stone-50" role="dialog" aria-label="Mobiel menu">
        <ul class="max-w-6xl mx-auto px-4 py-3 flex flex-col gap-0.5" role="list">
            @foreach($links as $link)
            <li>
                <a href="{{ route($link['route']) }}"
                   class="block px-3 py-2.5 text-sm font-medium rounded-md transition-colors duration-200 {{ request()->routeIs($link['route']) ? 'text-slate-900 bg-stone-100' : 'text-slate-600 hover:bg-stone-100 hover:text-slate-900' }}">
                    {{ $link['label'] }}
                </a>
            </li>
            @endforeach
            <li class="pt-2 mt-1 border-t border-stone-200">
                <a href="{{ route('contact') }}"
                   class="block px-3 py-2.5 text-sm font-semibold text-white bg-slate-900 rounded-md hover:bg-blue-800 transition-colors duration-200 text-center cursor-pointer">
                    Contact opnemen
                </a>
            </li>
        </ul>
    </div>
</header>
<div class="h-16" aria-hidden="true"></div>
