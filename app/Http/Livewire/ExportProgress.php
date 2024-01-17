<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ExportProgress extends Component
{
    public $progress = 0;

    public function export()
    {
        // Simulación de proceso de exportación (ajusta según tu lógica)
        for ($i = 0; $i <= 100; $i += 10) {
            sleep(1);
            $this->progress = $i;
            $this->dispatchBrowserEvent('updateProgress', ['progress' => $i]);
        }

        // Agrega aquí la lógica real de exportación

        $this->reset(['progress']);
    }

    public function render()
    {
        return view('livewire.export-progress');
    }
}
