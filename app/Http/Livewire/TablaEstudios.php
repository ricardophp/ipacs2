<?php


namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Estudio;
use Exception;
use Illuminate\Support\Facades\Http;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\NumberFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class TablaEstudios extends DataTableComponent
{
    protected $model = Estudio::class;

    // public array $filters = [
    //     'fecha' => '2023-10-24',
    // ];

    // public function render()
    // {
    //     if ($this->desde=='') $this->desde=date('Y-m-d', strtotime('now -1 days'));
    //     if ($this->hasta=='') $this->hasta=date('Y-m-d');

    //    // dump('cambiolafecha:'.$this->cambiolafecha);

    //     if($this->cambiolafecha=='si'){
    //      $this->Fetch( $this->desde,  $this->hasta);
    //      $this->cambiolafecha='no';
    //     }

    //     $this->setupColumnSelect();
    //     $this->setupPagination();
    //     $this->setupSecondaryHeader();
    //     $this->setupFooter();
    //     $this->setupReordering();

    //     return view('livewire-tables::datatable')
    //         ->with([
    //             'columns' => $this->getColumns(),
    //             'rows' => $this->getRows(),
    //             'customView' => $this->customView(),
    //         ]);
    // }

    public function configure(): void
    {

        $this->setPrimaryKey('id')
        ->setPageName('Estudios')
        ->setPerPageAccepted([25, 50, 100])
        ->setPerPage(25)
        ->setSearchDebounce(1000);

        $this->setDefaultReorderSort('fecha', 'desc');

        // $this->setConfigurableAreas([
        //     'toolbar-left-end' => 'tabla.boton',
        //   ]);
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable()
                ->collapseOnMobile()
                ->deselected(),
            Column::make("Mo", "Mo")
                ->sortable()
                ->collapseOnMobile(),
            Column::make("Fecha", "Fecha")
                ->sortable(),
            Column::make("Hora", "Hora")
                ->sortable(),
            Column::make("DNI", "DNI")
                ->sortable()
                ->searchable(),
            Column::make("Paciente", "Paciente")
                ->sortable()
                ->searchable(),
            Column::make("Sexo", "Sexo")
                ->sortable()
                ->collapseOnMobile(),
            Column::make("F.Nac", "Nacimiento")
                ->sortable()
                ->collapseOnMobile(),
            Column::make("Os", "Os")
                ->sortable()
                ->collapseOnMobile(),
            Column::make("Médico", "Médico")
                ->sortable(),
            Column::make("Diagnóstico", "Diagnóstico")
                ->sortable()
                ->collapseOnMobile(),
            Column::make("Descripcion", "Descripcion")
                ->sortable()
                ->collapseOnMobile()
                ->deselected(),
            Column::make("Ubicación", "Ubicación")
                ->sortable()
                ->collapseOnMobile(),
            Column::make("PCuerpo", "PCuerpo")
                ->sortable()
                ->collapseOnMobile()
                ->deselected(),
            Column::make("Informe", "Informe")
                ->sortable(),
            Column::make("Inst", "CantInst")
                ->sortable()
                ->collapseOnMobile(),
            Column::make("StudyUID", "studyUID")
                ->sortable()
                ->collapseOnMobile()
                ->deselected(),
            Column::make("Created at", "created_at")
                ->sortable()
                ->collapseOnMobile()
                ->deselected(),
            Column::make("Updated at", "updated_at")
                ->sortable()
                ->collapseOnMobile()
                ->deselected(),
            Column::make('Acciones')
                ->collapseOnMobile()
                ->label (fn($row)=>view('tabla.acciones',compact('row'))),
        ];
    }

    public function filters(): array
    {
        return[
            DateFilter::make('Desde')
            ->filter(function($query,$value){
                $query->whereDate('fecha','>=',$value);
            }),
            DateFilter::make('Hasta')
            ->filter(function($query,$value){
                $query->whereDate('fecha','<=',$value);
            }),
            NumberFilter::make('HDesde')
            ->config([
                'placeholder' => 'Hora Desde HHmm',
                'min' => '0000',
                'max'=>'2359'
            ])
            ->filter(function(Builder $builder, string $value) {
                $builder->where('hora', '>=', $value);
            }),
            NumberFilter::make('HHasta')
            ->config([
                'placeholder' => 'Hora Hasta HHmm',
                'min' => '0000',
                'max'=>'2359'
            ])
            ->filter(function(Builder $builder, string $value) {
                $builder->where('hora', '<=', $value);
            }),
            TextFilter::make('OS')
            ->config([
                'placeholder' => 'Obra social',
                'maxlength' => '25',
            ])
            ->filter(function(Builder $builder, string $value) {
                $builder->where('os', 'like', '%'.$value.'%');
            }),
            TextFilter::make('MO')
            ->config([
                'placeholder' => 'Modalidad',
                'maxlength' => '25',
            ])
            ->filter(function(Builder $builder, string $value) {
                $builder->where('mo', 'like', '%'.$value.'%');
            }),
            TextFilter::make('Ubicación')
            ->config([
                'placeholder' => 'Modalidad',
                'maxlength' => '25',
            ])
            ->filter(function(Builder $builder, string $value) {
                $builder->where('ubicación', 'like', '%'.$value.'%');
            }),
            TextFilter::make('Médico')
            ->config([
                'placeholder' => 'Médico',
                'maxlength' => '25',
            ])
            ->filter(function(Builder $builder, string $value) {
                $builder->where('médico', 'like', '%'.$value.'%');
            }),
            SelectFilter::make('Informe')
            ->options([
                '' => 'Todo',
                'si' => 'Con Informe',
                'no' => 'Sin Informe',
            ])
            ->filter(function(Builder $builder, string $value) {
                if ($value === 'si') {
                    $builder->where('Informe', 'si');
                } elseif ($value === 'no') {
                    $builder->where('Informe', 'no');
                }
            }),
        ];
    }


    public function mount() {
        // $this->setFilter('Desde', date('Y-m-d', strtotime('now -1 days')));
        // $this->setFilter('Hasta', date("Y-m-d"));

        //     // Llamada inicial para llenar los datos.
        // $this->Fetch(date('Y-m-d', strtotime('now -1 days')), date("Y-m-d"));
    }

    public function Fetch($desde=null,$hasta=null)
    {
     //   dump('desde:'.$desde.' hasta:'.$hasta);
        if ($desde=='') {
            $desde=date('Y-m-d', strtotime('now -1 days'));
        }
        if ($hasta=='') $hasta=$this->hasta;

        if ($desde<>'')
         $desde = str_replace("-", "", $desde);
        if ($hasta<>'')
        $hasta = str_replace("-", "", $hasta);

        if ($desde<>''and$hasta<>'') $guion='-';
        else $guion='';
     //   dump('Ndesde:'.$desde.' Nhasta:'.$hasta);
        $url_remota = config('api.url_remota');
        $ae_title_remoto = config('api.ae_title_remoto');

        $response = Http::get($url_remota.':8080/dcm4chee-arc/aets/'.$ae_title_remoto.'/rs/studies?includefield=all&StudyDate=' . $desde . $guion . $hasta);

        if (!$response->successful()) {// Manejar el error
            throw new Exception("Error al obtener estudios.");
        }

        $studies = $response->json();
        $dataToUpsert = [];

        // Obtener los campos de las series para cada estudio y combinarlos
        foreach ($studies as $study) {
            $studyId = $study['0020000D']['Value'][0]; // Reemplaza con la clave correcta para el ID del estudio
            $seriesResponse = Http::get($url_remota.':8080/dcm4chee-arc/aets/'.$ae_title_remoto.'/rs/studies/' . $studyId . '/series?includefield=all');
            $series = $seriesResponse->json();
            $study['series'] = $series;

            if (array_search('DOC', $study['00080061']['Value']) != '')
            $informe='si';else $informe='no';

            $dataToUpsert[] = [
                'Fecha' => $study['00080020']['Value'][0],
                'DNI' => $study['00100020']['Value'][0],
                'Paciente' => $study['00100010']['Value'][0]['Alphabetic'],
                'Sexo' => isset($study['00100040']['Value'][0])?$study['00100040']['Value'][0]:'-',
                'Nacimiento' => $study['00100030']['Value'][0] ?? null,
                'Os' =>isset($study['series'][0]['00081040']['Value'][0])
                ? $study['series'][0]['00081040']['Value'][0]
                : (isset($study['series'][0]['00081050']['Value'][0]['Alphabetic'])
                    ? $study['series'][0]['00081050']['Value'][0]['Alphabetic']
                    : '-'), // Si ninguno de los dos existe, asigna null
                // $study['series'][0]['00081040']['Value'][0] ?? $study['series'][0]['00081050']['Value'][0]['Alphabetic'], // Asume uno de estos
                'Médico' => isset($study['00080090']['Value'][0]['Alphabetic'])?$study['00080090']['Value'][0]['Alphabetic']:'-',
                'Diagnóstico' => isset($study['00081030']['Value'][0])?$study['00081030']['Value'][0]:'-',
                'Descripcion' => isset($study['001021B0']['Value'][0])?$study['001021B0']['Value'][0]:'-', // (0010,21B0) No estaba claro en tu código original
                'Ubicación' => isset($study['00080050']['Value'][0])?$study['00080050']['Value'][0]:'-',
                'PCuerpo' => isset($study['series'][0]['00180015']['Value'][0]),
                'Mo' => ($study['00080061']['Value'][0]=='DOC')?$study['00080061']['Value'][1]:$study['00080061']['Value'][0],
                'Informe'=>$informe,
                'CantInst' => $study['7777102A']['Value'][0],
                'studyUID' => $study['0020000D']['Value'][0],
            ];
        }
      //  dump($dataToUpsert);
        Estudio::upsert($dataToUpsert, ['studyUID'], ['Fecha', 'DNI', 'Paciente', 'Sexo', 'Nacimiento', 'Os', 'Médico', 'Diagnóstico', 'Descripcion', 'Ubicación', 'PCuerpo', 'Mo','Informe', 'CantInst']);

    }
    public function copiarTexto($texto)
    {
        // Crea un elemento temporal (input) para copiar el texto al portapapeles
        $tempInput = "<input type='text' value='{$texto}' id='temp-input'>";
        $this->emit('copiarTexto', $tempInput);
    }

}
