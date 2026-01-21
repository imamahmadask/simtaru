<?php

namespace App\Livewire\Admin\Disposisi;

use App\Models\Disposisi;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Disposisi')]
class DisposisiIndex extends Component
{
    use WithPagination;

    #[On('refresh-disposisi-list')]
    public function refresh()
    {}

    public function render()
    {
        $disposisi = [];
        $disposisi_selesai = [];
        // $disposisi_belum = [];

        if(Auth::user()->role == 'superadmin'){
                $disposisi = Disposisi::with(['layanan', 'permohonan.registrasi', 'tahapan', 'pemberi', 'penerima'])
                ->whereIn('id', function ($query) {
                    $query->selectRaw('max(id)')
                        ->from('disposisis')
                        ->groupBy('permohonan_id');
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        else
        {
            $disposisi = Disposisi::with('layanan')
                        ->where('penerima_id', Auth::user()->id)
                        ->where('is_done', false)
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

            $disposisi_selesai = Disposisi::with('layanan')
                        ->where('penerima_id', Auth::user()->id)
                        ->where('is_done', true)
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
        }


        return view('livewire.admin.disposisi.disposisi-index', [
            'disposisi_selesai' => $disposisi_selesai,
            'disposisi' => $disposisi,
        ]);
    }
}
