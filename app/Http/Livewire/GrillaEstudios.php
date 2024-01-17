<?php

namespace App\Http\Livewire;

use App\Exports\StudiesExport;
use App\Models\Estudio;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class GrillaEstudios extends Component
{
    use WithPagination;

    public $fechad, $fechah, $perPage;
    public $filtroPaciente, $mayuscula, $cadena;
    public $consultando = true;

    public $campoOrden = '00080020'; //fecha
    public $tipoOrden = 'DESC';
    public $exportando = false; // Variable para controlar el estado de exportación
    public $mostrarMensajeExportacion = false; // Variable para controlar la visibilidad del mensaje de exportación

    protected $listeners = ['borrar' => 'borrar', 'InformeExito' => 'render','exportar'];

    public $copiado = false;


    public function borrar()
    {
        $this->consultando = false;
    }


    // public function mostrar()
    // {
    //     $this->consultando = true;
    // }

    public function mount()
    {
        $hoy = date("Y-m-d");
        //        $this->fechad = date("Y-m-d");
        $this->fechad = date("Y-m-d", strtotime($hoy . " -1 day"));
        $this->fechah = date("Y-m-d");
    }

    public function render()
    {
        $this->perPage = 50;
        $page = $this->page;


        $desde = str_replace("-", "", $this->fechad);
        $hasta = str_replace("-", "", $this->fechah);

        $DNIPaciente = intval($this->filtroPaciente);

        if ($DNIPaciente === 0)
            $paciente = '&PatientName=';
        else
            $paciente = '&PatientID=';


        $this->mayuscula = strtoupper($this->filtroPaciente);

        if ($this->mayuscula <> '') {
            $filtro = $paciente . $this->mayuscula . '*&fuzzymatching=false';
        } else {
            $filtro = '&limit=' . $this->perPage . '&offset=' . ($page - 1) * $this->perPage;
        }

        $url_remota = config('api.url_remota');
        $ae_title_remoto = config('api.ae_title_remoto');

        //$this->cadena='$paciente='.$paciente.' http://imagenes.simedsalud.com.ar:8080/dcm4chee-arc/aets/SSPACS/rs/studies?includefield=all&StudyDate=' . $desde . '-' . $hasta . $filtro;
        $response = Http::get($url_remota . ':8080/dcm4chee-arc/aets/' . $ae_title_remoto . '/rs/studies?includefield=all&StudyDate=' . $desde . '-' . $hasta . $filtro);
        $studies = $response->json();

        $response2 = Http::get($url_remota . ':8080/dcm4chee-arc/aets/' . $ae_title_remoto . '/rs/studies/count?StudyDate=' . $desde . '-' . $hasta . $filtro);
        $count = $response2->json();

        $total = $count["count"] ?? 0;

        if (isset($studies)) { // Obtener los campos de las series para cada estudio y combinarlos
            foreach ($studies as &$study) {
                $studyId = $study['0020000D']['Value'][0]; // Reemplaza con la clave correcta para el ID del estudio
                $seriesResponse = Http::get($url_remota . ':8080/dcm4chee-arc/aets/' . $ae_title_remoto . '/rs/studies/' . $studyId . '/series?includefield=all');
                $series = $seriesResponse->json();
                $study['series'] = $series;

                if (array_search('DOC', $study['00080061']['Value']) != '')
                    $informe = 'si';
                else $informe = 'no';
                $dataToUpsert[] = [
                    'Fecha' => $study['00080020']['Value'][0]??NULL,
                    'Hora' => isset($study['00080030']['Value'][0])?substr($study['00080030']['Value'][0], 0, 4):NULL,
                    'DNI' => isset($study['00100020']['Value'][0])?$study['00100020']['Value'][0]:'-',
                    'Paciente' => isset($study['00100010']['Value'][0]['Alphabetic'])?$study['00100010']['Value'][0]['Alphabetic']:'-',
                    'Sexo' => isset($study['00100040']['Value'][0]) ? $study['00100040']['Value'][0] : '-',
                    'Nacimiento' => $study['00100030']['Value'][0] ?? NULL,
                    'Os' => isset($study['series'][0]['00081040']['Value'][0])
                        ? $study['series'][0]['00081040']['Value'][0]
                        : (isset($study['series'][0]['00081050']['Value'][0]['Alphabetic'])
                            ? $study['series'][0]['00081050']['Value'][0]['Alphabetic']
                            : '-'),
                    'Médico' => isset($study['00080090']['Value'][0]['Alphabetic']) ? $study['00080090']['Value'][0]['Alphabetic'] : '-',
                    'Diagnóstico' => isset($study['00081030']['Value'][0]) ? $study['00081030']['Value'][0] : '-',
                    'Descripcion' => isset($study['001021B0']['Value'][0]) ? $study['001021B0']['Value'][0] : '-', // (0010,21B0) No estaba claro en tu código original
                    'Ubicación' => isset($study['00080050']['Value'][0]) ? $study['00080050']['Value'][0] : '-',
                    'PCuerpo' => isset($study['series'][0]['00180015']['Value'][0])?$study['series'][0]['00180015']['Value'][0]:'-',
                    'Mo' => ($study['00080061']['Value'][0] == 'DOC') ? $study['00080061']['Value'][1] : $study['00080061']['Value'][0],
                    'Informe' => $informe,
                    'CantInst' => $study['00201208']['Value'][0]??NULL,
                    'studyUID' => $study['0020000D']['Value'][0],
                ];
            }

            Estudio::upsert($dataToUpsert, ['studyUID'], ['Fecha', 'Hora', 'DNI', 'Paciente', 'Sexo', 'Nacimiento', 'Os', 'Médico', 'Diagnóstico', 'Descripcion', 'Ubicación', 'PCuerpo', 'Mo', 'Informe', 'CantInst']);
        }
        $studiesCollection = collect($studies);


        // Ordenar los resultados según el campo y tipo de orden
        if (isset($studies)) {
            $studiesCollection = $studiesCollection->sortByDesc(function ($item) {
                return $item['00080020']['Value'][0];
            })->values();
        }
        $paginator = new LengthAwarePaginator($studiesCollection, $total, $this->perPage, $page);
        $paginator->withPath(request()->url());

        return view('livewire.grilla-estudios', compact('paginator'));
    }

    public function exportar()
    {
        // Establece el estado de exportación a true
       $this->exportando = true;
       $this->emit('mostrarMensajeExportacion');

       $export = new StudiesExport($this->fechad, $this->fechah, $this->filtroPaciente);
       return Excel::download($export, 'estudios.xlsx');

        // Establece el estado de exportación a false después de finalizar
        $this->exportando = false;

        $this->emit('ocultarMensajeExportacion');
    }


    // public function render()
    // {
    //     $this->perPage = 50;
    //     //$page = request()->query('page', 1); // Obtener el número de página actual
    //     $page = $this->page;


    //     // if (!$this->fechad) $this->fechad = date("Y-m-d");
    //     // if (!$this->fechah) $this->fechah = date("Y-m-d");

    //     $desde = str_replace("-", "", $this->fechad);
    //     $hasta = str_replace("-", "", $this->fechah);

    //     //',PatientID='.$this->paciente.
    //     if (isset($this->filtroPaciente)) $filtro='&PatientName='.$this->filtroPaciente.'&fuzzymatching=true';
    //     else $filtro='&limit=' . $this->perPage . '&offset=' . ($page - 1) * $this->perPage;

    //     $response = Http::get('http://imagenes.simedsalud.com.ar:8080/dcm4chee-arc/aets/SSPACS/rs/studies?includefield=all&StudyDate=' . $desde . '-' . $hasta . $filtro);
    //     $studies = $response->json();


    //     $response2 = Http::get('http://imagenes.simedsalud.com.ar:8080/dcm4chee-arc/aets/SSPACS/rs/studies/count?StudyDate=' . $desde . '-' . $hasta.$filtro); //.'&limit='.$perPage.'&offset='.($page - 1) * $perPage);
    //     $count = $response2->json();

    //     $total = $count["count"] ?? 0;

    //     $studies = collect($response->json());



    //     // Ordenar los resultados según el campo y tipo de orden
    //     //$studies = $studies->sortByDesc($this->campoOrden, SORT_REGULAR)->values(); //, $this->tipoOrden === 'DESC'
    //     $studies = $studies->sortByDesc(function ($item) {
    //         return $item['00080020']['Value'][0]; // Especifica el campo dentro de 'Value' para el ordenamiento
    //     })->values();


    //     $paginator = new LengthAwarePaginator($studies, $total, $this->perPage, $page);
    //     $paginator->withPath(request()->url());

    //     return view('livewire.grilla-estudios', compact('paginator')); //['paginator' => $paginator,'studies' => $this->studies]);

    // }

    public function gotoPage($page)
    {
        $this->page = $page;
    }

    public function ordenar($campo)
    {
        if ($this->campoOrden === $campo) {
            $this->tipoOrden = $this->tipoOrden === 'asc' ? 'desc' : 'asc';
        } else {
            $this->campoOrden = $campo;
            $this->tipoOrden = 'asc';
        }
    }

    public function copiarTexto($texto)
    {
        // Crea un elemento temporal (input) para copiar el texto al portapapeles
        $tempInput = "<input type='text' value='{$texto}' id='temp-input'>";
        $this->emit('copiarTexto', $tempInput);
    }
}
