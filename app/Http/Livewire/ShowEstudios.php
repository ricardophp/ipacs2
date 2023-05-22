<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ShowEstudios extends Component
{
    public function render()
    {
        $user = Auth::user();
        // Acceder al nombre de usuario
        $id_paciente = $user->id_paciente;
        $filtroPaciente='http://imagenes.simedsalud.com.ar:8080/dcm4chee-arc/aets/SSPACS/rs/patients?fuzzymatching=false&offset=0&includedefaults=true&onlyWithStudies=false&merged=false';
        $TodosEstudios ='http://imagenes.simedsalud.com.ar:8080/dcm4chee-arc/aets/SSPACS/rs/studies?includefield=all';
        $Filtrofecha = '&StudyDate=20220101-20220228';
        $FiltroPaciente='&PatientID='.$id_paciente;
        $response = Http::get($TodosEstudios.$FiltroPaciente);

        $data = $response->json();

        return view('livewire.show-estudios',compact('data'));
    }
}
