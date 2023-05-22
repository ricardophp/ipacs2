<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;


class EditorComponent extends Component
{
    public $content;

    public function render()
    {
        return view('livewire.editor-component');
    }

    public function generatePDF()
    {
        $pdf = PDF::loadView('pdf.document', ['content' => $this->content]);

        $pdf->save(storage_path('app/public/document.pdf'));

        $this->reset('content');

        return redirect()->route('pdf.generate');
    }
}
