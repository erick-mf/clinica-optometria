@props(['url'])

<a href="{{ $url }}"
    class="text-gray-600 hover:text-gray-900 font-medium transition-colors duration-150 ease-in-out flex items-center">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
    </svg>
    <span>Regresar</span>
</a>
