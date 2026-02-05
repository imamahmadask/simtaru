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
    public $jenis_pemanfaatan_ruang;
   
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

    #[Validate(['foto_pengawasan.*' => 'image|max:10240'])]
    public $foto_pengawasan = [];
    
    #[Layout('layouts.app-pelanggaran')]
    public function render()
    {
        return view('livewire.admin.pelanggaran.pelanggaran-create');
    }

    public function store()
    {
        $this->validate();

        $this->no_pelanggaran = 'PEL-' . date('Ymd') . '-' . Str::random(5);
        
        if($this->foto_pengawasan) 
        {
            $foto_pengawasan_path = [];
            foreach ($this->foto_pengawasan as $foto) {
                $foto_pengawasan_filename = $this->no_pelanggaran . '_' . Str::random(5) . '.' . $foto->getClientOriginalExtension();
                $foto_pengawasan_path[] = $foto->storeAs('pelanggaran/'.$this->no_pelanggaran.'/foto_pengawasan', $foto_pengawasan_filename, 'public');
            }
        }
        else
        {
            $foto_pengawasan_path = null;
        }

        Pelanggaran::create([
            'no_pelanggaran' => $this->no_pelanggaran,
            'tgl_laporan' => $this->tgl_laporan,
            'sumber_informasi_pelanggaran' => $this->sumber_informasi_pelanggaran,       
            'tanggal_pengawasan' => $this->tanggal_pengawasan,
            'foto_pengawasan' => json_encode($foto_pengawasan_path),
            'bentuk_laporan' => $this->bentuk_laporan,
            'nama_pelapor' => $this->nama_pelapor,
            'telp_pelapor' => $this->telp_pelapor,
            'isi_laporan' => $this->isi_laporan,
            'no_kkpr_skrk' => $this->no_kkpr_skrk,
            'no_ba_sk_penilaian_kkpr' => $this->no_ba_sk_penilaian_kkpr,
            'dokumen_penilaian_kkpr' => $this->dokumen_penilaian_kkpr,
            'jenis_pemanfaatan_ruang' => $this->jenis_pemanfaatan_ruang,
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
            'status' => 'Pending',
        ]);

        session()->flash('success', 'Data berhasil disimpan');

        return redirect()->route('pelanggaran.detail', Pelanggaran::where('no_pelanggaran', $this->no_pelanggaran)->first()->id);
    }

    public function removeImage($index)
    {
        unset($this->foto_pengawasan[$index]);
        $this->foto_pengawasan = array_values($this->foto_pengawasan);
    }
}
