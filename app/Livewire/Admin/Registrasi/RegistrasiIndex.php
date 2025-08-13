<?php

namespace App\Livewire\Admin\Registrasi;

use App\Models\Registrasi;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Registrasi')]
class RegistrasiIndex extends Component
{
    public function render()
    {
        $registrasis = Registrasi::with('layanan')->orderBy('created_at', 'desc')->get();

        return view('livewire.admin.registrasi.registrasi-index', [
            'registrasis' => $registrasis
        ]);
    }

    public function deleteRegistrasi(Registrasi $registrasi)
    {
        if (Auth::user()->role != 'superadmin') {
            abort(403);
        }

        $registrasi->permohonan()->delete();
        $registrasi->delete();

        session()->flash('message', 'Registrasi berhasil dihapus');

        return redirect()->route('registrasi.index');
    }
}
