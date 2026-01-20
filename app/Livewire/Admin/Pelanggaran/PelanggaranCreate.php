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
    public $jenis_formulir;
    public $tanggal_pengawasan;
    public $lokasi_pengawasan;
    public $hasil_pengawasan;
    public $anggota_tidak_hadir;
    public $temuan_pelanggaran;
    public $sumber_informasi_pelanggaran;
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
    public $bentuk_laporan;
    public $nama_pelapor;
    public $isi_laporan;
    public $jenis_indikasi_pelanggaran;
    
    public $status;

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
        
        if($this->foto_pengawasan) {
            $foto_pengawasan_path = [];
            foreach ($this->foto_pengawasan as $foto) {
                $foto_pengawasan_filename = $this->no_pelanggaran . '_' . Str::random(5) . '.' . $foto->getClientOriginalExtension();
                $foto_pengawasan_path[] = $foto->storeAs('pelanggaran/foto_pengawasan', $foto_pengawasan_filename, 'public');
            }
        }
        else
            {
                $foto_pengawasan_path = null;
            }

        Pelanggaran::create([
            'no_pelanggaran' => $this->no_pelanggaran,
            'jenis_formulir' => $this->jenis_formulir,
            'tanggal_pengawasan' => $this->tanggal_pengawasan,
            'lokasi_pengawasan' => $this->lokasi_pengawasan,
            'hasil_pengawasan' => $this->hasil_pengawasan,
            'anggota_tidak_hadir' => $this->anggota_tidak_hadir,
            'foto_pengawasan' => json_encode($foto_pengawasan_path),
            'temuan_pelanggaran' => $this->temuan_pelanggaran,
            'sumber_informasi_pelanggaran' => $this->sumber_informasi_pelanggaran,
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
            'bentuk_laporan' => $this->bentuk_laporan,
            'nama_pelapor' => $this->nama_pelapor,
            'isi_laporan' => $this->isi_laporan,
            'jenis_indikasi_pelanggaran' => $this->jenis_indikasi_pelanggaran,
            'status' => 'Success',
        ]);

        session()->flash('success', 'Data berhasil disimpan');

        redirect()->route('pelanggaran.index');
    }

    public function removeImage($index)
    {
        unset($this->foto_pengawasan[$index]);
        $this->foto_pengawasan = array_values($this->foto_pengawasan);
    }
}
