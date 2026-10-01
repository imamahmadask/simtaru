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

    public function manageAll(User $user): bool
    {
        return in_array($user->role, ['superadmin', 'supervisor']);
    }


    public function manageSurvey(User $user, Permohonan $permohonan): bool
    {
        return $this->canManageStage($user, $permohonan, 'surveyor');
    }

    public function manageAnalis(User $user, Permohonan $permohonan): bool
    {
        return $this->canManageStage($user, $permohonan, 'analis');
    }

    public function manageDataEntry(User $user, Permohonan $permohonan): bool
    {
        return $this->canManageStage($user, $permohonan, 'data-entry');
    }

    private function canManageStage(User $user, Permohonan $permohonan, string $expectedRole): bool
    {
        if ($permohonan->is_ditolak) {
            return false;
        }

        if (in_array($user->role, ['superadmin', 'supervisor'], true)) {
            return true;
        }

        if ($user->role !== $expectedRole || !$permohonan->layanan) {
            return false;
        }

        $layananName = Str::ucfirst(Str::lower($permohonan->layanan->kode));
        $layananClass = 'App\\Models\\' . $layananName;

        if ($permohonan->relationLoaded('disposisi')) {
            return $permohonan->disposisi->contains(
                fn ($d) => (int) $d->penerima_id === (int) $user->id
                    && ($d->layanan_type === $layananClass || $d->layanan_type_name === $layananName)
            );
        }

        return $permohonan->disposisi()
            ->where('penerima_id', $user->id)
            ->where('layanan_type', $layananClass)
            ->exists();
    }
}
