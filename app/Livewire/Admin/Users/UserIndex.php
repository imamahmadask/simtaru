<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
#[Title('Users')]
class UserIndex extends Component
{
    public function render()
    {
         $users = User::all();
        return view('livewire.admin.users.user-index', compact('users'));
    }

    public function deleteUser(User $user)
    {
        if (Auth::id() == $user->id) {
            return;
        }

        if($user)
        {
            //destroy
            $user->delete();
        }
    }
}
