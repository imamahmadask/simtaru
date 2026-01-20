<?php

namespace App\Livewire\Admin\Pelanggaran;

use App\Models\Pelanggaran;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Edit Pelanggaran')]
class PelanggaranEdit extends Component
{
    use WithFileUploads;

    public $pelanggaranId;
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

    public $existing_foto_pengawasan = [];
    
    #[Validate(['new_foto_pengawasan.*' => 'image|max:10240'])]
    public $new_foto_pengawasan = [];

    public function mount($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        $this->pelanggaranId = $pelanggaran->id;
        $this->no_pelanggaran = $pelanggaran->no_pelanggaran;
        $this->jenis_formulir = $pelanggaran->jenis_formulir;
        $this->tanggal_pengawasan = $pelanggaran->tanggal_pengawasan;
        $this->lokasi_pengawasan = $pelanggaran->lokasi_pengawasan;
        $this->hasil_pengawasan = $pelanggaran->hasil_pengawasan;
        $this->anggota_tidak_hadir = $pelanggaran->anggota_tidak_hadir;
        $this->temuan_pelanggaran = $pelanggaran->temuan_pelanggaran;
        $this->sumber_informasi_pelanggaran = $pelanggaran->sumber_informasi_pelanggaran;
        $this->nama_pelanggar = $pelanggaran->nama_pelanggar;
        $this->alamat_pelanggar = $pelanggaran->alamat_pelanggar;
        $this->kel_pelanggar = $pelanggaran->kel_pelanggar;
        $this->kec_pelanggar = $pelanggaran->kec_pelanggar;
        $this->kota_pelanggar = $pelanggaran->kota_pelanggar;
        $this->prov_pelanggar = $pelanggaran->prov_pelanggar;
        $this->alamat_pelanggaran = $pelanggaran->alamat_pelanggaran;
        $this->kel_pelanggaran = $pelanggaran->kel_pelanggaran;
        $this->kec_pelanggaran = $pelanggaran->kec_pelanggaran;
        $this->koordinat_pelanggaran = $pelanggaran->koordinat_pelanggaran;
        $this->gmaps_pelanggaran = $pelanggaran->gmaps_pelanggaran;
        $this->bentuk_laporan = $pelanggaran->bentuk_laporan;
        $this->nama_pelapor = $pelanggaran->nama_pelapor;
        $this->isi_laporan = $pelanggaran->isi_laporan;
        $this->jenis_indikasi_pelanggaran = $pelanggaran->jenis_indikasi_pelanggaran;
        $this->status = $pelanggaran->status;

        $this->existing_foto_pengawasan = json_decode($pelanggaran->foto_pengawasan, true) ?? [];
    }

    #[Layout('layouts.app-pelanggaran')]
    public function render()
    {
        return view('livewire.admin.pelanggaran.pelanggaran-edit');
    }

    public function update()
    {
        $this->validate();

        $pelanggaran = Pelanggaran::findOrFail($this->pelanggaranId);

        $foto_pengawasan_path = $this->existing_foto_pengawasan;

        if ($this->new_foto_pengawasan) {
            foreach ($this->new_foto_pengawasan as $foto) {
                $foto_pengawasan_filename = $this->no_pelanggaran . '_' . Str::random(5) . '.' . $foto->getClientOriginalExtension();
                $foto_pengawasan_path[] = $foto->storeAs('pelanggaran/foto_pengawasan', $foto_pengawasan_filename, 'public');
            }
        }

        $pelanggaran->update([
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
            'status' => $this->status,
        ]);

        session()->flash('success', 'Data berhasil diperbarui');

        return redirect()->route('pelanggaran.index');
    }

    public function removeExistingImage($index)
    {
        if (isset($this->existing_foto_pengawasan[$index])) {
            $path = $this->existing_foto_pengawasan[$index];
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            unset($this->existing_foto_pengawasan[$index]);
            $this->existing_foto_pengawasan = array_values($this->existing_foto_pengawasan);
            
            // Auto update field in database when removing existing image
            Pelanggaran::where('id', $this->pelanggaranId)->update([
                'foto_pengawasan' => json_encode($this->existing_foto_pengawasan)
            ]);
        }
    }

    public function removeNewImage($index)
    {
        unset($this->new_foto_pengawasan[$index]);
        $this->new_foto_pengawasan = array_values($this->new_foto_pengawasan);
    }
}
