<div>
    <!--Container-->
    <div class="flex justify-between items-center mb-4">
        <div>
            <label for="fechad">desde:</label>
            {{-- <input wire:model="fechad" type="date" id="fechad"> --}}
            <x-input wire:model="fechad" type="date" id="fechad"/>

            <label for="fechah">hasta:</label>
            {{-- <input wire:model.debounce.1s="fechah" type="date" id="fechah"> --}}
            <x-input wire:model="fechah" type="date" id="fechah"/>

            <label for="Nombre o DNI:">paciente:</label>
            {{-- <input wire:model.debounce.1s="paciente" type="text" id="paciente"> --}}
            <x-input wire:model="filtroPaciente" type="text" id="filtroPaciente"/>
        </div>
    </div>

    {{$cadena}}
    <!-- Mostrar mensaje de carga cuando $consultando sea true -->
    {{-- @if ($consultando)
        <div class="text-gray-500 text-center py-4">
            Consultando, por favor espere...
        </div>
    @endif --}}

    <!--Card-->
    <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
        @if ($copiado)
            <div>Contenido copiado al portapapeles</div>
        @endif
        <table id="estudios" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
            <thead>
                @if ($paginator->count())
                    <tr>
                        <th scope="col" class="cursor-pointer w-2 px-4 py-2 text-sm text-gray-900"
                            wire:click="ordenar('00080061')">Mod</th>
                        <th wire:click="ordenar('00080020')" class="cursor-pointer w-5 px-4 py-2 text-sm text-gray-900">
                            Fecha</th>
                        <th wire:click="ordenar('00100020')" class="cursor-pointer w-5 px-4 py-2 text-sm text-gray-900">
                            DNI</th>
                        <th wire:click="ordenar('00100010')"
                            class="cursor-pointer w-20 px-4 py-2 text-sm text-gray-900">Paciente
                        </th>
                        <th wire:click="ordenar('00100040')" class="cursor-pointer w-1 px-4 py-2 text-sm text-gray-900">
                            Sexo</th>

                        <th wire:click="ordenar('00100030')" class="cursor-pointer w-2 px-4 py-2 text-sm text-gray-900">
                            F Nac</th>
                        <th wire:click="ordenar('00081040')" class="cursor-pointer w-1 px-4 py-2 text-sm text-gray-900">
                            OS</th>
                        <th wire:click="ordenar('00080090')" class="cursor-pointer w-4 px-4 py-2 text-sm text-gray-900">
                            Médico</th>
                        <th wire:click="ordenar('00081030')"
                            class="cursor-pointer w-20 px-4 py-2 text-sm text-gray-900 ">Diagnóstico
                        </th>
                        {{-- <th wire:click="ordenar('00080061')"
                            class="cursor-pointer px-4 py-2 text-sm text-gray-900">Descripción
                        </th> --}}

                        <th wire:click="ordenar('00080050')" class="cursor-pointer w-1 px-4 py-2 text-sm text-gray-900">
                            Ubicación
                        </th>
                        {{-- <th wire:click="ordenar('00180015')"
                            class="cursor-pointer px-4 py-2 text-sm text-gray-900">P Cuerpo
                        </th> --}}
                        <th wire:click="ordenar('7777102A')" class="cursor-pointer w-1 px-4 py-2 text-sm text-gray-900">
                            Inst</th>
                        <th class="w-1">Informe</th>
                        <th class="w-1 px-4 py-2 text-sm text-gray-900">Acción</th>
                        <th class="w-1 px-4 py-2 text-sm text-gray-900"></th>
                        <th class="w-1 px-4 py-2 text-sm text-gray-900">Link</th>
                    </tr>
                @else
                    <tr></tr>
                @endif
            </thead>
            <tbody>
                @if ($paginator->count())
                    @foreach ($paginator as $estudio)
                        <tr>
                            {{-- Modalidad --}}
                            @if (isset($estudio['00080061']['Value'][0]))
                                @if (isset($estudio['00080061']['Value'][0]) and $estudio['00080061']['Value'][0] == 'DOC')
                                    <td class="px-4 py-2 font-medium text-gray-900">
                                        {{ $estudio['00080061']['Value'][1] }}</td>
                                @else
                                    <td class="px-4 py-2 font-medium text-gray-900">
                                        {{ $estudio['00080061']['Value'][0] }}</td>
                                @endif
                            @else
                                <td>-</td>
                            @endif
                            {{-- Fecha --}}
                            @if (isset($estudio['00080020']['Value'][0]))
                                <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">
                                    {{ date('d/m/Y', strtotime($estudio['00080020']['Value'][0])) }}</td>
                            @else
                                <td>-</td>
                            @endif

                            {{-- DNI --}}
                            @if (isset($estudio['00100020']['Value'][0]))
                                <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">
                                    {{ $estudio['00100020']['Value'][0] }}</td>
                            @else
                                <td>-</td>
                            @endif

                            {{-- Paciente --}}
                            @if (isset($estudio['00100010']['Value'][0]['Alphabetic']))
                                <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">
                                    {!! $estudio['00100010']['Value'][0]['Alphabetic'] !!}</td>
                            @else
                                <td>-</td>
                            @endif


                            {{-- Sexo --}}
                            @if (isset($estudio['00100040']['Value'][0]))
                                <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">
                                    {{ $estudio['00100040']['Value'][0] }}</td>
                            @else
                                <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">-</td>
                            @endif

                            {{-- ------------------------- --}}

                            {{-- Fecha de Nacimiento --}}
                            @if (isset($estudio['00100030']['Value'][0]))
                                <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">
                                    {{ date('d/m/Y', strtotime($estudio['00100030']['Value'][0])) }}</td>
                            @else
                                <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">-</td>
                            @endif

                            {{-- OS --}}
                            @if (isset($estudio['series'][0]['00081040']['Value'][0]))
                                <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">
                                    {{ $estudio['series'][0]['00081040']['Value'][0] }}</td>
                            @elseif (isset($estudio['series'][0]['00081050']['Value'][0]['Alphabetic']))
                                <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">
                                    {{ $estudio['series'][0]['00081050']['Value'][0]['Alphabetic'] }}</td>
                            @else
                                <td>-</td>
                            @endif

                            {{-- doctor --}}
                            @if (isset($estudio['00080090']['Value'][0]['Alphabetic']))
                                <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">
                                    {{ $estudio['00080090']['Value'][0]['Alphabetic'] }}</td>
                            @else
                                <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">-</td>
                            @endif

                            {{-- Diagnostico --}}
                            @if (isset($estudio['00081030']['Value'][0]))
                                <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">
                                    {{ $estudio['00081030']['Value'][0] }}</td>
                            @else
                                <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">-</td>
                            @endif


                            {{-- descripcion --}}
                            {{-- @if (isset($estudio['001021B0']['Value'][0]))
                                <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">
                                    {{ $estudio['001021B0']['Value'][0] }}</td>
                            @else
                                <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">-</td>
                            @endif --}}

                            {{-- ------------------------- --}}

                            {{-- Ubicacion --}}
                            @if (isset($estudio['00080050']['Value'][0]))
                                <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">
                                    {{ $estudio['00080050']['Value'][0] }}</td>
                            @else
                                <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">-</td>
                            @endif

                            {{-- Parte del Cuerpo
                            @if (isset($estudio['00180015']['Value'][0]))
                                <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">
                                    {{ $estudio['00180015']['Value'][0] }}</td>
                            @else
                                <td>-</td>
                            @endif --}}

                            {{-- Cantidad de Instancias --}}
                            @if (isset($estudio['00201208']['Value'][0]))
                                <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">
                                    {{ $estudio['00201208']['Value'][0] }}</td>
                            @else
                                <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">-</td>
                            @endif

                            @if (array_search('DOC', $estudio['00080061']['Value']) != '')
                                {{-- <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">
                                    {{ $estudio['00080061']['Value'][array_search('DOC', $estudio['00080061']['Value'])] }}
                                </td> --}}
                                <td class="px-6 py-4">
                                    <span
                                        class="text-sm inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 font-semibold text-green-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="h-3 w-3">
                                            <path fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Informado
                                    </span>
                                </td>
                            @else
                                <td class="px-6 py-4">
                                    <span
                                        class="text-sm inline-flex items-center gap-1 rounded-full bg-red-50 px-2 py-1  font-semibold text-red-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="h-3 w-3">
                                            <path
                                                d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                        </svg>
                                        Pendiente
                                    </span>
                                </td>
                            @endif

                            @if (isset($estudio['0020000D']['Value'][0]))
                                <td class="text-sm whitespace-normal px-4 py-2">
                                    <a href="http://imagenes.simedsalud.com.ar:8484/viewer.html?studyUID={{ $estudio['0020000D']['Value'][0] }}&serverName=Antartida"
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
                            @else
                                <td></td>
                                <td></td>
                            @endif


                            <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">
                                <i class="fas fa-square-2-stack"></i>
                                <a href="#"
                                    wire:click="copiarTexto('Estudio de {!! $estudio['00100010']['Value'][0]['Alphabetic'] !!} de fecha {{ date('d/m/Y', strtotime($estudio['00080020']['Value'][0])) }}: http://imagenes.simedsalud.com.ar:8484/viewer.html?studyUID={{ $estudio['0020000D']['Value'][0] }}&serverName=Antartida')">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.5 8.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v8.25A2.25 2.25 0 006 16.5h2.25m8.25-8.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-7.5A2.25 2.25 0 018.25 18v-1.5m8.25-8.25h-6a2.25 2.25 0 00-2.25 2.25v6" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <td class="whitespace-normal px-4 py-2 text-sm text-gray-900">'No existen estudio cargados
                        para el filtro seleccionado.'</td>
                @endif


            </tbody>

        </table>
        @if ($paginator->hasPages())
            <div class="mt-4">
                {{ $paginator->links() }}
            </div>
        @endif

    </div>
    <!--/Card-->

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
    document.addEventListener('livewire:load', function () {
        console.log('Livewire se ha cargado.');
        Livewire.on('borrar', function () {
            console.log('Se ha llamado a ocultarConsultando');
        });
        Livewire.on('mostrar', function () {
            console.log('Se ha llamado a MostrarConsultando');
        });
    });
</script>


</div>



