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

    public $riwayatSelected = [];

    #[On('refresh-disposisi-list')]
    public function refresh()
    {}

    public function render()
    {
        $user = Auth::user();
        $relations = ['layanan', 'permohonan.registrasi', 'tahapan', 'pemberi', 'penerima'];

        if ($user->role == 'superadmin') {
            $disposisi = Disposisi::with($relations)
                ->whereIn('id', function ($query) {
                    $query->selectRaw('max(id)')
                        ->from('disposisis')
                        ->groupBy('permohonan_id');
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('livewire.admin.disposisi.disposisi-index', [
                'disposisi' => $disposisi,
                'disposisi_selesai' => []
            ]);
        }

        $disposisi = Disposisi::with($relations)
            ->where('penerima_id', $user->id)
            ->where('is_done', false)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page');

        $disposisi_selesai = Disposisi::with($relations)
            ->where('penerima_id', $user->id)
            ->where('is_done', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page_selesai');

        return view('livewire.admin.disposisi.disposisi-index', [
            'disposisi' => $disposisi,
            'disposisi_selesai' => $disposisi_selesai,
        ]);
    }

    public function openHistory($permohonanId)
    {
        // Mengambil seluruh jejak disposisi secara kronologis (Linked List)
        $this->riwayatSelected = Disposisi::with(['pemberi', 'penerima', 'tahapan'])
            ->where('permohonan_id', $permohonanId)
            ->latest() // Urutkan dari yang paling pertama dibuat
            ->get();
        
        $this->dispatch('show-history-modal');
    }
}
