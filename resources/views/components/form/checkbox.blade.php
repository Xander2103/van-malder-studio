@props(['label', 'name', 'required' => false])

@php $id = 'field-' . $name; @endphp

<div>
    <label for="{{ $id }}" class="flex items-start gap-3 cursor-pointer">
        <input
            type="checkbox"
            id="{{ $id }}"
            name="{{ $name }}"
            value="1"
            @if(old($name)) checked @endif
            @if($required) required aria-required="true" @endif
            class="mt-0.5 w-4 h-4 rounded border-stone-300 text-blue-600 focus:ring-blue-600 cursor-pointer"
        >
        <span class="text-sm text-slate-600 leading-relaxed">{{ $label }}</span>
    </label>
    <x-form.error :name="$name" />
</div>
