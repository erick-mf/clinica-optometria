<x-app-layout>
    <div class="py-4 sm:py-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 sm:p-6 text-gray-900">
                    <!-- Encabezado -->
                    <div
                        class="mb-4 sm:mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                        <h1 class="text-lg font-bold sm:text-2xl">Listado de Doctores</h1>
                        <x-add-button action="{{ route('admin.doctors.create') }}" text="Agregar Doctor" />
                    </div>


                    @if (!request('search') && $doctors->isEmpty())
                        <div class="bg-gray-50 rounded-lg p-4 sm:p-8 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-10 w-10 sm:h-12 sm:w-12 mx-auto text-gray-400 mb-3 sm:mb-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            <p class="text-gray-600 text-sm sm:text-lg mb-3 sm:mb-4">No hay doctores registrados.</p>
                            <a href="{{ route('admin.doctors.create') }}"
                                class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium text-sm sm:text-base">
                                <span>Agregar tu primer doctor</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 ml-1"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    @else
                        <!-- Buscador -->
                        <div class="mb-4 sm:mb-6 relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <form action="{{ route('admin.doctors.index') }}" method="GET" class="relative">
                                <input type="text" name="search" id="searchDoctor"
                                    placeholder="Buscar por nombre, apellido o email..."
                                    class="w-full pl-10 pr-4 py-2 rounded-md border border-gray-300 focus:ring focus:ring-gray-300 focus:border-gray-300 text-sm sm:text-base"
                                    value="{{ request('search') }}" autocomplete="off">

                                <!-- Botón de limpiar búsqueda (aparece cuando hay texto) -->
                                @if (request('search'))
                                    <button type="button" id="clearSearch"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400 hover:text-gray-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                @endif
                            </form>
                        </div>

                        <!-- Mensaje de no resultados para búsqueda -->
                        <div id="noSearchResults"
                            class="{{ $doctors->isEmpty() && request('search') ? '' : 'hidden' }} bg-gray-50 rounded-lg p-3 sm:p-4 text-center mb-4 sm:mb-6">
                            <p class="text-gray-600 text-sm sm:text-base">No se encontraron doctores con ese criterio de
                                búsqueda.</p>
                            <a href="{{ route('admin.doctors.index') }}"
                                class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium text-sm sm:text-base mt-2">
                                <span>Volver a todos los doctores</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 ml-1"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                            </a>
                        </div>

                        <!-- Mensaje cuando no hay resultados visibles localmente -->
                        <div id="noVisibleResults"
                            class="hidden bg-gray-50 rounded-lg p-3 sm:p-4 text-center mb-4 sm:mb-6">
                            <p class="text-gray-600 text-sm sm:text-base">No hay doctores visibles con ese criterio en
                                esta página.</p>
                            <div id="searchServerBtnContainer" class="mt-3"></div>
                        </div>

                        <!-- Vista para móviles (card-based) -->
                        <div id="mobileView"
                            class="md:hidden space-y-3 mb-4 {{ $doctors->isEmpty() && request('search') ? 'hidden' : '' }}">
                            @foreach ($doctors as $doctor)
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-3" data-doctor-card>
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="font-semibold text-gray-900">{{ $doctor->name }}
                                                {{ $doctor->surnames }}</h3>
                                            <p class="text-xs text-gray-500 mt-1">{{ $doctor->email }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $doctor->phone }}</p>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('admin.doctors.edit', $doctor) }}"
                                                class="text-blue-600 hover:text-blue-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <button type="button"
                                                class="text-red-600 hover:text-red-900 delete-button-mobile">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                            <form action="{{ route('admin.doctors.destroy', $doctor) }}"
                                                method="POST" class="hidden delete-form-mobile">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Vista para tablet/desktop (table-based) -->
                        <div id="table"
                            class="hidden md:block overflow-x-auto bg-white rounded-lg shadow {{ $doctors->isEmpty() && request('search') ? 'hidden' : '' }}">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nombre
                                        </th>
                                        <th scope="col"
                                            class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Apellidos
                                        </th>
                                        <th scope="col"
                                            class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Email
                                        </th>
                                        <th scope="col"
                                            class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Teléfono
                                        </th>
                                        <th scope="col"
                                            class="px-3 sm:px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="doctorsTableBody">
                                    @foreach ($doctors as $doctor)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                            <td class="px-3 sm:px-4 py-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $doctor->name }}
                                                </div>
                                            </td>
                                            <td class="px-3 sm:px-4 py-3">
                                                <div class="text-sm text-gray-900">{{ $doctor->surnames }}</div>
                                            </td>
                                            <td class="px-3 sm:px-4 py-3">
                                                <div class="text-sm text-gray-900 truncate max-w-xs">
                                                    {{ $doctor->email }}</div>
                                            </td>
                                            <td class="px-3 sm:px-4 py-3">
                                                <div class="text-sm text-gray-900">{{ $doctor->phone }}</div>
                                            </td>
                                            <td class="px-3 sm:px-4 py-3 text-sm text-center">
                                                <div class="flex justify-center items-center space-x-3">
                                                    <a href="{{ route('admin.doctors.edit', $doctor) }}"
                                                        class="text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200 flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                        <span>Editar</span>
                                                    </a>
                                                    <form action="{{ route('admin.doctors.destroy', $doctor) }}"
                                                        method="POST" class="inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="text-red-600 hover:text-red-900 font-medium transition-colors duration-200 flex items-center delete-button">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4 mr-1" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                            <span>Eliminar</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 sm:mt-6" id="paginate"
                            class="{{ $doctors->isEmpty() && request('search') ? 'hidden' : '' }}">
                            <x-custom-pagination :paginator="$doctors" />
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <x-delete-modal title="Confirmar eliminación"
        content="¿Estás seguro que deseas eliminar este doctor? Esta acción no se puede deshacer." />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Referencias a elementos del DOM para búsqueda
            const searchInput = document.getElementById('searchDoctor');
            const searchForm = searchInput.closest('form');
            const tableRows = document.querySelectorAll('#doctorsTableBody tr');
            const doctorCards = document.querySelectorAll('[data-doctor-card]');
            const noSearchResults = document.getElementById('noSearchResults');
            const noVisibleResults = document.getElementById('noVisibleResults');
            const tableSection = document.getElementById('table');
            const mobileView = document.getElementById('mobileView');
            const paginateSection = document.getElementById('paginate');
            const searchServerBtnContainer = document.getElementById('searchServerBtnContainer');

            // Variables para el manejo de la búsqueda
            let timeout = null;
            let currentSearch = searchInput.value.trim();
            let performingSearch = false;

            // Función para filtrado local (en la página actual)
            function filterLocalItems(searchText) {
                searchText = searchText.toLowerCase().trim();

                let visibleCount = 0;

                // Filtrar cards para móvil
                doctorCards.forEach(card => {
                    const doctorInfo = card.textContent.toLowerCase();
                    if (doctorInfo.includes(searchText)) {
                        card.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        card.classList.add('hidden');
                    }
                });

                // Filtrar filas de tabla para desktop
                tableRows.forEach(row => {
                    const rowInfo = row.textContent.toLowerCase();
                    if (rowInfo.includes(searchText)) {
                        row.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        row.classList.add('hidden');
                    }
                });

                // Actualizar la visibilidad de los mensajes
                updateVisibilityMessages(visibleCount, searchText);

                return visibleCount;
            }

            // Actualizar mensajes de visibilidad
            function updateVisibilityMessages(visibleCount, searchText) {
                // Ocultar todos los mensajes primero
                noSearchResults.classList.add('hidden');
                noVisibleResults.classList.add('hidden');

                // Mostrar tabla/cards según corresponda
                if (visibleCount === 0 && searchText !== '') {
                    // No hay resultados visibles
                    if (tableSection) tableSection.classList.add('md:hidden');
                    if (mobileView) mobileView.classList.add('hidden');
                    if (paginateSection) paginateSection.classList.add('hidden');

                    // Mostrar mensaje de no resultados locales
                    noVisibleResults.classList.remove('hidden');

                    // Añadir botón de búsqueda en servidor si no existe
                    if (!document.getElementById('searchServerBtn')) {
                        const searchAllBtn = document.createElement('button');
                        searchAllBtn.id = 'searchServerBtn';
                        searchAllBtn.className =
                            'bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md text-sm transition-all duration-200';
                        searchAllBtn.textContent = 'Buscar en todas las páginas';
                        searchAllBtn.onclick = function(e) {
                            e.preventDefault();
                            searchForm.submit();
                        };

                        // Limpiar el contenedor antes de añadir el botón
                        searchServerBtnContainer.innerHTML = '';
                        searchServerBtnContainer.appendChild(searchAllBtn);
                    }
                } else {
                    // Hay resultados, mostrar tabla/cards
                    if (tableSection) tableSection.classList.remove('md:hidden');
                    if (mobileView) mobileView.classList.remove('hidden');
                    if (paginateSection) paginateSection.classList.remove('hidden');
                }
            }

            // Gestionar la búsqueda
            function handleSearch() {
                if (performingSearch) return;

                const searchText = searchInput.value.trim();

                // Si la búsqueda está vacía y es diferente a la actual, buscar en el servidor
                if (searchText === '' && currentSearch !== '') {
                    // Redirigir directamente a la página principal en lugar de hacer submit
                    window.location.href = '{{ route('admin.doctors.index') }}';
                    return;
                }

                // Para búsquedas que refinan la actual, filtrar localmente
                if ((searchText.includes(currentSearch) || currentSearch.includes(searchText)) && searchText !==
                    currentSearch) {
                    filterLocalItems(searchText);
                }
                // Para cambios significativos, buscar en el servidor
                else if (searchText !== currentSearch && searchText.length > 2) {
                    // Mostrar indicador de carga
                    performingSearch = true;

                    // Eliminar indicador existente si hay
                    const existingIndicator = document.getElementById('searchLoadingIndicator');
                    if (existingIndicator) existingIndicator.remove();

                    const loadingIndicator = document.createElement('div');
                    loadingIndicator.id = 'searchLoadingIndicator';
                    loadingIndicator.className = 'fixed top-0 left-0 right-0 bg-blue-500 h-1 z-50';
                    loadingIndicator.style.width = '0%';
                    document.body.appendChild(loadingIndicator);

                    // Animar el indicador de carga
                    let width = 0;
                    const interval = setInterval(() => {
                        width += 5;
                        if (width > 90) clearInterval(interval);
                        loadingIndicator.style.width = width + '%';
                    }, 50);

                    // Configurar un temporizador para evitar búsquedas múltiples rápidas
                    setTimeout(() => {
                        currentSearch = searchText;
                        searchForm.submit();
                    }, 300);
                }
            }

            // Evento input con debounce
            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    handleSearch();
                }, 400);
            });

            // Evento submit para actualizar la búsqueda actual
            searchForm.addEventListener('submit', function() {
                currentSearch = searchInput.value.trim();
                performingSearch = true;
            });

            // Si hay un valor de búsqueda al cargar, aplicarlo como filtro local
            if (currentSearch !== '') {
                filterLocalItems(currentSearch);
            }

            // Si el usuario presiona Enter, siempre buscar en el servidor
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    clearTimeout(timeout);
                    currentSearch = searchInput.value.trim();
                    searchForm.submit();
                }
            });

            // Limpiar búsqueda
            const clearSearchButton = document.getElementById('clearSearch');
            if (clearSearchButton) {
                clearSearchButton.addEventListener('click', function() {
                    searchInput.value = '';
                    currentSearch = '';
                    // Redirigir directamente en lugar de asignar y esperar el siguiente evento
                    window.location.href = '{{ route('admin.doctors.index') }}';
                });
            }

        });
    </script>
</x-app-layout>
