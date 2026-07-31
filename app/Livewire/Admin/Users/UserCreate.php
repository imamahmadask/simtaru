<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class UserCreate extends Component
{
    public $name;
    public $email;
    public $role;
    public $password;

    public function render()
    {
        return view('livewire.admin.users.user-create');
    }

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'role' => ['required'],
            'password' => [
                'required',
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
            ],
        ];
    }

    protected function messages()
    {
        return [
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password terlalu lemah. Password harus terdiri dari minimal 8 karakter, serta memiliki kombinasi huruf besar, huruf kecil, angka, dan simbol.',
        ];
    }

    public function createUser()
    {
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
