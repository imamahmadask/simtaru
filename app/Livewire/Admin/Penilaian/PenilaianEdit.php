<?php

namespace App\Livewire\Admin\Penilaian;

use App\Models\Penilaian;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Edit Penilaian')]
class PenilaianEdit extends Component
{
    use WithFileUploads;

    public $penilaianId;
    
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

    #[Validate('nullable|file|max:10240')]
    public $new_file_dokumen;

    public $existing_file_dokumen;

    #[Validate('required')]
    public $nama_usaha;

    public $alamat_lokasi_usaha;
    public $jenis_kegiatan_usaha;
    public $koordinat;
    public $analisa_penilaian;
    public $rekomendasi;
    public $link_hasil_penilaian;
    public $status;

    public function mount($id)
    {
        $penilaian = Penilaian::findOrFail($id);
        $this->penilaianId = $penilaian->id;
        $this->tanggal_penilaian = $penilaian->tanggal_penilaian;
        $this->jenis_penilaian = $penilaian->jenis_penilaian;
        $this->jenis_dokumen = $penilaian->jenis_dokumen;
        $this->nomor_dokumen = $penilaian->nomor_dokumen;
        $this->nama_pelaku_usaha = $penilaian->nama_pelaku_usaha;
        $this->alamat_pelaku_usaha = $penilaian->alamat_pelaku_usaha;
        $this->no_telepon = $penilaian->no_telepon;
        $this->email = $penilaian->email;
        $this->existing_file_dokumen = $penilaian->file_dokumen;
        $this->nama_usaha = $penilaian->nama_usaha;
        $this->alamat_lokasi_usaha = $penilaian->alamat_lokasi_usaha;
        $this->jenis_kegiatan_usaha = $penilaian->jenis_kegiatan_usaha;
        $this->koordinat = $penilaian->koordinat;
        $this->analisa_penilaian = $penilaian->analisa_penilaian;
        $this->rekomendasi = $penilaian->rekomendasi;
        $this->link_hasil_penilaian = $penilaian->link_hasil_penilaian;
        $this->status = $penilaian->status;
    }

    #[Layout('layouts.app-penilaian')]
    public function render()
    {
        return view('livewire.admin.penilaian.penilaian-edit');
    }

    public function update()
    {
        $this->validate();

        $penilaian = Penilaian::findOrFail($this->penilaianId);

        $file_dokumen_path = $this->existing_file_dokumen;
        if ($this->new_file_dokumen) {
            // Delete old file if exists
            if ($this->existing_file_dokumen && Storage::disk('public')->exists($this->existing_file_dokumen)) {
                Storage::disk('public')->delete($this->existing_file_dokumen);
            }
            $folder = 'penilaian/' . str_replace(['/', '\\'], '_', $this->nomor_dokumen);
            $filename = 'dokumen_' . Str::random(5) . '.' . $this->new_file_dokumen->getClientOriginalExtension();
            $file_dokumen_path = $this->new_file_dokumen->storeAs($folder, $filename, 'public');
        }

        $penilaian->update([
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
            'status' => $this->status,
        ]);

        return redirect()->route('penilaian.index')->with('success', 'Data Penilaian berhasil diupdate!');
    }
}
