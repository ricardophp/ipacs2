<div>
    <div class="p-5 h-screen bg-gray-100 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700   text-gray-700 dark:text-gray-400">
        {{-- LA CABECERA                         --}}
        {{-- *********************************   --}}
        <div class="text-sm flex justify-between items-center mb-4">
            <div>
                <label for="fechad">desde:</label>
                {{-- <input wire:model="fechad" type="date" id="fechad"> --}}
                <x-input wire:model="fechad" type="date" id="fechad" />

                <label for="fechah">hasta:</label>
                {{-- <input wire:model.debounce.1s="fechah" type="date" id="fechah"> --}}
                <x-input wire:model="fechah" type="date" id="fechah" />

                <label for="Nombre o DNI:">paciente:</label>
                {{-- <input wire:model.debounce.1s="paciente" type="text" id="paciente"> --}}
                <x-input wire:model="filtroPaciente" type="text" id="filtroPaciente" />
            </div>
            @role('Administrador')
                <div class="flex items-center">
                    <button wire:click="exportar" wire:loading.attr="disabled" wire:loading.class="invisible"
                        class="flex flex-col items-center mr-10 bg-transparent text-gray-600 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48px" height="48px">
                            <defs>
                                <linearGradient id="G7C1BuhajJQaEWHVlNUzHa" x1="6" x2="27" y1="24"
                                    y2="24" data-name="Excel10" gradientUnits="userSpaceOnUse">
                                    <stop offset="0" stop-color="#21ad64" />
                                    <stop offset="1" stop-color="#088242" />
                                </linearGradient>
                            </defs>
                            <path fill="#31c447" d="m41,10h-16v28h16c.55,0,1-.45,1-1V11c0-.55-.45-1-1-1Z" />
                            <path fill="#fff"
                                d="m32,15h7v3h-7v-3Zm0,10h7v3h-7v-3Zm0,5h7v3h-7v-3Zm0-10h7v3h-7v-3Zm-7-5h5v3h-5v-3Zm0,10h5v3h-5v-3Zm0,5h5v3h-5v-3Zm0-10h5v3h-5v-3Z" />
                            <path fill="url(#G7C1BuhajJQaEWHVlNUzHa)" d="m27,42l-21-4V10l21-4v36Z" />
                            <path fill="#fff"
                                d="m19.13,31l-2.41-4.56c-.09-.17-.19-.48-.28-.94h-.04c-.05.22-.15.54-.32.98l-2.42,4.52h-3.76l4.46-7-4.08-7h3.84l2,4.2c.16.33.3.73.42,1.18h.04c.08-.27.22-.68.44-1.22l2.23-4.16h3.51l-4.2,6.94,4.32,7.06h-3.74Z" />
                            <title>Exportar</title>
                        </svg>
                        <i class="fas fa-file-export"></i>
                    </button>

                    <!-- Contenedor del mensaje de exportación -->
                    <div wire:loading wire:target="exportar" class="mt-2 text-blue-500">
                        <i class="fas fa-spinner fa-spin"></i>Exportando Estudios...
                    </div>

                    <!-- Contenedor del mensaje de exportación finalizada -->
                    <div wire:loading.remove wire:target="exportar" class="mt-2 text-green-500">
                        @if ($mostrarMensajeExportacion)
                            Export Finalizada
                        @endif
                    </div>
                </div>
            @endrole
        </div>


        {{-- LA TABLA                           --}}
        {{-- *********************************   --}}
        <div class="overflow-x-auto w-full">
            <table id="estudios" class="w-full dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
                <thead class="bg-gray-50 border-b-2 dark:bg-gray-800 border-gray-100 dark:border-gray-700 dark:text-gray-200">
                    @if ($paginator->count())
                        <tr>
                            <th class="w-20 p-3 text-sm font-semibold tracking-wide text-left">Mod</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">Fecha</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">Hora</th>
                            <th class="w-24 p-3 text-sm font-semibold tracking-wide text-left">DNI</th>
                            <th class="w-50 p-3 text-sm font-semibold tracking-wide text-left">Nombre</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">S</th>
                            <th class="w-24 p-3 text-sm font-semibold tracking-wide text-left">Nac</th>
                            <th class="w-24 p-3 text-sm font-semibold tracking-wide text-left">OS</th>
                            <th class="w-32 p-3 text-sm font-semibold tracking-wide text-left">Médico</th>
                            <th class="w-40 p-3 text-sm font-semibold tracking-wide text-left">Diag</th>
                            {{-- <th class="w-24 p-3 text-sm font-semibold tracking-wide text-left">Desc</th> --}}
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">Ubic</th>
                            {{-- <th class="w-24 p-3 text-sm font-semibold tracking-wide text-left">PCuerpo</th> --}}
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">I</th>
                            <th class="w-32 p-3 text-sm font-semibold tracking-wide text-left">Informe</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">Acc1</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">Acc2</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">Link</th>
                        </tr>
                    @else
                        <tr></tr>
                    @endif
                </thead>
                <tbody class="divide-y divide-gray-100  dark:bg-gray-800 border-gray-100 dark:border-gray-700 dark:text-gray-400">
                    @if ($paginator->count())
                        @foreach ($paginator as $estudio)
                            <tr class="bg-white dark:bg-gray-800 border-gray-100 dark:border-gray-700  text-gray-700 dark:text-gray-400">
                                {{-- Modalidad --}}
                                @if (isset($estudio['00080061']['Value'][0]))
                                    @if (isset($estudio['00080061']['Value'][0]) and $estudio['00080061']['Value'][0] == 'DOC')
                                        <td class="p-3 text-sm">
                                            {{ $estudio['00080061']['Value'][1] }}</td>
                                    @else
                                        <td class="p-3 text-sm">
                                            {{ $estudio['00080061']['Value'][0] }}</td>
                                    @endif
                                @else
                                    <td>-</td>
                                @endif
                                {{-- Fecha --}}
                                @if (isset($estudio['00080020']['Value'][0]))
                                    <td class="p-3 text-sm">
                                        {{ date('d/m/Y', strtotime($estudio['00080020']['Value'][0])) }}</td>
                                @else
                                    <td>-</td>
                                @endif

                                {{-- Hora --}}
                                @if (isset($estudio['00080030']['Value'][0]))
                                    <td class="p-3 text-sm">
                                        {{ date('H:i', strtotime(substr($estudio['00080030']['Value'][0], 0, 2) . ':' . substr($estudio['00080030']['Value'][0], 2, 2))) }}
                                    </td>
                                @else
                                    <td>-</td>
                                @endif

                                {{-- DNI --}}
                                @if (isset($estudio['00100020']['Value'][0]))
                                    <td class="p-3 text-sm">
                                        {{ $estudio['00100020']['Value'][0] }}
                                    </td>
                                @else
                                    <td>-</td>
                                @endif

                                {{-- Paciente --}}
                                @if (isset($estudio['00100010']['Value'][0]['Alphabetic']))
                                    <td class="p-3 text-sm">
                                        {!! str_replace('^', ' ', $estudio['00100010']['Value'][0]['Alphabetic']) !!}

                                    </td>
                                @else
                                    <td>-</td>
                                @endif


                                {{-- Sexo --}}
                                @if (isset($estudio['00100040']['Value'][0]))
                                    <td class="p-3 text-sm">
                                        {{ $estudio['00100040']['Value'][0] }}
                                    </td>
                                @else
                                    <td class="p-3 text-sm">-</td>
                                @endif

                                {{-- ------------------------- --}}

                                {{-- Fecha de Nacimiento --}}
                                @if (isset($estudio['00100030']['Value'][0]))
                                    <td class="p-3 text-sm">
                                        {{ date('d/m/Y', strtotime($estudio['00100030']['Value'][0])) }}
                                    </td>
                                @else
                                    <td class="p-3 text-sm">-</td>
                                @endif

                                {{-- OS --}}
                                @if (isset($estudio['series'][0]['00081040']['Value'][0]))
                                    <td class="p-3 text-sm">
                                        {{ $estudio['series'][0]['00081040']['Value'][0] }}</td>
                                @elseif (isset($estudio['series'][0]['00081050']['Value'][0]['Alphabetic']))
                                    <td class="p-3 text-sm">
                                        {{ $estudio['series'][0]['00081050']['Value'][0]['Alphabetic'] }}</td>
                                @else
                                    <td>-</td>
                                @endif

                                {{-- doctor --}}
                                @if (isset($estudio['00080090']['Value'][0]['Alphabetic']))
                                    <td class="p-3 text-sm">
                                        {{ $estudio['00080090']['Value'][0]['Alphabetic'] }}</td>
                                @else
                                    <td class="p-3 text-sm">-</td>
                                @endif

                                {{-- Diagnostico --}}
                                @if (isset($estudio['00081030']['Value'][0]))
                                    <td class="p-3 text-sm">
                                        {{ $estudio['00081030']['Value'][0] }}</td>
                                @else
                                    <td class="p-3 text-sm">-</td>
                                @endif


                                {{-- descripcion --}}
                                {{-- @if (isset($estudio['001021B0']['Value'][0]))
                                    <td class="p-3 text-sm">
                                        {{ $estudio['001021B0']['Value'][0] }}</td>
                                @else
                                    <td class="p-3 text-sm">-</td>
                                @endif --}}

                                {{-- ------------------------- --}}

                                {{-- Ubicacion --}}
                                @if (isset($estudio['00080050']['Value'][0]))
                                    <td class="p-3 text-sm">
                                        {{ $estudio['00080050']['Value'][0] }}</td>
                                @else
                                    <td class="p-3 text-sm">-</td>
                                @endif

                                {{-- Parte del Cuerpo
                                @if (isset($estudio['00180015']['Value'][0]))
                                    <td class="p-3 text-sm">
                                        {{ $estudio['00180015']['Value'][0] }}</td>
                                @else
                                    <td>-</td>
                                @endif --}}

                                {{-- Cantidad de Instancias --}}
                                @if (isset($estudio['00201208']['Value'][0]))
                                    <td class="p-3 text-sm">
                                        {{ $estudio['00201208']['Value'][0] }}</td>
                                @else
                                    <td class="p-3 text-sm">-</td>
                                @endif

                                @if (array_search('DOC', $estudio['00080061']['Value']) != '')
                                    <td>
                                        <span
                                            class="text-sm inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 font-semibold text-green-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="h-3 w-3">
                                                <path fill-rule="evenodd"
                                                    d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Informado
                                        </span>
                                    </td>
                                @else
                                    <td>
                                        <span
                                            class="text-sm inline-flex items-center gap-1 rounded-full bg-red-50 dark:bg-gray-300 px-2 py-1  font-semibold text-red-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="h-3 w-3">
                                                <path
                                                    d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                            </svg>
                                            Pendiente
                                        </span>
                                    </td>
                                @endif

                                @if (isset($estudio['0020000D']['Value'][0]))
                                    <td class="text-sm whitespace-normal px-4 py-2">
                                        <a href="http://{{ config('api.url_medicview') }}/viewer.html?studyUID={{ $estudio['0020000D']['Value'][0] }}&serverName={{ config('api.server_medicview') }}"
                                            class="inline-block rounded bg-green-600 px-4 py-2 text-sm text-white hover:bg-green-700"
                                            target="_blank">
                                            Ver
                                        </a>
                                    </td>
                                    <td>

                                        @role('Administrador')
                                            @livewire('carga-informe', ['estudio' => $estudio['0020000D']['Value'][0], 'nombre' => $estudio['00100010']['Value'][0]['Alphabetic'], key($estudio['0020000D']['Value'][0])])
                                        @endrole

                                    </td>

                                    <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">
                                        <i class="fas fa-square-2-stack"></i>
                                        <a href="#"
                                            wire:click="copiarTexto('Estudio de {!! $estudio['00100010']['Value'][0]['Alphabetic'] !!} de fecha {{ date('d/m/Y', strtotime($estudio['00080020']['Value'][0])) }}: http://{{ config('api.url_medicview') }}/viewer.html?studyUID={{ $estudio['0020000D']['Value'][0] }}&serverName={{ config('api.server_medicview') }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.5 8.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v8.25A2.25 2.25 0 006 16.5h2.25m8.25-8.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-7.5A2.25 2.25 0 018.25 18v-1.5m8.25-8.25h-6a2.25 2.25 0 00-2.25 2.25v6" />
                                            </svg>
                                        </a>
                                    </td>
                                @else
                                    <td></td>
                                    <td></td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <td class="whitespace-normal px-4 py-2 text-sm text-gray-900">'No existen estudio cargados
                            para el filtro seleccionado.'</td>
                    @endif
                </tbody>
            </table>
            <div class="mt-4  bg-gray-100 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700   text-gray-700 dark:text-gray-400">
                {{ $paginator->links() }}
            </div>
        </div>

        @section('content')
            @push('styles')
                <style>
                    #estudios th,
                    #estudios td {
                        padding: 4px;
                        /* Ajusta el padding según sea necesario para reducir el espacio */
                        margin: 0;
                        /* Elimina cualquier margen entre celdas */
                    }
                </style>
            @endpush
        @endsection

        <script>
            document.addEventListener('livewire:load', function() {
                Livewire.on('copiarTexto', function(tempInput) {
                    // Agrega el elemento temporal al DOM para que esté disponible para copiar
                    document.body.insertAdjacentHTML('beforeend', tempInput);

                    // Selecciona el contenido del elemento temporal (input)
                    const input = document.getElementById('temp-input');
                    input.select();

                    // Ejecuta el comando de copiado al portapapeles
                    document.execCommand('copy');

                    // Remueve el elemento temporal del DOM
                    input.remove();

                    // Puedes mostrar una notificación o mensaje de éxito si lo deseas
                    alert('Texto copiado al portapapeles');
                });
            });
        </script>

        <script>
            document.addEventListener('livewire:load', function() {
                console.log('Livewire se ha cargado.');
                Livewire.on('borrar', function() {
                    console.log('Se ha llamado a borrar');
                });
                Livewire.on('mostrar', function() {
                    console.log('Se ha llamado a mostrar');
                });
            });
        </script>
    </div>
</div>
