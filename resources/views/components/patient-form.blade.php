@props(['patient' => null, 'action', 'isEdit' => false])

<form action="{{ $action }}" method="POST" class="space-y-6">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <!-- Datos personales -->
    <div class="bg-gray-50 p-4 sm:p-6 rounded-lg space-y-6">
        <h2 class="text-lg font-medium text-gray-900 border-b pb-2">Datos personales</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
            <!-- Nombre -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                <input type="text" name="name" id="name"
                    value="{{ old('name', $patient ? $patient->name : '') }}"
                    class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-1 focus:ring-teal-500 focus:border-teal-500">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Apellidos -->
            <div>
                <label for="surnames" class="block text-sm font-medium text-gray-700 mb-1">Apellidos *</label>
                <input type="text" name="surnames" id="surnames"
                    value="{{ old('surnames', $patient ? $patient->surnames : '') }}"
                    class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-1 focus:ring-teal-500 focus:border-teal-500">
                @error('surnames')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                <input type="email" name="email" id="email"
                    value="{{ old('email', $patient ? $patient->email : '') }}"
                    class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-1 focus:ring-teal-500 focus:border-teal-500">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Teléfono -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Teléfono *</label>
                <input type="tel" name="phone" id="phone"
                    value="{{ old('phone', $patient ? $patient->phone : '') }}"
                    class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-1 focus:ring-teal-500 focus:border-teal-500">
                @error('phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- DNI -->
            <div>
                <label for="dni" class="block text-sm font-medium text-gray-700 mb-1">DNI *</label>
                <input type="text" name="dni" id="dni"
                    value="{{ old('dni', $patient ? $patient->dni : '') }}"
                    class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-1 focus:ring-teal-500 focus:border-teal-500">
                @error('dni')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Birthdate -->
            <div>
                <label for="birthdate" class="block text-sm font-medium text-gray-700 mb-1">Fecha de nacimiento
                    *</label>
                <input type="date" name="birthdate" id="dni"
                    value="{{ old('birthdate', $patient ? $patient->birthdate : '') }}"
                    class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-1 focus:ring-teal-500 focus:border-teal-500">
                @error('birthdate')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Botones de acción -->
    <div class="flex flex-col sm:flex-row items-center justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-4">
        <a href="{{ route('admin.patients.index') }}"
            class="w-full sm:w-auto px-4 py-2 text-center border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-150 ease-in-out">
            Cancelar
        </a>
        <x-primary-button type="submit">{{ $isEdit ? 'Guardar cambios' : 'Crear paciente' }}</x-primary-button>
    </div>
</form>
