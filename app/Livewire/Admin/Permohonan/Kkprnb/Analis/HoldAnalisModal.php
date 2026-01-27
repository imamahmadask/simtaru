<?php

namespace App\Livewire\Admin\Permohonan\Kkprnb\Analis;

use App\Models\Kkprnb;
use Livewire\Component;
use Livewire\Attributes\On;

class HoldAnalisModal extends Component
{
    public $kkprnb_id;
    public $is_analis_hold;
    public $tgl_analis_hold;
    public $tgl_analis_unhold;
    public $ket_analis_hold;

    #[On('kkprnb-analis-hold')]
    public function loadKkprnb($kkprnb_id)
    {
        $this->kkprnb_id = $kkprnb_id;
        $kkprnb = Kkprnb::find($this->kkprnb_id);

        if ($kkprnb) {
            $this->is_analis_hold = $kkprnb->is_analis_hold;
            $this->tgl_analis_hold = $kkprnb->tgl_analis_hold ?? date('Y-m-d');
            $this->tgl_analis_unhold = $kkprnb->tgl_analis_unhold;
            $this->ket_analis_hold = $kkprnb->ket_analis_hold;
            
            $this->dispatch('open-hold-analis-modal');
        }
    }

    public function save()
    {
        $kkprnb = Kkprnb::find($this->kkprnb_id);
        
        if (!$kkprnb) {
            session()->flash('error', 'Data tidak ditemukan');
            return;
        }

        $this->authorize('manageAnalis', $kkprnb->permohonan);

        if ($this->is_analis_hold) {
            // Unhold
            $kkprnb->update([
                'is_analis_hold' => false,
                'tgl_analis_unhold' => date('Y-m-d'),
            ]);
            session()->flash('success', 'Status Analis berhasil di-Unhold');
        } else {
            // Hold
            $this->validate([
                'tgl_analis_hold' => 'required|date',
                'ket_analis_hold' => 'required|string',
            ], [
                'tgl_analis_hold.required' => 'Tanggal hold harus diisi',
                'ket_analis_hold.required' => 'Keterangan hold harus diisi',
            ]);

            $kkprnb->update([
                'is_analis_hold' => true,
                'tgl_analis_hold' => $this->tgl_analis_hold,
                'ket_analis_hold' => $this->ket_analis_hold,
            ]);
            session()->flash('success', 'Status Analis berhasil di-Hold');
        }

        $this->dispatch('refresh-kkprnb-analis-detail');
        $this->dispatch('trigger-close-hold-analis-modal');
    }

    public function render()
    {
        return view('livewire.admin.permohonan.kkprnb.analis.hold-analis-modal');
    }
}
