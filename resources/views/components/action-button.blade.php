@props(['action', 'color' => 'teal', 'icon' => '', 'text' => '', 'width' => 'w-32'])

@php
    $colorMap = [
        'teal' => [
            'bg' => 'bg-teal-50 hover:bg-teal-100',
            'text' => 'text-teal-700',
            'style' => 'background-color: rgba(21, 117, 100, 0.1); color: #157564;',
        ],
        'blue' => [
            'bg' => 'bg-blue-50 hover:bg-blue-100',
            'text' => 'text-blue-700',
            'style' => '',
        ],
        'red' => [
            'bg' => 'bg-red-100 hover:bg-red-200',
            'text' => 'text-red-700',
            'style' => '',
        ],
    ];
    $selectedColor = $colorMap[$color];
@endphp

<div class="w-full sm:w-auto">
    <a href="{{ $action }}"
        {{ $attributes->merge(['class' => "w-full inline-flex items-center justify-center px-4 py-2.5 {$selectedColor['bg']} {$selectedColor['text']} font-medium rounded-lg transition-colors duration-200 text-sm sm:text-base"]) }}
        @if ($selectedColor['style']) style="{{ $selectedColor['style'] }}" @endif>
        @if ($icon === 'edit')
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        @elseif($icon === 'appointment')
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
            </svg>
        @elseif($icon === 'delete')
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        @elseif($icon === 'show')
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        @endif
        <span class="whitespace-nowrap">{{ $text }}</span>
    </a>
</div>
