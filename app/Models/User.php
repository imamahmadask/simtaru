<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens;
    use SoftDeletes;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'password_changed_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'password_changed_at' => 'datetime',
        ];
    }

    /**
     * Cek apakah password user telah kedaluwarsa (berlaku untuk semua role kecuali superadmin).
     */
    public function isPasswordExpired(): bool
    {
        if ($this->role === 'superadmin') {
            return false;
        }

        if (is_null($this->password_changed_at)) {
            return true;
        }

        $expiresInDays = (int) config('auth.password_expires_days', 90);
        return $this->password_changed_at->addDays($expiresInDays)->isPast();
    }

        // disposisi yang diberikan user ini
    public function pemberi_disposisi()
    {
        return $this->hasMany(Disposisi::class, 'pemberi_id');
    }

    // disposisi yang diterima user ini
    public function penerima_disposisi()
    {
        return $this->hasMany(Disposisi::class, 'penerima_id');
    }
}
