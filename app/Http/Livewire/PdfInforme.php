<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PdfInforme extends Component
{
    public $open=false;

    public function pdf(){

        $this->validate(); //ejecuta las validaciones de $rules
        $content = $this->content;
        return view('pdf',compact('content'));
        $this->reset(['open']);

        $this->emitTo('grilla-estudios','render');
        $this->emitTo('alert','El Informe se grabó satisfactoriamente');
    }

    public function render()
    {
        return view('livewire.pdf-informe');
    }
}
