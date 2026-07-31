<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\On;
use Livewire\Component;

class UserEdit extends Component
{
    public $user_id;
    public $name;
    public $email;
    public $role;
    public $password;

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
        $this->password = '';
    }

    public function editUser()
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $this->user_id],
            'role' => ['required'],
        ];

        if (!empty($this->password)) {
            $rules['password'] = [
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
                function ($attribute, $value, $fail) {
                    if (empty($value)) return;
                    $cleanValue = strtolower(trim($value));

                    if ($this->email) {
                        $cleanEmail = strtolower(trim($this->email));
                        $emailUser = explode('@', $cleanEmail)[0];
                        if ($cleanValue === $cleanEmail || $cleanValue === $emailUser) {
                            $fail('Password tidak boleh sama dengan username atau email.');
                            return;
                        }
                    }

                    if ($this->name) {
                        $cleanName = strtolower(trim($this->name));
                        if ($cleanValue === $cleanName) {
                            $fail('Password tidak boleh sama dengan nama user.');
                            return;
                        }
                    }
                }
            ];
        }

        $this->validate($rules, [
            'password.min' => 'Password terlalu lemah. Password harus terdiri dari minimal 8 karakter, serta memiliki kombinasi huruf besar, huruf kecil, angka, dan simbol.',
        ]);

        $user = User::find($this->user_id);

        $updateData = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role
        ];

        if (!empty($this->password)) {
            $updateData['password'] = Hash::make($this->password);
        }

        $user->update($updateData);

        session()->flash('success', 'Data user berhasil diupdate!');

        $this->redirectRoute('users.index');
    }
}
