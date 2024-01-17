<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\TemporaryUploadedFile;
use Illuminate\Http\File;

use GuzzleHttp\Client;



class CargaInforme extends Component
{
    use WithFileUploads;


    public $open = false;
    public $title="Informe", $content="Informe", $pdf;
    public $estudio, $nombre, $key;
    public $response;

    protected $rules = [
        'title' => 'required|max:100',
        'content' => 'required',
     //   'pdf' => 'required|mimes:pdf|max:10240'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount(string $estudio, $nombre)
    {
        $this->estudio = $estudio;
        $this->nombre = $nombre;
    }

    public function  mwl()
    {
        $url = 'http://10.8.0.1:8080/dcm4chee-arc/aets/SSPACS/rs/mwlitems';

        $headers = [
            'Content-Type' => 'application/json',
        ];

        $jsonData = [
            '00100020' => ['vr' => 'LO', 'Value' => ['16142085']],
            '00080005' => ['vr' => 'CS', 'Value' => ['ISO_IR 100']],
            '00080050' => ['vr' => 'SH', 'Value' => ['ACC2021004580']],
            '0020000D' => ['vr' => 'UI', 'Value' => ['2.25.73206828945598928592846069017840410753']],
            '00380010' => ['vr' => 'LO', 'Value' => ['ADM123']],
            '00400100' => [
                'vr' => 'SQ',
                'Value' => [
                    [
                        '00080060' => ['vr' => 'CS', 'Value' => ['CR']],
                        '00400001' => ['vr' => 'AE', 'Value' => ['SSAET2']],
                        '00400002' => ['vr' => 'DA', 'Value' => ['20210218']],
                        '00400003' => ['vr' => 'TM', 'Value' => ['000000']],
                        '00400008' => ['vr' => 'SQ'],
                        '00400009' => ['vr' => 'SH', 'Value' => ['ACC2021004580']],
                        '00400020' => ['vr' => 'CS', 'Value' => ['SCHEDULED']],
                    ],
                ],
            ],
            '00401001' => ['vr' => 'SH', 'Value' => ['ACC2021004580']],
            '00401400' => ['vr' => 'LT', 'Value' => ['.']],
            '00402017' => ['vr' => 'LO', 'Value' => ['ACC2021004580']],
        ];

        $client = new Client();

        $response = $client->post($url, [
            'headers' => $headers,
            'json' => $jsonData,
        ]);

        // Puedes manejar la respuesta como desees, por ejemplo:
        $statusCode = $response->getStatusCode();
        $responseBody = $response->getBody()->getContents();

        return response()->json(['status' => $statusCode, 'response' => json_decode($responseBody)]);
    }

        /* *****************************************************************************************
        00100020 - Patient ID (Identificación del Paciente):

        vr: Tipo de valor (en este caso, "LO" que indica una cadena de texto)
        Value: Valor del campo (en este caso, "P12345" es un ejemplo de identificación de paciente)

        00100021 - Issuer of Patient ID (Emisor de la identificación del paciente):
        vr: Tipo de valor ("LO")
        Value: Valor del campo ("ADT" es un ejemplo)

        00080005 - Specific Character Set (Conjunto de caracteres específico):
        vr: Tipo de valor ("CS" para Código de Cadena)
        Value: Valor del campo ("ISO_IR 100" es un ejemplo)

        00080050 - Accession Number (Número de acceso):
        vr: Tipo de valor ("SH" para Código de Cadena Corto)
        Value: Valor del campo ("ACC2021004580" es un ejemplo)

        0020000D - Study Instance UID (UID de la Instancia de Estudio):
        vr: Tipo de valor ("UI" para Identificador Único)
        Value: Valor del campo ("2.25.73206828945598928592846069017840410753" es un ejemplo)

        00380010 - Admission ID (ID de admisión):
        vr: Tipo de valor ("LO" para Código de Cadena Largo)
        Value: Valor del campo ("ADM123" es un ejemplo)

        00400100 - Scheduled Procedure Step Sequence (Secuencia de pasos de procedimiento programado):
        vr: Tipo de valor ("SQ" para Secuencia)
        Value: Array que contiene subcampos para describir el procedimiento programado.

        00401001 - Scheduled Station Name (Nombre de la estación programada):
        vr: Tipo de valor ("SH" para Código de Cadena Corto)
        Value: Valor del campo ("ACC2021004580" es un ejemplo)

        00401400 - Comments on the Scheduled Procedure Step (Comentarios sobre el paso de procedimiento programado):
        vr: Tipo de valor ("LT" para Texto Largo)
        Value: Valor del campo ("." es un ejemplo de comentario)

        00402017 - Filler Order Number (Número de pedido de relleno):
        vr: Tipo de valor ("LO" para Código de Cadena Largo)
        Value: Valor del campo ("ACC2021004580" es un ejemplo)
        *********************************************************************************************** */



    public function SubeInforme($estudio,$pdf,$ruta=''){

        if ($ruta=='')
            $path = $pdf->path();
        else
            $path=$ruta;

        $barra = strrpos($path, "p/");
        $archivo = substr($path, $barra + 2);

        $url_local = config('api.url_local');
        $ae_title_local = config('api.ae_title_local');
        $nombre_institucion=config('api.nombre_institucion');

        $PACS = $url_local.":8080/dcm4chee-arc/aets/". $ae_title_local."/rs/studies";
        $boundary = "myboundary";

        $descripcion = "Informe Médico ".$nombre_institucion;
        // Create the MIME headers
        $metadata_header = "\r\n--{$boundary}\r\nContent-Type: application/dicom+json\r\n\r\n";
        $pdf_header = "\r\n--{$boundary}\r\nContent-Type: application/pdf\r\nContent-Location: ".$archivo."\r\n\r\n";
        $mime_tail = "\r\n--{$boundary}--";

        // Load the metadata and PDF file into memory
        //$metadata = file_get_contents("/meta2.json");
        $metadata = '[{"00080005": {"vr": "CS","Value": ["ISO_IR 100"]},"0008103E": {"vr": "LO","Value": ["' . $descripcion .
        '"]},"0020000D": {"vr": "UI","Value": ["' . $estudio . '"]},"00280301": {"vr": "CS","Value": ["YES"]},"00420010": {"vr": "ST","Value": ["Informe"]},'.'"00080070":{"vr":"UI"},'.
        '"00420012": {"vr": "LO","Value": ["application/pdf"]},"00080064": {"vr": "CS","Value": ["SD"]},"00420011": {"vr": "OB","BulkDataURI":"' .$archivo. '"}}]';

        $metadata2='[{"00080005":{"vr": "CS","Value": ["ISO_IR 100"]},"0008103E": {"vr": "LO","Value": ["Sanatorio Antártida Informe Médico"]},"0020000D": {"vr": "UI","Value": ["'. $this->estudio .'"]},"00420012": {"vr": "LO","Value": ["application/pdf"]},"00080064": {"vr": "CS","Value": ["SD"]},"00420011": {"vr": "OB","BulkDataURI": "'.$archivo.'"}}]';


         // Combine the MIME parts into a single file
         $mime_parts = array(
             $metadata_header,
             $metadata,
             $pdf_header,
             $pdf,
             $mime_tail
         );
         $reporte_mime = implode("", $mime_parts);


         // Send the POST request to the PACS server
         $curl = curl_init();
         curl_setopt($curl, CURLOPT_URL, $PACS);
         curl_setopt($curl, CURLOPT_POST, true);
         curl_setopt($curl, CURLOPT_POSTFIELDS, $reporte_mime);
         curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: multipart/related; type=\"application/dicom+json\"; boundary={$boundary}"));
         curl_setopt($curl, CURLOPT_VERBOSE, true);
         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
         $response = curl_exec($curl);
         $info = curl_getinfo($curl);
         curl_close($curl);

         // Check for errors
         if ($info["http_code"]==200){
             $this->reset(['open']);
             $this->emit('InformeExito');
             $this->emitTo('alert', "El informe subió exitosamente");
         } else {
                 $this->emit('InformeError');
                 echo 'Error: ' . $response;
                 $this->emit('alert', $response);
         }
         return $info["http_code"];
    }

    public function save()
    {
        if ($this->pdf) {
            $contenidoPDF = file_get_contents($this->pdf->getRealPath());
            $nombrePDF = $this->pdf->getClientOriginalName();
            $this->SubeInforme($this->estudio, $contenidoPDF, $nombrePDF);
         }
    }


    public function render()
    {
        return view('livewire.carga-informe');//,compact('thumb'));
    /* ************************************
        'Fecha',//);//00080020
        'DNI',//);//00100020
        'Paciente',//);//00100010
        'Sexo',//);//00100040
        'Nacimiento',//);//00100030
        'Os',//);Series: 00081040: Institution Department Name ó 00081050: Accession Number
        'Médico',//);//00080090
        'Diagnóstico',//)//;//00081030
        'Descripcion',//)//;//ver serie
        'Ubicación',//);//00080050
        'PCuerpo',//);//Series: 00180015: Body Part Examined
        'Mo',//);//00080061
        'CantInst',//);//7777102A
        'studyUID',//)->unique();//0020000D
    *********************************** */
    }

    public function pdf()
    {
        $this->validate(); //ejecuta las validaciones de $rules
        $content = $this->content;

        $url_local = config('api.url_local');
        $ae_title_local = config('api.ae_title_local');

        $response = Http::get($url_local.':8080/dcm4chee-arc/aets/'.$ae_title_local.'/rs/studies?includefield=all&StudyInstanceUID='. $this->estudio);
        $estudio = $response->json();

        $response2 = Http::get($url_local.':8080/dcm4chee-arc/aets/'.$ae_title_local.'/rs/studies/'. $this->estudio .'/series?includefield=all');
        $series = $response2->json();

        $pdf = PDF::loadView('livewire.pdf-informe', ['content'=>$content,'estudio'=>$estudio,'series'=>$series]);

        Storage::put('public/' . $this->estudio . '.pdf', $pdf->output());

        $this->SubeInforme($this->estudio, $pdf->output(),'app/public/'.$this->estudio.'.pdf');

        $this->open=false;

        // return $pdf->stream('app\public\\'.$this->estudio.'.pdf');

        // $this->SubeInforme($this->estudio, $pdf->output(),'app/public/'.$this->estudio.'.pdf');
    }


    public function abreForm(){
        $this->open=true;
        $this->content="";

      }
}
