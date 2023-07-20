<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           usuarios
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md">
                    <div class="flex bg-white px-4 py-3 border-t border-gray-200 sm:px6">
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

                    @if($users->count())
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
                        @foreach ($users as $user)
                        <tr class="hover:bg-gray-50">
                          <td class="px-6 py-4">
                            <div class="flex justify-end gap-4">
                              <a x-data="{ tooltip: 'Delete' }" href="#"
                                wire:click="ShowModalD({{$user->id}})">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6" x-tooltip="tooltip">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                              </a>
                              <a x-data="{ tooltip: 'Edite' }" href="#"
                              wire:click="ShowModalE({{$user->id}})">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6" x-tooltip="tooltip">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                </svg>
                              </a>
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
                    {{$users->links()}}
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
</div>


@push('modals')

<div class="{{$showModal}} h-80">
    <div x-data="{ showModal: true }" x-on:keydown.window.escape="showModal = false">
      <div class="flex justify-center">
        <button x-on:click="showModal = !showModal" class="rounded-lg border border-primary-500 bg-primary-500 px-5 py-2.5 text-center text-sm font-medium text-white shadow-sm transition-all hover:border-primary-700 hover:bg-primary-700 focus:ring focus:ring-primary-200 disabled:cursor-not-allowed disabled:border-primary-300 disabled:bg-primary-300">Toggle Modal</button>
      </div>
      <div x-cloak x-show="showModal" x-transition.opacity class="fixed inset-0 z-10 bg-secondary-700/50"></div>
      <div x-cloak x-show="showModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0">
        <div class="mx-auto overflow-hidden rounded-lg bg-white shadow-xl sm:w-full sm:max-w-xl">
          <div class="relative p-6">
            <div class="flex gap-4">
              <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100 text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
              </div>
              <div class="flex-1">
                <h3 class="text-lg font-medium text-secondary-900">Delete blog post</h3>
                <div class="mt-2 text-sm text-secondary-500">Are you sure you want to delete this post? This action cannot be undone.</div>
              </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
              <button type="button" x-on:click="showModal = false" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-center text-sm font-medium text-gray-700 shadow-sm transition-all hover:bg-gray-100 focus:ring focus:ring-gray-100 disabled:cursor-not-allowed disabled:border-gray-100 disabled:bg-gray-50 disabled:text-gray-400">Cancel</button>
              <button type="button" class="rounded-lg border border-red-500 bg-red-500 px-4 py-2 text-center text-sm font-medium text-white shadow-sm transition-all hover:border-red-700 hover:bg-red-700 focus:ring focus:ring-red-200 disabled:cursor-not-allowed disabled:border-red-300 disabled:bg-red-300">Delete</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endpush
