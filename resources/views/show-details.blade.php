<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalles de la Cita') }}
            </h2>
            @if (auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ route('admin.appointments.index') }}"
                    class="text-gray-600 hover:text-gray-900 font-medium transition-colors duration-150 ease-in-out flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Volver al listado</span>
                </a>
            @else
                <a href="{{ route('appointments.index') }}"
                    class="text-gray-600 hover:text-gray-900 font-medium transition-colors duration-150 ease-in-out flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Volver al listado</span>
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    <h1 class="text-xl font-bold sm:text-2xl mb-6">Detalles de la Cita</h1>

                    <!-- Información de la cita -->
                    <div class="bg-gray-50 p-4 sm:p-6 rounded-lg space-y-6">
                        <h2 class="text-lg font-medium text-gray-900 border-b pb-2">Información de la cita</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            <!-- Fecha y Hora -->
                            <div>
                                <p class="text-sm text-gray-500">Fecha:</p>
                                <p class="text-lg font-medium text-gray-900">
                                    {{ $appointment->timeSlot->availableHour->availableDate->date }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Hora:</p>
                                <p class="text-lg font-medium text-gray-900">{{ $appointment->timeSlot->start_time }} -
                                    {{ $appointment->timeSlot->end_time }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Día:</p>
                                <p class="text-lg font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($appointment->timeSlot->availableHour->availableDate->date)->translatedFormat('l') }}
                                </p>
                            </div>

                            <!-- Paciente -->
                            <div>
                                <p class="text-sm text-gray-500">Paciente:</p>
                                <p class="text-lg font-medium text-gray-900">{{ $appointment->patient->name }}
                                    {{ $appointment->patient->surnames }}</p>
                            </div>

                            <!-- Doctor (solo si el usuario es administrador) -->
                            @if (auth()->user()->role === 'admin')
                                <div>
                                    <p class="text-sm text-gray-500">Doctor:</p>
                                    <p class="text-lg font-medium text-gray-900">{{ $appointment->user->name }}
                                        {{ $appointment->user->surnames }}</p>
                                </div>
                            @endif

                            <!-- Tipo de cita -->
                            <div>
                                <p class="text-sm text-gray-500">Tipo de Cita:</p>
                                <p class="text-lg font-medium text-gray-900">{{ ucfirst($appointment->type) }}</p>
                            </div>

                            <!-- Detalles -->
                            <div>
                                <p class="text-sm text-gray-500">Detalles:</p>
                                <p class="text-lg font-medium text-gray-900">
                                    {{ $appointment->details ?? 'Sin detalles' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
