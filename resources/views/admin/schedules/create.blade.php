 <x-app-layout>

     <!-- Elemento para pasar datos de PHP a JavaScript -->
     <div id="app-data" data-disabled-dates="{{ json_encode($disabledDates ?? []) }}" style="display: none;"></div>

     <div class="container mx-auto px-4 py-8 max-w-4xl">
         <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Configuración de Horarios</h1>

         <div class="bg-white rounded-lg shadow p-4 sm:p-6 mb-8">
             <form method="POST" action="{{ route('admin.schedules.store') }}">
                 @csrf
                 <!-- Paso 1: Seleccionar rango de fechas -->
                 <div class="mb-8">
                     <h2 class="text-lg font-semibold text-gray-800 mb-4">1. Selecciona el rango de fechas</h2>
                     <div class="grid md:grid-cols-2 gap-4 sm:gap-6">
                         <div>
                             <label for="start_date_picker" class="block text-sm font-medium text-gray-700 mb-1">Fecha
                                 inicial</label>
                             <input type="text" id="start_date_picker"
                                 class="w-full px-3 sm:px-4 py-2 rounded border border-gray-300" required
                                 placeholder="Selecciona fecha">
                             <input type="hidden" name="start_date" id="start_date">
                             <p class="text-xs text-gray-500 mt-1">Primer día donde aplicarán los horarios</p>
                         </div>
                         <div>
                             <label for="end_date_picker" class="block text-sm font-medium text-gray-700 mb-1">Fecha
                                 final</label>
                             <input type="text" id="end_date_picker"
                                 class="w-full px-3 sm:px-4 py-2 rounded border border-gray-300" required
                                 placeholder="Selecciona fecha">
                             <input type="hidden" name="end_date" id="end_date">
                             <p class="text-xs text-gray-500 mt-1">Último día donde aplicarán los horarios</p>
                         </div>
                     </div>
                 </div>

                 <!-- Paso 2: Seleccionar días de la semana -->
                 <div class="mb-8">
                     <h2 class="text-lg font-semibold text-gray-800 mb-4">2. Selecciona los días de la semana</h2>
                     <div class="grid grid-cols-3 xs:grid-cols-4 sm:grid-cols-7 gap-2">
                         @foreach ([['id' => 'day-1', 'value' => 1, 'short' => 'L', 'long' => 'Lun'], ['id' => 'day-2', 'value' => 2, 'short' => 'M', 'long' => 'Mar'], ['id' => 'day-3', 'value' => 3, 'short' => 'M', 'long' => 'Mié'], ['id' => 'day-4', 'value' => 4, 'short' => 'J', 'long' => 'Jue'], ['id' => 'day-5', 'value' => 5, 'short' => 'V', 'long' => 'Vie'], ['id' => 'day-6', 'value' => 6, 'short' => 'S', 'long' => 'Sáb'], ['id' => 'day-0', 'value' => 0, 'short' => 'D', 'long' => 'Dom']] as $day)
                             <div class="day-selector">
                                 <input type="checkbox" id="{{ $day['id'] }}" name="days[]"
                                     value="{{ $day['value'] }}" class="hidden day-checkbox peer">
                                 <label for="{{ $day['id'] }}"
                                     class="flex flex-col items-center p-2 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:text-indigo-600 hover:bg-gray-50 transition-colors">
                                     <span class="text-sm font-medium">{{ $day['short'] }}</span>
                                     <span class="text-xs">{{ $day['long'] }}</span>
                                 </label>
                             </div>
                         @endforeach
                     </div>
                 </div>

                 <!-- Paso 3: Configurar turnos -->
                 <div class="mb-8">
                     <h2 class="text-lg font-semibold text-gray-800 mb-4">3. Define los turnos disponibles</h2>
                     <div id="turns-wrapper" class="space-y-4 mb-4">
                         <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-end">
                             <div class="w-full sm:flex-1 min-w-[120px]">
                                 <label class="block text-sm text-gray-700 mb-1">Hora inicio</label>
                                 <input type="time" name="turns[0][start]"
                                     class="w-full px-3 py-2 border border-gray-300 rounded" required>
                             </div>
                             <div class="w-full sm:flex-1 min-w-[120px]">
                                 <label class="block text-sm text-gray-700 mb-1">Hora fin</label>
                                 <input type="time" name="turns[0][end]"
                                     class="w-full px-3 py-2 border border-gray-300 rounded" required>
                             </div>
                             <button type="button"
                                 class="remove-turn w-full sm:w-auto px-3 py-2 bg-red-100 text-red-700 rounded hover:bg-red-200 mt-0 sm:mt-[1.625rem]">
                                 Eliminar
                             </button>
                         </div>
                     </div>
                     <button type="button" id="add-turn"
                         class="w-full sm:w-auto px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                         + Añadir otro turno
                     </button>
                     <p class="text-sm text-gray-600 mt-2">Estos horarios se aplicarán a cada uno de los días
                         seleccionados</p>
                 </div>
                 <div class="mb-8">
                     <h2 class="text-lg font-semibold text-gray-800 mb-4">4. Duración de las citas</h2>
                     <input type="number" id="interval_minutes" name="interval_minutes" min="1" value="30"
                         class="w-full px-3 py-2 border border-gray-300 rounded" required>
                     <p class="text-sm text-gray-600 mt-2">Duración de las citas en minutos </p>
                 </div>
                 <!-- Botón de envío -->

                 <div
                     class="flex flex-col sm:flex-row items-center justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-4">
                     <a href="{{ route('admin.schedules.index') }}"
                         class="w-full sm:w-auto px-4 py-2 text-center border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-150 ease-in-out">
                         Cancelar
                     </a>
                     <button type="submit"
                         class="w-full sm:w-auto px-4 py-2 text-center border  rounded-md text-white bg-primary hover:bg-teal-800 transition-colors duration-150 ease-in-out">
                         Guardar Horarios
                     </button>
                 </div>
             </form>
         </div>
 </x-app-layout>
