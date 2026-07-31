<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    protected function passwordRules(?string $usernameOrEmail = null, ?string $name = null): array
    {
        return [
            'required',
            'string',
            Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols(),
            'confirmed',
            function ($attribute, $value, $fail) use ($usernameOrEmail, $name) {
                if (empty($value)) return;
                $cleanValue = strtolower(trim($value));

                if ($usernameOrEmail) {
                    $cleanUser = strtolower(trim($usernameOrEmail));
                    $emailUser = explode('@', $cleanUser)[0];
                    if ($cleanValue === $cleanUser || $cleanValue === $emailUser) {
                        $fail('Password tidak boleh sama dengan username atau email.');
                        return;
                    }
                }

                if ($name) {
                    $cleanName = strtolower(trim($name));
                    if ($cleanValue === $cleanName) {
                        $fail('Password tidak boleh sama dengan nama user.');
                        return;
                    }
                }
            }
        ];
    }
}
