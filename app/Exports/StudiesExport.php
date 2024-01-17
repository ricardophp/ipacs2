<?php

namespace App\Exports;

use App\Models\Estudio;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\Http;

class StudiesExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $estudios;

    public $fechad, $fechah, $filtroPaciente, $mayuscula;


    public function __construct($fechad, $fechah, $filtroPaciente)
    {
        $this->fechad = $fechad;
        $this->fechah = $fechah;
        $this->filtroPaciente = $filtroPaciente;
    }



    public function collection()
    {
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
            $filtro = '';
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
        }

        $tableCollection = collect($dataToUpsert)->map(function ($item) {

            // Formatear la fecha
            $formattedDate = isset($item['Fecha']) ? \Carbon\Carbon::parse($item['Fecha'])->format('d/m/Y') : null;
            $item['Fecha'] = $formattedDate;

            $formattedHora = isset($item['Hora']) ? \Carbon\Carbon::parse($item['Hora'])->format('H:i') : null;
            $item['Hora'] = $formattedHora;

            $formattedDate = isset($item['Nacimiento']) ? \Carbon\Carbon::parse($item['Nacimiento'])->format('d/m/Y') : null;
            $item['Nacimiento'] = $formattedDate;

            return collect($item)->only(['Fecha', 'Hora', 'DNI', 'Paciente', 'Sexo', 'Nacimiento', 'Os', 'Médico', 'Diagnóstico', 'Descripcion', 'Ubicación', 'PCuerpo', 'Mo', 'Informe', 'CantInst']);
        });

        // Agregar los nombres de los campos en el primer registro
        $columnNames = collect(['Fecha', 'Hora', 'DNI', 'Paciente', 'Sexo', 'Nacimiento', 'Os', 'Médico', 'Diagnóstico', 'Descripcion', 'Ubicación', 'PCuerpo', 'Mo', 'Informe', 'CantInst']);
        $tableCollection->prepend($columnNames, '__columnNames');

        return $tableCollection;
    }
}
