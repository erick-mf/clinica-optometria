<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Reservar horarios personales') }}
            </h2>
            <x-back-link :url="route('dashboard')" />
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Columna del formulario -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6 text-gray-900">
                        <div class="flex justify-between items-start mb-6">
                            <h2 class="text-xl font-semibold">{{ __('Crear reserva') }}</h2>
                        </div>

                        <form method="POST" action="{{ route('reserved-times.store') }}" class="space-y-4 md:space-y-6"
                            id="reservation-form">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                            <div class="grid grid-cols-1 gap-4 sm:gap-6">
                                <!-- campo para seleccionar oficina/espacio -->
                                <div class="text-left w-full">
                                    <label for="office_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        oficina/espacio*
                                    </label>
                                    <select id="office_id" name="office_id"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                                        <option value="">seleccione una oficina o espacio</option>
                                        @foreach ($offices as $office)
                                            <option value="{{ $office->id }}"
                                                {{ old('office_id') == $office->id ? 'selected' : '' }}>
                                                {{ $office->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('office_id')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="text-left w-full">
                                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">
                                        Fecha*
                                    </label>
                                    <div class="relative">
                                        <input type="text" id="date" name="date"
                                            class="w-full px-3 py-2 pl-10 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('date')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Sección para mostrar horas reservadas -->
                                <div class="text-left w-full">
                                    <div id="reserved-hours-display"
                                        class="p-3 bg-gray-50 rounded-md min-h-10 border border-gray-200">
                                        <p class="text-sm text-gray-500">Seleccione una fecha y espacio para ver las
                                            horas
                                            reservadas</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <!-- Hora de inicio -->
                                    <div class="text-left w-full">
                                        <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">
                                            Hora de inicio*
                                        </label>
                                        <div class="relative">
                                            <input type="time" id="start_time" name="start_time"
                                                placeholder="Seleccione hora de inicio"
                                                class="time-picker w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                                        </div>
                                        @error('start_time')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Hora de fin -->
                                    <div class="text-left w-full">
                                        <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">
                                            Hora de fin*
                                        </label>
                                        <div class="relative">
                                            <input type="time" id="end_time" name="end_time"
                                                placeholder="Seleccione hora de fin"
                                                class="time-picker w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                                        </div>
                                        @error('end_time')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Motivo -->
                                <div class="text-left w-full">
                                    <label for="details" class="block text-sm font-medium text-gray-700 mb-1">
                                        Motivo*
                                    </label>
                                    <div class="relative">
                                        <textarea id="details" name="details" rows="3" maxlength="255"
                                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary resize-none"
                                            placeholder="Ej: reunión externa, descanso, videollamada...">{{ old('details') }}</textarea>
                                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Máximo 255 caracteres</p>
                                    </div>
                                    @error('details')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Botones -->
                                <div class="flex justify-end gap-4 pt-2">
                                    <x-primary-button>{{ __('Guardar') }}</x-primary-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Columna de la lista -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6 text-gray-900">
                        @if (!$reservedTimes || $reservedTimes->isEmpty())
                            <div id="empty-state" class="p-6 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                No tienes reservas personales registradas.
                            </div>
                        @else
                            <h3 class="text-lg font-semibold mb-2">Reservas personales</h3>
                            <ul id="reservation-list"
                                class="divide-y divide-gray-200 max-h-[550px] overflow-y-auto pr-1">
                                @foreach ($reservedTimes as $reservedTime)
                                    <li class="py-3 hover:bg-gray-50 px-3 rounded-md transition duration-150 reservation-item"
                                        data-date="{{ \Carbon\Carbon::parse($reservedTime->date)->isoFormat('D [de] MMMM [de] YYYY') }}"
                                        data-reason="{{ $reservedTime->details ?? '' }}">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="font-medium text-gray-800">
                                                    {{ \Carbon\Carbon::parse($reservedTime->date)->isoFormat('D [de] MMMM [de] YYYY') }}
                                                    <br>
                                                    <span class="text-sm">
                                                        Hora: {{ substr($reservedTime->start_time, 0, 5) }}
                                                        a {{ substr($reservedTime->end_time, 0, 5) }}
                                                    </span>
                                                </p>
                                                @if ($reservedTime->office)
                                                    <p class="text-sm text-gray-600">
                                                        <span class="font-medium">Espacio:</span>
                                                        {{ $reservedTime->office->name }}
                                                    </p>
                                                @endif
                                                @if ($reservedTime->details)
                                                    <p class="text-sm text-gray-600 mt-1">
                                                        <span class="font-medium">Motivo:</span>
                                                        {{ $reservedTime->details }}
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="flex gap-2">
                                                <x-action-delete-button :action="route('reserved-times.destroy', $reservedTime->id)"
                                                    data-id="{{ $reservedTime->id }}" class="delete-btn" />
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-delete-modal title="Eliminar esta reserva"
        content="¿Seguro que deseas eliminar esta reserva? Esta acción no se puede deshacer." />
</x-app-layout>
