<div>
    {{-- <button wire:click="toggleModal" class="btn btn-primary">Editar Usuario</button> --}}
    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            Editar
        </x-slot>

        <x-slot name="content">

            <form wire:submit.prevent="save">
                <div class="mb-4">
                    <x-label for="id_paciente" value="DNI" />
                    <x-input
                        id="id_paciente"
                        type="text"
                        class="mt-1 block w-full"
                        wire:model.defer="user.id_paciente"     {{-- model.defer: pone en cola la solicitud --}}
                    />
                    <x-input-error for="user.id_paciente" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-label for="name" value="Nombre" />
                    <x-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="user.name" />
                    <x-input-error for="user.name" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-label for="email" value="Correo Electrónico" />
                    <x-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="user.email" />
                    <x-input-error for="user.email" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-label for="roles" value="Roles" />
                    <select id="roles" class="mt-1 block w-full" multiple wire:model="selectedRoles">
                        @foreach ($roles as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="toggleModal">
                Cancelar
            </x-secondary-button>

            <x-button wire:click="save">
                Guardar
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
