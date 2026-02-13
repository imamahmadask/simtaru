<?php

namespace App\Livewire\Admin\Pelanggaran;

use App\Models\Pelanggaran;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Tambah Pelanggaran')]
class PelanggaranCreate extends Component
{
    use WithFileUploads;
    
    public $no_pelanggaran;
    
    #[Validate('required')]
    public $tgl_laporan, $sumber_informasi_pelanggaran;
    
    #[Validate('required_if:sumber_informasi_pelanggaran,Hasil Pengawasan dan Monitoring')]
    public $tanggal_pengawasan;  

    #[Validate('required_if:sumber_informasi_pelanggaran,Laporan Masyarakat')]
    public $bentuk_laporan;
    public $nama_pelapor;
    public $telp_pelapor;
    public $isi_laporan;

    #[Validate('required_if:sumber_informasi_pelanggaran,Hasil Penilaian KKPR atau SKRK')]
    public $no_kkpr_skrk;
    public $no_ba_sk_penilaian_kkpr;
    public $dokumen_penilaian_kkpr;    
   
    #[Validate('required')]
    public $nama_pelanggar;
    public $alamat_pelanggar;
    public $kel_pelanggar;
    public $kec_pelanggar;
    public $kota_pelanggar;
    public $prov_pelanggar;
    public $alamat_pelanggaran;
    public $kel_pelanggaran;
    public $kec_pelanggaran;
    public $koordinat_pelanggaran;
    public $gmaps_pelanggaran;

    #[Validate('required')]
    public $jenis_indikasi_pelanggaran;   
    public $jenis_pemanfaatan_ruang; 
    public $penjelasan_singkat;

    #[Validate(['foto_pengawasan.*' => 'image|max:10240'])]
    public $foto_pengawasan = [];

    #[Validate(['foto_existing.*' => 'image|max:10240'])]
    public $foto_existing = [];
    
    #[Layout('layouts.app-pelanggaran')]
    public function render()
    {
        return view('livewire.admin.pelanggaran.pelanggaran-create');
    }

    public function store()
    {
        $this->validate();

        $this->no_pelanggaran = $this->generateNoPelanggaran();

        $foto_pengawasan_path = $this->uploadMultipleFiles($this->foto_pengawasan, 'foto_pengawasan');
        $foto_existing_path = $this->uploadMultipleFiles($this->foto_existing, 'foto_existing');
        
        $dokumen_penilaian_kkpr_path = $this->dokumen_penilaian_kkpr 
            ? $this->dokumen_penilaian_kkpr->storeAs(
                "pelanggaran/{$this->no_pelanggaran}/dokumen_penilaian_kkpr", 
                str_replace('/', '-', $this->no_pelanggaran) . "_" . Str::random(5) . '.' . $this->dokumen_penilaian_kkpr->getClientOriginalExtension(), 
                'public'
            ) 
            : null;

        $pelanggaran = Pelanggaran::create([
            'no_pelanggaran' => $this->no_pelanggaran,
            'tgl_laporan' => $this->tgl_laporan,
            'sumber_informasi_pelanggaran' => $this->sumber_informasi_pelanggaran,       
            'tanggal_pengawasan' => $this->tanggal_pengawasan,
            'foto_pengawasan' => $foto_pengawasan_path,
            'bentuk_laporan' => $this->bentuk_laporan,
            'nama_pelapor' => $this->nama_pelapor,
            'telp_pelapor' => $this->telp_pelapor,
            'isi_laporan' => $this->isi_laporan,
            'no_kkpr_skrk' => $this->no_kkpr_skrk,
            'no_ba_sk_penilaian_kkpr' => $this->no_ba_sk_penilaian_kkpr,
            'dokumen_penilaian_kkpr' => $dokumen_penilaian_kkpr_path,            
            'nama_pelanggar' => $this->nama_pelanggar,
            'alamat_pelanggar' => $this->alamat_pelanggar,
            'kel_pelanggar' => $this->kel_pelanggar,
            'kec_pelanggar' => $this->kec_pelanggar,
            'kota_pelanggar' => $this->kota_pelanggar,
            'prov_pelanggar' => $this->prov_pelanggar,
            'alamat_pelanggaran' => $this->alamat_pelanggaran,
            'kel_pelanggaran' => $this->kel_pelanggaran,
            'kec_pelanggaran' => $this->kec_pelanggaran,
            'koordinat_pelanggaran' => $this->koordinat_pelanggaran,
            'gmaps_pelanggaran' => $this->gmaps_pelanggaran,
            'jenis_indikasi_pelanggaran' => $this->jenis_indikasi_pelanggaran,  
            'jenis_pemanfaatan_ruang' => $this->jenis_pemanfaatan_ruang,
            'foto_existing' => $foto_existing_path,          
            'penjelasan_singkat' => $this->penjelasan_singkat,
            'status' => 'On Progress',
        ]);

        return redirect()->route('pelanggaran.detail', $pelanggaran->id)->with('success', 'Data Pelanggaran berhasil ditambahkan!');
    }

    private function uploadMultipleFiles($files, $folder)
    {
        if (empty($files)) {
            return null;
        }

        $paths = [];
        foreach ($files as $file) {
            $filename = str_replace('/', '-', $this->no_pelanggaran) . "_" . Str::random(5) . '.' . $file->getClientOriginalExtension();
            $paths[] = $file->storeAs("pelanggaran/{$this->no_pelanggaran}/{$folder}", $filename, 'public');
        }

        return $paths;
    }

    public function removeImage($index)
    {
        unset($this->foto_pengawasan[$index]);
        $this->foto_pengawasan = array_values($this->foto_pengawasan);
    }

    private function generateNoPelanggaran()
    {
        $bulan = date('n');
        $tahun = date('Y');
        $romawi = $this->getRomawi($bulan);
        
        $urutan = Pelanggaran::whereYear('created_at', $tahun)->count() + 1;
        
        return sprintf("%03d/Wasdal-Taru/%s/%s", $urutan, $romawi, $tahun);
    }

    private function getRomawi($bulan)
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        return $map[$bulan];
    }
}
