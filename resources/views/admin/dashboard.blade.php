<x-app-layout>
    <div class="py-6 sm:py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Encabezado -->
            <div class="mb-6 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-700" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" style="color: #157564;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Panel de Administración</h1>
            </div>

            <!-- Tarjetas de Acceso Rápido -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6 mb-6 md:mb-8">
                <!-- Gestionar Doctores -->
                <a href="{{ route('admin.doctors.index') }}"
                    class="block p-4 sm:p-6 bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-start gap-4">
                        <div class="rounded-full p-3 flex-shrink-0" style="background-color: rgba(21, 117, 100, 0.1);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" style="color: #157564;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">Profesionales</h2>
                            <p class="text-sm text-gray-600">Administra perfiles de los profesionales</p>
                        </div>
                    </div>
                </a>

                <!-- Gestionar Pacientes -->
                <a href="{{ route('admin.patients.index') }}"
                    class="block p-4 sm:p-6 bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-start gap-4">
                        <div class="rounded-full p-3 flex-shrink-0" style="background-color: rgba(21, 117, 100, 0.1);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" style="color: #157564;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">Pacientes</h2>
                            <p class="text-sm text-gray-600">Gestiona historiales</p>
                        </div>
                    </div>
                </a>

                <!-- Gestionar Horarios -->
                <a href="{{ route('admin.schedules.index') }}"
                    class="block p-4 sm:p-6 bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-start gap-4">
                        <div class="rounded-full p-3 flex-shrink-0" style="background-color: rgba(21, 117, 100, 0.1);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" style="color: #157564;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">Horarios</h2>
                            <p class="text-sm text-gray-600">Configura disponibilidad</p>
                        </div>
                    </div>
                </a>

                <!-- Gestionar Citas -->
                <a href="{{ route('admin.appointments.index') }}"
                    class="block p-4 sm:p-6 bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-start gap-4">
                        <div class="rounded-full p-3 flex-shrink-0" style="background-color: rgba(21, 117, 100, 0.1);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" style="color: #157564;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">Citas</h2>
                            <p class="text-sm text-gray-600">Administra consultas</p>
                        </div>
                    </div>
                </a>

                <!-- Gestionar Espacios/Clínicas -->
                <a href="{{ route('admin.offices.index') }}"
                    class="block p-4 sm:p-6 bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-start gap-4">
                        <div class="rounded-full p-3 flex-shrink-0" style="background-color: rgba(21, 117, 100, 0.1);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" style="color: #157564;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">Espacios</h2>
                            <p class="text-sm text-gray-600">Administra clínicas y consultorios</p>
                        </div>
                    </div>
                </a>

                <!-- Gestionar Reservas de Espacios -->
                <a href="#"
                    class="block p-4 sm:p-6 bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-start gap-4">
                        <div class="rounded-full p-3 flex-shrink-0" style="background-color: rgba(21, 117, 100, 0.1);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" style="color: #157564;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">Reservas</h2>
                            <p class="text-sm text-gray-600">Gestiona reserva de espacios</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Sección de Citas de Hoy -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                <div class="bg-gradient-to-r from-gray-50 to-teal-50 px-6 py-4 border-b border-gray-200 flex items-center justify-between"
                    style="background: linear-gradient(to right, #f9fafb, rgba(21, 117, 100, 0.1));">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-700" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" style="color: #157564;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h3 class="font-semibold text-lg text-gray-800">Próximas Citas</h3>
                    </div>
                </div>

                @if ($appointments->count() == 0)
                    <div class="bg-gradient-to-br from-gray-50 to-teal-50 rounded-lg p-8 sm:p-12 text-center border border-gray-200 shadow-sm m-6"
                        style="background: linear-gradient(to bottom right, #f9fafb, rgba(21, 117, 100, 0.1));">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-6 opacity-80"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: #157564;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">No hay citas programadas para hoy</h3>
                        <p class="text-gray-600">Todas las citas programadas aparecerán aquí</p>
                    </div>
                @else
                    <!-- Vista móvil: Tarjetas para cada cita -->
                    <div class="sm:hidden space-y-4 p-4">
                        @foreach ($appointments as $appointment)
                            <div
                                class="bg-white border border-gray-200 rounded-lg shadow-sm p-5 hover:shadow-md transition-shadow duration-200 relative overflow-hidden">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="font-semibold text-lg text-gray-900 flex items-center">
                                        {{ $appointment->timeSlot->start_time }} -
                                        {{ $appointment->timeSlot->end_time }}
                                    </span>
                                    <span class="text-xs px-2 py-1 rounded-full font-medium"
                                        style="background-color: rgba(21, 117, 100, 0.1); color: #157564;">
                                        {{ ucfirst($appointment->type) }}
                                    </span>
                                </div>
                                <div class="space-y-2 mb-4">
                                    <span class="text-gray-600 text-sm flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" style="color: #157564;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($appointment->timeSlot->availableHour->availableDate->date)->format('d/m/Y') }}
                                    </span>
                                    <span class="text-gray-600 text-sm flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" style="color: #157564;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        {{ ucfirst($appointment->patient->name) }}
                                        {{ ucfirst($appointment->patient->surnames) }}
                                    </span>
                                    <span class="text-gray-600 text-sm flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" style="color: #157564;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Prof. {{ ucfirst($appointment->user->name) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Vista tablet/desktop: Tabla tradicional -->
                    <div class="hidden sm:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-50 to-teal-50"
                                style="background: linear-gradient(to right, #f9fafb, rgba(21, 117, 100, 0.1));">
                                <tr>
                                    <th scope="col"
                                        class="px-4 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Hora
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fecha
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Paciente
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Profesional
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tipo de cita
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($appointments as $appointment)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $appointment->timeSlot->start_time }} -
                                            {{ $appointment->timeSlot->end_time }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ \Carbon\Carbon::parse($appointment->timeSlot->availableHour->availableDate->date)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ ucfirst($appointment->patient->name) }}
                                            {{ ucfirst($appointment->patient->surnames) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ ucfirst($appointment->user->surnames) }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full"
                                                style="background-color: rgba(21, 117, 100, 0.1); color: #157564;">
                                                {{ ucfirst($appointment->type) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
