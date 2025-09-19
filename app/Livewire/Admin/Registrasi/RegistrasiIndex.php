<?php

namespace App\Livewire\Admin\Registrasi;

use App\Models\Layanan;
use App\Models\Registrasi;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Registrasi')]
class RegistrasiIndex extends Component
{
    public $search = '';
    public $filterLayanan = '';
    public $filterStatus = '';
    public $filterPrioritas = '';
    public $layanans;

    public function render()
    {
        $registrasis = Registrasi::with('layanan')
                     ->whereHas('layanan', function($query) {
                            $query->where('id', 'like', '%'.$this->filterLayanan.'%');
                        })
                    ->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('kode', 'like', '%' . $this->search . '%')
                    ->orderBy('created_at', 'desc')->get();

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

    public function mount()
    {
        $this->layanans = Layanan::all();
    }
}
