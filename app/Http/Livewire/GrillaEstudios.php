<?php

namespace App\Http\Livewire;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Livewire\WithPagination;

class GrillaEstudios extends Component
{
    use WithPagination;

    public $fechad, $fechah, $perPage;
    public $filtroPaciente;

    public $campoOrden = '00080020';//fecha
    public $tipoOrden = 'desc';

    protected $listeners=['InformeExito'=>'render'];

    public function mount()
    {
        $this->fechad = date("Y-m-d");
        $this->fechah = date("Y-m-d");
    }


    public function render()
    {
        $this->perPage = 15;
        //$page = request()->query('page', 1); // Obtener el número de página actual
        $page = $this->page;


        // if (!$this->fechad) $this->fechad = date("Y-m-d");
        // if (!$this->fechah) $this->fechah = date("Y-m-d");

        $desde = str_replace("-", "", $this->fechad);
        $hasta = str_replace("-", "", $this->fechah);

        //',PatientID='.$this->paciente.
        if (isset($this->filtroPaciente)) $filtro='&PatientName='.$this->filtroPaciente.'&fuzzymatching=true';
        else $filtro='&limit=' . $this->perPage . '&offset=' . ($page - 1) * $this->perPage;

        $response = Http::get('http://imagenes.simedsalud.com.ar:8080/dcm4chee-arc/aets/SSPACS/rs/studies?includefield=all&StudyDate=' . $desde . '-' . $hasta . $filtro);
        $studies = $response->json();


        $response2 = Http::get('http://imagenes.simedsalud.com.ar:8080/dcm4chee-arc/aets/SSPACS/rs/studies/count?StudyDate=' . $desde . '-' . $hasta.$filtro); //.'&limit='.$perPage.'&offset='.($page - 1) * $perPage);
        $count = $response2->json();

        $total = $count["count"] ?? 0;

        $studies = collect($response->json());

        // Ordenar los resultados según el campo y tipo de orden
        $studies = $studies->sortBy($this->campoOrden, SORT_REGULAR, $this->tipoOrden === 'desc')->values();

        // Crear una instancia de LengthAwarePaginator para gestionar la paginación
        $paginator = new LengthAwarePaginator($studies, $total, $this->perPage, $page);
        $paginator->withPath(request()->url());

        return view('livewire.grilla-estudios', compact('paginator')); //['paginator' => $paginator,'studies' => $this->studies]);

    }

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
}
