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

    #[Validate('nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240')]
    public $dokumen_penilaian_kkpr;    
    public $jenis_pemanfaatan_ruang;
    public $pemanfaatan_ruang;

    #[Validate('required')]
    public $nama_pelanggar;
    public $nama_pemilik_perusahaan;
    public $alamat_pelanggaran;
    public $kel_pelanggaran;
    public $kec_pelanggaran;
    public $koordinat_pelanggaran;
    public $gmaps_pelanggaran;

    public $penjelasan_singkat;
    public $status;

    public $existing_foto_pengawasan = [];
    public $existing_foto_existing = [];
    public $existing_dokumen_penilaian_kkpr;
    
    #[Validate(['new_foto_pengawasan.*' => 'image|max:10240'])]
    public $new_foto_pengawasan = [];

    #[Validate(['new_foto_existing.*' => 'image|max:10240'])]
    public $new_foto_existing = [];

    public function mount($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        $this->pelanggaranId = $pelanggaran->id;
        $this->no_pelanggaran = $pelanggaran->no_pelanggaran;
        $this->tgl_laporan = $pelanggaran->tgl_laporan;
        $this->sumber_informasi_pelanggaran = $pelanggaran->sumber_informasi_pelanggaran;
        $this->tanggal_pengawasan = $pelanggaran->tanggal_pengawasan;
        $this->bentuk_laporan = $pelanggaran->bentuk_laporan;
        $this->nama_pelapor = $pelanggaran->nama_pelapor;
        $this->telp_pelapor = $pelanggaran->telp_pelapor;
        $this->isi_laporan = $pelanggaran->isi_laporan;
        $this->no_kkpr_skrk = $pelanggaran->no_kkpr_skrk;
        $this->no_ba_sk_penilaian_kkpr = $pelanggaran->no_ba_sk_penilaian_kkpr;
        $this->existing_dokumen_penilaian_kkpr = $pelanggaran->dokumen_penilaian_kkpr;
        $this->jenis_pemanfaatan_ruang = $pelanggaran->jenis_pemanfaatan_ruang;
        $this->pemanfaatan_ruang = $pelanggaran->pemanfaatan_ruang;
        $this->nama_pelanggar = $pelanggaran->nama_pelanggar;
        $this->nama_pemilik_perusahaan = $pelanggaran->nama_pemilik_perusahaan;
        $this->alamat_pelanggaran = $pelanggaran->alamat_pelanggaran;
        $this->kel_pelanggaran = $pelanggaran->kel_pelanggaran;
        $this->kec_pelanggaran = $pelanggaran->kec_pelanggaran;
        $this->koordinat_pelanggaran = $pelanggaran->koordinat_pelanggaran;
        $this->gmaps_pelanggaran = $pelanggaran->gmaps_pelanggaran;
        $this->penjelasan_singkat = $pelanggaran->penjelasan_singkat;
        $this->status = $pelanggaran->status;

        $this->existing_foto_pengawasan = $pelanggaran->foto_pengawasan ?? [];
        $this->existing_foto_existing = $pelanggaran->foto_existing ?? [];
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
            $new_paths = $this->uploadMultipleFiles($this->new_foto_pengawasan, 'foto_pengawasan');
            $foto_pengawasan_path = array_merge($foto_pengawasan_path, $new_paths);
        }

        $foto_existing_path = $this->existing_foto_existing;
        if ($this->new_foto_existing) {
            $new_paths = $this->uploadMultipleFiles($this->new_foto_existing, 'foto_existing');
            $foto_existing_path = array_merge($foto_existing_path, $new_paths);
        }

        $safeFolder = str_replace('/', '-', $this->no_pelanggaran);
        $dokumen_penilaian_kkpr_path = $this->existing_dokumen_penilaian_kkpr;
        if ($this->dokumen_penilaian_kkpr) {
            // Delete old file if exists
            if ($this->existing_dokumen_penilaian_kkpr && Storage::disk('public')->exists($this->existing_dokumen_penilaian_kkpr)) {
                Storage::disk('public')->delete($this->existing_dokumen_penilaian_kkpr);
            }
            $dokumen_penilaian_kkpr_path = $this->dokumen_penilaian_kkpr->storeAs(
                "pelanggaran/{$safeFolder}/dokumen_penilaian_kkpr", 
                "{$safeFolder}_" . Str::random(5) . '.' . $this->dokumen_penilaian_kkpr->getClientOriginalExtension(), 
                'public'
            );
        }

        $pelanggaran->update([
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
            'nama_pemilik_perusahaan' => $this->nama_pemilik_perusahaan,
            'alamat_pelanggaran' => $this->alamat_pelanggaran,
            'kel_pelanggaran' => $this->kel_pelanggaran,
            'kec_pelanggaran' => $this->kec_pelanggaran,
            'koordinat_pelanggaran' => $this->koordinat_pelanggaran,
            'gmaps_pelanggaran' => $this->gmaps_pelanggaran,
            'pemanfaatan_ruang' => $this->pemanfaatan_ruang,
            'jenis_pemanfaatan_ruang' => $this->jenis_pemanfaatan_ruang,
            'foto_existing' => $foto_existing_path,
            'penjelasan_singkat' => $this->penjelasan_singkat,
            'status' => $this->status,
        ]);

        return redirect()->route('pelanggaran.detail', $this->pelanggaranId)->with('success', 'Data Pelanggaran berhasil diupdate!');
    }

    private function uploadMultipleFiles($files, $folder)
    {
        if (empty($files)) {
            return [];
        }

        $safeFolder = str_replace('/', '-', $this->no_pelanggaran);
        $paths = [];
        foreach ($files as $file) {
            $filename = "{$safeFolder}_" . Str::random(5) . '.' . $file->getClientOriginalExtension();
            $paths[] = $file->storeAs("pelanggaran/{$safeFolder}/{$folder}", $filename, 'public');
        }

        return $paths;
    }

    public function removeExistingImage($index, $type = 'foto_pengawasan')
    {
        $property = "existing_{$type}";
        if (isset($this->$property[$index])) {
            $path = $this->$property[$index];
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $currentImages = $this->$property;
            unset($currentImages[$index]);
            $this->$property = array_values($currentImages);
            
            // Auto update field in database when removing existing image
            Pelanggaran::where('id', $this->pelanggaranId)->update([
                $type => $this->$property
            ]);
        }
    }

    public function removeNewImage($index, $type = 'foto_pengawasan')
    {
        $property = "new_{$type}";
        $currentImages = $this->$property;
        unset($currentImages[$index]);
        $this->$property = array_values($currentImages);
    }
}
