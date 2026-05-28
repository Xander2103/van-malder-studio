@props(['label', 'name', 'options' => [], 'required' => false, 'placeholder' => 'Kies een optie'])

@php $id = 'field-' . $name; @endphp

<div>
    <label for="{{ $id }}" class="block text-sm font-medium text-slate-700 mb-1.5">
        {{ $label }}
        @if($required)<span class="text-red-500 ml-0.5" aria-hidden="true">*</span>@endif
    </label>
    <select
        id="{{ $id }}"
        name="{{ $name }}"
        @if($required) required aria-required="true" @endif
        {{ $attributes->merge(['class' => 'w-full px-4 py-2.5 text-sm bg-white border rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-colors duration-200 ' . ($errors->has($name) ? 'border-red-400' : 'border-stone-200')]) }}
    >
        <option value="">{{ $placeholder }}</option>
        @foreach($options as $value => $label)
        <option value="{{ $value }}" {{ old($name) == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
    <x-form.error :name="$name" />
</div>
