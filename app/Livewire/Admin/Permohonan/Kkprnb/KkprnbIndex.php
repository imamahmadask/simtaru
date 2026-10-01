<?php

namespace App\Livewire\Admin\Permohonan\Kkprnb;

use App\Livewire\Concerns\HasPermohonanTimeline;
use App\Models\Kkprnb;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Permohonan KKPR Non Berusaha')]
class KkprnbIndex extends Component
{
    use WithPagination, HasPermohonanTimeline;

    public $search = '';

    public function showTimeline($kkprnbId)
    {
        $kkprnb = Kkprnb::with(['permohonan.registrasi', 'permohonan.disposisi.tahapan', 'permohonan.disposisi.penerima', 'registrasi'])->findOrFail($kkprnbId);
        $this->loadTimelineForPermohonan($kkprnb->permohonan, $kkprnb->registrasi->kode . ' - ' . $kkprnb->registrasi->nama);
    }

    public function render()
    {
        $kkprnb = Kkprnb::with(['permohonan.registrasi', 'registrasi'])
            ->whereHas('layanan', function($query) {
                        $query->where('kode', 'KKPRNB');
            })
            ->whereHas('registrasi', (function($query) {
                $query->where('kode', 'LIKE', '%'.$this->search.'%')
                ->orWhere('nama', 'LIKE', '%'.$this->search.'%');
            }))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.permohonan.kkprnb.kkprnb-index', [
            'kkprnb' => $kkprnb,
        ]);
    }
}
