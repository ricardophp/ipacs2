<?php

namespace App\Http\Livewire;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ShowEstudios extends Component
{
    public $campoOrden='00080020';
    public $tipoOrden='desc';
    public $perPage;
    public $page;

    public function render()
    {
        $this->perPage = 10;
        $page = request()->query('page', 1); // Obtener el número de página actual
        //$page = $this->page;

        $url_remota = config('api.url_remota');
        $ae_title_remoto = config('api.ae_title_remoto');

        $user = Auth::user();
        // Acceder al nombre de usuario
        $id_paciente = $user->id_paciente;
        $filtroPaciente=$url_remota.':8080/dcm4chee-arc/aets/'.$ae_title_remoto.'/rs/patients?fuzzymatching=false&offset=0&includedefaults=true&onlyWithStudies=false&merged=false';
        $TodosEstudios =$url_remota.':8080/dcm4chee-arc/aets/'.$ae_title_remoto.'/rs/studies?includefield=all';
        $Filtrofecha = '&StudyDate=20220101-20220228';
        $FiltroPaciente='&PatientID='.$id_paciente;
        $response = Http::get($TodosEstudios.$FiltroPaciente);
        $estudios = $response->json();

        $response2 = Http::get($url_remota.':8080/dcm4chee-arc/aets/'.$ae_title_remoto.'/rs/studies/count'.'?PatientID='.$id_paciente);
        $count = $response2->json();

        $total = $count["count"] ?? 0;

        $estudios = collect($response->json());

        // Ordenar los resultados según el campo y tipo de orden
        $estudios = $estudios->sortBy($this->campoOrden, SORT_REGULAR, $this->tipoOrden === 'desc')->values();

        // Crear una instancia de LengthAwarePaginator para gestionar la paginación
        $data = new LengthAwarePaginator($estudios, $total, $this->perPage, $page);
        $data->withPath(request()->url());

        return view('livewire.show-estudios',compact('data'));
    }
}
