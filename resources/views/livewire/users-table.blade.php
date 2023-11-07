<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Usuarios
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md">
                    <div class="flex bg-white px-4 py-3 border-t border-gray-200 sm:px6">
                        <button wire:click="create()" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                            Nuevo
                        </button>

                        <input
                            wire:model="search"
                            class="form-imput rounded-md shadow-sm mt-1 block w-full"
                            type="text"
                            placeholder="Buscar..."
                        >

                        <select wire:model="perPage" class="form-imput rounded-md shadow-sm mt-1 block outline-none text-gray-500 ml-6">
                            <option value="10">10 por página</option>
                            <option value="30">30 por página</option>
                            <option value="50">50 por página</option>
                            <option value="100">100 por página</option>
                        </select>
                        @if($search!=='')
                        <button wire:click="clear" class="form-imput rounded-md shadow-sm mt-1 block text-gray-500 ml-6">X</button>
                        @endif
                    </div>
                </div>

                    @if($users1)
                    <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                      <thead class="bg-gray-50">
                        <tr>
                          <th scope="col" class="px-6 py-4 font-medium text-gray-900">Acción</th>
                          <th scope="col" class="px-6 py-4 font-medium text-gray-900">Usuario</th>
                          <th scope="col" class="px-6 py-4 font-medium text-gray-900">DNI</th>
                          <th scope="col" class="px-6 py-4 font-medium text-gray-900">Rol</th>
                          <th scope="col" class="px-6 py-4 font-medium text-gray-900">Estado</th>

                        </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                        @foreach ($users1 as $user)
                        <tr class="hover:bg-gray-50">
                          <td class="px-6 py-4">
                            <div class="flex justify-end gap-4">
                              <button wire:click="showEditModal({{ $user->id }})">Borrar</button>
                              <button wire:click="showEditModal({{ $user->id }})">Editar</button>
                            </div>
                          </td>
                          <th class="flex gap-3 px-6 py-4 font-normal text-gray-900">
                            <div class="relative h-10 w-10">
                              <img class="h-full w-full rounded-full object-cover object-center" src="{{$user->profile_photo_url}}" alt="" />
                              <span class="absolute right-0 bottom-0 h-2 w-2 rounded-full bg-green-400 ring ring-white"></span>
                            </div>
                            <div class="text-sm">
                              <div class="font-medium text-gray-700 px-6">{{$user->name}}</div>
                              <div class="text-gray-400 px-6">{{$user->email}}</div>
                            </div>
                          </th>
                          <td class="px-6 py-4">{{$user->id_paciente}}</td>
                          <td class="px-6 py-4">{{$user->getRoleNames()->join(', ')}}</td>
                          <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-green-600">
                              <span class="h-1.5 w-1.5 rounded-full bg-green-600"></span>
                              Activo
                            </span>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px6">
                    {{$users1->links()}}
                    </div>
                    @else
                    <div class="bg-white px-4 py-3 border-t text-gray-500 border-gray-200 sm:px6">
                        No hay resultados para la búsqueda "{{ $search }}" en la página {{ $page }} al mostrar {{ $perPage }} por página
                    </div>
                    @endif

                 </div>


           </div>
        </div>
    </div>

   <!-- Tabla de usuarios -->
   {{-- <table class="min-w-full bg-white">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <button wire:click="showEditModal({{ $user->id }})">Editar</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table> --}}

 <!-- Modal para editar usuarios -->
 @if($selectedUser)
 <div class="modal" tabindex="-1" id="editUserModal">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title">Editar Usuario</h5>
             </div>
             <div class="modal-body">
                 <p>ID: {{ $selectedUser->id }}</p>
                 <p>Name: {{ $selectedUser->name }}</p>
                 <p>Email: {{ $selectedUser->email }}</p>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                 <button type="button" class="btn btn-primary">Guardar cambios</button>
             </div>
         </div>
     </div>
 </div>
 @endif
</div>

@push('scripts')
    <script>
        Livewire.on('showEditUserModal', function () {
            $('#editUserModal').modal('show');
        });
    </script>
@endpush
