<?php

namespace App\Livewire\Admin\Registrasi;

use App\Models\Registrasi;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Registrasi')]
class RegistrasiIndex extends Component
{
    public function render()
    {
        $registrasis = Registrasi::with('layanan')->orderBy('tanggal', 'desc')->get();

        return view('livewire.admin.registrasi.registrasi-index', [
            'registrasis' => $registrasis
        ]);
    }


}
