<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class EstudioController extends Controller
{
    public function index(){
    /*    $filtroPaciente='http://imagenes.simedsalud.com.ar:8080/dcm4chee-arc/aets/SSPACS/rs/patients?fuzzymatching=false&offset=0&includedefaults=true&onlyWithStudies=false&merged=false';
        $TodosEstudios ='http://imagenes.simedsalud.com.ar:8080/dcm4chee-arc/aets/SSPACS/rs/studies?includefield=all';
        $Filtrofecha = '&StudyDate=20220101-20220228';
        $FiltroPaciente='&PatientID=52248583';
        $response = Http::get($TodosEstudios.$FiltroPaciente);


        $data = $response->json();
        return view('estudios.index',compact('data'));
*/
    }

    public function create(){
        return view("estudios.create");
    }

    public function show($estudio){
/*
        compact ('estudio'); //es igual que ['estudio'=>$estudio]
        return view("estudios.show",['estudio'=>$estudio]);
        */
    }

}
