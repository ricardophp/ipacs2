@if (isset($row['studyUID']))
    <a href="http://imagenes.simedsalud.com.ar:8484/viewer.html?studyUID={{ $row['studyUID'] }}&serverName=Antartida"
        class="inline-block rounded bg-green-600 px-4 py-2 text-sm text-white hover:bg-green-700"
        target="_blank">
        Ver
    </a>
{{-- <td>
    @role('Administrador')
        @livewire('carga-informe', ['estudio' => $row['studyUID'], 'nombre' => $row['Paciente'], key($row['studyUID'])])
    @endrole
</td>
@else
<td></td> --}}
@endif

{{-- <td class="text-sm whitespace-normal px-4 py-2 text-gray-700">
<i class="fas fa-square-2-stack"></i>
<a href="#"
    wire:click="copiarTexto('Estudio de {!! $row['Paciente'] !!} de fecha {{ date('d/m/Y', strtotime($row['Fecha'])) }}: http://imagenes.simedsalud.com.ar:8484/viewer.html?studyUID={{$row['studyUID']}}&serverName=Antartida')">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M16.5 8.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v8.25A2.25 2.25 0 006 16.5h2.25m8.25-8.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-7.5A2.25 2.25 0 018.25 18v-1.5m8.25-8.25h-6a2.25 2.25 0 00-2.25 2.25v6" />
    </svg>
</a>
</td> --}}


