@props(['label', 'name', 'id' => null, 'value' => null, 'required' => false, 'wrapperClass' => ''])

@php
    // Safe HTML id (no brackets)
    $inputId = $id ?? str_replace(['[', ']'], ['_', ''], $name);

    // Convert array name to dot notation for Laravel
    $errorKey = str_replace(['[', ']'], ['.', ''], $name);
    $errorKey = rtrim($errorKey, '.');
@endphp

<div class="space-y-1 {{ $wrapperClass }}">
    <label for="{{ $inputId }}" class="label-text {{ $required ? 'required' : '' }}">
        {{ $label }}
    </label>

    <textarea class="textarea {{ $errors->has($errorKey) ? 'is-invalid' : '' }}" id="{{ $inputId }}"
        name="{{ $name }}" {{ $attributes }}>{{ old($errorKey, $value) }}</textarea>

    @error($errorKey)
        <span class="helper-text">{{ $message }}</span>
    @enderror
</div>
