<div>
    {{-- envoltorio--}}
    <div class="py-12 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                {{-- Empieza la Grilla -------------------------------- --}}

                <div class="overflow-x-auto rounded-lg shadow hidden md:block">
                @if ($data->count()>0)
                    <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                        <thead class="ltr:text-left rtl:text-right">
                            <tr>
                                <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Mod</th>
                                <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Fecha</th>
                                <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Médico</th>
                                <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Diagnóstico</th>
                                <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Informe</th>
                                <th class="px-4 py-2">Acción</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                        @if ($data)
                            @foreach ($data as $estudio)
                            <tr>
                            {{-- Modalidad --}}
                            @if (isset($estudio['00080061']['Value'][0]))
                              @if((isset($estudio['00080061']['Value'][0]))and($estudio['00080061']['Value'][0]=='DOC'))
                                <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{$estudio['00080061']['Value'][1]}}</td>
                                @else
                                <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{$estudio['00080061']['Value'][0]}}</td>
                                @endif
                            @else
                                <td>-</td>
                            @endif

                                {{-- Fecha--}}
                            @if(isset($estudio['00080020']['Value'][0]))
                                <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{date('d/m/Y', strtotime($estudio['00080020']['Value'][0]))}}</td>
                            @else
                                <td>-</td>
                            @endif

                            {{-- doctor --}}
                            @if(isset($estudio['00080090']['Value'][0]['Alphabetic']))
                                <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{$estudio['00080090']['Value'][0]['Alphabetic']}}</td>
                            @else
                                <td>-</td>
                            @endif

                                {{-- Diagnostico--}}
                            <div class="visible md:invisible">
                            @if(isset($estudio['00081030']['Value'][0]))
                                <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{$estudio['00081030']['Value'][0]}}</td>
                            @else <td>-</td>
                            @endif
                            </div>

                                {{-- Informe --}}
                            @if (array_search('DOC', $estudio['00080061']['Value']) != '')
                            <td class="px-4 py-2">
                                <span class="text-sm inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 font-semibold text-green-600">
                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3 w-3">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                  </svg>
                                  Informado
                                </span>
                              </td>
                            @else
                            <td class="px-4 py-2">
                                <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2 py-1 text-xs font-semibold text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3 w-3">
                                      <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                    </svg>
                                    Informe Pendiente
                                  </span>
                                </td>
                            @endif

                            @if(isset($estudio['0020000D']['Value'][0]))
                                <td class="whitespace-nowrap px-4 py-2">
                                    <a href="http://imagenes.simedsalud.com.ar:8484/viewer.html?studyUID={{$estudio['0020000D']['Value'][0]}}&serverName=Antartida"
                                        class="inline-block rounded bg-green-600 px-4 py-2 text-xs font-medium text-white hover:bg-green-700"
                                        target="_blank">
                                        @if (array_search('DOC', $estudio['00080061']['Value']) != '')
                                        Ver Estudio + informe
                                        @else
                                        Ver Estudio
                                        @endif
                                    </a>
                                </td>
                            @else
                                <td>-</td>
                            @endif
                            </tr>
                            @endforeach
                        @else
                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">'No existen estudio cargados con su DNI. Si cree que es un error comuníquese con el área diagnóstico por Imágenes Sanatorio Antártida'</td>
                        @endif
                        </tbody>
                    </table>
                    @else
                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">No hay estudios para mostrar</th>
                    @endif
                    @if ($data->hasPages())
                    <div class="mt-4">
                        {{ $data->links() }}
                    </div>
                    @endif
                </div>
                {{-- fin grilla ------------------------ --}}
            </div>
        </div>
    </div>

 <x-action-message class="mr-3" on="created">
    Probando el componente action-message
</x-action-message>


                {{-- GRILLA PARA mobile--}}
                @if($data)
                <div class="p-5 h-screen bg-gray-100">
                <h1 class="text-xl mb-2 md:hidden">Mis Estudios</h1>
                @foreach ($data as $estudio)

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 border-gray-200 md:hidden">
                    <div class="mb-4 bg-white space-y-3 p-4 border-gray-200 rounded-lg shadow">
                      <div class="flex items-center border-gray-200 space-x-2 text-sm">
                        <div>
                            {{-- Modalidad --}}
                            @if (isset($estudio['00080061']['Value'][0]))
                              @if((isset($estudio['00080061']['Value'][0]))and($estudio['00080061']['Value'][0]=='DOC'))
                                <a class="text-blue-500 font-bold">{{$estudio['00080061']['Value'][1]}}</a>
                                @else
                                <a class="text-blue-500 font-bold">{{$estudio['00080061']['Value'][0]}}</a>
                                @endif
                            @else
                                <a>-</a>
                            @endif
                        </div>
                        <div class="text-gray-500">
                                {{-- Fecha--}}
                                @if(isset($estudio['00080020']['Value'][0]))
                                <a class="whitespace-nowrap px-4 py-2 text-gray-700 font-bold">{{date('d/m/Y', strtotime($estudio['00080020']['Value'][0]))}}</a>
                            @else
                                <a>-</a>
                            @endif
                        </div>
                        <div>
                            {{-- doctor --}}
                            @if(isset($estudio['00080090']['Value'][0]['Alphabetic']))
                            <a class="whitespace-nowrap px-4 py-2 text-gray-700 font-bold">Médico: {{$estudio['00080090']['Value'][0]['Alphabetic']}}</a>
                            @else
                            <a>-</a>
                            @endif
                        </div>
                        <div>
                            {{-- Informe --}}
                            @if((isset($estudio['00080061']['Value'][0]))and($estudio['00080061']['Value'][0]=='DOC'))
                            <a class="px-4 py-2">
                                <span class="text-sm inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 font-semibold text-green-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3 w-3">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                    </svg>
                                    Informado
                                </span>
                                </a>
                            @else
                            <a class="px-4 py-2">
                            <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2 py-1 text-xs font-semibold text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3 w-3">
                                  <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                </svg>
                                Informe Pendiente
                              </span>
                                </a>
                            @endif
                        </div>
                      </div>
                      <div>
                        @if(isset($estudio['00081030']['Value'][0]))
                            <a class="whitespace-nowrap px-4 py-2 text-gray-700">Diagnóstico: {{$estudio['00081030']['Value'][0]}}</a>
                        @else <a>-</a>
                        @endif
                       </div>
                      <div class="text-sm font-medium text-black">
                        @if(isset($estudio['0020000D']['Value'][0]))
                        <a class="whitespace-nowrap px-4 py-2">
                            <a href="http://imagenes.simedsalud.com.ar:8484/viewer.html?studyUID={{$estudio['0020000D']['Value'][0]}}&serverName=Antartida"
                                class="inline-block rounded bg-green-600 px-4 py-2 text-xs font-medium text-white hover:bg-green-700"
                                target="_blank">
                                @if((isset($estudio['00080061']['Value'][0]))and($estudio['00080061']['Value'][0]=='DOC'))
                                Ver Estudio + informe
                                @else
                                Ver Estudio
                                @endif
                            </a>
                        </a>
                    </div>
                    @else
                        <a>-</a>
                    @endif
                      </div>

                </div>
                @endforeach
                @if ($data->hasPages())
                <div class="mt-4 md:hidden">
                    {{ $data->links() }}
                </div>
                @endif
                @else
                <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">'No existen estudio cargados con su DNI. Si cree que es un error comuníquese con el área diagnóstico por Imágenes Sanatorio Antártida'</td>
                @endif

                {{-- FIN GRILLA PARA MOBILE--}}
</div>
