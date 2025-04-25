<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Espacio') }}
            </h2>
            <x-back-link :url="route('admin.dashboard')" />
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Columna del formulario -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6 text-gray-900">
                        <div class="flex justify-between items-start mb-6">
                            <h2 class="text-xl font-semibold">{{ $isEdit ? 'Editar Espacio' : 'Crear Espacio' }}</h2>
                        </div>

                        <form method="POST"
                            action="{{ $isEdit ? route('admin.offices.update', $office) : route('admin.offices.store') }}"
                            class="space-y-4 md:space-y-6">
                            @csrf
                            @if ($isEdit)
                                @method('PUT')
                            @endif
                            <div class="grid grid-cols-1 gap-4 sm:gap-6">
                                <!-- Nombre del espacio -->
                                <div class="text-left w-full">
                                    <label for="name"
                                        class="block text-sm sm:text-base font-medium text-gray-700 mb-1">
                                        Nombre del espacio:
                                    </label>
                                    <input type="text" id="name" name="name"
                                        value="{{ old('name', $office->name ?? '') }}"
                                        class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition duration-150"
                                        placeholder="Ej: Consultorio 1, Sala de Tratamientos...">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Estado (Activo/Inactivo/En mantenimiento) -->
                                <div class="text-left w-full">
                                    <label
                                        class="block text-sm sm:text-base font-medium text-gray-700 mb-2">Estado:</label>
                                    <div class="flex flex-wrap gap-4">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="status" value="activo"
                                                {{ $isEdit && $office->status == 'activo' ? 'checked' : '' }}
                                                class="w-4 h-4 text-primary border-gray-300 focus:ring-primary">
                                            <div class="ml-2 flex items-center">
                                                <span class="text-sm font-medium text-gray-700">Activo</span>
                                            </div>
                                        </label>

                                        <label class="inline-flex items-center">
                                            <input type="radio" name="status" value="inactivo"
                                                {{ $isEdit && $office->status == 'inactivo' ? 'checked' : '' }}
                                                class="w-4 h-4 text-primary border-gray-300 focus:ring-primary">
                                            <div class="ml-2 flex items-center">
                                                <span class="text-sm font-medium text-gray-700">Inactivo</span>
                                            </div>
                                        </label>

                                        <label class="inline-flex items-center">
                                            <input type="radio" name="status" value="en mantenimiento"
                                                {{ $isEdit && $office->status == 'en mantenimiento' ? 'checked' : '' }}
                                                class="w-4 h-4 text-primary border-gray-300 focus:ring-primary">
                                            <div class="ml-2 flex items-center">
                                                <span class="text-sm font-medium text-gray-700">En mantenimiento</span>
                                            </div>
                                        </label>
                                    </div>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Asignación de doctor -->
                                <div class="text-left w-full">
                                    <label for="user_id"
                                        class="block text-sm sm:text-base font-medium text-gray-700 mb-1">
                                        Doctor asignado:
                                    </label>
                                    <select id="user_id" name="user_id"
                                        class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition duration-150">
                                        <option value="">Seleccionar doctor</option>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}"
                                                {{ old('user_id', $office->user_id ?? '') == $doctor->id ? 'selected' : '' }}>
                                                {{ $doctor->name }} {{ $doctor->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="mt-1 text-xs text-gray-500">Opcional: selecciona un doctor para asignar a
                                        este espacio</p>
                                    @error('user_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div
                                    class="flex flex-col sm:flex-row items-center justify-end space-y-2 sm:space-y-0 sm:space-x-4 pt-2">
                                    @if ($isEdit)
                                        <a href="{{ route('admin.offices.index') }}"
                                            class="w-full sm:w-auto px-4 py-2 text-center border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-150 ease-in-out">
                                            Cancelar
                                        </a>
                                    @endif
                                    <button type="submit"
                                        class="w-full sm:w-auto px-4 py-2 text-center border rounded-md text-white bg-primary hover:bg-teal-800 transition-colors duration-150 ease-in-out">
                                        {{ $isEdit ? 'Guardar cambios' : 'Crear espacio' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Columna de la lista de espacios -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    @if ($offices->isEmpty())
                        <div class="p-4 sm:p-6 text-gray-900 flex justify-center items-center h-full">
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <h2 class="mt-2 text-xl font-semibold">No hay espacios registrados</h2>
                                <p class="mt-1 text-gray-500">Crea tu primer espacio usando el formulario.</p>
                            </div>
                        </div>
                    @else
                        <div class="p-4 sm:p-6 text-gray-900">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-xl font-semibold">Lista de Espacios</h2>
                            </div>

                            <!-- Lista de espacios -->
                            <div class="overflow-y-auto max-h-[550px] pr-1">
                                <ul class="divide-y divide-gray-200">
                                    @foreach ($offices as $office)
                                        <li class="py-4 hover:bg-gray-50 rounded-md px-3 transition duration-150">
                                            <div class="flex flex-col sm:flex-row justify-between sm:items-center">
                                                <div class="mb-2 sm:mb-0">
                                                    <h3 class="text-base font-medium text-gray-800">
                                                        {{ $office->name }}</h3>
                                                    <div class="mt-1 flex flex-wrap gap-2 flex-col">
                                                        <!-- Estado con mejor visualización -->
                                                        <div class="flex items-center">
                                                            <div
                                                                class="w-2.5 h-2.5 rounded-full mr-1.5
                                                            {{ $office->status == 'activo'
                                                                ? 'bg-green-500'
                                                                : ($office->status == 'inactivo'
                                                                    ? 'bg-red-500'
                                                                    : 'bg-yellow-500') }}">
                                                            </div>
                                                            <span class="text-sm text-gray-600">
                                                                {{ ucfirst($office->status) }}
                                                            </span>
                                                        </div>

                                                        @if (isset($office->doctor))
                                                            <div class="flex items-center">
                                                                <span class="text-sm text-gray-600">
                                                                    Prof. {{ $office->doctor->name }}
                                                                    {{ $office->doctor->last_name }}
                                                                </span>
                                                            </div>
                                                        @else
                                                            <div class="flex items-center text-gray-400">
                                                                <span class="text-sm">Sin doctor asignado</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- Acciones -->
                                                <div class="flex items-center space-x-2">
                                                    <x-action-button
                                                        action="{{ route('admin.offices.edit', $office) }}"
                                                        color="teal" icon="edit" text="Editar" />
                                                    <x-action-delete-button
                                                        action="{{ route('admin.offices.destroy', $office) }}" />
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <x-delete-modal title="Confirmar eliminación"
        content="¿Estás seguro que deseas eliminar este espacio? Esta acción no se puede deshacer." />
</x-app-layout>
