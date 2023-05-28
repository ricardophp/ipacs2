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
                                <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Paciente</th>
                                <th class="px-4 py-2">Boton</th>
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
                            <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{$estudio['00080061']['Value'][0]}}</td>

                                {{-- Fecha--}}
                            @if(isset($estudio['00080020']['Value'][0]))
                                <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{date('d/m/Y', strtotime($estudio['00080020']['Value'][0]))}}</td>
                            @else <td>-</td>
                            @endif

                            {{-- doctor --}}
                            @if(isset($estudio['00080090']['Value'][0]['Alphabetic']))
                                <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{$estudio['00080090']['Value'][0]['Alphabetic']}}</td>
                            @else <td>-</td>
                            @endif

                                {{-- Diagnostico--}}
                            @if(isset($estudio['00081030']['Value'][0]))
                                <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{$estudio['00081030']['Value'][0]}}</td>
                            @else <td>-</td>
                            @endif

                                {{-- Paciente--}}
                            @if(isset($estudio['00100010']['Value'][0]['Alphabetic']))
                                <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{$estudio['00100010']['Value'][0]['Alphabetic']}}</td>
                                @else <td>-</td>
                            @endif

                            {{-- DNI--}}
    {{--                             @if(isset($estudio['00100020']['Value'][0]))
                                <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{$estudio['00100020']['Value'][0]}}</td>
                            @else <td>-</td>
                            @endif

                            {{-- Nacim--}}
    {{--                             @if(isset($estudio['00100030']['Value'][0]))
                                <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{$estudio['00100030']['Value'][0]}}</td>
                            @else <td>-</td>
                            @endif

                            {{-- Sexo--}}
    {{--                             @if(isset($estudio['00100040']['Value'][0]))
                                <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{$estudio['00100040']['Value'][0]}}</td>
                            @else <td>-</td>
                            @endif

                                                {{-- Edad--}}
    {{--                             @if(isset($estudio['00101010']['Value'][0]))
                                <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{$estudio['00101010']['Value'][0]}}</td>
                            @else <td>-</td>
                            @endif

                                {{-- Tipo--}}
    {{--                             @if(isset($estudio['00080050']['Value'][0]))
                                <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{$estudio['00080050']['Value'][0]}}</td>
                            @else <td>-</td>
                            @endif
                            --}}
                            @if(isset($estudio['0020000D']['Value'][0]))

                            <td class="whitespace-nowrap px-4 py-2">

                                <a href="http://imagenes.simedsalud.com.ar:8484/viewer.html?studyUID={{$estudio['0020000D']['Value'][0]}}&serverName=Antartida"
                                    class="inline-block rounded bg-green-600 px-4 py-2 text-xs font-medium text-white hover:bg-green-700"
                                    target="_blank">
                                    Ver Estudio
                                </a>
                            </td>

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
