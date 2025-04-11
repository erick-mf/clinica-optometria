@props(['appointment' => null, 'patients', 'doctor', 'schedules', 'action', 'isEdit' => false])

<form action="{{ $action }}" method="POST" class="space-y-6">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <!-- Datos personales -->
    <div class="bg-gray-50 p-4 sm:p-6 rounded-lg space-y-6">
        <h2 class="text-lg font-medium text-gray-900 border-b pb-2">Datos de la cita</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
            <!-- Paciente -->
            <div>
                <label for="patient_id" class="block text-sm font-medium text-gray-700">Paciente *</label>
                <select id="patient_id" name="patient_id"
                    class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="" disabled selected>Selecciona el paciente</option>
                    @foreach ($patients as $patient)
                        <option value="{{ $patient->id }}"
                            {{ $appointment && $appointment->patient_id == $patient->id ? 'selected' : '' }}>
                            {{ $patient->name }} {{ $patient->surnames }}
                        </option>
                    @endforeach
                </select>
                @error('patient_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Doctor -->
            <div>
                <input type="hidden" name="doctor_id" id="doctor_id" value="{{ $doctor }}">
            </div>

            <!-- Horario -->
            <div>
                <label for="schedule_id" class="block text-sm font-medium text-gray-700">Horario *</label>
                <select id="schedule_id" name="schedule_id"
                    class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="" disabled selected>Selecciona el horario</option>
                    @foreach ($schedules as $schedule)
                        <option value="{{ $schedule->id }}"
                            {{ $appointment && $appointment->schedule_id == $schedule->id ? 'selected' : '' }}>
                            {{ $schedule->date }} ({{ $schedule->start_time }} - {{ $schedule->end_time }})
                        </option>
                    @endforeach
                </select>
                @error('schedule_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tipo de cita -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700">Tipo de Cita *</label>
                <select id="type" name="type"
                    class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="" disabled selected>Selecciona el tipo de cita</option>
                    <option value="primera cita"
                        {{ $appointment && $appointment->type == 'primera cita' ? 'selected' : '' }}>Primera Cita
                    </option>
                    <option value="revision" {{ $appointment && $appointment->type == 'revision' ? 'selected' : '' }}>
                        Revisión</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Detalles de la cita -->
            <div>
                <label for="details" class="block text-sm font-medium text-gray-700">Detalles de la Cita</label>
                <textarea id="details" name="details" rows="4"
                    class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Escribe los detalles de la cita aquí...">{{ old('details', $appointment ? $appointment->details : '') }}</textarea>
                @error('details')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Botones de acción -->
    <div class="flex flex-col sm:flex-row items-center justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-4">
        <a href="{{ route('appointments.index') }}"
            class="w-full sm:w-auto px-4 py-2 text-center border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-150 ease-in-out">
            Cancelar
        </a>
        <button type="submit"
            class="w-full sm:w-auto px-4 py-2 text-center text-white bg-gray-800 rounded-md hover:bg-gray-700 transition-colors duration-150 ease-in-out">
            {{ $isEdit ? 'Guardar cambios' : 'Crear cita' }}
        </button>
    </div>
</form>
