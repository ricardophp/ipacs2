<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class CargaInforme extends Component
{
    use WithFileUploads;


    public $open = false;
    public $title="Informe", $content="vacio", $pdf;
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

    public function save()
    {

       //$this->validate(); //ejecuta las validaciones de $rules

       $PACS = "http://181.88.198.23:8080/dcm4chee-arc/aets/SSPACS/rs/studies";
       $boundary = "myboundary";

       $path = $this->pdf->path();

       $barra = strrpos($path, "p/");

       $archivo = substr($path, $barra + 2);



       $descripcion = "Sanatorio Antartida Informe Médico";
       // Create the MIME headers
       $metadata_header = "\r\n--{$boundary}\r\nContent-Type: application/dicom+json\r\n\r\n";
       $pdf_header = "\r\n--{$boundary}\r\nContent-Type: application/pdf\r\nContent-Location: ".$archivo."\r\n\r\n";
       $mime_tail = "\r\n--{$boundary}--";

       // Load the metadata and PDF file into memory
       //$metadata = file_get_contents("/meta2.json");
       $metadata = '[{"00080005": {"vr": "CS","Value": ["ISO_IR 100"]},"0008103E": {"vr": "LO","Value": ["' . $descripcion .
       '"]},"0020000D": {"vr": "UI","Value": ["' . $this->estudio . '"]},"00280301": {"vr": "CS","Value": ["YES"]},"00420010": {"vr": "ST","Value": ["Informe"]},'.'"00080070":{"vr":"UI"},'.
       '"00420012": {"vr": "LO","Value": ["application/pdf"]},"00080064": {"vr": "CS","Value": ["SD"]},"00420011": {"vr": "OB","BulkDataURI":"' .$archivo. '"}}]';

       $metadata2='[{"00080005":{"vr": "CS","Value": ["ISO_IR 100"]},"0008103E": {"vr": "LO","Value": ["Sanatorio Antártida Informe Médico"]},"0020000D": {"vr": "UI","Value": ["'. $this->estudio .'"]},"00420012": {"vr": "LO","Value": ["application/pdf"]},"00080064": {"vr": "CS","Value": ["SD"]},"00420011": {"vr": "OB","BulkDataURI": "'.$archivo.'"}}]';

       $pdf = file_get_contents($this->pdf->path());


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
    }


    public function render()
    {

        $response = Http::get('http://imagenes.simedsalud.com.ar:8080/dcm4chee-arc/aets/SSPACS/rs/studies/'. $this->estudio .'/series');
        $series = $response->json();

        foreach ($series as $serie) {
//            $response = Http::get('http://imagenes.simedsalud.com.ar:8080/dcm4chee-arc/aets/SSPACS/rs/studies/'. $this->estudio .'/series/'.$serie["0020000E"]["Value"][0].'/thumbnail');
            $thumb[] = 'http://imagenes.simedsalud.com.ar:8080/dcm4chee-arc/aets/SSPACS/rs/studies/'. $this->estudio .'/series/'.$serie["0020000E"]["Value"][0].'/thumbnail';
        }
       // dd($thumb);
        return view('livewire.carga-informe',compact('thumb'));
    }
}
