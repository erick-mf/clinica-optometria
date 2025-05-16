<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    <div class="flex justify-between items-start mb-6">
                        <h1 class="text-xl font-bold sm:text-2xl">Detalles de la Cita</h1>

                        @if (auth() && auth()->user()->role == 'admin')
                            <x-back-link :url="route('admin.appointments.index')" />
                        @else
                            <x-back-link :url="route('appointments.index')" />
                        @endif
                    </div>

                    <!-- Información principal -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <!-- Tarjeta Paciente -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <div class="flex items-center mb-4">
                                <div class="bg-teal-100 p-3 rounded-full mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold">Paciente</h3>
                            </div>
                            <div class="space-y-2">
                                <p class="text-sm text-gray-500">Nombre completo:</p>
                                <p class="font-medium">{{ ucfirst($appointment->patient->name) }}
                                    {{ ucfirst($appointment->patient->surnames) }}</p>

                                <p class="text-sm text-gray-500">{{ $appointment->patient->document_type }}:</p>
                                <p class="font-medium">{{ $appointment->patient->document_number ?? 'No especificado' }}
                                </p>

                                <p class="text-sm text-gray-500">Teléfono:</p>
                                <p class="font-medium">{{ $appointment->patient->phone ?? 'No especificado' }}</p>
                            </div>
                        </div>

                        <!-- Tarjeta Cita -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <div class="flex items-center mb-4">
                                <div class="bg-purple-100 p-3 rounded-full mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold">Cita</h3>
                            </div>
                            <div class="space-y-2">
                                <p class="text-sm text-gray-500">Fecha:</p>
                                <p class="font-medium">
                                    {{ \Carbon\Carbon::parse($appointment->timeSlot->availableHour->availableDate->date)->format('d/m/Y') }}
                                </p>

                                <p class="text-sm text-gray-500">Horario:</p>
                                <p class="font-medium">{{ $appointment->timeSlot->start_time }} -
                                    {{ $appointment->timeSlot->end_time }}</p>

                                <p class="text-sm text-gray-500">Tipo:</p>
                                <p class="font-medium">
                                    <span
                                        class="px-2 py-1 rounded-full {{ $appointment->type === 'Primera cita' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                        {{ ucfirst($appointment->type) }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- Tarjeta Doctor -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <div class="flex items-center mb-4">
                                <div class="bg-blue-100 p-3 rounded-full mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold">Profesional</h3>
                            </div>
                            <div class="space-y-2">
                                <p class="text-sm text-gray-500">Nombre:</p>
                                <p class="font-medium">Prof. {{ ucfirst($appointment->user->surnames) }}</p>

                                <p class="text-sm text-gray-500">Especialidad:</p>
                                <p class="font-medium">{{ 'General' }}</p>

                                <p class="text-sm text-gray-500">Consultorio:</p>
                                <p class="font-medium">
                                    {{ $appointment->user->office->abbreviation ?? 'No especificado' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Detalles adicionales -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm mb-6">
                        <h3 class="text-lg font-semibold mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Detalles Adicionales
                        </h3>
                        <div class="prose max-w-none h-auto overflow-y-auto break-words">
                            {!! $appointment->details
                                ? nl2br(e($appointment->details))
                                : '<p class="text-gray-500">No hay detalles adicionales</p>' !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
