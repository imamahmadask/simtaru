<?php

namespace App\Livewire\Guest\Maps;

use App\Models\Permohonan;
use App\Models\Registrasi;
use App\Models\Saran;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Peta Pemanfaatan Ruang')]
#[Layout('layouts.guest-onepage')]
class PetaPemanfaatanRuang extends Component
{
    public $kecamatan;
    public array $locations = [];

    // Properties for Saran/Masukan
    public $selectedPermohonanId;
    public $saranNama;
    public $saranPesan;
    public $showSaranModal = false;
    public $successMessage;
    public $pemanfaatan_ruang;

    public function mount()
    {
        $this->loadLocations();
    }

    public function render()
    {
        return view('livewire.guest.maps.peta-pemanfaatan-ruang');
    }

    private function loadLocations()
    {
        $query = Permohonan::with(['skrk', 'itr', 'kkprb', 'kkprnb', 'registrasi']);

        $query->when($this->kecamatan || $this->pemanfaatan_ruang, function ($query) {
            $query->whereHas('registrasi', function ($query) {
                $query->where(function ($query) {
                    $query->when($this->kecamatan, fn($q) => $q->orWhere('kec_tanah', $this->kecamatan))
                        ->when($this->pemanfaatan_ruang, fn($q) => $q->orWhere('fungsi_bangunan', 'like', '%' . $this->pemanfaatan_ruang . '%'));
                });
            });
        });

        $permohonans = $query->get();

        $this->locations = $permohonans->flatMap(function ($permohonan) {
            return $this->extractCoordinatesFromPermohonan($permohonan);
        })->toArray();
    }

    private function extractCoordinatesFromPermohonan($permohonan)
    {
        $coords = [];
        $relations = ['skrk', 'itr', 'kkprb', 'kkprnb'];

        foreach ($relations as $relation) {
            $kesimpulan = ($relation !== 'itr' && $permohonan->$relation) ? $permohonan->$relation->kesimpulan : null;
            if ($permohonan->$relation && $permohonan->$relation->koordinat) {
                $koordinatArray = $permohonan->$relation->koordinat;
                
                if (!empty($koordinatArray) && isset($koordinatArray[0])) {
                    $firstCoord = $koordinatArray[0];
                    $coords[] = [
                        'id' => $permohonan->id,
                        'name' => 'Kode Registrasi: ' . ($permohonan->registrasi->kode ?? '-'),
                        'lng' => $this->dmsToDecimal($firstCoord['x'] ?? null),
                        'lat' => $this->dmsToDecimal($firstCoord['y'] ?? null),
                        'info' => 'Status : ' . ($permohonan->status ?? 'Tidak ada deskripsi'),
                        'alamat' => 'Alamat : ' . ($permohonan->registrasi->alamat_tanah ?? '-'),
                        'kelurahan' => 'Kelurahan : ' . ($permohonan->registrasi->kel_tanah ?? '-'),
                        'kecamatan' => 'Kecamatan : ' . ($permohonan->registrasi->kec_tanah ?? '-'),
                        'jenis_kegiatan' => 'Jenis Kegiatan : ' . ($permohonan->registrasi->fungsi_bangunan ?? '-'),
                        'kesimpulan' => 'Kesimpulan : ' . ($kesimpulan ?? '-'),
                    ];
                }
            }
        }

        return $coords;
    }   

    /**
     * Convert DMS (Degrees Minutes Seconds) to Decimal Degrees
     * Example: "8°36'46,648\"S" => -8.612958
     * Example: "116°6'26,406\"E" => 116.107335
     */
    private function dmsToDecimal($dms)
    {
        if (empty($dms)) {
            return null;
        }

        // Remove spaces and normalize
        $dms = trim($dms);
        
        // Extract direction (N, S, E, W)
        $direction = '';
        if (preg_match('/[NSEW]$/i', $dms, $matches)) {
            $direction = strtoupper($matches[0]);
            $dms = rtrim($dms, $direction);
        }

        // Replace comma with dot for decimal separator
        $dms = str_replace(',', '.', $dms);
        
        // Parse degrees, minutes, seconds
        // Pattern: 8°36'46.648"
        if (preg_match('/(\d+)°(\d+)\'([\d.]+)"?/', $dms, $matches)) {
            $degrees = (float) $matches[1];
            $minutes = (float) $matches[2];
            $seconds = (float) $matches[3];
            
            // Convert to decimal
            $decimal = $degrees + ($minutes / 60) + ($seconds / 3600);
            
            // Apply direction (S and W are negative)
            if ($direction === 'S' || $direction === 'W') {
                $decimal = -$decimal;
            }
            
            return $decimal;
        }
        
        // If already decimal, return as is
        if (is_numeric($dms)) {
            return (float) $dms;
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
        $this->selectedPermohonanId = $id;
        $this->reset(['saranNama', 'saranPesan', 'successMessage']);
        $this->resetErrorBag();
        $this->showSaranModal = true;
        $this->dispatch('open-modal-saran');
    }

    public function closeSaranModal()
    {
        $this->showSaranModal = false;
        $this->reset(['selectedPermohonanId', 'saranNama', 'saranPesan']);
        $this->resetErrorBag();
        $this->dispatch('close-modal-saran');
    }

    public function saveSaran()
    {
        $this->validate([
            'saranNama' => 'required|string|max:255',
            'saranPesan' => 'required|string',
        ]);

        Saran::create([
            'permohonan_id' => $this->selectedPermohonanId,
            'nama' => $this->saranNama,
            'pesan' => $this->saranPesan,
        ]);

        $this->closeSaranModal();
        $this->successMessage = 'Saran/Masukan berhasil dikirim. Terima kasih!';
        $this->dispatch('show-success-toast');
    }
}
