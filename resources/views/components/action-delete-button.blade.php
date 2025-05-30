@props(['action', 'width' => 'w-32'])

<div class="w-full sm:w-auto" data-container="modal">
    <!-- Button optimized for both mobile and desktop -->
    <button type="button"
        class="delete-button w-full md:w-auto lg:w-auto inline-flex items-center justify-center px-4 py-2.5 bg-red-100 text-red-700 hover:bg-red-200 font-medium rounded-lg transition-colors duration-200 text-sm sm:text-base">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
        <span class="whitespace-nowrap">Eliminar</span>
    </button>
    <form action="{{ $action }}" method="POST" class="delete-form hidden">
        @csrf
        @method('DELETE')
    </form>
</div>
