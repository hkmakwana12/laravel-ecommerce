@props(['label', 'name', 'id' => null, 'checked' => false, 'value' => 1])

@php
    // Safe HTML id
    $inputId = $id ?? str_replace(['[', ']'], ['_', ''], $name);

    // Convert array name to dot notation for old() & validation
    $errorKey = str_replace(['[', ']'], ['.', ''], $name);
    $errorKey = rtrim($errorKey, '.');
@endphp

<div class="flex items-center gap-2">
    <input type="checkbox" class="checkbox checkbox-primary" id="{{ $inputId }}" name="{{ $name }}"
        value="{{ $value }}" @checked(old($errorKey, $checked)) {{ $attributes }} />

    <label class="label-text text-base-content/80 p-0 text-base" for="{{ $inputId }}">
        {{ $label }}
    </label>
</div>
