<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\TryCatch;
use Throwable;


class Estudio extends Model
{
    //use HasFactory;
    protected $fillable = [
        'Fecha',//);//00080020
        'Hora',//);//,00080030
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
        'Informe',//00080061
        'CantInst',//);//7777102A
        'studyUID',//)->unique();//0020000D
    ];

//     public static function fetchStudiesByDateRange($desde, $hasta)
//     {

//         $url = 'http://imagenes.simedsalud.com.ar:8080/dcm4chee-arc/aets/SSPACS/rs/series?includefield=all&StudyDate='.$desde.'-'.$hasta;

//         $query = [
//             'includefield' => 'all',
//             'StudyDate' => $desde.'-'.$hasta,
//         ];

//         $response = Http::withOptions([
//             'query' => $query,
//         ])->get($url);



//         $response = Http::get('http://imagenes.simedsalud.com.ar:8080/dcm4chee-arc/aets/SSPACS/rs/series?includefield=all&StudyDate='.$desde.'-'.$hasta);

//         $studies = $response->json();

//         foreach ($studies as $estudio) {
//             // Chequeo los campos antes del insert/update
//             //------------------------------------------------------
//             $fecha=date("Y-m-d");
//             $dni='';
//             $paciente='';
//             $sexo='';
//             $nacimiento=date("Y-m-d");
//             $os='';
//             $medico='';
//             $diagnostico='';
//             $descripcion='';
//             $ubicacion='';
//             $pcuerpo='';
//             $mo='';
//             $cantinst=0;
//             $studyuid='';

//             if((isset($estudio['00080020']['Value'][0])&&(array_key_exists('Value', $estudio['00080020'])))) $fecha=date('Y-m-d', strtotime($estudio['00080020']['Value'][0]));
//             if((isset($estudio['00100020']['Value'][0])&&(array_key_exists('Value', $estudio['00100020'])))) $dni=$estudio['00100020']['Value'][0];
//             if((isset($estudio['00100010']['Value'][0]['Alphabetic'])&&(array_key_exists('Value', $estudio['00100010'])))) $paciente=$estudio['00100010']['Value'][0]['Alphabetic'];
//             if((isset($estudio['00100040']['Value'][0])&&(array_key_exists('Value', $estudio['00100040'])))) $sexo=$estudio['00100040']['Value'][0];
//             if((isset($estudio['00100030']['Value'][0])&&(array_key_exists('Value', $estudio['00100030'])))) $nacimiento=date('Y-m-d', strtotime($estudio['00100030']['Value'][0]));
//             if((isset($estudio['00080090']['Value'][0]['Alphabetic'])&&(array_key_exists('Value', $estudio['00080090'])))) $medico=$estudio['00080090']['Value'][0]['Alphabetic'];
//             if((isset($estudio['00081030']['Value'][0])&&(array_key_exists('Value', $estudio['00081030'])))) $diagnostico=$estudio['00081030']['Value'][0];
//             if((isset($estudio['00080050']["Value"][0])&&(array_key_exists('Value', $estudio['00080050'])))) $ubicacion=$estudio['00080050']["Value"][0];
//             if((isset($estudio['00180015']['Value'][0])&&(array_key_exists('Value', $estudio['00180015'])))) $pcuerpo=$estudio['00180015']['Value'][0];
//             if((isset($estudio['00080061']['Value'][0])&&(array_key_exists('Value', $estudio['00080061'])))) $mo=$estudio['00080061']['Value'][0];
//             if((isset($estudio['7777102A']['Value'][0])&&(array_key_exists('Value', $estudio['7777102A'])))) $cantinst=intval($estudio['7777102A']['Value'][0]);
//             if((isset($estudio['0020000D']['Value'][0])&&(array_key_exists('Value', $estudio['0020000D'])))) $studyuid=$estudio['0020000D']['Value'][0];

//             //------------------------------------------------------
//             // Inserto o Actualizo
//             self::updateOrCreate(
//                 ['studyUID' => $studyuid],
//                 [
//                     'Fecha'=> $fecha,//$estudio['00080020']['Value'][0],
//                     'DNI'=> $dni,
//                     'Paciente'=> $paciente,
//                     'Sexo'=> $sexo,
//                     'Nacimiento'=> $nacimiento,
//                     'Os'=> $os,
//                     'Médico'=> $medico,
//                     'Diagnóstico'=> $diagnostico,
//                     'Descripcion'=> $descripcion,
//                     'Ubicación'=>$ubicacion,
//                     'PCuerpo'=> $pcuerpo,
//                     'Mo'=> $mo,
//                     'CantInst'=> $cantinst,
//                     'studyUID'=> $studyuid,
//                 ]
//             );
//     }
// }
}

