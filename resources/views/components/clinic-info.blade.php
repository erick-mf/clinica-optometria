<div
    class="bg-gray-50 rounded-xl p-8 shadow-sm border border-gray-100 transform transition-all duration-300 hover:shadow-2xl sm:max-h-[31.5rem]">
    <div class="space-y-6">
        <div>
            <h3 class="text-2xl font-semibold text-gray-900 mb-3">Nuestra Dirección</h3>
            @if (!empty($address) && $address !== 'No configurada')
                <p class="text-gray-700 leading-relaxed text-base">
                    <svg class="w-5 h-5 inline-block mr-2 text-[#157564]" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    {{ $address }}
                </p>
            @else
                <p class="text-gray-500 italic leading-relaxed text-base">
                    <svg class="w-5 h-5 inline-block mr-2 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Dirección no disponible.
                </p>
            @endif
        </div>

        <div class="grid grid-cols-1 gap-x-8 gap-y-6">
            <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#157564]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    Periodos de atención
                </h4>
                @if (!empty($attentionMonthRanges))
                    <ul class="space-y-2 text-gray-700 text-base">
                        @foreach ($attentionMonthRanges as $range)
                            <li class="flex items-start">
                                <span
                                    class="inline-block flex-shrink-0 w-2 h-2 rounded-full bg-[#157564] mt-[0.4rem] mr-2.5"></span>
                                <span>
                                    {{ $monthsTranslation[$range['start_month']] ?? 'Mes' }}
                                    @if (isset($range['end_month']) && $range['start_month'] != $range['end_month'])
                                        - {{ $monthsTranslation[$range['end_month']] ?? 'Mes' }}
                                    @endif
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 italic text-base">No hay periodos de atención definidos.</p>
                @endif
            </div>

            <div class="sm:overflow-hidden">
                <h4 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#157564]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Horarios
                </h4>
                @if (!empty($operatingHourPatterns))
                    <div
                        class="max-h-40 sm:max-h-48 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                        <div class="space-y-3 sm:grid sm:grid-cols-2 sm:gap-4 sm:space-y-0 text-gray-700 text-base">
                            @foreach ($operatingHourPatterns as $pattern)
                                <div class="pattern-item">
                                    <div class="flex items-start">
                                        <span
                                            class="inline-block flex-shrink-0 w-2 h-2 rounded-full bg-[#157564] mt-[0.4rem] mr-2.5"></span>
                                        <span>
                                            @if (!empty($pattern['active_days']))
                                                @php
                                                    $formattedDays = array_map(function ($dayKey) use (
                                                        $daysTranslation,
                                                    ) {
                                                        return $daysTranslation[$dayKey] ?? ucfirst($dayKey);
                                                    }, (array) $pattern['active_days']);
                                                @endphp
                                                {{ implode(', ', $formattedDays) }}:
                                            @else
                                                Horario general:
                                            @endif
                                        </span>
                                    </div>

                                    @if (!empty($pattern['time_slots']))
                                        <ul class="list-none pl-7 mt-1 space-y-1">
                                            @foreach ($pattern['time_slots'] as $slot)
                                                <li class="text-gray-600">
                                                    {{ \Carbon\Carbon::parse($slot['start_time'])->format('H:i') }} -
                                                    {{ \Carbon\Carbon::parse($slot['end_time'])->format('H:i') }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <p class="text-gray-500 italic text-base">No hay horarios definidos.</p>
                @endif
            </div>
        </div>
    </div>
</div>
