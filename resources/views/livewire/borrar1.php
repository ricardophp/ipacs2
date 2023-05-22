<div>

    <!--Container-->
    <div class="container w-full md:w-4/5 xl:w-3/5  mx-auto px-2">

        {{-- Filtro Fecha --}}
        <div>
            <label>desde
                <input wire:model="fechad" type="date">
            </label>
            <label>hasta
                <input wire:model="fechah" type="date">
            </label>
            DESDE {{ $fechad }} HASTA {{ $fechah }}

        </div>

        <!--Card-->
        <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">

            <table id="estudios" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                <thead>
                    <tr>
                        @foreach ($fields as $field)
                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ $field }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>

                    @foreach ($studies as $study)
                    <tr>
                        @foreach ($fields as $field)
                            @if ((isset($study[$field]['Value'][0]) and ($field != "00081032") and ($field != "00081111") and ($field != "00082218")))
                                @if ((gettype($study[$field]['Value'][0]) == 'string') or (gettype($study[$field]['Value'][0]) == 'integer'))
                                    @if($field == "0020000D")
                                        <td class="whitespace-nowrap px-8 py-2 font-medium text-gray-900">{{ $study[$field]['Value'][0] }}</td>
                                    @else
                                        <td class="whitespace-normal px-4 py-2 text-gray-700">{{ $study[$field]['Value'][0] }}</td>
                                    @endif
                                @elseif (gettype($study[$field]['Value'][0]) == 'array')
                                    <td class="whitespace-normal px-4 py-2 text-gray-700">{{ $study[$field]['Value'][0]['Alphabetic'] }}</td>
                                @else
                                    <td>no entiendo esto {{ $study[$field]['Value'][0] }}</td>
                                @endif
                            @else
                                <td></td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach


                                {{-- @if (isset($estudio['0020000D']['Value'][0]))
                                    <td class="whitespace-normal px-4 py-2">

                                        <a href="http://imagenes.simedsalud.com.ar:8484/viewer.html?studyUID={{ $estudio['0020000D']['Value'][0] }}&serverName=Antartida"
                                            class="inline-block rounded bg-green-600 px-4 py-2 text-xs font-medium text-white hover:bg-green-700"
                                            target="_blank">
                                            Ver Estudio
                                        </a>
                                    </td>
                                @endif --}}

                </tbody>

            </table>
        </div>
        <!--/Card-->
    </div>

</div>

