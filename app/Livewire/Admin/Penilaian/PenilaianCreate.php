<?php

namespace App\Livewire\Admin\Penilaian;

use App\Models\Penilaian;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Tambah Penilaian')]
class PenilaianCreate extends Component
{
    use WithFileUploads;
    
    #[Validate('required')]
    public $tanggal_penilaian;
    
    #[Validate('required')]
    public $jenis_penilaian;

    #[Validate('required')]
    public $jenis_dokumen;

    #[Validate('required')]
    public $nomor_dokumen;

    #[Validate('required')]
    public $nama_pelaku_usaha;

    public $alamat_pelaku_usaha;
    public $no_telepon;
    public $email;

    #[Validate('required|file|max:10240')] // 10MB max
    public $file_dokumen;

    #[Validate('required')]
    public $nama_usaha;

    public $alamat_lokasi_usaha;
    public $jenis_kegiatan_usaha;
    public $koordinat;
    public $analisa_penilaian;
    public $rekomendasi;
    public $link_hasil_penilaian;

    #[Layout('layouts.app-penilaian')]
    public function render()
    {
        return view('livewire.admin.penilaian.penilaian-create');
    }

    public function store()
    {
        $this->validate();

        $file_dokumen_path = null;
        if ($this->file_dokumen) {
            $folder = 'penilaian/' . str_replace(['/', '\\'], '_', $this->nomor_dokumen);
            $filename = 'dokumen_' . Str::random(5) . '.' . $this->file_dokumen->getClientOriginalExtension();
            $file_dokumen_path = $this->file_dokumen->storeAs($folder, $filename, 'public');
        }

        $penilaian = Penilaian::create([
            'tanggal_penilaian' => $this->tanggal_penilaian,
            'jenis_penilaian' => $this->jenis_penilaian,
            'jenis_dokumen' => $this->jenis_dokumen,
            'nomor_dokumen' => $this->nomor_dokumen,
            'nama_pelaku_usaha' => $this->nama_pelaku_usaha,
            'alamat_pelaku_usaha' => $this->alamat_pelaku_usaha,
            'no_telepon' => $this->no_telepon,
            'email' => $this->email,
            'file_dokumen' => $file_dokumen_path,
            'nama_usaha' => $this->nama_usaha,
            'alamat_lokasi_usaha' => $this->alamat_lokasi_usaha,
            'jenis_kegiatan_usaha' => $this->jenis_kegiatan_usaha,
            'koordinat' => $this->koordinat,
            'analisa_penilaian' => $this->analisa_penilaian,
            'rekomendasi' => $this->rekomendasi,
            'link_hasil_penilaian' => $this->link_hasil_penilaian,
            'status' => 'Selesai',
        ]);

        return redirect()->route('penilaian.index')->with('success', 'Data Penilaian berhasil ditambahkan!');
    }
}
