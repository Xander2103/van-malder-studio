@props(['name'])

@error($name)
<p class="mt-1.5 text-xs text-red-600" role="alert" id="error-{{ $name }}">{{ $message }}</p>
@enderror
