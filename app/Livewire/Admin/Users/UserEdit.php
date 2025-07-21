<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UserEdit extends Component
{
    public $user_id;

    #[Validate('required|string|max:255')]
    public $name;

    #[Validate('required|email')]
    public $email;

    #[Validate('required')]
    public $role;
    public function render()
    {
        return view('livewire.admin.users.user-edit');
    }
    #[On('user-edit')]
    public function getUser($id)
    {
        $user = User::find($id);
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
    }

    public function editUser()
    {
        $this->validate();

        $user = User::find($this->user_id);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role
        ]);

        session()->flash('success', 'Data user berhasil diupdate!');

        $this->redirectRoute('users.index');

    }
}
