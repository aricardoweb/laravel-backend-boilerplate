@props([
    'name' => 'view',
])

@php
    $iconClass = 'h-4 w-4 shrink-0';
@endphp

@switch($name)
    @case('edit')
        <svg {{ $attributes->merge(['class' => $iconClass]) }} viewBox="0 0 20 20" fill="none" aria-hidden="true">
            <path d="M14.167 2.5a2.357 2.357 0 0 1 3.333 3.333L6.25 17.083 1.667 18.333 2.917 13.75 14.167 2.5Z" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        @break
    @case('delete')
        <svg {{ $attributes->merge(['class' => $iconClass]) }} viewBox="0 0 20 20" fill="none" aria-hidden="true">
            <path d="M15.833 5.833 15.111 15.944A1.667 1.667 0 0 1 13.435 17.5H6.565a1.667 1.667 0 0 1-1.676-1.556L4.167 5.833M8.333 9.167v5M11.667 9.167v5M13.333 5.833V4.167A1.667 1.667 0 0 0 11.667 2.5H8.333A1.667 1.667 0 0 0 6.667 4.167v1.666M3.333 5.833h13.334" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        @break
    @case('copy')
        <svg {{ $attributes->merge(['class' => $iconClass]) }} viewBox="0 0 20 20" fill="none" aria-hidden="true">
            <path d="M6.667 6.667V4.167A1.667 1.667 0 0 1 8.333 2.5h7.5A1.667 1.667 0 0 1 17.5 4.167v7.5a1.667 1.667 0 0 1-1.667 1.666h-2.5M4.167 7.5h7.5A1.667 1.667 0 0 1 13.333 9.167v7.5a1.667 1.667 0 0 1-1.666 1.666h-7.5A1.667 1.667 0 0 1 2.5 16.667v-7.5A1.667 1.667 0 0 1 4.167 7.5Z" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        @break
    @default
        <svg {{ $attributes->merge(['class' => $iconClass]) }} viewBox="0 0 20 20" fill="none" aria-hidden="true">
            <path d="M1.667 10S4.167 4.167 10 4.167 18.333 10 18.333 10 15.833 15.833 10 15.833 1.667 10 1.667 10Z" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
@endswitch
