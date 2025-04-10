@props([
    'appointment' => null,
    'patients',
    'doctors',
    'timeSlots',
    'action',
    'isEdit' => false,
])

<form action="{{ $action }}" method="POST" class="space-y-6">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

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
                <label for="user_id" class="block text-sm font-medium text-gray-700">Doctor *</label>
                <select id="user_id" name="user_id"
                    class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="" disabled selected>Selecciona el doctor</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}"
                            {{ $appointment && $appointment->user_id == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->name }} {{ $doctor->surnames }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Horario -->
            <div>
                <label for="time_slot_id" class="block text-sm font-medium text-gray-700">Horario *</label>
                <select id="time_slot_id" name="time_slot_id"
                    class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="" disabled selected>Selecciona el horario</option>
                    @foreach ($timeSlots as $timeSlot)
                        <option value="{{ $timeSlot->id }}"
                            {{ $appointment && $appointment->time_slot_id == $timeSlot->id ? 'selected' : '' }}>
                            {{ $timeSlot->date }} ({{ $timeSlot->start_time }} - {{ $timeSlot->end_time }})
                        </option>
                    @endforeach
                </select>
                @error('time_slot_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tipo de cita -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700">Tipo de Cita *</label>
                <select id="type" name="type"
                    class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="" disabled selected>Selecciona el tipo de cita</option>
                    <option value="normal" {{ $appointment && $appointment->type == 'normal' ? 'selected' : '' }}>
                        Normal</option>
                    <option value="revision" {{ $appointment && $appointment->type == 'revision' ? 'selected' : '' }}>
                        Revisión</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Detalles de la cita -->
            <div class="sm:col-span-2">
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
        <a href="{{ route('admin.appointments.index') }}"
            class="w-full sm:w-auto px-4 py-2 text-center border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-150 ease-in-out">
            Cancelar
        </a>
        <button type="submit"
            class="w-full sm:w-auto px-4 py-2 text-center text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition-colors duration-150 ease-in-out">
            {{ $isEdit ? 'Guardar cambios' : 'Crear cita' }}
        </button>
    </div>
</form>
