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




class CargaInforme extends Component
{
    use WithFileUploads;


    public $open = false;
    public $title="Informe", $content="Informe", $pdf;
    public $estudio, $nombre, $key;

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

    public function SubeInforme($estudio,$pdf,$ruta=''){

        if ($ruta=='')  $path = $pdf->path();
        else $path=$ruta;
        $barra = strrpos($path, "p/");
        $archivo = substr($path, $barra + 2);

        $PACS = "http://181.88.198.23:8080/dcm4chee-arc/aets/SSPACS/rs/studies";
        $boundary = "myboundary";

        $descripcion = "Sanatorio Antártida Informe Médico";
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
        $this->SubeInforme($this->estudio, $this->pdf);
    }


    public function render()
    {

        $response = Http::get('http://imagenes.simedsalud.com.ar:8080/dcm4chee-arc/aets/SSPACS/rs/studies/'. $this->estudio .'/series');
        $series = $response->json();

        foreach ($series as $serie) {
            $thumb[] = 'http://imagenes.simedsalud.com.ar:8080/dcm4chee-arc/aets/SSPACS/rs/studies/'. $this->estudio .'/series/'.$serie["0020000E"]["Value"][0].'/thumbnail';
        }
        return view('livewire.carga-informe',compact('thumb'));

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

        view()->share('content',$content);
        $pdf = PDF::loadView('livewire.pdf-informe', ['content'=>$content]);
        $pdf->save(storage_path('app/public/'.$this->estudio.'.pdf'));

        $this->SubeInforme($this->estudio, $pdf->output(),'app/public/'.$this->estudio.'.pdf');
    }

}
