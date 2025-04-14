<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Pacientes') }}
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
                                placeholder="Buscar por nombre, apellido, DNI, teléfono o email..."
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
                        <div class="md:hidden space-y-3 mb-4" id="patientsListMobile">
                            @foreach ($patients as $patient)
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 patient-card"
                                    data-patient-card>
                                    <div class="mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900 patient-name">
                                            {{ $patient->name }} {{ $patient->surnames }}</h3>
                                    </div>
                                    <div class="mb-2">
                                        <p class="text-sm text-gray-900 patient-email">
                                            <strong>Email:</strong> {{ $patient->email }}
                                        </p>
                                        <p class="text-sm text-gray-900 patient-phone">
                                            <strong>Teléfono:</strong> {{ $patient->phone }}
                                        </p>
                                        <p class="text-sm text-gray-900 patient-dni">
                                            <strong>DNI:</strong> {{ $patient->dni }}
                                        </p>
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
                                            Nombre
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
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="patientsTableBody">
                                    @foreach ($patients as $patient)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200 patient-row"
                                            data-patient-row>
                                            <td class="px-3 sm:px-4 py-3">
                                                <div class="text-sm font-medium text-gray-900 patient-name">
                                                    {{ $patient->name }} {{ $patient->surnames }}
                                                </div>
                                            </td>
                                            <td class="px-3 sm:px-4 py-3">
                                                <div class="text-sm text-gray-500 patient-email">
                                                    {{ $patient->email }}
                                                </div>
                                            </td>
                                            <td class="px-3 sm:px-4 py-3">
                                                <div class="text-sm text-gray-500 patient-phone">
                                                    {{ $patient->phone }}
                                                </div>
                                            </td>
                                            <td class="px-3 sm:px-4 py-3">
                                                <div class="text-sm text-gray-500 patient-dni">
                                                    {{ $patient->dni }}
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
                            {{ $patients->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
