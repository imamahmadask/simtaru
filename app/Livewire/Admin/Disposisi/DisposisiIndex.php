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
        $disposisi = [];
        $disposisi_selesai = [];
        // $disposisi_belum = [];

        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'supervisor'){
            $disposisi = Disposisi::with('layanan')->orderBy('created_at', 'desc')->get();
        }
        else
        {
            $disposisi = Disposisi::with('layanan')
                        ->where('penerima_id', Auth::user()->id)
                        ->where('is_done', false)
                        ->orderBy('created_at', 'desc')
                        ->get();

            $disposisi_selesai = Disposisi::with('layanan')
                        ->where('penerima_id', Auth::user()->id)
                        ->where('is_done', true)
                        ->orderBy('created_at', 'desc')
                        ->get();
        }


        return view('livewire.admin.disposisi.disposisi-index', [
            'disposisi_selesai' => $disposisi_selesai,
            'disposisi' => $disposisi,
        ]);
    }
}
