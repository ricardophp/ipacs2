<div>
<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md">
                    <div class="flex bg-white px-4 py-3 border-t border-gray-200 sm:px6">
                        <x-button class="mr-3" wire:click="confirmUserAdd()">
                            Nuevo
                        </x-button>

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
                              <button wire:click="confirmUserDeletion({{ $user->id }})" wire:loading.attr="disabled">
                                @unless($user->getRoleNames()->join(', ')=='Administrador') Borrar @endunless </button>
                              <button wire:click="confirmUserEdit({{ $user->id }})">
                                @unless($user->getRoleNames()->join(', ')=='Administrador') Editar @endunless</button>
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

        <!-- Delete User Confirmation Modal -->
    <x-dialog-modal wire:model="confirmingUserDeletion">
        <x-slot name="title">
                {{ __('Delete Account') }}
        </x-slot>

        <x-slot name="content">
                {{ __('¿Seguro que desea ELIMINAR el usuario?.') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingUserDeletion',false)" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click="deleteUser({{ $confirmingUserDeletion }})" wire:loading.attr="disabled">
                    {{ __('Delete Account') }}
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>

        <!-- Add User Confirmation Modal -->
        <x-dialog-modal wire:model="confirmingUserAdd">
            <x-slot name="title">
                    {{ isset($this->user->id)? 'Editar Usuario' : 'Nuevo usuario' }}
            </x-slot>

            <x-slot name="content">
                <!-- Name -->
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="user.name"/>
                    <x-input-error for="user.name" class="mt-2" />
                </div>



                <!-- Email -->
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="user.email"/>
                    <x-input-error for="user.email" class="mt-2" />
                </div>

                <!-- Paciente -->
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="id_paciente" value="{{ __('DNI Paciente') }}" />
                    <x-input id="id_paciente" type="text" class="mt-1 block w-full" wire:model.defer="user.id_paciente" />
                    <x-input-error for="user.id_paciente" class="mt-2" />
                </div>

                <!-- Rol -->
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="role" value="{{ __('Role') }}" />
                    <select id="role" wire:model.defer="selectedRole" class="mt-1 block w-full">
                        <option value="" disabled>Select a role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="selectedRole" class="mt-2" />
                </div>

                 <!-- Password -->
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" type="password" class="mt-1 block w-full" wire:model.defer="user.password"/>
                    <x-input-error for="user.password" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-input id="password_confirmation" type="password" class="mt-1 block w-full" wire:model.defer="user.password_confirmation" />
                    <x-input-error for="user.password_confirmation" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$set('confirmingUserAdd',false)" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="saveUser()" wire:loading.attr="disabled">
                        {{ __('Save') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>

</div>
</div>
