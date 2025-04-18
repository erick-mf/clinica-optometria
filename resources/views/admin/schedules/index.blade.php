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
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Horarios Configurados
                        </h1>

                        <div class="flex flex-wrap gap-3 w-full sm:w-auto">
                            <x-add-button action="{{ route('admin.schedules.create') }}" text="Agregar Horario"
                                class="w-full sm:w-auto" />

                            <x-delete-button action="{{ route('admin.schedules.destroyAll') }}"
                                text="Eliminar Horarios" />
                        </div>
                    </div>

                    <!-- Stats Card - Resumen -->
                    @if (!$schedules->isEmpty())
                        <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">

                            <div
                                class="bg-gradient-to-br from-teal-50 to-teal-100 rounded-xl p-4 border border-teal-200 shadow-sm">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-full bg-teal-100 mr-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Próxima fecha</p>
                                        <p class="text-xl font-bold text-gray-800">
                                            {{ $nextDate }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Mensaje de Sin Resultados -->
                    @if ($schedules->isEmpty())
                        <div class="bg-gradient-to-br from-gray-50 to-teal-50 rounded-lg p-8 sm:p-12 text-center border border-gray-200 shadow-sm"
                            style="background: linear-gradient(to bottom right, #f9fafb, rgba(21, 117, 100, 0.1));">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-6 opacity-80"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: #157564;">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <line x1="8" y1="2" x2="8" y2="6" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <line x1="16" y1="2" x2="16" y2="6" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <line x1="3" y1="10" x2="21" y2="10" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">No hay horarios registrados</h3>
                            <p class="text-gray-600 mb-6">Comienza configurando tu primer horario para las citas</p>
                        </div>
                    @else
                        <!-- Filtrar fechas con turnos -->
                        @php
                            $filteredSchedules = $schedules->filter(function ($date) {
                                return $date->hours->isNotEmpty();
                            });
                        @endphp

                        @if ($filteredSchedules->isEmpty())
                            <div class="bg-gradient-to-br from-gray-50 to-teal-50 rounded-lg p-8 sm:p-12 text-center border border-gray-200 shadow-sm"
                                style="background: linear-gradient(to bottom right, #f9fafb, rgba(21, 117, 100, 0.1));">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-6 opacity-80"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: #157564;">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <line x1="8" y1="2" x2="8" y2="6" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <line x1="16" y1="2" x2="16" y2="6" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <line x1="3" y1="10" x2="21" y2="10"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">No hay fechas con turnos
                                    configurados</h3>
                                <p class="text-gray-600 mb-6">Las fechas existen pero no tienen turnos asignados</p>
                                <x-add-button action="{{ route('admin.schedules.create') }}"
                                    text="Configurar Turnos" />
                            </div>
                        @else
                            <!-- Filtro  -->
                            <div class="mb-6 flex flex-col sm:flex-row gap-4">
                                <div class="flex gap-2">
                                    <select id="filterMonth"
                                        class="rounded-lg border border-gray-300 px-8 py-2.5 focurs:outline-none w-full">
                                        <option value="">Todos los meses</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">
                                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <!-- Vista para Móviles (Tarjetas) -->
                            <div class="sm:hidden space-y-4 mb-6">
                                @foreach ($filteredSchedules as $date)
                                    <div
                                        class="bg-white border border-gray-200 rounded-lg shadow-sm p-5 hover:shadow-md transition-shadow duration-200 relative overflow-hidden schedule-card">
                                        <!-- Indicador de día de la semana -->
                                        <div class="absolute top-0 right-0 bg-teal-700 text-white px-3 py-1 font-bold rounded-bl-lg"
                                            style="background-color: #157564;">
                                            {{ \Carbon\Carbon::parse($date->date)->translatedFormat('l') }}
                                        </div>

                                        <div class="flex justify-between items-center mb-4">
                                            <span class="font-semibold text-lg text-gray-900 flex items-center">
                                                {{ \Carbon\Carbon::parse($date->date)->format('d/m/Y') }}
                                            </span>
                                        </div>

                                        <div class="mb-4">
                                            <span
                                                class="text-gray-600 text-sm font-medium mb-2 block flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4 mr-1.5 text-teal-700" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor"
                                                    style="color: #157564;">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Turnos disponibles ({{ $date->hours->count() }}):
                                            </span>
                                            <div class="flex flex-wrap gap-2 mt-2">
                                                @foreach ($date->hours as $hour)
                                                    <span
                                                        class="inline-block px-3 py-1.5 bg-teal-50 text-teal-700 text-xs font-medium rounded-full whitespace-nowrap"
                                                        style="background-color: rgba(21, 117, 100, 0.1); color: #157564;">
                                                        {{ \Carbon\Carbon::parse($hour->start_time)->format('H:i') }} -
                                                        {{ \Carbon\Carbon::parse($hour->end_time)->format('H:i') }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="flex space-x-2 pt-3 border-t border-gray-100">
                                            <a href="{{ route('admin.schedules.edit', $date) }}"
                                                class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-teal-50 text-teal-700 hover:bg-teal-100 font-medium rounded-lg transition-colors duration-200"
                                                style="background-color: rgba(21, 117, 100, 0.1); color: #157564;">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Editar
                                            </a>

                                            <!-- Botón eliminar -->
                                            <button type="button"
                                                class="delete-button-mobile flex-1 inline-flex justify-center items-center px-4 py-2 bg-red-100 text-red-700 hover:bg-red-200 font-medium rounded-lg transition-colors duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Eliminar
                                            </button>
                                            <form action="{{ route('admin.schedules.destroy', $date->id) }}"
                                                method="POST" class="delete-form-mobile hidden">
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
                                                Fecha
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Día
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Turnos Disponibles
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Acciones
                                            </th>
                                        </tr>
                                    </thead>

                                    @foreach ($filteredSchedules as $date)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200 schedule-row">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    {{ \Carbon\Carbon::parse($date->date)->format('d/m/Y') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2.5 py-1">
                                                    {{ \Carbon\Carbon::parse($date->date)->translatedFormat('l') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex flex-wrap gap-2 max-w-md">
                                                    @foreach ($date->hours as $hour)
                                                        <span
                                                            class="inline-block px-3 py-1.5 bg-teal-50 text-teal-700 text-xs font-medium rounded-full whitespace-nowrap"
                                                            style="background-color: rgba(21, 117, 100, 0.1); color: #157564;">
                                                            {{ \Carbon\Carbon::parse($hour->start_time)->format('H:i') }}
                                                            -
                                                            {{ \Carbon\Carbon::parse($hour->end_time)->format('H:i') }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="flex justify-center space-x-2">
                                                    <a href="{{ route('admin.schedules.edit', $date) }}"
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
                                                    <form action="{{ route('admin.schedules.destroy', $date->id) }}"
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

                            <!-- Paginación -->
                            <div class="mt-6" id="paginate">
                                <x-custom-pagination :paginator="$schedules" />
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación mejorado -->
    <x-delete-modal title="Confirmar eliminación"
        content="¿Estás seguro que deseas eliminar este horario? Esta acción no se puede deshacer y eliminará todos los turnos y citas asociados." />

</x-app-layout>
