<?php

namespace App\Livewire\Guest\Maps;

use App\Models\Penilaian;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Peta Penilaian')]
#[Layout('layouts.guest-onepage')]
class PetaPenilaian extends Component
{
    public $kecamatan;
    public $filterYear;
    public $filterJenis;
    public array $locations = [];

    public $selectedPenilaianId;
    public $saranNama;
    public $saranPesan;
    public $showSaranModal = false;
    public $successMessage;

    public function mount()
    {
        $this->loadLocations();
    }

    public function render()
    {
        return view('livewire.guest.maps.peta-penilaian');
    }

    public function loadLocations()
    {
        $query = \App\Models\Penilaian::query();

        $query->when($this->filterYear, function ($q) {
            $q->whereYear('tanggal_penilaian', $this->filterYear);
        });

        $query->when($this->filterJenis, function ($q) {
            $q->where('jenis_penilaian', $this->filterJenis);
        });
        
        $penilaians = $query->whereNotNull('koordinat')->get();

        $this->locations = $penilaians->map(function ($penilaian) {
            return $this->extractCoordinates($penilaian);
        })->filter()->values()->toArray();
    }

    private function extractCoordinates($penilaian)
    {
        if (empty($penilaian->koordinat)) {
            return null;
        }

        $coordString = $penilaian->koordinat;
        $lat = null;
        $lng = null;

        if (strpos($coordString, ',') !== false) {
            $parts = explode(',', $coordString);
            if (count($parts) >= 2) {
                if (is_numeric(trim($parts[0])) && is_numeric(trim($parts[1]))) {
                    $lat = (float) trim($parts[0]);
                    $lng = (float) trim($parts[1]);
                }
            }
        }

        if ($lat && $lng) {
             return [
                'id' => $penilaian->id,
                'nomor_dokumen' => $penilaian->nomor_dokumen,
                'lat' => $lat,
                'lng' => $lng,
                'status' => $penilaian->status,
                'nama_usaha' => $penilaian->nama_usaha,
                'alamat' => $penilaian->alamat_lokasi_usaha,
                'jenis_penilaian' => $penilaian->jenis_penilaian,
                'tanggal_penilaian' => $penilaian->tanggal_penilaian ? \Carbon\Carbon::parse($penilaian->tanggal_penilaian)->format('d/m/Y') : '-',
                'jenis_kegiatan_usaha' => $penilaian->jenis_kegiatan_usaha,
                'analisa_penilaian' => $penilaian->analisa_penilaian,
            ];
        }

        return null;
    }

    public function filterMap()
    {
        $this->loadLocations();
        $this->dispatch('refresh-map');
    }

    public function openSaranModal($id)
    {
        $this->selectedPenilaianId = $id;
        $this->reset(['saranNama', 'saranPesan', 'successMessage']);
        $this->resetErrorBag();
        $this->showSaranModal = true;
        $this->dispatch('open-modal-saran');
    }

    public function closeSaranModal()
    {
        $this->showSaranModal = false;
        $this->reset(['selectedPenilaianId', 'saranNama', 'saranPesan']);
        $this->resetErrorBag();
        $this->dispatch('close-modal-saran');
    }

    public function saveSaran()
    {
        $this->validate([
            'saranNama' => 'required|string|max:255',
            'saranPesan' => 'required|string',
        ]);

        \App\Models\SaranPenilaian::create([
            'penilaian_id' => $this->selectedPenilaianId,
            'nama' => $this->saranNama,
            'pesan' => $this->saranPesan,
        ]);

        $this->closeSaranModal();
        $this->successMessage = 'Saran/Masukan berhasil dikirim. Terima kasih!';
        $this->dispatch('show-success-toast');
    }
}
