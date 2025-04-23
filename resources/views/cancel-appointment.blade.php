<x-app-layout>
    <x-rrss />

    <!-- Sección de cancelación -->
    <div class="location-section max-w-7xl mx-auto py-12 px-6 sm:px-8">
        <!-- Contenedor del formulario con márgenes -->
        <div class="relative z-10 max-w-md mx-auto px-4 sm:px-0 my-8">
            <div class="bg-white bg-opacity-90 p-6 rounded-lg shadow-lg">
                <!-- Contenido del formulario -->
                <form action="{{ route('appointments.cancel.confirm', $appointment->token) }}" method="POST"
                    class="space-y-4" data-container="modal">
                    @csrf
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Cancelar Cita:</h2>

                    <!-- Información de la cita -->
                    <div class="space-y-4">
                        <p><strong>Paciente:</strong> {{ $appointment->patient->name }}
                            {{ $appointment->patient->surnames }}</p>
                        <p><strong>Fecha:</strong>
                            {{ date('d/m/Y', strtotime($appointment->timeSlot->availableHour->availableDate->date)) }}
                        </p>
                        <p><strong>Hora de la cita:</strong>
                            {{ date('H:i', strtotime($appointment->timeSlot->start_time)) }}</p>
                        <p><strong>Lugar:</strong> Hospital San Rafael</p>
                        <p><strong>Dirección:</strong> Calle San Juan de Dios, 19, centro, 18001 Granada</p>
                    </div>

                    <button type="submit"
                        class="delete-button w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md">
                        Cancelar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <x-footer />
</x-app-layout>
