<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    <div class="flex justify-between items-start mb-6">
                        <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">
                            {{ $isEdit ? 'Editar Información de la Clínica' : 'Configurar Información de la Clínica' }}
                        </h2>
                    </div>

                    <form method="POST" action="{{ route('admin.clinic-info.save') }}">
                        @csrf
                        @if ($isEdit)
                            @method('PUT')
                        @endif

                        {{-- Dirección --}}
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg sm:text-xl font-medium leading-6 text-gray-900 mb-4">Nuestra Dirección
                            </h3>
                            <div>
                                <label for="direction"
                                    class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Dirección de la
                                    Clínica *</label>
                                <input type="text" id="direction" name="direction"
                                    value="{{ old('direction', $direction->direction ?? '') }}"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#157564] focus:border-[#157564] sm:text-sm"
                                    placeholder="Ej: Calle Principal 123, Ciudad">
                                @error('direction')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Periodos de Atención (Rangos de Meses) --}}
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg sm:text-xl font-medium leading-6 text-gray-900 mb-4">Periodos de Atención
                                <span class="text-sm text-gray-500 font-normal">(Rangos de Meses de Operación)</span>
                            </h3>
                            <div id="month-ranges-container" class="space-y-4">
                                @php
                                    $monthRangesData = old('attention_month_ranges', $attentionMonthRanges);
                                    if (
                                        $monthRangesData instanceof \Illuminate\Support\Collection &&
                                        $monthRangesData->isEmpty() &&
                                        !is_array(old('attention_month_ranges'))
                                    ) {
                                        $monthRangesData = collect([['start_month' => '', 'end_month' => '']]);
                                    } elseif (
                                        is_array($monthRangesData) &&
                                        empty($monthRangesData) &&
                                        !is_array(old('attention_month_ranges'))
                                    ) {
                                        $monthRangesData = [['start_month' => '', 'end_month' => '']];
                                    }
                                @endphp
                                @foreach ($monthRangesData as $rangeIndex => $range)
                                    <div class="month-range-row p-3 border border-gray-200 rounded-md"
                                        data-index="{{ $rangeIndex }}">
                                        <div class="grid grid-cols-1 sm:grid-cols-[1fr_1fr_auto] gap-4 items-end">
                                            <div>
                                                <label for="range_{{ $rangeIndex }}_start"
                                                    class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Mes
                                                    Inicio*</label>
                                                <select name="attention_month_ranges[{{ $rangeIndex }}][start_month]"
                                                    id="range_{{ $rangeIndex }}_start"
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#157564] focus:border-[#157564] sm:text-sm">
                                                    <option value="">Seleccione</option>
                                                    @foreach ($months as $num => $name)
                                                        <option value="{{ $num }}"
                                                            {{ ($range['start_month'] ?? null) == $num ? 'selected' : '' }}>
                                                            {{ $name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('attention_month_ranges.' . $rangeIndex . '.start_month')
                                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="range_{{ $rangeIndex }}_end"
                                                    class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Mes
                                                    Fin*</label>
                                                <select name="attention_month_ranges[{{ $rangeIndex }}][end_month]"
                                                    id="range_{{ $rangeIndex }}_end"
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#157564] focus:border-[#157564] sm:text-sm">
                                                    <option value="">Seleccione</option>
                                                    @foreach ($months as $num => $name)
                                                        <option value="{{ $num }}"
                                                            {{ ($range['end_month'] ?? null) == $num ? 'selected' : '' }}>
                                                            {{ $name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('attention_month_ranges.' . $rangeIndex . '.end_month')
                                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="remove-button-container-month-range self-end pb-1"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-month-range-button"
                                class="mt-3 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-[#157564] hover:bg-opacity-80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157564]">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Agregar Rango de Meses
                            </button>
                        </div>

                        {{-- Horarios (Patrones de Días y Turnos) --}}
                        <div class="border-b-0 pb-6">
                            <h3 class="text-lg sm:text-xl font-medium leading-6 text-gray-900 mb-4">Horarios <span
                                    class="text-sm text-gray-500 font-normal">(Patrones de Días y Turnos
                                    Aplicables)</span></h3>
                            <div id="hour-patterns-container" class="space-y-6">
                                @php
                                    $hourPatternsData = old('operating_hour_patterns', $operatingHourPatterns);
                                    if (
                                        $hourPatternsData instanceof \Illuminate\Support\Collection &&
                                        $hourPatternsData->isEmpty() &&
                                        !is_array(old('operating_hour_patterns'))
                                    ) {
                                        $hourPatternsData = collect([
                                            [
                                                'active_days' => [],
                                                'time_slots' => [['start_time' => '', 'end_time' => '']],
                                            ],
                                        ]);
                                    } elseif (
                                        is_array($hourPatternsData) &&
                                        empty($hourPatternsData) &&
                                        !is_array(old('operating_hour_patterns'))
                                    ) {
                                        $hourPatternsData = [
                                            [
                                                'active_days' => [],
                                                'time_slots' => [['start_time' => '', 'end_time' => '']],
                                            ],
                                        ];
                                    }
                                @endphp
                                @foreach ($hourPatternsData as $patternIndex => $pattern)
                                    <div class="hour-pattern-row border border-gray-300 p-4 rounded-lg shadow-md"
                                        data-pattern-index="{{ $patternIndex }}">
                                        <div class="flex justify-end mb-3 remove-button-container-hour-pattern"></div>

                                        <div class="space-y-4">
                                            <div>
                                                <h4 class="text-md sm:text-lg font-semibold text-gray-700 mb-2">Días
                                                    para este patrón:</h4>
                                                <div
                                                    class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-7 gap-2">
                                                    @foreach ($dayKeys as $dIndex => $dayKey)
                                                        @php
                                                            $patternActiveDays = $pattern['active_days'] ?? [];
                                                            if (is_string($patternActiveDays)) {
                                                                $patternActiveDays = array_map(
                                                                    'trim',
                                                                    explode(',', $patternActiveDays),
                                                                );
                                                            }
                                                            $isDayActive = in_array(
                                                                $dayKey,
                                                                (array) $patternActiveDays,
                                                            );
                                                        @endphp
                                                        <div
                                                            class="flex items-center p-2 border border-gray-200 rounded-md hover:bg-gray-50">
                                                            <input type="checkbox"
                                                                id="pattern_{{ $patternIndex }}_days_{{ $dayKey }}"
                                                                name="operating_hour_patterns[{{ $patternIndex }}][active_days][]"
                                                                value="{{ $dayKey }}"
                                                                {{ $isDayActive ? 'checked' : '' }}
                                                                class="h-4 w-4 text-[#157564] border-gray-300 rounded focus:ring-[#157564]">
                                                            <label
                                                                for="pattern_{{ $patternIndex }}_days_{{ $dayKey }}"
                                                                class="ml-2 block text-sm sm:text-base text-gray-900">{{ $daysOfWeek[$dIndex] }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @error('operating_hour_patterns.' . $patternIndex . '.active_days')
                                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <h4
                                                    class="text-md sm:text-lg font-semibold text-gray-700 mb-2 pt-3 border-t border-gray-200">
                                                    Turnos en este patrón:</h4>
                                                <div class="time-slots-container-pattern space-y-3">
                                                    @php
                                                        $timeSlots = $pattern['time_slots'] ?? [
                                                            ['start_time' => '', 'end_time' => ''],
                                                        ];
                                                        if (empty($timeSlots)) {
                                                            $timeSlots = [['start_time' => '', 'end_time' => '']];
                                                        }
                                                    @endphp
                                                    @foreach ($timeSlots as $slotIndex => $slot)
                                                        <div class="time-slot-row grid grid-cols-1 sm:grid-cols-[1fr_1fr_auto] gap-4 items-end p-3 border border-gray-200 rounded-md bg-gray-50"
                                                            data-slot-index="{{ $slotIndex }}">
                                                            <div>
                                                                <label
                                                                    for="pattern_{{ $patternIndex }}_slot_{{ $slotIndex }}_start"
                                                                    class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Hora
                                                                    Inicio Turno*</label>
                                                                <input type="time"
                                                                    name="operating_hour_patterns[{{ $patternIndex }}][time_slots][{{ $slotIndex }}][start_time]"
                                                                    id="pattern_{{ $patternIndex }}_slot_{{ $slotIndex }}_start"
                                                                    value="{{ $slot['start_time'] ?? '' }}"
                                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#157564] focus:border-[#157564] sm:text-sm">
                                                                @error('operating_hour_patterns.' . $patternIndex .
                                                                    '.time_slots.' . $slotIndex . '.start_time')
                                                                    <p class="mt-2 text-sm text-red-600">
                                                                        {{ $message }}</p>
                                                                @enderror
                                                            </div>
                                                            <div>
                                                                <label
                                                                    for="pattern_{{ $patternIndex }}_slot_{{ $slotIndex }}_end"
                                                                    class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Hora
                                                                    Fin Turno*</label>
                                                                <input type="time"
                                                                    name="operating_hour_patterns[{{ $patternIndex }}][time_slots][{{ $slotIndex }}][end_time]"
                                                                    id="pattern_{{ $patternIndex }}_slot_{{ $slotIndex }}_end"
                                                                    value="{{ $slot['end_time'] ?? '' }}"
                                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#157564] focus:border-[#157564] sm:text-sm">
                                                                @error('operating_hour_patterns.' . $patternIndex .
                                                                    '.time_slots.' . $slotIndex . '.end_time')
                                                                    <p class="mt-2 text-sm text-red-600">
                                                                        {{ $message }}</p>
                                                                @enderror
                                                            </div>
                                                            <div
                                                                class="remove-button-container-time-slot self-end pb-1">
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <button type="button"
                                                    class="add-time-slot-to-pattern-button mt-3 inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157564]">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                    </svg>
                                                    Agregar Turno
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-hour-pattern-button"
                                class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md shadow-sm text-white bg-[#157564] hover:bg-opacity-80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157564]">
                                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Agregar Patrón de Horario
                            </button>
                        </div>

                        {{-- Botones de Acción del Formulario --}}
                        <div class="pt-8 flex justify-end space-x-3">
                            <a href="{{ route('admin.clinic-info.index') }}"
                                class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm sm:text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157564]">
                                Cancelar
                            </a>
                            <x-primary-button
                                type="submit">{{ $isEdit ? 'Guardar Cambios' : 'Guardar Configuración' }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const svgIconRemove =
                `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>`;

            const monthsJs = @json($months);
            const daysOfWeekJs = @json($daysOfWeek);
            const dayKeysJs = @json($dayKeys);

            function createRemoveBtn(onClickAction, text = '') {
                const button = document.createElement('button');
                button.type = 'button';
                button.className =
                    'inline-flex items-center justify-center p-1.5 border border-transparent rounded-full shadow-sm text-red-500 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500';
                button.innerHTML = svgIconRemove + (text ? `<span class="sr-only">${text}</span>` : '');
                button.addEventListener('click', onClickAction);
                return button;
            }

            const monthRangesContainer = document.getElementById('month-ranges-container');
            let monthRangeIndex = monthRangesContainer.querySelectorAll('.month-range-row').length;

            function updateMonthRangeRemoveButtons() {
                const rows = monthRangesContainer.querySelectorAll('.month-range-row');
                rows.forEach(row => {
                    let container = row.querySelector('.remove-button-container-month-range');
                    if (!container) return;

                    let existingButton = container.querySelector('button');
                    if (rows.length > 1) {
                        if (!existingButton) {
                            container.appendChild(createRemoveBtn(() => {
                                row.remove();
                                updateMonthRangeRemoveButtons();
                            }, 'Eliminar Rango de Mes'));
                        }
                    } else if (existingButton) {
                        existingButton.remove();
                    }
                });
            }

            document.getElementById('add-month-range-button').addEventListener('click', function() {
                const index = monthRangeIndex++;
                const newRow = document.createElement('div');
                newRow.className = 'month-range-row p-3 border border-gray-200 rounded-md';
                newRow.dataset.index = index;
                let monthOptions = '<option value="">Seleccione</option>';
                Object.entries(monthsJs).forEach(([num, name]) => monthOptions +=
                    `<option value="${num}">${name}</option>`);
                newRow.innerHTML = `
            <div class="grid grid-cols-1 sm:grid-cols-[1fr_1fr_auto] gap-4 items-end">
                <div>
                    <label for="range_${index}_start" class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Mes Inicio*</label>
                    <select name="attention_month_ranges[${index}][start_month]" id="range_${index}_start" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#157564] focus:border-[#157564] sm:text-sm">${monthOptions}</select>
                </div>
                <div>
                    <label for="range_${index}_end" class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Mes Fin*</label>
                    <select name="attention_month_ranges[${index}][end_month]" id="range_${index}_end" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#157564] focus:border-[#157564] sm:text-sm">${monthOptions}</select>
                </div>
                <div class="remove-button-container-month-range self-end pb-1"></div>
            </div>`;
                monthRangesContainer.appendChild(newRow);
                updateMonthRangeRemoveButtons();
            });
            updateMonthRangeRemoveButtons();

            const hourPatternsContainer = document.getElementById('hour-patterns-container');
            let hourPatternIndex = hourPatternsContainer.querySelectorAll('.hour-pattern-row').length;

            function updateHourPatternRemoveButtons() {
                const rows = hourPatternsContainer.querySelectorAll('.hour-pattern-row');
                rows.forEach(row => {
                    let container = row.querySelector('.remove-button-container-hour-pattern');
                    if (!container) return;

                    let existingButton = container.querySelector('button');
                    if (rows.length > 1) {
                        if (!existingButton) {
                            container.appendChild(createRemoveBtn(() => {
                                row.remove();
                                updateHourPatternRemoveButtons();
                            }, 'Eliminar Patrón de Horario'));
                        }
                    } else if (existingButton) {
                        existingButton.remove();
                    }
                });
            }

            document.getElementById('add-hour-pattern-button').addEventListener('click', function() {
                const patternIdx = hourPatternIndex++;
                const newPatternRow = document.createElement('div');
                newPatternRow.className =
                    'hour-pattern-row border border-gray-300 p-4 rounded-lg shadow-md';
                newPatternRow.dataset.patternIndex = patternIdx;

                let daysHtml = dayKeysJs.map((dayKey, dIdx) => `
            <div class="flex items-center p-2 border border-gray-200 rounded-md hover:bg-gray-50">
                <input type="checkbox" id="pattern_${patternIdx}_days_${dayKey}" name="operating_hour_patterns[${patternIdx}][active_days][]" value="${dayKey}" class="h-4 w-4 text-[#157564] border-gray-300 rounded focus:ring-[#157564]">
                <label for="pattern_${patternIdx}_days_${dayKey}" class="ml-2 block text-sm sm:text-base text-gray-900">${daysOfWeekJs[dIdx]}</label>
            </div>`).join('');

                newPatternRow.innerHTML = `
            <div class="flex justify-end mb-3 remove-button-container-hour-pattern"></div>
            <div class="space-y-4">
                <div>
                    <h4 class="text-md sm:text-lg font-semibold text-gray-700 mb-2">Días para este patrón:</h4>
                    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-7 gap-2">${daysHtml}</div>
                </div>
                <div>
                    <h4 class="text-md sm:text-lg font-semibold text-gray-700 mb-2 pt-3 border-t border-gray-200">Turnos en este patrón:</h4>
                    <div class="time-slots-container-pattern space-y-3">
                        ${generateTimeSlotHtmlForPattern(patternIdx, 0)}
                    </div>
                    <button type="button" class="add-time-slot-to-pattern-button mt-3 inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157564]">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Agregar Turno
                    </button>
                </div>
            </div>
        `;
                hourPatternsContainer.appendChild(newPatternRow);
                initializeTimeSlotManagementForPattern(newPatternRow);
                updateHourPatternRemoveButtons();
            });
            updateHourPatternRemoveButtons();

            function generateTimeSlotHtmlForPattern(patternIdx, slotIdx) {
                return `
            <div class="time-slot-row grid grid-cols-1 sm:grid-cols-[1fr_1fr_auto] gap-4 items-end p-3 border border-gray-200 rounded-md bg-gray-50" data-slot-index="${slotIdx}">
                <div>
                    <label for="pattern_${patternIdx}_slot_${slotIdx}_start" class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Hora Inicio Turno*</label>
                    <input type="time" name="operating_hour_patterns[${patternIdx}][time_slots][${slotIdx}][start_time]" id="pattern_${patternIdx}_slot_${slotIdx}_start" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#157564] focus:border-[#157564] sm:text-sm">
                </div>
                <div>
                    <label for="pattern_${patternIdx}_slot_${slotIdx}_end" class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Hora Fin Turno*</label>
                    <input type="time" name="operating_hour_patterns[${patternIdx}][time_slots][${slotIdx}][end_time]" id="pattern_${patternIdx}_slot_${slotIdx}_end" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#157564] focus:border-[#157564] sm:text-sm">
                </div>
                <div class="remove-button-container-time-slot self-end pb-1"></div>
            </div>`;
            }

            function updateTimeSlotInPatternRemoveButtons(timeSlotsContainer) {
                const slotRows = timeSlotsContainer.querySelectorAll('.time-slot-row');
                slotRows.forEach(slotRow => {
                    let container = slotRow.querySelector('.remove-button-container-time-slot');
                    if (!container) return;

                    let existingButton = container.querySelector('button');
                    if (slotRows.length > 1) {
                        if (!existingButton) {
                            container.appendChild(createRemoveBtn(() => {
                                slotRow.remove();
                                updateTimeSlotInPatternRemoveButtons(timeSlotsContainer);
                            }, 'Eliminar Turno'));
                        }
                    } else if (existingButton) {
                        existingButton.remove();
                    }
                });
            }

            function initializeTimeSlotManagementForPattern(patternRowElement) {
                const timeSlotsContainer = patternRowElement.querySelector('.time-slots-container-pattern');
                const addSlotButton = patternRowElement.querySelector('.add-time-slot-to-pattern-button');
                const patternIndex = patternRowElement.dataset.patternIndex;
                let slotIndexCounter = timeSlotsContainer.querySelectorAll('.time-slot-row').length;

                addSlotButton.addEventListener('click', function() {
                    const currentSlotIndex = slotIndexCounter++;
                    timeSlotsContainer.insertAdjacentHTML('beforeend', generateTimeSlotHtmlForPattern(
                        patternIndex, currentSlotIndex));
                    updateTimeSlotInPatternRemoveButtons(timeSlotsContainer);
                });
                updateTimeSlotInPatternRemoveButtons(timeSlotsContainer);
            }

            hourPatternsContainer.querySelectorAll('.hour-pattern-row').forEach(patternRow => {
                initializeTimeSlotManagementForPattern(patternRow);
            });
        });
    </script>
</x-app-layout>
