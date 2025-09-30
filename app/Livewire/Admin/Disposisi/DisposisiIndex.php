<?php

namespace App\Livewire\Admin\Disposisi;

use App\Models\Disposisi;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Disposisi')]
class DisposisiIndex extends Component
{
    public function render()
    {
        $disposisi_masuk = [];
        $disposisi_keluar = [];

        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'supervisor'){
            $disposisi_masuk = Disposisi::with('layanan')->orderBy('created_at', 'desc')->get();
        }
        else
        {
            $disposisi_masuk = Disposisi::with('layanan')
                        ->where('penerima_id', Auth::user()->id)
                        ->orderBy('created_at', 'desc')
                        ->get();

            $disposisi_keluar = Disposisi::with('layanan')
                        ->where('pemberi_id', Auth::user()->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
        }


        return view('livewire.admin.disposisi.disposisi-index', [
            'disposisi_masuk' => $disposisi_masuk,
            'disposisi_keluar' => $disposisi_keluar,
        ]);
    }
}
