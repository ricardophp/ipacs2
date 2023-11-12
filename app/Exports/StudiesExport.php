<?php

namespace App\Exports;

use App\Models\Estudio;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudiesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $estudios;

    public function __construct($estudios)
    {
        $this->$estudios = $estudios;
    }

    public function collection()
    {
        return $this->estudios;
        //return Estudio::all();
    }
}
