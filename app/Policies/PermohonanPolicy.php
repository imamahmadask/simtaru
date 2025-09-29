<?php

namespace App\Policies;

use App\Models\Permohonan;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Auth\Access\Response;

class PermohonanPolicy
{
     /**
     * Aturan: boleh manage tahap survey jika
     * - user.role = superadmin / supervisor
     * - ATAU user penerima disposisi tahap survey
     */
    public function manageSurvey(User $user, Permohonan $permohonan): bool
    {
        // superadmin & supervisor selalu boleh
        if (in_array($user->role, ['superadmin', 'supervisor'])) {
            return true;
        }

        // cek disposisi untuk user ini
        if ($user->role === 'surveyor') {
            $layanan = Str::ucfirst(Str::lower($permohonan->layanan->nama));
            return $permohonan->disposisi()
                ->where('penerima_id', $user->id)
                ->get()
                ->contains(fn ($d) => $d->layanan_type_name === $layanan);
        }

        return false;
    }

    public function manageAnalis(User $user, Permohonan $permohonan): bool
    {
        // superadmin & supervisor selalu boleh
        if (in_array($user->role, ['superadmin', 'supervisor'])) {
            return true;
        }

        // cek disposisi untuk user ini
        if ($user->role === 'analis') {
            $layanan = Str::ucfirst(Str::lower($permohonan->layanan->nama));
            return $permohonan->disposisi()
                ->where('penerima_id', $user->id)
                ->get()
                ->contains(fn ($d) => $d->layanan_type_name === $layanan);
        }

        return false;
    }

    public function manageDataEntry(User $user, Permohonan $permohonan): bool
    {
        // superadmin & supervisor selalu boleh
        if (in_array($user->role, ['superadmin', 'supervisor'])) {
            return true;
        }

        // cek disposisi untuk user ini
        if ($user->role === 'data-entry') {
            $layanan = Str::ucfirst(Str::lower($permohonan->layanan->nama));
            return $permohonan->disposisi()
                ->where('penerima_id', $user->id)
                ->get()
                ->contains(fn ($d) => $d->layanan_type_name === $layanan);
        }

        return false;
    }
}
