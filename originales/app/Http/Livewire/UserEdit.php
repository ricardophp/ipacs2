<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserEdit extends Component
{
    public $user1;
    public $roles = [];
    public $selectedRoles = [];
    public $userEdit;
    public $showModal = false;
    protected $listeners = ['openModal'];

    public $id_user                ;
    public $name                   ;
    public $email                  ;
    public $email_verified_at      ;
    public $two_factor_confirmed_at;
    public $current_team_id        ;
    public $profile_photo_path     ;
    public $id_paciente            ;
    public $created_at             ;
    public $updated_at             ;

    protected $rules = [
        'user.name' => 'required|string',
        'user.email' => 'required|email|unique:users,email',
        'user.id_paciente' => 'required|string',
    ];

    public function create()
    {
        $this->showModal = true;
    }
    // Método para abrir el modal
    public function openModal($userEdit)
    {
        if ($userEdit){
        $this->id_user                  = $userEdit['id'];
        $this->name                     = $userEdit['name'];
        $this->email                    = $userEdit['email'];
        $this->email_verified_at        = $userEdit['email_verified_at'];
        $this->two_factor_confirmed_at  = $userEdit['two_factor_confirmed_at'];
        $this->current_team_id          = $userEdit['current_team_id'];
        $this->profile_photo_path       = $userEdit['profile_photo_path'];
        $this->id_paciente              = $userEdit['id_paciente'];
        $this->created_at               = $userEdit['created_at'];
        $this->updated_at               = $userEdit['updated_at'];
        }


        $this->userEdit = $userEdit;
        $this->showModal = true;
    }


    public function mount(User $user)
    {
        $this->user1 = $user;
        $this->roles = Role::all()->pluck('name', 'id')->toArray();
        $this->selectedRoles = $user->roles->pluck('id')->toArray();
    }

    public function render()
    {
        return view('livewire.user-edit');
    }

    public function toggleModal()
    {
        $this->showModal = !$this->showModal;
    }

    public function save()
    {
        $this->validate();

        $this->user->save();
        $this->user->syncRoles($this->selectedRoles);

        $this->toggleModal();

        session()->flash('success', 'Usuario actualizado exitosamente.');
    }
}

