<?php

namespace App\Livewire\Admin\Permohonan\Skrk;

use App\Livewire\Concerns\HasPermohonanTimeline;
use App\Models\Skrk;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Permohonan SKRK')]
class SkrkIndex extends Component
{
    use WithPagination, HasPermohonanTimeline;

    public $search = '';

    public function showTimeline($skrkId)
    {
        $skrk = Skrk::with(['permohonan.registrasi', 'permohonan.disposisi.tahapan', 'permohonan.disposisi.penerima', 'registrasi'])->findOrFail($skrkId);
        $this->loadTimelineForPermohonan($skrk->permohonan, $skrk->registrasi->kode . ' - ' . $skrk->registrasi->nama);
    }

    public function render()
    {
        $skrk = Skrk::with(['permohonan.registrasi', 'registrasi'])
            ->whereHas('layanan', function($query) {
                        $query->where('kode', 'SKRK');
            })
            ->whereHas('registrasi', (function($query) {
                $query->where('kode', 'LIKE', '%'.$this->search.'%')
                ->orWhere('nama', 'LIKE', '%'.$this->search.'%');
            }))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.permohonan.skrk.skrk-index', [
            'skrk' => $skrk
        ]);
    }
}
