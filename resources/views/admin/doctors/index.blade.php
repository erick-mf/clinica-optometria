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
                                        <x-actions-buttons-mobile :editAction="route('admin.doctors.edit', $doctor)" :deleteAction="route('admin.doctors.destroy', $doctor)" />
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
                                                <x-actions-buttons :editAction="route('admin.doctors.edit', $doctor)" :deleteAction="route('admin.doctors.destroy', $doctor)" />
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
</x-app-layout>
