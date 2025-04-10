<x-app-layout>
    <div class="py-6 sm:py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                <div class="p-4 sm:p-8 text-gray-900">

                    <!-- Título y Acciones -->
                    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <h1 class="text-xl font-bold sm:text-2xl text-gray-800 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Listado de Citas
                        </h1>

                        <div class="flex flex-wrap gap-3 w-full sm:w-auto">
                            <x-add-button action="{{ route('admin.appointments.create') }}" text="Nueva Cita" />
                        </div>
                    </div>

                    <!-- Mensaje de Sin Resultados -->
                    @if ($appointments->isEmpty())
                        <div class="bg-gradient-to-br from-gray-50 to-teal-50 rounded-lg p-8 sm:p-12 text-center border border-gray-200 shadow-sm m-6"
                            style="background: linear-gradient(to bottom right, #f9fafb, rgba(21, 117, 100, 0.1));">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-6 opacity-80"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: #157564;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">No hay citas programadas</h3>
                            <p class="text-gray-600">Puedes programar citas para tus pacientes.</p>
                        </div>
                    @else
                        <!-- Vista para Móviles (Tarjetas) -->
                        <div class="sm:hidden space-y-4 mb-6">
                            @foreach ($appointments as $appointment)
                                <div
                                    class="bg-white border border-gray-200 rounded-lg shadow-sm p-5 hover:shadow-md transition-shadow duration-200 relative overflow-hidden">
                                    <div class="flex justify-between items-center mb-4">
                                        <span class="font-semibold text-lg text-gray-900 flex items-center">
                                            {{ ucfirst($appointment->patient->name) }}
                                            {{ ucfirst($appointment->patient->surnames) }}
                                        </span>
                                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                            {{ $appointment->type === 'normal' ? 'Normal' : 'Revisión' }}
                                        </span>
                                    </div>

                                    <div class="space-y-2 mb-4">
                                        <div class="text-gray-600 text-sm flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-teal-600"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ \Carbon\Carbon::parse($appointment->timeSlot->availableHour->availableDate->date)->format('d/m/Y') }}
                                        </div>
                                        <div class="text-gray-600 text-sm flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-teal-600"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            Prof. {{ ucfirst($appointment->user->surnames) }}
                                        </div>
                                        <div class="text-gray-600 text-sm flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-teal-600"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $appointment->timeSlot->start_time }} -
                                            {{ $appointment->timeSlot->end_time }}
                                        </div>
                                    </div>

                                    <!-- Versión mejorada de la vista móvil con botones -->
                                    <div class="flex flex-col pt-3 border-t border-gray-100 gap-2">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.appointments.show', $appointment) }}"
                                                class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-teal-50 text-teal-700 hover:bg-teal-100 font-medium rounded-lg transition-colors duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Ver más
                                            </a>

                                            <a href="{{ route('admin.appointments.edit', $appointment) }}"
                                                class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-blue-50 text-blue-700 hover:bg-blue-100 font-medium rounded-lg transition-colors duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                                Editar
                                            </a>
                                        </div>

                                        <button type="button"
                                            class="delete-button-mobile w-full inline-flex justify-center items-center px-3 py-2 bg-red-100 text-red-700 hover:bg-red-200 font-medium rounded-lg transition-colors duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Eliminar
                                        </button>
                                        <form action="{{ route('admin.appointments.destroy', $appointment->id) }}"
                                            method="POST" class="delete-form hidden">
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
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-gray-50 to-teal-50">
                                    <tr>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Paciente</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Doctor</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Fecha</th>
                                        <th
                                            class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($appointments as $appointment)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ ucfirst($appointment->patient->name) }}
                                                    {{ ucfirst($appointment->patient->surnames) }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">Prof.
                                                    {{ ucfirst($appointment->user->surnames) }}</div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ \Carbon\Carbon::parse($appointment->timeSlot->availableHour->availableDate->date)->format('d/m/Y') }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                                <div class="flex justify-center space-x-2">
                                                    <a href="{{ route('admin.appointments.show', $appointment) }}"
                                                        class="inline-flex items-center px-3 py-1.5 bg-teal-50 text-teal-700 hover:bg-teal-100 font-medium rounded-lg transition-colors duration-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                        Ver más
                                                    </a>

                                                    <a href="{{ route('admin.appointments.edit', $appointment) }}"
                                                        class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 font-medium rounded-lg transition-colors duration-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
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
                                                    <form
                                                        action="{{ route('admin.appointments.destroy', $appointment) }}"
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
                            <x-custom-pagination :paginator="$appointments" />
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación -->
    <x-delete-modal title="Confirmar eliminación"
        content="¿Estás seguro que deseas eliminar esta cita? Esta acción no se puede deshacer." />

</x-app-layout>
