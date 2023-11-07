<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Log;



class UsersTable extends Component
{
    public $users;
    public $selectedUser;

    public $search='';
    public $perPage='10';
    public $user;
    public $page;

    public function mount()
    {
        //$this->users = User::all();
    }

    public function showEditModal($id)
    {
        $this->selectedUser = User::find($id);
        $this->emit('showEditUserModal');
        dd($this->selectedUser);
    }

    public function render()
    {
        $users1 = User::where('name', 'LIKE', "%{$this->search}%")
        ->orWhere('email', 'LIKE', "%{$this->search}%")
        ->orWhere('id_paciente', 'LIKE', "%{$this->search}%")
        ->paginate($this->perPage);

      //  dd($users);

        return view('livewire.users-table', compact('users1'));
    }
}

// class UsersTable extends Component
// {
//     use WithPagination;

//     // protected $queryString=[
//     //     'search'=>['except'=>''],
//     //     'perPage'
//     // ];

//     public $search='';
//     public $perPage='10';
//     public $user;

//     public $roles = [];
//     public $selectedUser; // New property to store the selected user
//     public $users,
//     $user_id,
//     $id_paciente,
//     $name,
//     $email,
//     $selectedRoles = [],
//     $showModal = true;


//     public function render()
//     {
//         $users1=User::where('name', 'LIKE', "%{$this->search}%")
//         ->orWhere('email', 'LIKE', "%{$this->search}%")
//         ->orWhere('id_paciente', 'LIKE', "%{$this->search}%")
//         ->paginate($this->perPage);


//        return view('livewire.users-table',compact('users1'));

//     }

//     public function create()
//     {
//         $this->resetFields();
//         $this->showModal = true;
//     }

//     public function edit($id)
//     {
//         $user = User::findOrFail($id);
//         // $this->user_id = $user->id;
//         // $this->id_paciente = $user->id_paciente;
//         // $this->name = $user->name;
//         // $this->email = $user->email;
//         // $this->selectedRoles = $user->roles->pluck('name')->toArray();
//         // $this->showModal = true;
//         $this->emit('showEditUserModal');
//         //dd("user_id:".$user->id." name:".$user->name." showModal:".$this->showModal);
//     }

//     public function update()
//     {
//         $this->validate([
//             'name' => 'required',
//             'email' => 'required|email|unique:users,email,' . $this->user_id,
//             'id_paciente' => 'required|unique:users',
//         ]);

//         $user = User::find($this->user_id);
//         $user->update([
//             'name' => $this->name,
//             'email' => $this->email,
//             'id_paciente' => $this->id_paciente,
//         ]);

//         $user->syncRoles($this->selectedRoles);

//         $this->closeModal();
//         $this->resetFields();
//     }


//     public function store()
//     {
//         $this->validate([
//             'name' => 'required',
//             'email' => 'required|email|unique:users,email,' . $this->user_id,
//         ]);

//         $user = User::updateOrCreate(['id' => $this->user_id], [
//             'name' => $this->name,
//             'email' => $this->email,
//             'id_paciente' => $this->id_paciente,
//         ]);

//         $user->syncRoles($this->selectedRoles);

//         $this->closeModal();
//         $this->resetFields();
//     }

//     public function delete($id)
//     {
//         User::findOrFail($id)->delete();
//     }

//     private function resetFields()
//     {
//         $this->user_id = null;
//         $this->name = '';
//         $this->email = '';
//         $this->id_paciente = '';
//         $this->selectedRoles = [];
//     }
// }
