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
    public array $locations = [];

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
        $query = Penilaian::query();

        // Assuming kecamatan filter is relevant if penilaians have addresses with kecamatan info
        // If penilaians don't have a specific kec_penilaian field, we might need to filter by alamat_lokasi_usaha
        // But for consistency with Pelanggaran, let's see if we can filter.
        // Based on the migration, there's no explicit kecamatan field, but there's alamat_lokasi_usaha.
        
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
}
