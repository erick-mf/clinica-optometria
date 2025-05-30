<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Información de la Clínica') }}
            </h2>
            <x-back-link :url="route('admin.dashboard')" />
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <h1 class="text-xl font-bold sm:text-2xl text-gray-800 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#157564]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Configuración Actual de la Clínica
                        </h1>

                        <div class="flex flex-wrap gap-3 w-full sm:w-auto">
                            <a href="{{ route('admin.clinic-info.configure') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md shadow-sm text-white bg-[#157564] hover:bg-opacity-80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157564]">
                                Configurar Información
                            </a>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Dirección Actual -->
                        <div>
                            <h3 class="text-lg sm:text-xl font-medium text-gray-900 mb-2">Nuestra Dirección</h3>
                            @if ($direction && !empty($direction->direction) && $direction->direction !== 'No configurada')
                                <div class="bg-gray-50 p-4 rounded-md shadow">
                                    <p class="text-sm sm:text-base text-gray-700">{{ $direction->direction }}</p>
                                </div>
                            @else
                                <div class="bg-gray-50 p-4 rounded-md shadow">
                                    <p class="text-sm sm:text-base text-gray-500 italic">No hay dirección configurada.
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Períodos de Atención (Rangos de Meses) -->
                        <div>
                            <h3 class="text-lg sm:text-xl font-medium text-gray-900 mb-2">Periodos de Atención <span
                                    class="text-sm text-gray-500 font-normal">(Rangos de Meses de Operación)</span></h3>
                            @if (!empty($attentionMonthRanges))
                                <div class="bg-gray-50 p-4 rounded-md shadow space-y-2">
                                    @foreach ($attentionMonthRanges as $range)
                                        <p class="text-sm sm:text-base text-gray-700">
                                            <span
                                                class="font-medium">{{ $monthsTranslation[$range['start_month']] ?? 'Mes Inválido' }}</span>
                                            @if ($range['start_month'] != $range['end_month'])
                                                - <span
                                                    class="font-medium">{{ $monthsTranslation[$range['end_month']] ?? 'Mes Inválido' }}</span>
                                            @endif
                                        </p>
                                    @endforeach
                                </div>
                            @else
                                <div class="bg-gray-50 p-4 rounded-md shadow">
                                    <p class="text-sm sm:text-base text-gray-500 italic">No hay periodos de atención
                                        configurados.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Horarios (Patrones de Días y Turnos) -->
                        <div>
                            <h3 class="text-lg sm:text-xl font-medium text-gray-900 mb-2">Horarios <span
                                    class="text-sm text-gray-500 font-normal">(Patrones de Días y Turnos
                                    Aplicables)</span></h3>
                            @if (!empty($operatingHourPatterns))
                                <div class="bg-gray-50 p-4 rounded-md shadow space-y-3">
                                    @foreach ($operatingHourPatterns as $pattern)
                                        <div
                                            class="pb-2 mb-2 @if (!$loop->last) border-b border-gray-200 @endif">
                                            @if (!empty($pattern['active_days']))
                                                <p class="text-sm sm:text-base text-gray-800 font-semibold mb-1">
                                                    @php
                                                        $formattedDays = array_map(function ($dayKey) use (
                                                            $daysTranslation,
                                                        ) {
                                                            return $daysTranslation[$dayKey] ?? ucfirst($dayKey);
                                                        }, $pattern['active_days']);
                                                    @endphp
                                                    {{ implode(', ', $formattedDays) }}:
                                                </p>
                                            @else
                                                <p class="text-sm sm:text-base text-gray-500 italic mb-1">Días no
                                                    especificados para este patrón.</p>
                                            @endif

                                            @if (!empty($pattern['time_slots']))
                                                <ul class="list-disc list-inside ml-4 space-y-1">
                                                    @foreach ($pattern['time_slots'] as $slot)
                                                        <li class="text-sm sm:text-base text-gray-600">
                                                            {{ \Carbon\Carbon::parse($slot['start_time'])->format('H:i') }}
                                                            -
                                                            {{ \Carbon\Carbon::parse($slot['end_time'])->format('H:i') }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p class="text-sm sm:text-base text-gray-500 italic ml-4">No hay turnos
                                                    definidos para estos días.</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="bg-gray-50 p-4 rounded-md shadow">
                                    <p class="text-sm sm:text-base text-gray-500 italic">No hay patrones de horarios
                                        configurados.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
