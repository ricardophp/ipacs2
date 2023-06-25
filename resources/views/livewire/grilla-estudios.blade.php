<div>

    <!--Container-->
    {{-- <div class="container w-full md:w-4/5 xl:w-3/5  mx-auto px-2 padding-top: 1em;"> --}}
        <div class="flex justify-between items-center mb-4">
            <div>
                <label for="fechad">desde:</label>
                {{-- <input wire:model="fechad" type="date" id="fechad"> --}}
                <x-input wire:model="fechad" type="date" />

                <label for="fechah">hasta:</label>
                {{-- <input wire:model="fechah" type="date" id="fechah"> --}}
                <x-input wire:model="fechah" type="date" />

                <label for="paciente">paciente:</label>
                {{-- <input wire:model="paciente" type="text" id="paciente"> --}}
                <x-input wire:model="filtroPaciente" type="text" />
            </div>
        </div>
        <!--Card-->
        <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">

            <table id="estudios" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                <thead>
                    @if ($paginator->count())
                        <tr>
                            <th scope="col"
                                class="cursor-pointer whitespace-nowrap px-4 py-2 text-sm text-gray-900"
                                wire:click="ordenar('00080061')">Mod</th>
                            <th wire:click="ordenar('00080020')"
                                class="cursor-pointer whitespace-nowrap px-4 py-2 text-sm text-gray-900">Fecha</th>
                            <th wire:click="ordenar('00100020')"
                                class="cursor-pointer whitespace-nowrap px-4 py-2 text-sm text-gray-900">DNI</th>
                            <th wire:click="ordenar('00100010')"
                                class="cursor-pointer whitespace-nowrap px-4 py-2 text-sm text-gray-900">Paciente
                            </th>
                            <th wire:click="ordenar('00100040')"
                                class="cursor-pointer whitespace-nowrap px-4 py-2 text-sm text-gray-900">Sexo</th>

                            <th wire:click="ordenar('00100030')"
                                class="cursor-pointer whitespace-nowrap px-4 py-2 text-sm text-gray-900">F Nac</th>
                            {{-- <th wire:click="ordenar('00081040')"
                                class="cursor-pointer whitespace-nowrap px-4 py-2 text-sm text-gray-900">OS</th> --}}
                            <th wire:click="ordenar('00080090')"
                                class="cursor-pointer whitespace-nowrap px-4 py-2 text-sm text-gray-900">Médico</th>
                            <th wire:click="ordenar('00081030')"
                                class="cursor-pointer whitespace-nowrap px-4 py-2 text-sm text-gray-900">Diagnóstico
                            </th>
                            {{-- <th wire:click="ordenar('00080061')"
                                class="cursor-pointer whitespace-nowrap px-4 py-2 text-sm text-gray-900">Descripción
                            </th> --}}

                            <th wire:click="ordenar('00080050')"
                                class="cursor-pointer whitespace-nowrap px-4 py-2 text-sm text-gray-900">Ubicación
                            </th>
                            {{-- <th wire:click="ordenar('00180015')"
                                class="cursor-pointer whitespace-nowrap px-4 py-2 text-sm text-gray-900">P Cuerpo
                            </th> --}}
                            <th wire:click="ordenar('7777102A')"
                                class="cursor-pointer whitespace-nowrap px-4 py-2 text-sm text-gray-900">Inst</th>
                            <th>Informe</th>
                            <th class="cursor-pointer whitespace-nowrap px-4 py-2 text-sm text-gray-900">Acción</th>

                            </th>
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
                                    <td class="text-sm whitespace-normal px-4 py-2 text-gray-900">
                                        {{ $estudio['00080061']['Value'][0] }}</td>
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
                                    <td>-</td>
                                @endif

                                {{-- ------------------------- --}}

                                {{-- Fecha de Nacimiento --}}
                                @if (isset($estudio['00100030']['Value'][0]))
                                    <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">
                                        {{ date('d/m/Y', strtotime($estudio['00100030']['Value'][0])) }}</td>
                                @else
                                    <td>-</td>
                                @endif

                                {{-- OS --}}
                                {{-- @if (isset($estudio['00081040']['Value'][0]['Alphabetic']))
                                    <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">
                                        {{ $estudio['00081040']['Value'][0]['Alphabetic'] }}</td>
                                @else
                                    <td>-</td>
                                @endif --}}

                                {{-- doctor --}}
                                @if (isset($estudio['00080090']['Value'][0]['Alphabetic']))
                                    <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">
                                        {{ $estudio['00080090']['Value'][0]['Alphabetic'] }}</td>
                                @else
                                    <td>-</td>
                                @endif

                                {{-- Diagnostico --}}
                                @if (isset($estudio['00081030']['Value'][0]))
                                    <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">
                                        {{ $estudio['00081030']['Value'][0] }}</td>
                                @else
                                    <td>-</td>
                                @endif

                                {{-- descripcion --}}
                                {{-- <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">descripcion</td> --}}

                                {{-- ------------------------- --}}

                                {{-- Ubicacion --}}
                                @if (isset($estudio['00080050']['Value'][0]))
                                    <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">
                                        {{ $estudio['00080050']['Value'][0] }}</td>
                                @else
                                    <td>-</td>
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
                                    <td>-</td>
                                @endif

                                @if (array_search('DOC', $estudio['00080061']['Value']) != '')
                                    {{-- <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">
                                        {{ $estudio['00080061']['Value'][array_search('DOC', $estudio['00080061']['Value'])] }}
                                    </td> --}}
                                    <td class="px-6 py-4">
                                        <span class="text-sm inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 font-semibold text-green-600">
                                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3 w-3">
                                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                          </svg>
                                          Informado
                                        </span>
                                      </td>
                                @else
                                <td class="px-6 py-4">
                                    <span class="text-sm inline-flex items-center gap-1 rounded-full bg-red-50 px-2 py-1  font-semibold text-red-600">
                                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3 w-3">
                                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
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
                                        {{-- <x-danger-button wire:click="abreForm()" class="bg-blue-600">
                                            Informe
                                        </x-danger-button> --}}

                                        @livewire('carga-informe', ['estudio' => $estudio['0020000D']['Value'][0], 'nombre' => $estudio['00100010']['Value'][0]['Alphabetic'], key($estudio['0020000D']['Value'][0])])

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
            @if ($paginator->hasPages())
                <div class="mt-4">
                    {{ $paginator->links() }}
                </div>
            @endif
        </div>
        <!--/Card-->
    {{-- </div> --}}
</div>
