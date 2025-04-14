<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Citas') }}
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
                        <h1 class="text-lg font-bold sm:text-2xl">Listado de Citas</h1>
                        <a href="{{ route('appointments.create') }}"
                            class="bg-gray-800 hover:bg-gray-700 text-white py-2 px-4 rounded-md transition duration-150 ease-in-out
                            w-full sm:w-auto text-center flex items-center justify-center text-sm sm:text-base">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Nueva Cita
                        </a>
                    </div>
                    @if ($appointments->isEmpty())
                        <div class="bg-gray-50 rounded-lg p-4 sm:p-8 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-10 w-10 sm:h-12 sm:w-12 mx-auto text-gray-400 mb-3 sm:mb-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            <p class="text-gray-600 text-sm sm:text-lg mb-3 sm:mb-4">No hay citas registradas.</p>
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
                            <input type="text" id="searchAppointment"
                                placeholder="Buscar por nombre, apellido o email..."
                                class="w-full pl-10 pr-4 py-2 rounded-md border border-gray-300 focus:ring focus:ring-gray-300 focus:border-gray-300 text-sm sm:text-base">
                        </div>

                        <!-- Mensaje de no resultados para búsqueda -->
                        <div id="noSearchResults"
                            class="hidden bg-gray-50 rounded-lg p-3 sm:p-4 text-center mb-4 sm:mb-6">
                            <p class="text-gray-600 text-sm sm:text-base">No se encontraron citas con ese criterio de
                                búsqueda.</p>
                        </div>

                        <!-- Vista para móviles (card-based) -->
                        <div class="md:hidden space-y-3 mb-4">
                            @foreach ($appointments as $appointment)
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4"
                                    data-appointment-card>
                                    <!-- Paciente -->
                                    <div class="mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            {{ $appointment->patient->name }} {{ $appointment->patient->surnames }}</h3>
                                    </div>

                                    <!-- Fecha y Hora -->
                                    <div class="mb-2">
                                        <p class="text-sm text-gray-900">
                                            <strong>Fecha:</strong>
                                            {{ $appointment->timeSlot->availableHour->availableDate->date }}
                                        </p>
                                        <p class="text-sm text-gray-900">
                                            <strong>Hora:</strong> {{ $appointment->timeSlot->start_time }} -
                                            {{ $appointment->timeSlot->end_time }}
                                        </p>
                                    </div>

                                    <!-- Tipo de cita -->
                                    <div class="mb-2">
                                        <p class="text-sm text-gray-900">
                                            <strong>Tipo:</strong> {{ ucfirst($appointment->type) }}
                                        </p>
                                    </div>

                                    <!-- Detalles -->
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-900">
                                            <strong>Detalles:</strong> {{ $appointment->details ?? 'Sin detalles' }}
                                        </p>
                                    </div>

                                    <!-- Acciones -->
                                    <div class="flex justify-between items-center">
                                        <a href="{{ route('admin.appointments.show', $appointment) }}"
                                            class="text-green-600 hover:text-green-800 font-medium transition-colors duration-200 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12h.01M12 15h.01M9 12h.01M12 9h.01M21 12c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 8-8 8 3.582 8 8z" />
                                            </svg>
                                            <span>Ver Detalles</span>
                                        </a>
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('admin.appointments.edit', $appointment) }}"
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
                                            <form action="{{ route('admin.appointments.destroy', $appointment) }}"
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
                                            class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Fecha
                                        </th>
                                        <th scope="col"
                                            class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Paciente
                                        </th>
                                        <th scope="col"
                                            class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tipo
                                        </th>
                                        <th scope="col"
                                            class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Detalles
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="appointmentsTableBody">
                                    @foreach ($appointments as $appointment)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                            <!-- Fecha de la cita -->
                                            <td class="px-3 sm:px-4 py-3">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $appointment->timeSlot->availableHour->availableDate->date }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($appointment->timeSlot->start_time)->format('H:i') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($appointment->timeSlot->end_time)->format('H:i') }}
                                                    | {{ $appointment->timeSlot->availableHour->availableDate->date }}
                                                </div>
                                            </td>

                                            <!-- Paciente -->
                                            <td class="px-3 sm:px-4 py-3">
                                                <div class="text-sm font-medium text-gray-500">
                                                    {{ $appointment->patient->name }}
                                                    {{ $appointment->patient->surnames }}
                                                </div>
                                            </td>

                                            <!-- Tipo de cita -->
                                            <td class="px-3 sm:px-4 py-3">
                                                <div class="text-sm text-gray-900">
                                                    {{ ucfirst($appointment->type) }}
                                                </div>
                                            </td>

                                            <!-- Ver Detalles -->
                                            <td class="px-3 sm:px-4 py-3 text-sm text-center">
                                                <a href="{{ route('appointments.show', $appointment) }}"
                                                    class="text-green-600 hover:text-green-800 font-medium transition-colors duration-200 flex items-center">
                                                    <span>Ver Detalles</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mensaje cuando no hay resultados visibles -->
                        <div id="noVisibleResults"
                            class="hidden mt-4 sm:mt-6 bg-gray-50 rounded-lg p-3 sm:p-4 text-center">
                            <p class="text-gray-600 text-sm sm:text-base">No hay citas visibles con los filtros
                                actuales.</p>
                        </div>

                        <div class="mt-4 sm:mt-6" id="paginate">
                            <x-custom-pagination :paginator="$appointments" />
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
                    cita? Esta acción no se puede
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
            const searchInput = document.getElementById('searchAppointment');
            const tableRows = document.querySelectorAll('#appointmentsTableBody tr');
            const appointmentCards = document.querySelectorAll('[data-appointment-card]');
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
                appointmentCards.forEach(card => {
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
                if (visibleCount === 0 && appointmentCards.length > 0 && searchTerm !== '') {
                    noSearchResults.classList.remove('hidden');
                    noVisibleResults.classList.add('hidden');
                    paginateSection.classList.add('hidden');
                } else if (visibleCount === 0 && appointmentCards.length > 0) {
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
