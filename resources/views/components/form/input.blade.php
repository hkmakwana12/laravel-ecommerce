@props([
    'label',
    'name',
    'id' => null,
    'type' => 'text',
    'value' => null,
    'required' => false,
    'wrapperClass' => '',
])

@php
    $inputId = $id ?? str_replace(['[', ']'], ['_', ''], $name);

    // Convert array name to dot notation for Laravel
    $errorKey = str_replace(['[', ']'], ['.', ''], $name);
    $errorKey = rtrim($errorKey, '.');
@endphp

<div class="space-y-1 {{ $wrapperClass }}">
    <label for="{{ $inputId }}" class="label-text {{ $required ? 'required' : '' }}">
        {{ $label }}
    </label>

    <input
        {{ $attributes->merge([
            'class' => 'input ' . ($errors->has($errorKey) ? 'is-invalid' : ''),
        ]) }}
        type="{{ $type }}" id="{{ $inputId }}" name="{{ $name }}"
        value="{{ old($errorKey, $value) }}" />

    @error($errorKey)
        <span class="helper-text">{{ $message }}</span>
    @enderror
</div>
