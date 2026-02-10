<?php

namespace App\Livewire\Admin\Pelanggaran;

use App\Models\Pelanggaran;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Detail Pelanggaran')]
class PelanggaranDetail extends Component
{
    public $pelanggaran;

    public function mount($id)
    {
        $this->pelanggaran = Pelanggaran::findOrFail($id);
    }

    #[On('refresh-pelanggaran-analis-list')]
    public function refresh()
    {
        $this->pelanggaran->refresh();
    }

    #[Layout('layouts.app-pelanggaran')]
    public function render()
    {
        return view('livewire.admin.pelanggaran.pelanggaran-detail');
    }
}
