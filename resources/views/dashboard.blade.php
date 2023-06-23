<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Estudios de

        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                 @livewire('show-estudios');{{--, ['fechad' => $fechad], ['fechah' => $fechah]) --}}

            </div>
        </div>
    </div>
</x-app-layout>
