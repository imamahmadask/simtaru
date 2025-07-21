<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UserCreate extends Component
{
     #[Validate('required|string|max:255')]
    public $name;

    #[Validate('required|email|unique:users,email')]
    public $email;

    #[Validate('required')]
    public $role;

    #[Validate('required|string|min:8')]
    public $password;

    public function render()
    {
        return view('livewire.admin.users.user-create');
    }

    public function createUser(){
        $this->validate();

        User::create([
           'name' => $this->name,
           'email' => $this->email,
           'role' => $this->role,
           'password' => Hash::make($this->password),
        ]);

        session()->flash('success', 'User berhasil ditambahkan!');

        $this->redirectRoute('users.index');
    }
}
