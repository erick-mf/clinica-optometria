<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Patientes') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-4 sm:py-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 sm:p-6 text-gray-900">
                    <!-- Encabezado -->
                    <div
                        class="mb-4 sm:mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                        <h1 class="text-lg font-bold sm:text-2xl">Listado de Pacientes</h1>
                        <a href="{{ route('admin.patients.create') }}"
                            class="bg-gray-800 hover:bg-gray-700 text-white py-2 px-4 rounded-md transition duration-150 ease-in-out
                            w-full sm:w-auto text-center flex items-center justify-center text-sm sm:text-base">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Nuevo Paciente
                        </a>
                    </div>


                    @if ($patients->isEmpty())
                        <div class="bg-gray-50 rounded-lg p-4 sm:p-8 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-10 w-10 sm:h-12 sm:w-12 mx-auto text-gray-400 mb-3 sm:mb-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            <p class="text-gray-600 text-sm sm:text-lg mb-3 sm:mb-4">No hay pacientes registrados.</p>
                            <a href="{{ route('admin.patients.create') }}"
                                class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium text-sm sm:text-base">
                                <span>Agregar tu primer paciente</span>
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
                            <input type="text" id="searchPatient"
                                placeholder="Buscar por nombre, apellido o email..."
                                class="w-full pl-10 pr-4 py-2 rounded-md border border-gray-300 focus:ring focus:ring-gray-300 focus:border-gray-300 text-sm sm:text-base">
                        </div>

                        <!-- Mensaje de no resultados para búsqueda -->
                        <div id="noSearchResults"
                            class="hidden bg-gray-50 rounded-lg p-3 sm:p-4 text-center mb-4 sm:mb-6">
                            <p class="text-gray-600 text-sm sm:text-base">No se encontraron pacientes con ese criterio
                                de
                                búsqueda.</p>
                        </div>

                        <!-- Vista para móviles (card-based) -->
                        <div class="md:hidden space-y-3 mb-4">
                            @foreach ($patients as $patient)
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-3" data-patient-card>
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="font-semibold text-gray-900">{{ $patient->name }}
                                                {{ $patient->surnames }}</h3>
                                            <p class="text-xs text-gray-500 mt-1">{{ $patient->email }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $patient->phone }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $patient->dni }}</p>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('admin.patients.edit', $patient) }}"
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
                                            <form action="{{ route('admin.patients.destroy', $patient) }}"
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
                        <div id="table" class="hidden md:block overflow-x-auto bg-white rounded-lg shadow">
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
                                            class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            DNI
                                        </th>
                                        <th scope="col"
                                            class="px-3 sm:px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="patientsTableBody">
                                    @foreach ($patients as $patient)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                            <td class="px-3 sm:px-4 py-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $patient->name }}
                                                </div>
                                            </td>
                                            <td class="px-3 sm:px-4 py-3">
                                                <div class="text-sm text-gray-900">{{ $patient->surnames }}</div>
                                            </td>
                                            <td class="px-3 sm:px-4 py-3">
                                                <div class="text-sm text-gray-900 truncate max-w-xs">
                                                    {{ $patient->email }}</div>
                                            </td>
                                            <td class="px-3 sm:px-4 py-3">
                                                <div class="text-sm text-gray-900">{{ $patient->phone }}</div>
                                            </td>
                                            <td class="px-3 sm:px-4 py-3">
                                                <div class="text-sm text-gray-900">{{ $patient->dni }}</div>
                                            </td>
                                            <td class="px-3 sm:px-4 py-3 text-sm text-center">
                                                <div class="flex justify-center items-center space-x-3">
                                                    <a href="{{ route('admin.patients.edit', $patient) }}"
                                                        class="text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200 flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                        <span>Editar</span>
                                                    </a>
                                                    <form action="{{ route('admin.patients.destroy', $patient) }}"
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

                        <!-- Mensaje cuando no hay resultados visibles -->
                        <div id="noVisibleResults"
                            class="hidden mt-4 sm:mt-6 bg-gray-50 rounded-lg p-3 sm:p-4 text-center">
                            <p class="text-gray-600 text-sm sm:text-base">No hay pacientes visibles con los filtros
                                actuales.</p>
                        </div>

                        <div class="mt-4 sm:mt-6" id="paginate">
                            <x-custom-pagination :paginator="$patients" />
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación de eliminación -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg w-11/12 max-w-md mx-auto p-4 sm:p-6 shadow-xl">
            <div class="text-center">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-10 w-10 sm:h-12 sm:w-12 text-red-500 mx-auto mb-3 sm:mb-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Confirmar eliminación</h3>
                <p class="text-gray-600 mb-4 sm:mb-6 text-sm sm:text-base">¿Estás seguro que deseas eliminar este
                    paciente? Esta acción no se puede
                    deshacer.</p>
                <div class="flex justify-center space-x-3 sm:space-x-4">
                    <button id="cancelDelete"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-3 sm:px-4 rounded text-sm sm:text-base transition-colors duration-200">
                        Cancelar
                    </button>
                    <button id="confirmDelete"
                        class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-3 sm:px-4 rounded text-sm sm:text-base transition-colors duration-200">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchPatient');
            const tableRows = document.querySelectorAll('#patientsTableBody tr');
            const patientCards = document.querySelectorAll('[data-patient-card]');
            const noSearchResults = document.getElementById('noSearchResults');
            const noVisibleResults = document.getElementById('noVisibleResults');
            const deleteModal = document.getElementById('deleteModal');
            const cancelDelete = document.getElementById('cancelDelete');
            const confirmDelete = document.getElementById('confirmDelete');
            const tableSection = document.getElementById("table");
            const paginateSection = document.getElementById("paginate");
            let currentForm = null;
            let isMobile = window.innerWidth < 768;

            // Actualizar variable isMobile en resize
            window.addEventListener('resize', function() {
                isMobile = window.innerWidth < 768;
            });

            // Función mejorada de búsqueda para ambas vistas
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                let visibleCount = 0;

                // Búsqueda en tarjetas móviles
                patientCards.forEach(card => {
                    const cardText = card.textContent.toLowerCase();
                    if (cardText.includes(searchTerm)) {
                        card.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        card.classList.add('hidden');
                    }
                });

                // Búsqueda en filas de tabla
                tableRows.forEach(row => {
                    const rowText = row.textContent.toLowerCase();
                    if (rowText.includes(searchTerm)) {
                        row.classList.remove('hidden');
                    } else {
                        row.classList.add('hidden');
                    }
                });

                // Mostrar mensaje cuando no hay resultados
                if (visibleCount === 0 && patientCards.length > 0 && searchTerm !== '') {
                    noSearchResults.classList.remove('hidden');
                    noVisibleResults.classList.add('hidden');
                    paginateSection.classList.add('hidden');
                } else if (visibleCount === 0 && patientCards.length > 0) {
                    noSearchResults.classList.add('hidden');
                    noVisibleResults.classList.remove('hidden');
                    paginateSection.classList.add('hidden');
                } else {
                    noSearchResults.classList.add('hidden');
                    noVisibleResults.classList.add('hidden');
                    paginateSection.classList.remove('hidden');
                }
            });

            // Configurar los botones de eliminar para mostrar el modal (vista desktop)
            document.querySelectorAll('.delete-button').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    currentForm = this.closest('.delete-form');
                    deleteModal.classList.remove('hidden');
                    deleteModal.classList.add('flex');
                });
            });

            // Configurar los botones de eliminar para móvil
            document.querySelectorAll('.delete-button-mobile').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    currentForm = this.closest('div').querySelector('.delete-form-mobile');
                    deleteModal.classList.remove('hidden');
                    deleteModal.classList.add('flex');
                });
            });

            // Cancelar eliminación
            cancelDelete.addEventListener('click', function() {
                deleteModal.classList.add('hidden');
                deleteModal.classList.remove('flex');
                currentForm = null;
            });

            // Confirmar eliminación
            confirmDelete.addEventListener('click', function() {
                if (currentForm) {
                    currentForm.submit();
                }
            });

            // Cerrar modal al hacer clic fuera
            deleteModal.addEventListener('click', function(e) {
                if (e.target === deleteModal) {
                    deleteModal.classList.add('hidden');
                    deleteModal.classList.remove('flex');
                    currentForm = null;
                }
            });
        });
    </script>
</x-app-layout>
