<div>
    <x-danger-button wire:click="$set('open',true)" class="bg-blue-600">
        Informe
    </x-danger-button>

    <x-dialog-modal wire:model="open">

        <x-slot name="title">
            <h1> Informe del Estudio de {{ $nombre }}</h1>
        </x-slot>

        <x-slot name="content">

            <div wire:loading wire:target="pdf"
                class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Simed es Salud</strong>
                <span class="block sm:inline">Espere un momento hasta que la imagen se termine de procesar.</span>
            </div>

            <div class="mb-4">
                <x-label value="INFORME" />
                <textarea rows=10
                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    wire:model="content"></textarea>

                <x-input-error for="content"></x-input-error>
            </div>

            <div class="grid grid-cols-2 grid-rows-2 gap-4 sm:gap-6 lg:gap-8">
                <input type="file" value="Subir Informe en formato PDF" wire:model="pdf" >
                <x-input-error for="pdf"></x-input-error>

                <x-danger-button wire:click="save" wire:loading.attr="disabled" wire:target="save, pdf"
                class="disabled:opacity-25">
                Subir archivo PDF
            </x-danger-button>
            </div>

            <div class="mt-4 grid grid-cols-2 grid-rows-2 gap-4 sm:gap-6 lg:gap-8">
                <div class="flex -space-x-2 overflow-hidden">
                    <h2 class="text-2xl font-bold text-gray-900"></h2>
                    @foreach ($thumb as $mini)
                    <img class="inline-block h-10 w-10 rounded-full ring-2 ring-white" src="{{ $mini }}" alt="">
                    @endforeach
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('open',false)">
                Cancelar
            </x-secondary-button>

            <x-danger-button wire:click="pdf" wire:loading.attr="disabled" wire:target="pdf, save"
                class="disabled:opacity-25">
                Grabar Informe
            </x-danger-button>

        </x-slot>

    </x-dialog-modal>
</div>
