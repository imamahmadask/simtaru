<?php

namespace App\Livewire\Admin\Permohonan\Itr;

use App\Livewire\Concerns\HasPermohonanTimeline;
use App\Models\Itr;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Permohonan ITR')]
class ItrIndex extends Component
{
    use WithPagination, HasPermohonanTimeline;

    public $search = '';

    public function showTimeline($itrId)
    {
        $itr = Itr::with(['permohonan.registrasi', 'permohonan.disposisi.tahapan', 'permohonan.disposisi.penerima', 'registrasi'])->findOrFail($itrId);
        $this->loadTimelineForPermohonan($itr->permohonan, $itr->registrasi->kode . ' - ' . $itr->registrasi->nama);
    }

    public function render()
    {
        $itr = Itr::with(['permohonan.registrasi', 'registrasi'])
            ->whereHas('layanan', function($query) {
                        $query->where('kode', 'ITR');
            })
            ->whereHas('registrasi', (function($query) {
                $query->where('kode', 'LIKE', '%'.$this->search.'%')
                ->orWhere('nama', 'LIKE', '%'.$this->search.'%');
            }))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.permohonan.itr.itr-index', [
            'itr' => $itr
        ]);
    }
}
