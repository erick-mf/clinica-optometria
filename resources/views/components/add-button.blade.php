@props(['action', 'text'])

<a href="{{ $action }}"
    class="bg-gray-800 hover:bg-gray-700 text-white py-2 px-4 rounded-md transition duration-150 ease-in-out
                            w-full sm:w-auto text-center flex items-center justify-center text-sm sm:text-base">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-2" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
    </svg>
    {{ $text }}
</a>
