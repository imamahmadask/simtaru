<?php

namespace App\Livewire\Guest;

use App\Models\Permohonan;
use App\Models\Registrasi;
use Illuminate\Support\Collection;
use Livewire\Component;

class Maps extends Component
{
    public $kecamatan;
    public array $locations = [];

    public function render()
    {
        return view('livewire.guest.maps');
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
        if($this->kecamatan != '')
        {
            $data = Permohonan::with(['skrk', 'itr', 'kkprb', 'kkprnb', 'registrasi'])
            ->whereHas('registrasi', function ($query) {
                $query->where('kec_tanah', $this->kecamatan);
            })->get();
        }
        else
        {
            $data = Permohonan::with(['skrk', 'itr', 'kkprb', 'kkprnb', 'registrasi'])->get();
        }     

        $this->locations = $data->flatMap(function ($permohonan) {
            $coords = [];
            
            // Ambil dari Skrk jika ada
            if ($permohonan->skrk && $permohonan->skrk->koordinat) {                
                $koordinatArray = $permohonan->skrk->koordinat;
                // Get first coordinate if array is not empty
                if (!empty($koordinatArray) && isset($koordinatArray[0])) {
                    $firstCoord = $koordinatArray[0];                    
                    $coords[] = [
                        'name' => 'Kode Registrasi: ' . $permohonan->registrasi->kode,
                        'lng' => $this->dmsToDecimal($firstCoord['x'] ?? null),
                        'lat' => $this->dmsToDecimal($firstCoord['y'] ?? null),
                        'info' => 'Status : ' . ($permohonan->status ?? 'Tidak ada deskripsi'),
                        'alamat' => 'Alamat : ' . $permohonan->registrasi->alamat_tanah,
                        'kelurahan' => 'Kelurahan : ' . $permohonan->registrasi->kel_tanah,
                        'kecamatan' => 'Kecamatan : ' . $permohonan->registrasi->kec_tanah,
                    ];
                }
            }

            // Ambil dari Itr jika ada
            if ($permohonan->itr && $permohonan->itr->koordinat) {
                $koordinatArray = $permohonan->itr->koordinat;
                // Get first coordinate if array is not empty
                if (!empty($koordinatArray) && isset($koordinatArray[0])) {
                    $firstCoord = $koordinatArray[0];                    
                    $coords[] = [
                        'name' => 'Kode Registrasi: ' . $permohonan->registrasi->kode,
                        'lng' => $this->dmsToDecimal($firstCoord['x'] ?? null),
                        'lat' => $this->dmsToDecimal($firstCoord['y'] ?? null),
                        'info' => 'Status : ' . ($permohonan->status ?? 'Tidak ada deskripsi'),
                        'alamat' => 'Alamat : ' . $permohonan->registrasi->alamat_tanah,
                        'kelurahan' => 'Kelurahan : ' . $permohonan->registrasi->kel_tanah,
                        'kecamatan' => 'Kecamatan : ' . $permohonan->registrasi->kec_tanah,
                    ];
                }
            }

            // Ambil dari Kkprb jika ada
            if ($permohonan->kkprb && $permohonan->kkprb->koordinat) {
                $koordinatArray = $permohonan->kkprb->koordinat;
                // Get first coordinate if array is not empty
                if (!empty($koordinatArray) && isset($koordinatArray[0])) {
                    $firstCoord = $koordinatArray[0];                    
                    $coords[] = [
                        'name' => 'Kode Registrasi: ' . $permohonan->registrasi->kode,
                        'lng' => $this->dmsToDecimal($firstCoord['x'] ?? null),
                        'lat' => $this->dmsToDecimal($firstCoord['y'] ?? null),
                        'info' => 'Status : ' . ($permohonan->status ?? 'Tidak ada deskripsi'),
                        'alamat' => 'Alamat : ' . $permohonan->registrasi->alamat_tanah,
                        'kelurahan' => 'Kelurahan : ' . $permohonan->registrasi->kel_tanah,
                        'kecamatan' => 'Kecamatan : ' . $permohonan->registrasi->kec_tanah,
                    ];
                }   
            }

            // Ambil dari Kkprnb jika ada
            if ($permohonan->kkprnb && $permohonan->kkprnb->koordinat) {
                $koordinatArray = $permohonan->kkprnb->koordinat;
                // Get first coordinate if array is not empty
                if (!empty($koordinatArray) && isset($koordinatArray[0])) {
                    $firstCoord = $koordinatArray[0];                    
                    $coords[] = [
                        'name' => 'Kode Registrasi: ' . $permohonan->registrasi->kode,
                        'lng' => $this->dmsToDecimal($firstCoord['x'] ?? null),
                        'lat' => $this->dmsToDecimal($firstCoord['y'] ?? null),
                        'info' => 'Status : ' . ($permohonan->status ?? 'Tidak ada deskripsi'),
                        'alamat' => 'Alamat : ' . $permohonan->registrasi->alamat_tanah,
                        'kelurahan' => 'Kelurahan : ' . $permohonan->registrasi->kel_tanah,
                        'kecamatan' => 'Kecamatan : ' . $permohonan->registrasi->kec_tanah,
                    ];
                }
            }

            return $coords;
        })->toArray(); // Convert Collection to array
        
        // Dispatch event to refresh map with new filtered data
        $this->dispatch('refresh-map');
    }

    public function mount()
    {
        // Query semua permohonan dengan relasi layanan (eager load untuk efisiensi)
        $permohonans = Permohonan::with(['skrk', 'itr', 'kkprb', 'kkprnb'])->get(); // Atau filter spesifik, misalnya ::where('status', 'approved')->get()
        // Collect koordinat dari masing-masing layanan yang ada, jadikan 1 array
        $this->locations = $permohonans->flatMap(function ($permohonan) {
            $coords = [];
            
            // Ambil dari Skrk jika ada
            if ($permohonan->skrk && $permohonan->skrk->koordinat) {                
                $koordinatArray = $permohonan->skrk->koordinat;
                // Get first coordinate if array is not empty
                if (!empty($koordinatArray) && isset($koordinatArray[0])) {
                    $firstCoord = $koordinatArray[0];                    
                    $coords[] = [
                        'name' => 'Kode Registrasi: ' . $permohonan->registrasi->kode,
                        'lng' => $this->dmsToDecimal($firstCoord['x'] ?? null),
                        'lat' => $this->dmsToDecimal($firstCoord['y'] ?? null),
                        'info' => 'Status : ' . ($permohonan->status ?? 'Tidak ada deskripsi'),
                        'alamat' => 'Alamat : ' . $permohonan->registrasi->alamat_tanah,
                        'kelurahan' => 'Kelurahan : ' . $permohonan->registrasi->kel_tanah,
                        'kecamatan' => 'Kecamatan : ' . $permohonan->registrasi->kec_tanah,
                    ];
                }
            }

            // Ambil dari Itr jika ada
            if ($permohonan->itr && $permohonan->itr->koordinat) {
                $koordinatArray = $permohonan->itr->koordinat;
                // Get first coordinate if array is not empty
                if (!empty($koordinatArray) && isset($koordinatArray[0])) {
                    $firstCoord = $koordinatArray[0];                    
                    $coords[] = [
                        'name' => 'Kode Registrasi: ' . $permohonan->registrasi->kode,
                        'lng' => $this->dmsToDecimal($firstCoord['x'] ?? null),
                        'lat' => $this->dmsToDecimal($firstCoord['y'] ?? null),
                        'info' => 'Status : ' . ($permohonan->status ?? 'Tidak ada deskripsi'),
                        'alamat' => 'Alamat : ' . $permohonan->registrasi->alamat_tanah,
                        'kelurahan' => 'Kelurahan : ' . $permohonan->registrasi->kel_tanah,
                        'kecamatan' => 'Kecamatan : ' . $permohonan->registrasi->kec_tanah,
                    ];
                }
            }

            // Ambil dari Kkprb jika ada
            if ($permohonan->kkprb && $permohonan->kkprb->koordinat) {
                $koordinatArray = $permohonan->kkprb->koordinat;
                // Get first coordinate if array is not empty
                if (!empty($koordinatArray) && isset($koordinatArray[0])) {
                    $firstCoord = $koordinatArray[0];                    
                    $coords[] = [
                        'name' => 'Kode Registrasi: ' . $permohonan->registrasi->kode,
                        'lng' => $this->dmsToDecimal($firstCoord['x'] ?? null),
                        'lat' => $this->dmsToDecimal($firstCoord['y'] ?? null),
                        'info' => 'Status : ' . ($permohonan->status ?? 'Tidak ada deskripsi'),
                        'alamat' => 'Alamat : ' . $permohonan->registrasi->alamat_tanah,
                        'kelurahan' => 'Kelurahan : ' . $permohonan->registrasi->kel_tanah,
                        'kecamatan' => 'Kecamatan : ' . $permohonan->registrasi->kec_tanah,
                    ];
                }
            }

            // Ambil dari Kkprnb jika ada
            if ($permohonan->kkprnb && $permohonan->kkprnb->koordinat) {
                $koordinatArray = $permohonan->kkprnb->koordinat;
                // Get first coordinate if array is not empty
                if (!empty($koordinatArray) && isset($koordinatArray[0])) {
                    $firstCoord = $koordinatArray[0];                    
                    $coords[] = [
                        'name' => 'Kode Registrasi: ' . $permohonan->registrasi->kode,
                        'lng' => $this->dmsToDecimal($firstCoord['x'] ?? null),
                        'lat' => $this->dmsToDecimal($firstCoord['y'] ?? null),
                        'info' => 'Status : ' . ($permohonan->status ?? 'Tidak ada deskripsi'),
                        'alamat' => 'Alamat : ' . $permohonan->registrasi->alamat_tanah,
                        'kelurahan' => 'Kelurahan : ' . $permohonan->registrasi->kel_tanah,
                        'kecamatan' => 'Kecamatan : ' . $permohonan->registrasi->kec_tanah,
                    ];
                }
            }

            return $coords;
        })->toArray(); // Convert Collection to array          
    }
}
