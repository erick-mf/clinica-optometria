<x-app-layout>

    <div class="py-4 sm:py-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 sm:p-6 text-gray-900">
                    <div
                        class="mb-4 sm:mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                        <h1 class="text-lg font-bold sm:text-2xl">Listado de Horarios</h1>
                        <a href="{{ route('admin.schedules.create') }}"
                            class="bg-gray-800 hover:bg-gray-700 text-white py-2 px-4 rounded-md transition duration-150 ease-in-out w-full sm:w-auto text-center flex items-center justify-center text-sm sm:text-base">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Nuevo Horario
                        </a>
                    </div>

                    <x-search-box placeholder="Buscar horarios" />

                    <div id="noSearchResults" class="hidden bg-gray-50 rounded-lg p-3 sm:p-4 text-center mb-4 sm:mb-6">
                        <p class="text-gray-600 text-sm sm:text-base">No se encontraron horarios con ese criterio de
                            búsqueda.</p>
                    </div>

                    @if ($schedules->isEmpty())
                        <div class="bg-gray-50 rounded-lg p-4 sm:p-8 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-10 w-10 sm:h-12 sm:w-12 mx-auto text-gray-400 mb-3 sm:mb-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <line x1="8" y1="2" x2="8" y2="6" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <line x1="16" y1="2" x2="16" y2="6" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <line x1="3" y1="10" x2="21" y2="10" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="text-gray-600 text-sm sm:text-lg mb-3 sm:mb-4">No hay horarios registrados.</p>
                            <a href="{{ route('admin.schedules.create') }}"
                                class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium text-sm sm:text-base">
                                <span>Agregar tu primer horario</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 ml-1"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    @else
                        <!-- Vista para móviles (card-based) -->
                        <div class="sm:hidden space-y-3 mb-4">
                            @foreach ($schedules as $schedule)
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-3">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="font-semibold text-gray-900">{{ $schedule->day }}</span>
                                        <x-actions-buttons-mobile :editAction="route('admin.schedules.edit', $schedule)" :deleteAction="route('admin.schedules.destroy', $schedule)" />
                                    </div>
                                    <div class="grid grid-cols-2 gap-2 text-sm">
                                        <div>
                                            <span class="text-gray-500">Fecha:</span>
                                            <p class="text-gray-900">{{ $schedule->date }}</p>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Horario:</span>
                                            <p class="text-gray-900">{{ $schedule->start_time }} -
                                                {{ $schedule->end_time }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Vista para tablet/desktop (table-based) -->
                        <div class="hidden sm:block overflow-x-auto bg-white rounded-lg shadow">
                            <table id="table" class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Día</th>
                                        <th scope="col"
                                            class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Fecha</th>
                                        <th scope="col"
                                            class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Inicio</th>
                                        <th scope="col"
                                            class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Fin</th>
                                        <th scope="col"
                                            class="px-2 sm:px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="schedulesTableBody">
                                    @foreach ($schedules as $schedule)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                            <td class="px-2 sm:px-4 py-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $schedule->day }}
                                                </div>
                                            </td>
                                            <td class="px-2 sm:px-4 py-3">
                                                <div class="text-sm text-gray-900">{{ $schedule->date }}</div>
                                            </td>
                                            <td class="px-2 sm:px-4 py-3">
                                                <div class="text-sm text-gray-900">{{ $schedule->start_time }}</div>
                                            </td>
                                            <td class="px-2 sm:px-4 py-3">
                                                <div class="text-sm text-gray-900">{{ $schedule->end_time }}</div>
                                            </td>
                                            <td class="px-2 sm:px-4 py-3 text-sm text-center">
                                                <x-actions-buttons :editAction="route('admin.schedules.edit', $schedule)" :deleteAction="route('admin.schedules.destroy', $schedule)" />
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id="noVisibleResults"
                            class="hidden mt-4 sm:mt-6 bg-gray-50 rounded-lg p-3 sm:p-4 text-center">
                            <p class="text-gray-600 text-sm sm:text-base">No hay horarios visibles con los filtros
                                actuales.</p>
                        </div>
                        <div class="mt-4 sm:mt-6" id="paginate">
                            <x-custom-pagination :paginator="$schedules" />
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
            const searchInput = document.getElementById('searchSchedule');
            const tableRows = document.querySelectorAll('#schedulesTableBody tr');
            const mobileCards = document.querySelectorAll('.sm\\:hidden > div');
            const noSearchResults = document.getElementById('noSearchResults');
            const noVisibleResults = document.getElementById('noVisibleResults');
            const paginateSection = document.getElementById('paginate');

            // Función de búsqueda que funciona tanto para tablas como para tarjetas
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                let visibleItems = 0;

                // Para vista móvil (tarjetas)
                mobileCards.forEach(card => {
                    const cardText = card.textContent.toLowerCase();
                    if (cardText.includes(searchTerm)) {
                        card.classList.remove('hidden');
                        visibleItems++;
                    } else {
                        card.classList.add('hidden');
                    }
                });

                // Para vista desktop (tabla)
                tableRows.forEach(row => {
                    const rowText = row.textContent.toLowerCase();
                    if (rowText.includes(searchTerm)) {
                        row.classList.remove('hidden');
                    } else {
                        row.classList.add('hidden');
                    }
                });

                // Mostrar mensajes apropiados según los resultados
                if (visibleItems === 0 && mobileCards.length > 0) {
                    noSearchResults.classList.remove('hidden');
                    paginateSection.classList.add('hidden');
                } else {
                    noSearchResults.classList.add('hidden');
                    paginateSection.classList.remove('hidden');
                }
            });

        });
    </script>
</x-app-layout>
