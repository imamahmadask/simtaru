<?php

namespace App\Livewire\Admin\Permohonan;

use App\Models\Disposisi;
use App\Models\Layanan;
use App\Models\Permohonan;
use App\Models\Registrasi;
use App\Models\RiwayatPermohonan;
use App\Models\Skrk;
use App\Models\Tahapan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Tambah Permohonan')]
class PermohonanCreate extends Component
{
    use WithFileUploads;

    public $layanans, $registrasis, $users;
    public $tahapans = [];

    #[Validate('required')]
    public $registrasi_id, $layanan_id, $nama, $nik, $no_hp, $email, $alamat_pemohon, $alamat_tanah, $kel_tanah, $kec_tanah, $jenis_bangunan, $luas_tanah, $tahapan_id, $penerima_id;
    public $npwp, $keterangan, $status, $pemberi_id, $catatan, $status_modal, $kbli, $judul_kbli;
    public $berkas_ktp, $berkas_nib, $berkas_penguasaan, $berkas_permohonan, $berkas_kuasa;
    public function render()
    {
        return view('livewire.admin.permohonan.permohonan-create');
    }

    public function addPermohonan()
    {
        $this->validate();

        $path_berkas_ktp = $this->uploadFile($this->berkas_ktp, 'berkas_ktp');
        $path_berkas_nib = $this->uploadFile($this->berkas_nib, 'berkas_nib');
        $path_berkas_penguasaan = $this->uploadFile($this->berkas_penguasaan, 'berkas_penguasaan');
        $path_berkas_permohonan = $this->uploadFile($this->berkas_permohonan, 'berkas_permohonan');
        $path_berkas_kuasa = $this->uploadFile($this->berkas_kuasa, 'berkas_kuasa');

        $permohonan = Permohonan::create([
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
            'status' => 'Proses Survey',
            'keterangan' => $this->keterangan,
            'berkas_ktp' => $path_berkas_ktp,
            'berkas_nib' => $path_berkas_nib,
            'berkas_penguasaan' => $path_berkas_penguasaan,
            'berkas_permohonan' => $path_berkas_permohonan,
            'berkas_kuasa' => $path_berkas_kuasa,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id
        ]);

        $this->createRiwayat($permohonan, 'Entry Permohonan');

        $layanan = Layanan::findOrFail($this->layanan_id);
        $skrk = '';
        if($layanan->kode == 'SKRK') {
            $skrk = Skrk::create([
                'permohonan_id' => $permohonan->id,
                'layanan_id' => $this->layanan_id,
            ]);
        }

        if($layanan->kode == 'SKRK'){
            $skrk->disposisis()->create([
                'permohonan_id' => $skrk->permohonan_id,
                'tahapan_id' => $this->tahapan_id,
                'pemberi_id' => Auth::user()->id,
                'penerima_id' => $this->penerima_id,
                'catatan' => $this->catatan,
            ]);
        }

        $this->createRiwayat($permohonan, "Disposisi kepada {$this->users->where('id', $this->penerima_id)->first()->name} pada tahapan Survey Berkas");

        session()->flash('success', 'Permohonan berhasil ditambahkan!');

        $this->redirectRoute('permohonan.index');
    }

    private function createRiwayat(Permohonan $permohonan, string $keterangan)
    {
        RiwayatPermohonan::create([
            'registrasi_id' => $permohonan->registrasi_id,
            'user_id' => Auth::user()->id,
            'keterangan' => $keterangan
        ]);
    }

    private function uploadFile($file, $folder)
    {
        if ($file) {
            $registrasi = Registrasi::find($this->registrasi_id);

            $filename = $registrasi->kode . '.' . $file->getClientOriginalExtension();

            return $file->storeAs($folder, $filename, 'public');
        }

        return null;
    }

    public function mount()
    {
        $this->layanans = Layanan::all();
        $this->registrasis = Registrasi::doesntHave('permohonan')->get();
        $this->users = User::where('role', 'surveyor')->get();
    }

    public function updated($registrasi_id)
    {
        if ($this->registrasi_id != "") {
            $registrasi = Registrasi::find($this->registrasi_id);
            $this->layanan_id = $registrasi->layanan_id;
            $this->nama = $registrasi->nama;
            $this->nik = $registrasi->nik;
            $this->no_hp = $registrasi->no_hp;
            $this->email = $registrasi->email;
            $this->tahapans = Tahapan::where('layanan_id', $this->layanan_id)->where('urutan', 1)->get();
        }
        else
        {
            $this->layanan_id = "";
            $this->nama = "";
            $this->nik = "";
            $this->no_hp = "";
            $this->email = "";
            $this->tahapans = [];
        }
    }
}
