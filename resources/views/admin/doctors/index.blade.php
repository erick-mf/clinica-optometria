<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Doctores') }}
                </h2>
                </div>
                </x-slot>

                <div class="py-6 sm:py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                <!-- Encabezado responsivo mejorado -->
                <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h1 class="text-xl font-bold sm:text-2xl">Listado de Doctores</h1>
                <a href="{{ route('admin.doctors.create') }}"
                class="bg-gray-800 hover:bg-gray-700 text-white py-2 px-4 rounded-md transition duration-150 ease-in-out
                w-full sm:w-auto text-center flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Nuevo Doctor
                </a>
                </div>

                <!-- Buscador responsivo mejorado -->
                <div class="mb-6 relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                </div>
                <input type="text" id="searchDoctor" placeholder="Buscar por nombre, apellido o email..."
                class="w-full pl-10 pr-4 py-2 rounded-md border border-gray-300 focus:ring focus:ring-gray-300 focus:border-gray-300">
                </div>

                <!-- Mensaje de no resultados para búsqueda -->
                <div id="noSearchResults" class="hidden bg-gray-50 rounded-lg p-4 text-center mb-6">
                <p class="text-gray-600">No se encontraron doctores con ese criterio de búsqueda.</p>
                </div>

                @if ($doctors->isEmpty())
                <div class="bg-gray-50 rounded-lg p-6 sm:p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                <p class="text-gray-600 text-base sm:text-lg mb-4">No hay doctores registrados.</p>
                <a href="{{ route('admin.doctors.create') }}"
                class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                <span>Agregar tu primer doctor</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
                </a>
                </div>
                @else
                <!-- Tabla responsiva mejorada -->
                <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                <th scope="col"
                class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Nombre
                </th>
                <th scope="col"
                class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                Apellidos
                </th>
                <th scope="col"
                class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                Email
                </th>
                <th scope="col"
                class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                Teléfono
                </th>
                <th scope="col"
                class="px-4 sm:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                Acciones
                </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="doctorsTableBody">
                @foreach ($doctors as $doctor)
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                <td class="px-4 sm:px-6 py-4">
                <div class="text-sm font-medium text-gray-900">
                {{ $doctor->name }}
                    <!-- Mostrar apellido en móvil -->
                <span class="sm:hidden block text-gray-600">
                {{ $doctor->surnames }}
                    </span>
                </div>
                <!-- Mostrar email y teléfono en móvil -->
                <div class="md:hidden block mt-1">
                <div class="text-xs text-gray-500 truncate">
                {{ $doctor->email }}
                    </div>
                <div class="text-xs text-gray-500 mt-1">
                {{ $doctor->phone }}
                    </div>
                </div>
                </td>
                <td class="px-4 sm:px-6 py-4 hidden sm:table-cell">
                <div class="text-sm text-gray-900">{{ $doctor->surnames }}</div>
                </td>
                <td class="px-4 sm:px-6 py-4 hidden md:table-cell">
                <div class="text-sm text-gray-900 truncate max-w-xs">{{ $doctor->email }}</div>
                </td>
                <td class="px-4 sm:px-6 py-4 hidden md:table-cell">
                <div class="text-sm text-gray-900">{{ $doctor->phone }}</div>
                    </td>
                <td class="px-4 sm:px-6 py-4 text-sm text-center">
                <div class="flex justify-center items-center space-x-3">
                <a href="{{ route('admin.doctors.edit', $doctor) }}"
                class="text-indigo-600 hover:text-indigo-900 font-medium transition-colors duration-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span class="hidden sm:inline">Editar</span>
                </a>
                <form action="{{ route('admin.doctors.destroy', $doctor) }}"
                                                method="POST" class="inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="text-red-600 hover:text-red-900 font-medium transition-colors duration-200 flex items-center delete-button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    <span class="hidden sm:inline">Eliminar</span>
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
                    <div id="noVisibleResults" class="hidden mt-6 bg-gray-50 rounded-lg p-4 text-center">
                        <p class="text-gray-600">No hay doctores visibles con los filtros actuales.</p>
                    </div>

                    <div class="mt-6">
                        <x-custom-pagination :paginator="$doctors" />
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación de eliminación -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg max-w-md mx-auto p-6 shadow-xl">
            <div class="text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Confirmar eliminación</h3>
                <p class="text-gray-600 mb-6">¿Estás seguro que deseas eliminar este doctor? Esta acción no se puede deshacer.</p>
                <div class="flex justify-center space-x-4">
                    <button id="cancelDelete" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded transition-colors duration-200">
                        Cancelar
                    </button>
                    <button id="confirmDelete" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded transition-colors duration-200">
                        Sí, eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchDoctor');
        const tableRows = document.querySelectorAll('#doctorsTableBody tr');
        const noSearchResults = document.getElementById('noSearchResults');
        const noVisibleResults = document.getElementById('noVisibleResults');
        const deleteModal = document.getElementById('deleteModal');
        const cancelDelete = document.getElementById('cancelDelete');
        const confirmDelete = document.getElementById('confirmDelete');
        let currentForm = null;

        // Función mejorada de búsqueda
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            let visibleCount = 0;

            tableRows.forEach(row => {
                // Obtener texto completo de la fila para búsqueda
                const rowText = row.textContent.toLowerCase();
                const hasMatch = rowText.includes(searchTerm);

                if (hasMatch) {
                    row.classList.remove('hidden');
                    visibleCount++;
                } else {
                    row.classList.add('hidden');
                }
            });

            // Mostrar mensaje cuando no hay resultados
            if (visibleCount === 0 && searchTerm !== '') {
                noSearchResults.classList.remove('hidden');
                noVisibleResults.classList.add('hidden');
            } else if (visibleCount === 0) {
                noSearchResults.classList.add('hidden');
                noVisibleResults.classList.remove('hidden');
            } else {
                noSearchResults.classList.add('hidden');
                noVisibleResults.classList.add('hidden');
            }
        });

        // Configurar los botones de eliminar para mostrar el modal
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                currentForm = this.closest('.delete-form');
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
