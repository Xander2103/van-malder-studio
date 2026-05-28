@props(['href', 'variant' => 'primary'])

@php
    $classes = match($variant) {
        'primary'   => 'inline-flex items-center px-5 py-3 text-sm font-medium bg-slate-900 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 cursor-pointer',
        'secondary' => 'inline-flex items-center px-5 py-3 text-sm font-medium bg-white text-slate-900 border border-slate-200 rounded-lg hover:border-slate-400 hover:bg-stone-50 transition-colors duration-200 cursor-pointer',
        'ghost'     => 'inline-flex items-center px-5 py-3 text-sm font-medium text-blue-700 hover:text-blue-900 transition-colors duration-200 cursor-pointer',
        default     => 'inline-flex items-center px-5 py-3 text-sm font-medium bg-slate-900 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 cursor-pointer',
    };
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
