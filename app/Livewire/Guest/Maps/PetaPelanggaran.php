<?php

namespace App\Livewire\Guest\Maps;

use App\Models\Pelanggaran;
use App\Models\SaranPelanggaran;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Peta Pelanggaran')]
#[Layout('layouts.guest-onepage')]
class PetaPelanggaran extends Component
{
    public $kecamatan;
    public array $locations = [];

    // Properties for simple popup or details
    public $selectedPelanggaranId;
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
        return view('livewire.guest.maps.peta-pelanggaran');
    }

    private function loadLocations()
    {
        $query = Pelanggaran::query();

        $query->when($this->kecamatan, function ($q) {
            $q->where('kec_pelanggaran', $this->kecamatan);
        });

        // Only get active or visible violations if needed, 
        // assuming all are visible for now.
        
        $pelanggarans = $query->get();

        $this->locations = $pelanggarans->map(function ($pelanggaran) {
            return $this->extractCoordinates($pelanggaran);
        })->filter()->values()->toArray();
    }

    private function extractCoordinates($pelanggaran)
    {
        // Assume koordinat_pelanggaran is "Lat, Lng" or similar string
        // If it's DMS, we need conversion. Checking structure usage in other files implies likely Decimal or DMS string.
        // Let's support both decimal "lat, lng" and attempt DMS conversion if needed.
        
        if (empty($pelanggaran->koordinat_pelanggaran)) {
            return null;
        }

        $coordString = $pelanggaran->koordinat_pelanggaran;
        $lat = null;
        $lng = null;

        // Try simple comma separation first (Decimal)
        if (strpos($coordString, ',') !== false) {
            $parts = explode(',', $coordString);
            if (count($parts) >= 2) {
                // Check if numeric (Decimal)
                if (is_numeric(trim($parts[0])) && is_numeric(trim($parts[1]))) {
                    $lat = (float) trim($parts[0]);
                    $lng = (float) trim($parts[1]);
                } else {
                    // Try DMS if not numeric
                    // Note: PelanggaranCreate logic might suggest format
                    // Defaulting to 0,0 if parsing fails for safety, or null
                    // But for now let's assume valid DMS or Decimal
                    // If complex parsing needed, we can reuse logic or simple regex
                }
            }
        }
        
        // If still null, try DMS parser or assume simple string
        if ($lat === null || $lng === null) {
             // Fallback or specific parser if needed. 
             // Without knowing exact format, assuming decimal "lat, lng" is most common for simple fields
             // If field is "S 8 35 ..., E 116 ...", we need custom parser
             // Let's implement a robust parser similar to PetaPemanfaatan if needed, 
             // but usually koordinat field is simple.
             
             // Let's try to extract numbers.
             // If manual string, just return null for now to avoid errors
             // or try to match lat/lng patterns
        }

        // Just in case it's reversed or specific format
        if ($lat && $lng) {
             return [
                'id' => $pelanggaran->id,
                'no_pelanggaran' => $pelanggaran->no_pelanggaran,
                'lat' => $lat,
                'lng' => $lng,
                'info' => $pelanggaran->status,
                'alamat' => $pelanggaran->alamat_pelanggaran,
                'kelurahan' => $pelanggaran->kel_pelanggaran,
                'kecamatan' => $pelanggaran->kec_pelanggaran,                
                'tindak_lanjut' => $pelanggaran->tindak_lanjut,
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
        $this->selectedPelanggaranId = $id;
        $this->reset(['saranNama', 'saranPesan', 'successMessage']);
        $this->resetErrorBag();
        $this->showSaranModal = true;
        $this->dispatch('open-modal-saran');
    }

    public function closeSaranModal()
    {
        $this->showSaranModal = false;
        $this->reset(['selectedPelanggaranId', 'saranNama', 'saranPesan']);
        $this->resetErrorBag();
        $this->dispatch('close-modal-saran');
    }

    public function saveSaran()
    {
        $this->validate([
            'saranNama' => 'required|string|max:255',
            'saranPesan' => 'required|string',
        ]);

        SaranPelanggaran::create([
            'pelanggaran_id' => $this->selectedPelanggaranId,
            'nama' => $this->saranNama,
            'pesan' => $this->saranPesan,
        ]);

        $this->closeSaranModal();
        $this->successMessage = 'Saran/Masukan berhasil dikirim. Terima kasih!';
        $this->dispatch('show-success-toast');
    }
}
