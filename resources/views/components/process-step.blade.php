@props(['number', 'title', 'description', 'last' => false])

<div class="flex gap-5">
    <div class="flex flex-col items-center">
        <div class="w-9 h-9 rounded-full bg-slate-900 text-white text-sm font-semibold flex items-center justify-center shrink-0">
            {{ $number }}
        </div>
        @if(!$last)
        <div class="w-px flex-1 bg-stone-200 mt-2" aria-hidden="true"></div>
        @endif
    </div>
    <div class="pb-10 {{ $last ? '' : '' }}">
        <h3 class="font-serif text-lg font-medium text-slate-900 leading-tight">{{ $title }}</h3>
        <p class="mt-1.5 text-sm text-slate-500 leading-relaxed max-w-lg">{{ $description }}</p>
    </div>
</div>
