<div>
    {{-- envoltorio--}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                {{-- Empieza la Grilla -------------------------------- --}}

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                        <thead class="ltr:text-left rtl:text-right">
                            <tr>
                                @if ($data)
                                <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Mod</th>
                                <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Fecha</th>
                                <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Médico</th>
                                <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Diagnóstico</th>
                                <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Informe</th>
                                <th class="px-4 py-2">Acción</th>
                                @else
                                <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">No hay estudios para mostrar</th>
                                @endif
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
                            @if(isset($estudio['00081030']['Value'][0]))
                                <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{$estudio['00081030']['Value'][0]}}</td>
                            @else <td>-</td>
                            @endif

                                {{-- Informe --}}
                            @if((isset($estudio['00080061']['Value'][0]))and($estudio['00080061']['Value'][0]=='DOC'))
                            <td class="px-4 py-2">
                                <span class="text-sm inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 font-semibold text-green-600">
                                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3 w-3">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                  </svg>
                                  Informado
                                </span>
                              </td>
                            @else
                                <td>Pendiente</td>
                            @endif

                            @if(isset($estudio['0020000D']['Value'][0]))
                                <td class="whitespace-nowrap px-4 py-2">
                                    <a href="http://imagenes.simedsalud.com.ar:8484/viewer.html?studyUID={{$estudio['0020000D']['Value'][0]}}&serverName=Antartida"
                                        class="inline-block rounded bg-green-600 px-4 py-2 text-xs font-medium text-white hover:bg-green-700"
                                        target="_blank">
                                        @if((isset($estudio['00080061']['Value'][0]))and($estudio['00080061']['Value'][0]=='DOC'))
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
</div>
