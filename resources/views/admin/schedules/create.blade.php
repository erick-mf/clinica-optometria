<x-app-layout>
    <!-- Elemento para pasar datos de PHP a JavaScript -->
    <div id="app-data" data-disabled-dates="{{ json_encode($disabledDates ?? []) }}"
        data-doctors="{{ json_encode($doctors ?? []) }}" style="display: none;"></div>

    <div class="py-6 sm:py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                <div class="p-4 sm:p-8 text-gray-900">
                    <!-- Título -->
                    <div class="mb-6">
                        <h1 class="text-xl font-bold sm:text-2xl text-gray-800 flex items-center gap-2 justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" style="color: #157564;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6l4 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Configuración de Horarios
                        </h1>
                    </div>

                    <form method="POST" action="{{ route('admin.schedules.store') }}">
                        @csrf
                        <!-- Paso 1: Seleccionar rango de fechas -->
                        <div class="mb-8">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                <span
                                    class="bg-teal-100 text-teal-800 rounded-full w-6 h-6 flex items-center justify-center text-sm">1</span>
                                Selecciona el rango de fechas
                            </h2>
                            <div class="grid md:grid-cols-2 gap-4 sm:gap-6">
                                <div>
                                    <label for="start_date_picker"
                                        class="block text-sm font-medium text-gray-700 mb-1">Fecha inicial</label>
                                    <input type="text" id="start_date_picker"
                                        class="w-full px-3 sm:px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                        required placeholder="Selecciona fecha">
                                    <input type="hidden" name="start_date" id="start_date">
                                    <p class="text-xs text-gray-500 mt-1">Primer día donde aplicarán los horarios</p>
                                </div>
                                <div>
                                    <label for="end_date_picker"
                                        class="block text-sm font-medium text-gray-700 mb-1">Fecha final</label>
                                    <input type="text" id="end_date_picker"
                                        class="w-full px-3 sm:px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                        required placeholder="Selecciona fecha">
                                    <input type="hidden" name="end_date" id="end_date">
                                    <p class="text-xs text-gray-500 mt-1">Último día donde aplicarán los horarios</p>
                                </div>
                            </div>
                        </div>

                        <!-- Paso 2: Seleccionar días de la semana -->
                        <div class="mb-8">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                <span
                                    class="bg-teal-100 text-teal-800 rounded-full w-6 h-6 flex items-center justify-center text-sm">2</span>
                                Selecciona los días de la semana
                            </h2>
                            <div class="grid grid-cols-3 xs:grid-cols-4 sm:grid-cols-7 gap-2">
                                @foreach ([['id' => 'day-1', 'value' => 1, 'short' => 'L', 'long' => 'Lun'], ['id' => 'day-2', 'value' => 2, 'short' => 'M', 'long' => 'Mar'], ['id' => 'day-3', 'value' => 3, 'short' => 'M', 'long' => 'Mié'], ['id' => 'day-4', 'value' => 4, 'short' => 'J', 'long' => 'Jue'], ['id' => 'day-5', 'value' => 5, 'short' => 'V', 'long' => 'Vie'], ['id' => 'day-6', 'value' => 6, 'short' => 'S', 'long' => 'Sáb'], ['id' => 'day-0', 'value' => 0, 'short' => 'D', 'long' => 'Dom']] as $day)
                                    <div class="day-selector">
                                        <input type="checkbox" id="{{ $day['id'] }}" name="days[]"
                                            value="{{ $day['value'] }}" class="hidden day-checkbox peer">
                                        <label for="{{ $day['id'] }}"
                                            class="flex flex-col items-center p-2 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-teal-500 peer-checked:bg-teal-50 peer-checked:text-teal-700 hover:bg-gray-50 transition-colors">
                                            <span class="text-sm font-medium">{{ $day['short'] }}</span>
                                            <span class="text-xs">{{ $day['long'] }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Paso 3: Configurar turnos -->
                        <div class="mb-8">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                <span
                                    class="bg-teal-100 text-teal-800 rounded-full w-6 h-6 flex items-center justify-center text-sm">3</span>
                                Define los turnos y los profesional que atenderán los horarios
                            </h2>
                            <div id="turns-wrapper" class="space-y-4 mb-4">
                                <!-- Turno base -->
                                <div class="turn-group flex flex-col gap-4 p-4 border border-gray-200 rounded-lg">
                                    <div class="grid sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Hora inicio</label>
                                            <input type="time" name="turns[0][start]"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                required>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-700 mb-1">Hora fin</label>
                                            <input type="time" name="turns[0][end]"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                                required>
                                        </div>
                                    </div>

                                    <!-- Selector múltiple de doctores -->
                                    <div>
                                        <label class="block text-sm text-gray-700 mb-1">Profesionales para este
                                            turno (tienen que tener un espacio asignado)</label>
                                        <div
                                            class="space-y-2 max-h-60 overflow-y-auto p-2 border border-gray-200 rounded-lg doctors-container">
                                            @foreach ($doctors as $doctor)
                                                <div class="flex items-center">
                                                    <input type="checkbox" id="turn-0-doctor-{{ $doctor->id }}"
                                                        name="turns[0][doctors][]" value="{{ $doctor->id }}"
                                                        class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
                                                    <label for="turn-0-doctor-{{ $doctor->id }}"
                                                        class="ml-2 text-sm text-gray-700">
                                                        {{ $doctor->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Selecciona uno o varios profesionales</p>
                                    </div>

                                    <button type="button"
                                        class="remove-turn w-full sm:w-auto px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors">
                                        Eliminar turno
                                    </button>
                                </div>
                            </div>
                            <button type="button" id="add-turn"
                                class="w-full sm:w-auto px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                                + Añadir otro turno
                            </button>
                            <p class="text-sm text-gray-600 mt-2">Estos horarios se aplicarán a cada uno de los días
                                seleccionados</p>
                        </div>

                        <!-- Paso 4: Duración de citas -->
                        <div class="mb-8">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                <span
                                    class="bg-teal-100 text-teal-800 rounded-full w-6 h-6 flex items-center justify-center text-sm">4</span>
                                Duración de las citas
                            </h2>
                            <input type="number" id="interval_minutes" name="interval_minutes" min="1"
                                value="30"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                required>
                            <p class="text-sm text-gray-600 mt-2">Duración de las citas en minutos</p>
                        </div>

                        <!-- Botones de acción -->
                        <div
                            class="flex flex-col sm:flex-row items-center justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-4">
                            <a href="{{ route('admin.schedules.index') }}"
                                class="w-full sm:w-auto px-4 py-2 text-center border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-150">
                                Cancelar
                            </a>
                            <x-primary-button>Guardar Horarios</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
