<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UsersTable extends Component
{
    public $users;
    public $selectedUser;

    public $roles;
    public $selectedRole;

    public $page;
    public $search='';
    public $perPage='10';

    public $user;
    public $role;
    public $confirmingUserDeletion=false;
    public $confirmingUserAdd=false;
    public $confirmingUserEdit=false;

    protected $rules = [
        'user.name'  => 'required|string|min:4',
        'user.email' => 'required|email',
        'user.password' =>'nullable|min:6|same:user.password_confirmation',
        'user.password_confirmation' => 'nullable',
        'user.id_paciente' => 'required|string',
    ];


    public function resetCampos()
    {
        $this->user['name']='';
        $this->user['email']='';
        $this->user['id_paciente']='';
        $this->selectedRole='';

        $this->user=null;
    }

    public function render()
    {
        $users1 = User::where('name', 'LIKE', "%{$this->search}%")
        ->orWhere('email', 'LIKE', "%{$this->search}%")
        ->orWhere('id_paciente', 'LIKE', "%{$this->search}%")
        ->paginate($this->perPage);

        $this->roles = Role::all();

        if (isset($this->user)) {
            // Cargar roles disponibles
            $this->roles = Role::all();

            // Cargar el rol del usuario actual
            if (isset($this->user->roles))
            $this->selectedRole = $this->user->roles->first()->id;
        }

        return view('livewire.users-table', compact('users1'));
    }

    public function confirmUserDeletion($id)
    {
        $this->confirmingUserDeletion=$id;
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        $this->confirmingUserDeletion=false;
    }

    public function confirmUserAdd()
    {
        $this->resetCampos();
        $this->confirmingUserAdd=true;
    }

    public function saveUser()
    {
        $this->validate();

        if (isset($this->user->id))
        {
            $user = User::findOrFail($this->user->id);

            $user->update([
                'name' => $this->user['name'],
                'email' => $this->user['email'],
                'id_paciente' => $this->user['id_paciente'],
                'password' => isset($this->user['password']) ? bcrypt($this->user['password']) : $user->password,
            ]);
            $user->roles()->sync([$this->selectedRole]);
        }else{
        User::create([
            'name'         => $this->user['name'],
            'email'        => $this->user['email'],
            'password'     => bcrypt($this->user['password']),
            'id_paciente'  => $this->user['id_paciente']
        ])->assignRole($this->selectedRole);
        }
        $this->confirmingUserAdd=false;
    }

    public function confirmUserEdit(User $user)
    {
        $this->user = $user;
        $this->confirmingUserAdd=true;
    }

    public function editUser(User $user)
    {
        $user->save();
        $this->confirmingUserAdd=false;
    }

}
