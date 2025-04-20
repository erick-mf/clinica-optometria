@props(['action', 'placeholder'])

<form action="{{ $action }}" method="GET" class="mb-5 sm:mb-6 relative">
    <!-- Icono de búsqueda -->
    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </div>

    <!-- Input de búsqueda -->
    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $placeholder }}"
        minlength="3" maxlength="50" autocomplete="off"
        class="w-full pl-10 pr-24 sm:pr-28 py-2 rounded-md border border-gray-300 focus:ring focus:ring-gray-300 focus:border-gray-300 text-sm sm:text-base">

    @if (request('search'))
        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
            <a href="{{ $action }}" class="text-gray-400 hover:text-teal-600 transition-colors flex items-center"
                title="Mostrar todos los pacientes">
                <!-- Texto visible solo en desktop/tablet -->
                <span class="text-xs sm:text-sm mr-1 hidden sm:inline-block">
                    Limpiar
                </span>
                <!-- Icono visible en todos los dispositivos -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </div>
    @endif

    <button type="submit" class="hidden">Buscar</button>
</form>
