<?php

namespace App\Livewire\Admin\Pelanggaran\Analis;

use App\Models\Pelanggaran;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class PelanggaranAnalisDetail extends Component
{
    use WithFileUploads;

    public $pelanggaran;
    public $temuan_pelanggaran;
    public $existing_foto_tindak_lanjut = [];
    
    #[Validate('required_if:temuan_pelanggaran,Ada Pelanggaran', message: 'Tindak lanjut wajib diisi')]
    public $tindak_lanjut;
    
    #[Validate(['foto_tindak_lanjut.*' => 'image|max:10240'])]
    public $foto_tindak_lanjut = [];

    public function render()
    {
        return view('livewire.admin.pelanggaran.analis.pelanggaran-analis-detail');
    }

    #[On('refresh-pelanggaran-analis-list')]
    public function refresh() {
        $this->mount($this->pelanggaran->id);
    }

    public function mount($id)
    {
        $this->pelanggaran = Pelanggaran::find($id);
        $this->temuan_pelanggaran = $this->pelanggaran->temuan_pelanggaran;
        $this->tindak_lanjut = $this->pelanggaran->tindak_lanjut;
        $this->existing_foto_tindak_lanjut = $this->pelanggaran->foto_tindak_lanjut ?? [];
    }

    public function storeAnalisa()
    {
        if ($this->temuan_pelanggaran == 'Ada Pelanggaran') {
            $this->validate();
        } else {
            $this->validate([
                'temuan_pelanggaran' => 'required'
            ]);
        }

        $all_photos = $this->existing_foto_tindak_lanjut;

        if($this->foto_tindak_lanjut) 
        {
            foreach ($this->foto_tindak_lanjut as $foto) {
                $foto_tindak_lanjut_filename = $this->pelanggaran->no_pelanggaran . '_' . Str::random(5) . '.' . $foto->getClientOriginalExtension();
                $all_photos[] = $foto->storeAs('pelanggaran/'.$this->pelanggaran->no_pelanggaran.'/foto_tindak_lanjut', $foto_tindak_lanjut_filename, 'public');
            }
        }

        $this->pelanggaran->update([
            'temuan_pelanggaran' => $this->temuan_pelanggaran,
            'tindak_lanjut' => $this->tindak_lanjut,
            'foto_tindak_lanjut' => count($all_photos) > 0 ? $all_photos : null,
        ]);

        session()->flash('message', 'Analisa Pelanggaran Berhasil Ditambahkan!');

        $this->dispatch('refresh-pelanggaran-analis-list');
        $this->dispatch('closeModal');
        
        // Reset new photos after save
        $this->foto_tindak_lanjut = [];
    }

    public function removeImage($index)
    {
        unset($this->foto_tindak_lanjut[$index]);
        $this->foto_tindak_lanjut = array_values($this->foto_tindak_lanjut);
    }

    public function removeExistingImage($index)
    {
        unset($this->existing_foto_tindak_lanjut[$index]);
        $this->existing_foto_tindak_lanjut = array_values($this->existing_foto_tindak_lanjut);
    }
}
