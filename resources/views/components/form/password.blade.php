@props(['label', 'name' => 'password', 'id' => null, 'required' => false, 'wrapperClass' => ''])

@php
    // Safe ID (no brackets)
    $inputId = $id ?? str_replace(['[', ']'], ['_', ''], $name);

    // Convert array name to dot notation for validation/errors
    $errorKey = str_replace(['[', ']'], ['.', ''], $name);
    $errorKey = rtrim($errorKey, '.');
@endphp

<div class="space-y-1 {{ $wrapperClass }}">
    <label class="label-text {{ $required ? 'required' : '' }}" for="{{ $inputId }}">
        {{ $label }}
    </label>

    <div class="input {{ $errors->has($errorKey) ? 'is-invalid' : '' }}">
        <input id="{{ $inputId }}" type="password" name="{{ $name }}" autocomplete="new-password"
            {{ $attributes }} />

        <button type="button" data-toggle-password='{ "target": "#{{ $inputId }}" }' class="block cursor-pointer"
            aria-label="Toggle password visibility">
            <span class="icon-[tabler--eye] password-active:block hidden size-5 shrink-0"></span>
            <span class="icon-[tabler--eye-off] password-active:hidden block size-5 shrink-0"></span>
        </button>
    </div>

    @error($errorKey)
        <span class="helper-text">{{ $message }}</span>
    @enderror
</div>
