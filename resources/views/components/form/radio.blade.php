@props(['label', 'name', 'id' => null, 'value', 'checked' => false])

@php
    // Safe HTML id (no brackets)
    $inputId = $id ?? str_replace(['[', ']'], ['_', ''], $name) . '-' . $value;

    // Convert array name to dot notation
    $errorKey = str_replace(['[', ']'], ['.', ''], $name);
    $errorKey = rtrim($errorKey, '.');
@endphp

<div class="flex items-center gap-2">
    <input type="radio" class="radio radio-primary {{ $errors->has($errorKey) ? 'is-invalid' : '' }}"
        id="{{ $inputId }}" name="{{ $name }}" value="{{ $value }}" @checked(old($errorKey, $checked) == $value)
        {{ $attributes }} />

    <label class="label-text text-base-content/80 p-0 text-base" for="{{ $inputId }}">
        {{ $label }}
    </label>
</div>
