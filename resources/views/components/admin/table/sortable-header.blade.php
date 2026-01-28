@props(['field', 'currentSort' => null])

@php
    $isActive =
        !is_null($currentSort) &&
        (str_starts_with($currentSort, $field) || str_starts_with($currentSort, '-' . $field));
    $isDesc = !is_null($currentSort) && str_starts_with($currentSort, '-' . $field);
    $nextSort = $isActive && !$isDesc ? '-' . $field : $field;
@endphp

<a href="{{ request()->fullUrlWithQuery(['sort' => $nextSort]) }}" class="text-decoration-none text-nowrap">
    {{ $slot }}
    <span class="ms-2">
        @if ($isActive)
            @if ($isDesc)
                <span class="icon-[tabler--arrow-up] size-4 fw-semibold"></span>
            @else
                <span class="icon-[tabler--arrow-down] size-4"></span>
            @endif
        @else
            <span class="icon-[tabler--arrows-sort] size-4"></span>
        @endif
    </span>
</a>
