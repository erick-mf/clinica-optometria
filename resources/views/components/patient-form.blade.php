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
            <div class="text-left">
                <label for="name" class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Nombre *</label>
                <input type="text" id="name" name="name" placeholder="Ingrese su nombre"
                    value="{{ old('name') ?? ($patient->name ?? '') }}"
                    class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                @error('name')
                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Apellidos -->
            <div class="text-left">
                <label for="surnames" class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Apellidos
                    *</label>
                <input type="text" id="surnames" name="surnames" placeholder="Ingrese sus apellidos"
                    value="{{ old('surnames') ?? ($patient->surnames ?? '') }}"
                    class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                @error('surnames')
                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fecha de Nacimiento -->
            <div class="text-left">
                <label for="birthdate" class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Fecha de
                    Nacimiento *</label>
                <input type="date" id="birthdate" name="birthdate"
                    value="{{ old('birthdate') ?? ($patient->birthdate ?? '') }}"
                    min="{{ \Carbon\Carbon::now()->subYears(100)->format('Y-m-d') }}"
                    max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                    class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                @error('birthdate')
                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Correo -->
            <div class="text-left">
                <label for="email" class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Correo *</label>
                <input type="email" id="email" name="email" placeholder="Ingrese su correo"
                    value="{{ old('email') ?? ($patient->email ?? '') }}"
                    class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                @error('email')
                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Teléfono -->
            <div class="text-left">
                <label for="phone" class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Teléfono
                    *</label>
                <input type="tel" id="phone" name="phone" placeholder="Ingrese su teléfono"
                    value="{{ old('phone') ?? ($patient->phone ?? '') }}"
                    class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                @error('phone')
                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Documentación -->
            <div class="text-left w-full">
                <div class="flex flex-wrap sm:flex-nowrap gap-4 items-end">
                    <!-- Tipo de Documento-->
                    <div class="w-full sm:w-[40%]">
                        <label for="document_type"
                            class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Tipo de Documento</label>
                        <select id="document_type" name="document_type"
                            class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition duration-150">
                            <option value="">Seleccionar</option>
                            <option value="DNI"
                                {{ old('document_type', $patiend->document_type ?? '') == 'DNI' ? 'selected' : '' }}>
                                DNI
                            </option>
                            <option value="NIE"
                                {{ old('document_type', $patiend->document_type ?? '') == 'NIE' ? 'selected' : '' }}>
                                NIE</option>
                            <option value="Pasaporte"
                                {{ old('document_type', $patiend->document_type ?? '') == 'Pasaporte' ? 'selected' : '' }}>
                                Pasaporte
                            </option>
                        </select>
                        @error('document_type')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Número de Documento -->
                    <div class="w-full sm:w-[60%]">
                        <label for="document_number"
                            class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Número de
                            Documento</label>
                        <input type="text" id="document_number" name="document_number"
                            placeholder="Ingrese el número de documentación"
                            value="{{ old('document_number') ?? ($patient->document_number ?? '') }}"
                            class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                        @error('document_number')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Datos del tutor legal (requerido para menores de edad) -->
        <h2 class="text-lg font-medium text-gray-900 border-b pb-2">Datos del tutor legal (requerido para menores de
            edad)</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
            <!-- Nombre del tutor -->
            <div class="text-left">
                <label for="tutor_name" class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Nombre del
                    tutor *</label>
                <input type="text" id="tutor_name" name="tutor_name" placeholder="Ingrese el nombre del tutor"
                    value="{{ old('tutor_name') ?? ($patient->tutor_name ?? '') }}"
                    class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                @error('tutor_name')
                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Correo del tutor -->
            <div class="text-left">
                <label for="tutor_email" class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Correo del
                    tutor *</label>
                <input type="email" id="tutor_email" name="tutor_email" placeholder="Ingrese el correo del tutor"
                    value="{{ old('tutor_email') ?? ($patient->tutor_email ?? '') }}"
                    class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                @error('tutor_email')
                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Documentación tutor -->
            <div class="text-left w-full">
                <div class="flex flex-wrap sm:flex-nowrap gap-4 items-end">
                    <!-- Tipo de Documento-->
                    <div class="w-full sm:w-[40%]">
                        <label for="tutor_document_type"
                            class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Tipo de Documento</label>
                        <select id="tutor_document_type" name="tutor_document_type"
                            class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition duration-150">
                            <option value="">Seleccionar</option>
                            <option value="DNI"
                                {{ old('tutor_document_type', $patient->tutor_document_type ?? '') == 'DNI' ? 'selected' : '' }}>
                                DNI
                            </option>
                            <option value="NIE"
                                {{ old('tutor_document_type', $patient->tutor_document_type ?? '') == 'NIE' ? 'selected' : '' }}>
                                NIE
                            </option>
                            <option value="Pasaporte"
                                {{ old('tutor_document_type', $patient->tutor_document_type ?? '') == 'Pasaporte' ? 'selected' : '' }}>
                                Pasaporte
                            </option>
                        </select>
                        @error('tutor_document_type')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Número de Documento -->
                    <div class="w-full sm:w-[60%]">
                        <label for="tutor_document_number"
                            class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Número de
                            Documento</label>
                        <input type="text" id="tutor_document_number" name="tutor_document_number"
                            placeholder="Ingrese el número de documentación"
                            value="{{ old('tutor_document_number') ?? ($patient->tutor_document_number ?? '') }}"
                            class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                        @error('document_number')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Teléfono del tutor -->
            <div class="text-left">
                <label for="tutor_phone" class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Teléfono
                    del
                    tutor *</label>
                <input type="tel" id="tutor_phone" name="tutor_phone"
                    placeholder="Ingrese el teléfono del tutor"
                    value="{{ old('tutor_phone') ?? ($patient->tutor_phone ?? '') }}"
                    class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                @error('tutor_phone')
                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Botones de acción -->
    <div class="flex flex-col sm:flex-row items-center justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-4">
        <a href="{{ route('admin.patients.index') }}"
            class="w-full sm:w-auto px-4 py-2 text-center border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-150 ease-in-out">
            Cancelar</a>
        <x-primary-button type="submit">{{ $isEdit ? 'Guardar cambios' : 'Crear paciente' }}</x-primary-button>
    </div>
</form>
