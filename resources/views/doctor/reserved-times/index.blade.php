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
                            <h2 class="text-xl font-semibold">{{ __('Crear reservación') }}</h2>
                        </div>

                        <form method="POST" action="{{ route('reserved-times.store') }}"
                            class="space-y-4 md:space-y-6">
                            @csrf

                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <div class="grid grid-cols-1 gap-4 sm:gap-6">
                                <!-- Fecha -->
                                <div class="text-left w-full">
                                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">
                                        Fecha:
                                    </label>
                                    <input type="text" id="date" name="date" value="{{ old('date') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                                    @error('date')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Hora de inicio -->
                                <div class="text-left w-full">
                                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">
                                        Hora de inicio:
                                    </label>
                                    <input type="time" id="start_time" name="start_time"
                                        value="{{ old('start_time') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                                    @error('start_time')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Hora de fin -->
                                <div class="text-left w-full">
                                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">
                                        Hora de fin:
                                    </label>
                                    <input type="time" id="end_time" name="end_time" value="{{ old('end_time') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                                    @error('end_time')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Motivo -->
                                <div class="text-left w-full">
                                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">
                                        Motivo (opcional):
                                    </label>
                                    <textarea id="reason" name="reason" rows="3" maxlength="255"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary resize-none"
                                        placeholder="Ej: reunión externa, descanso, videollamada...">{{ old('description') }}</textarea>
                                    @error('reason')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Botones -->
                                <div class="flex justify-end gap-4 pt-2">
                                    <button type="submit"
                                        class="px-4 py-2 border rounded-md text-white bg-primary hover:bg-teal-800 transition">
                                        {{ 'Crear bloque' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Columna de la lista -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    @if (!$reservedTimes || $reservedTimes->isEmpty())
                        <div class="p-6 text-center text-gray-500">
                            No tienes reservasiones personales registrados.
                        </div>
                    @else
                        <div class="p-4 sm:p-6 text-gray-900">
                            <h2 class="text-xl font-semibold mb-4">Tus reservaciones personales</h2>

                            <ul class="divide-y divide-gray-200 max-h-[550px] overflow-y-auto pr-1">
                                @foreach ($reservedTimes as $reservedTime)
                                    <li class="py-3 hover:bg-gray-50 px-3 rounded-md transition duration-150">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="font-medium text-gray-800">
                                                    {{ \Carbon\Carbon::parse($reservedTime->date)->format('d/m/Y') }}
                                                    de {{ substr($reservedTime->start_time, 0, 5) }}
                                                    a {{ substr($reservedTime->end_time, 0, 5) }}
                                                </p>
                                                @if ($reservedTime->reason)
                                                    <p class="text-sm text-gray-600">{{ __('Motivo:') }}
                                                        {{ $reservedTime->reason }}</p>
                                                @endif
                                            </div>
                                            <div class="flex gap-2">
                                                <x-action-delete-button :action="route('reserved-times.destroy', $reservedTime->id)" />
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-delete-modal title="Eliminar bloque" content="¿Seguro que deseas eliminar este bloque reservado?" />
</x-app-layout>
