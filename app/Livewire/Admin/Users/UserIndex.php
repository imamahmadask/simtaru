<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;

class UserIndex extends Component
{
    public function render()
    {
         $users = User::all();
        return view('livewire.admin.users.user-index', compact('users'));
    }

    public function deleteUser(User $user)
    {
        if($user)
        {
            //destroy
            $user->delete();
        }
    }
}
