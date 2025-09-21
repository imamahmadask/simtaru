<?php

namespace App\Livewire\Admin\Permohonan;

use App\Models\Disposisi;
use App\Models\Layanan;
use App\Models\Permohonan;
use App\Models\Registrasi;
use App\Models\RiwayatPermohonan;
use App\Models\Tahapan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Edit Permohonan')]
class PermohonanEdit extends Component
{
    use WithFileUploads;

    public $layanans, $registrasis, $tahapans, $users;
    public $permohonan_id, $disposisi;

    #[Validate('required')]
    public $registrasi_id, $layanan_id, $nama, $nik, $no_hp, $email, $alamat_pemohon, $alamat_tanah, $kel_tanah, $kec_tanah, $jenis_bangunan, $luas_tanah, $tahapan_id, $penerima_id;

    public $npwp, $keterangan, $status, $pemberi_id, $catatan, $berkas_ktp, $berkas_nib, $berkas_penguasaan, $berkas_permohonan, $status_modal, $kbli, $judul_kbli;

    public $berkas_ktp_lama, $berkas_nib_lama, $berkas_penguasaan_lama, $berkas_permohonan_lama;

   public $is_prioritas;

    public function mount($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        $this->permohonan_id = $permohonan->id;
        $this->registrasi_id = $permohonan->registrasi_id;
        $this->layanan_id = $permohonan->layanan_id;
        $this->nama = $permohonan->registrasi->nama;
        $this->nik = $permohonan->registrasi->nik;
        $this->no_hp = $permohonan->registrasi->no_hp;
        $this->email = $permohonan->registrasi->email;
        $this->alamat_pemohon = $permohonan->alamat_pemohon;
        $this->npwp = $permohonan->npwp;
        $this->luas_tanah = $permohonan->luas_tanah;
        $this->alamat_tanah = $permohonan->alamat_tanah;
        $this->kel_tanah = $permohonan->kel_tanah;
        $this->kec_tanah = $permohonan->kec_tanah;
        $this->jenis_bangunan = $permohonan->jenis_bangunan;
        $this->keterangan = $permohonan->keterangan;
        $this->status = $permohonan->status;
        $this->berkas_ktp_lama = $permohonan->berkas_ktp;
        $this->berkas_nib_lama = $permohonan->berkas_nib;
        $this->berkas_penguasaan_lama = $permohonan->berkas_penguasaan;
        $this->berkas_permohonan_lama = $permohonan->berkas_permohonan;
        $this->is_prioritas = $permohonan->is_prioritas;
        $this->status_modal = $permohonan->status_modal;
        $this->kbli = $permohonan->kbli;
        $this->judul_kbli = $permohonan->judul_kbli;

        $this->disposisi = Disposisi::where('permohonan_id', $permohonan->id)->first();
        $this->pemberi_id = $this->disposisi->pemberi_id;
        $this->penerima_id = $this->disposisi->penerima_id;
        $this->catatan = $this->disposisi->catatan;
        $this->tahapan_id = $this->disposisi->tahapan_id;

        // $this->berkas_pemohon_lama = $permohonan->berkas_pemohon;

        $this->layanans = Layanan::all();

        $this->registrasis = Registrasi::all();

        $this->tahapans = Tahapan::where('layanan_id', $this->layanan_id)->where('urutan', 1)->get();

        $this->users = User::where('role', 'surveyor')->get();
    }

    public function updatePermohonan()
    {
        $this->validate();

        $permohonan = Permohonan::findOrFail($this->permohonan_id);

        $path_berkas_ktp = $this->uploadFile($this->berkas_ktp, 'berkas_ktp', $this->berkas_ktp_lama);
        $path_berkas_nib = $this->uploadFile($this->berkas_nib, 'berkas_nib', $this->berkas_nib_lama);
        $path_berkas_penguasaan = $this->uploadFile($this->berkas_penguasaan, 'berkas_penguasaan', $this->berkas_penguasaan_lama);
        $path_berkas_permohonan = $this->uploadFile($this->berkas_permohonan, 'berkas_permohonan', $this->berkas_permohonan_lama);

        $permohonan->update([
            'registrasi_id' => $this->registrasi_id,
            'layanan_id' => $this->layanan_id,
            'alamat_pemohon' => $this->alamat_pemohon,
            'npwp' => $this->npwp,
            'alamat_tanah' => $this->alamat_tanah,
            'kel_tanah' => $this->kel_tanah,
            'kec_tanah' => $this->kec_tanah,
            'jenis_bangunan' => $this->jenis_bangunan,
            'luas_tanah' => $this->luas_tanah,
            'status_modal' => $this->status_modal,
            'kbli' => $this->kbli,
            'judul_kbli' => $this->judul_kbli,
            'status' => 'process',
            'keterangan' => $this->keterangan,
            'berkas_ktp' => $path_berkas_ktp,
            'berkas_nib' => $path_berkas_nib,
            'berkas_penguasaan' => $path_berkas_penguasaan,
            'berkas_permohonan' => $path_berkas_permohonan,
            'is_prioritas' => $this->is_prioritas,
            'updated_by' => Auth::user()->id
        ]);

        $this->disposisi->update([
            'pemberi_id' => $this->pemberi_id,
            'penerima_id' => $this->penerima_id,
            'tahapan_id' => $this->tahapan_id,
            'catatan' => $this->catatan,
            'updated_by' => Auth::user()->id
        ]);

        if($this->disposisi->penerima_id != $this->penerima_id || $this->disposisi->catatan != $this->catatan) {
            $this->editRiwayat($permohonan, "Update: Disposisi kepada {$this->users->where('id', $this->penerima_id)->first()->name} pada tahapan Survey Berkas");
        }

        session()->flash('message', 'Permohonan berhasil diperbarui.');

        $this->redirectRoute('permohonan.index');
    }

    public function render()
    {
        return view('livewire.admin.permohonan.permohonan-edit');
    }

    private function editRiwayat(Permohonan $permohonan, string $keterangan)
    {
        RiwayatPermohonan::create([
            'registrasi_id' => $permohonan->registrasi_id,
            'user_id' => Auth::user()->id,
            'keterangan' => $keterangan
        ]);
    }

    private function uploadFile($file, $folder, $old_file)
    {
        if ($file) {
            $registrasi = Registrasi::find($this->registrasi_id);

            $filename = $registrasi->kode . '.' . $file->getClientOriginalExtension();

            return $file->storeAs($folder, $filename, 'public');
        }
        else
        {
            return $old_file;
        }


        return null;
    }
}
