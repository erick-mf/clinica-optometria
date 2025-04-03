 <x-app-layout>
     <div class="py-4 sm:py-12">
         <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
             <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                 <div class="p-3 sm:p-6 text-gray-900">
                     <div
                         class="mb-4 sm:mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                         <h1 class="text-lg font-bold sm:text-2xl">Crear de Horarios</h1>

                         <div id="calendar"></div>

                         <!-- El formulario para agregar horarios -->
                         <form id="event-form" method="POST" action="{{ route('admin.schedules.store') }}">
                             @csrf
                             <input type="hidden" name="fecha_inicio" id="fecha_inicio">
                             <input type="hidden" name="fecha_fin" id="fecha_fin">
                             <input type="hidden" name="titulo" id="titulo">

                             <button type="submit">Guardar horario</button>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <x-delete-modal title="Confirmar eliminación"
         content="¿Estás seguro que deseas eliminar este doctor? Esta acción no se puede deshacer." />

 </x-app-layout>
