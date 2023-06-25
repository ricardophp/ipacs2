<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersTable extends Component
{
    use WithPagination;

    // protected $queryString=[
    //     'search'=>['except'=>''],
    //     'perPage'
    // ];

    public $search='';

    public $perPage='10';

    public function render()
    {
      return view('livewire.users-table',[
        'users' => User::where('name', 'LIKE', "%{$this->search}%")
        ->orWhere('email', 'LIKE', "%{$this->search}%")
        ->orWhere('id_paciente', 'LIKE', "%{$this->search}%")
        ->paginate($this->perPage)
    ]);

    }

    public function clear(){

        $this->search='';
        $this->perPage='10';
        $this->page='1';
    }
}
