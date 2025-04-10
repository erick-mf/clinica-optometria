<x-app-layout>
    <div class="py-6 sm:py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                <div class="p-4 sm:p-8 text-gray-900">

                    <!-- Título y Acciones -->
                    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <h1 class="text-xl font-bold sm:text-2xl text-gray-800 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" style="color: #157564;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Listado de Pacientes
                        </h1>

                        <div class="flex flex-wrap gap-3 w-full sm:w-auto">
                            <a href="{{ route('admin.patients.create') }}"
                                class="bg-teal-700 hover:bg-teal-800 text-white py-2 px-4 rounded-lg transition duration-150 ease-in-out
                                w-full sm:w-auto text-center flex items-center justify-center text-sm sm:text-base"
                                style="background-color: #157564;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-2"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Nuevo Paciente
                            </a>
                        </div>
                    </div>

                    <!-- Mensaje de Sin Resultados -->
                    @if ($patients->isEmpty())
                        <div class="bg-gradient-to-br from-gray-50 to-teal-50 rounded-lg p-8 sm:p-12 text-center border border-gray-200 shadow-sm"
                            style="background: linear-gradient(to bottom right, #f9fafb, rgba(21, 117, 100, 0.1));">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-6 opacity-80"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: #157564;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">No hay pacientes registrados</h3>
                            <p class="text-gray-600 mb-6">Comienza agregando tu primer paciente al sistema</p>
                        </div>
                    @else
                        <!-- Buscador -->
                        <div class="mb-5 relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: #9ca3af;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" id="searchPatient"
                                placeholder="Buscar por nombre, apellido o email..."
                                class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring focus:ring-teal-500 focus:border-teal-600 text-sm sm:text-base">
                        </div>

                        <!-- Mensaje de no resultados para búsqueda -->
                        <div id="noSearchResults"
                            class="hidden bg-gray-50 rounded-lg p-3 sm:p-4 text-center mb-4 sm:mb-6">
                            <p class="text-gray-600 text-sm sm:text-base">No se encontraron pacientes con ese criterio
                                de búsqueda.</p>
                        </div>

                        <!-- Vista para Móviles (Tarjetas) -->
                        <div class="sm:hidden space-y-4 mb-6">
                            @foreach ($patients as $patient)
                                <div
                                    class="bg-white border border-gray-200 rounded-lg shadow-sm p-5 hover:shadow-md transition-shadow duration-200 relative overflow-hidden patient-card">

                                    <div class="flex justify-between items-center mb-4">
                                        <span class="font-semibold text-lg text-gray-900 flex items-center">
                                            {{ ucfirst($patient->name) }} {{ ucfirst($patient->surnames) }}
                                        </span>
                                    </div>

                                    <div class="space-y-2 mb-4">
                                        <span class="text-gray-600 text-sm flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" style="color: #157564;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            {{ $patient->email }}
                                        </span>
                                        <span class="text-gray-600 text-sm flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" style="color: #157564;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            {{ $patient->phone }}
                                        </span>
                                        <span class="text-gray-600 text-sm flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" style="color: #157564;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                            </svg>
                                            {{ $patient->dni }}
                                        </span>
                                    </div>

                                    <div class="flex space-x-2 pt-3 border-t border-gray-100">
                                        <a href="{{ route('admin.patients.edit', $patient) }}"
                                            class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-teal-50 text-teal-700 hover:bg-teal-100 font-medium rounded-lg transition-colors duration-200"
                                            style="background-color: rgba(21, 117, 100, 0.1); color: #157564;">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Editar
                                        </a>

                                        <!-- Botón eliminar -->
                                        <button type="button"
                                            class="delete-button-mobile flex-1 inline-flex justify-center items-center px-4 py-2 bg-red-100 text-red-700 hover:bg-red-200 font-medium rounded-lg transition-colors duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Eliminar
                                        </button>
                                        <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST"
                                            class="delete-form hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Vista para Tablets/Desktop (Tabla) -->
                        <div
                            class="hidden sm:block overflow-hidden bg-white rounded-xl shadow-sm border border-gray-100">
                            <table id="table" class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-gray-50 to-teal-50"
                                    style="background: linear-gradient(to right, #f9fafb, rgba(21, 117, 100, 0.1));">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nombre
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Apellidos
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Email
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Teléfono
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            DNI
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200" id="patientsTableBody">
                                    @foreach ($patients as $patient)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                {{ ucfirst($patient->name) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                {{ ucfirst($patient->surnames) }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 truncate max-w-xs">
                                                {{ $patient->email }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                {{ $patient->phone }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                {{ $patient->dni }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="flex justify-center space-x-2">
                                                    <a href="{{ route('admin.patients.edit', $patient) }}"
                                                        class="inline-flex items-center px-3 py-1.5 bg-teal-50 text-teal-700 hover:bg-teal-100 font-medium rounded-lg transition-colors duration-200"
                                                        style="background-color: rgba(21, 117, 100, 0.1); color: #157564;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                        Editar
                                                    </a>

                                                    <button type="button"
                                                        class="delete-button-mobile inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 font-medium rounded-lg transition-colors duration-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Eliminar
                                                    </button>
                                                    <form action="{{ route('admin.patients.destroy', $patient) }}"
                                                        method="POST" class="delete-form hidden">
                                                        @csrf
                                                        @method('DELETE')
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

                        <!-- Paginación -->
                        <div class="mt-6" id="paginate">
                            <x-custom-pagination :paginator="$patients" />
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación mejorado -->
    <x-delete-modal title="Confirmar eliminación"
        content="¿Estás seguro que deseas eliminar este paciente? Esta acción no se puede deshacer." />

</x-app-layout>
