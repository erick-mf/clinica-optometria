@props(['title', 'content'])

<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg w-11/12 max-w-md mx-auto p-4 sm:p-6 shadow-xl">
        <div class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 sm:h-12 sm:w-12 text-red-400 mx-auto mb-3 sm:mb-4"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464
                     0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <!-- Título del modal -->
            <h3 class="text-lg font-bold text-gray-900 mb-2"> {{ $title }}</h3>
            <!-- Contenido del modal -->
            <p class="text-gray-600 mb-4 sm:mb-6 text-sm sm:text-base">{{ $content }}</p>
            <div class="flex justify-center space-x-3 sm:space-x-4">
                <button id="cancelDelete"
                    class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 hover:bg-gray-200 font-medium rounded-lg transition-colors duration-200">
                    Cancelar
                </button>
                <button id="confirmDelete"
                    class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 font-medium rounded-lg transition-colors duration-200">
                    Si, Eliminar
                </button>
            </div>
        </div>
    </div>
</div>
