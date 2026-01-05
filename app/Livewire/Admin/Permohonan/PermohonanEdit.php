<?php

namespace App\Livewire\Admin\Permohonan;

use App\Models\Disposisi;
use App\Models\Kkprb;
use App\Models\Kkprnb;
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
use PhpOffice\PhpWord\TemplateProcessor;

#[Title('Edit Permohonan')]
class PermohonanEdit extends Component
{
    use WithFileUploads;

    public $layanans, $registrasis, $tahapans, $users, $kode_layanan;
    public $permohonan_id, $disposisi;

    #[Validate('required')]
    public $registrasi_id, $layanan_id, $nama, $nik, $no_hp, $email, $alamat_pemohon, $alamat_tanah, $kel_tanah, $kec_tanah, $fungsi_bangunan, $luas_tanah, $tahapan_id, $penerima_id;
    public $npwp, $keterangan, $status, $pemberi_id, $catatan, $status_modal, $kbli, $judul_kbli;
    public $berkas_ktp, $berkas_nib, $berkas_penguasaan, $berkas_permohonan, $berkas_kuasa;
    public $berkas_ktp_lama, $berkas_nib_lama, $berkas_penguasaan_lama, $berkas_permohonan_lama, $berkas_kuasa_lama;

    public $is_prioritas;

    // PTP
    public $tgl_ptp, $tgl_terima_ptp, $tgl_validasi, $no_ptp, $berkas_ptp_lama, $rdtr_rtrw, $tgl_pnbp;
    public $tanggapan_1a_lama, $tanggapan_1b_lama, $tanggapan_2_lama, $ceklis_lama, $surat_pengantar_kelengkapan_lama;
    public $kode_registrasi, $tgl_registrasi;

    #[Validate('nullable|mimes:pdf|max:10240')]
    public $berkas_ptp, $tanggapan_1a, $tanggapan_1b, $tanggapan_2, $ceklis, $surat_pengantar_kelengkapan;

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
        $this->alamat_tanah = $permohonan->registrasi->alamat_tanah;
        $this->kel_tanah = $permohonan->registrasi->kel_tanah;
        $this->kec_tanah = $permohonan->registrasi->kec_tanah;
        $this->fungsi_bangunan = $permohonan->registrasi->fungsi_bangunan;
        $this->keterangan = $permohonan->keterangan;
        $this->status = $permohonan->status;
        $this->berkas_ktp_lama = $permohonan->berkas_ktp;
        $this->berkas_nib_lama = $permohonan->berkas_nib;
        $this->berkas_penguasaan_lama = $permohonan->berkas_penguasaan;
        $this->berkas_permohonan_lama = $permohonan->berkas_permohonan;
        $this->berkas_kuasa_lama = $permohonan->berkas_kuasa;
        $this->is_prioritas = $permohonan->is_prioritas;
        $this->status_modal = $permohonan->status_modal;
        $this->kbli = $permohonan->kbli;
        $this->judul_kbli = $permohonan->judul_kbli;    
        $this->kode_registrasi = $permohonan->registrasi->kode;
        $this->tgl_registrasi = $permohonan->registrasi->tanggal;    

        $this->disposisi = Disposisi::where('permohonan_id', $permohonan->id)->first();
        $this->pemberi_id = $this->disposisi->pemberi_id;
        $this->penerima_id = $this->disposisi->penerima_id;
        $this->catatan = $this->disposisi->catatan;
        $this->tahapan_id = $this->disposisi->tahapan_id;
        $layanans = Layanan::find($this->layanan_id);
        $this->kode_layanan = $layanans->kode;  

        if($this->kode_layanan == 'KKPRNB')
        {
            $kkprnb = Kkprnb::where('permohonan_id', $permohonan->id)->first();
            $this->rdtr_rtrw = $kkprnb->rdtr_rtrw;
            $this->tgl_validasi = $kkprnb->tgl_validasi;
            $this->tgl_terima_ptp = $kkprnb->tgl_terima_ptp;
            $this->tgl_ptp = $kkprnb->tgl_ptp;
            $this->no_ptp = $kkprnb->no_ptp;
            $this->berkas_ptp_lama = $kkprnb->berkas_ptp;
            $this->tanggapan_1a_lama = $kkprnb->tanggapan_1a;
            $this->tanggapan_1b_lama = $kkprnb->tanggapan_1b;
            $this->tanggapan_2_lama = $kkprnb->tanggapan_2;
            $this->ceklis_lama = $kkprnb->ceklis;
            $this->surat_pengantar_kelengkapan_lama = $kkprnb->surat_pengantar_kelengkapan;
        }

        if($this->kode_layanan == 'KKPRB')
        {
            $kkprb = Kkprb::where('permohonan_id', $permohonan->id)->first();
            $this->tgl_validasi = $kkprb->tgl_validasi;
            $this->tgl_pnbp = $kkprb->tgl_pnbp;
            $this->tgl_ptp = $kkprb->tgl_ptp;
            $this->no_ptp = $kkprb->no_ptp;
            $this->berkas_ptp_lama = $kkprb->berkas_ptp;
        }

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
        $path_berkas_kuasa = $this->uploadFile($this->berkas_kuasa, 'berkas_kuasa', $this->berkas_kuasa_lama);

        $permohonan->update([
            'registrasi_id' => $this->registrasi_id,
            'layanan_id' => $this->layanan_id,
            'alamat_pemohon' => $this->alamat_pemohon,
            'npwp' => $this->npwp,
            'alamat_tanah' => $this->alamat_tanah,
            'kel_tanah' => $this->kel_tanah,
            'kec_tanah' => $this->kec_tanah,
            'fungsi_bangunan' => $this->fungsi_bangunan,
            'luas_tanah' => $this->luas_tanah,
            'status_modal' => $this->status_modal,
            'kbli' => $this->kbli,
            'judul_kbli' => $this->judul_kbli,
            'keterangan' => $this->keterangan,
            'berkas_ktp' => $path_berkas_ktp,
            'berkas_nib' => $path_berkas_nib,
            'berkas_penguasaan' => $path_berkas_penguasaan,
            'berkas_permohonan' => $path_berkas_permohonan,
            'berkas_kuasa' => $path_berkas_kuasa,
            'is_prioritas' => $this->is_prioritas,
            'updated_by' => Auth::user()->id
        ]);

        if($this->kode_layanan == 'KKPRNB') {
            $path_berkas_ptp = $this->uploadFile($this->berkas_ptp, 'kkprnb/'.$permohonan->registrasi->kode.'/berkas_ptp', $this->berkas_ptp_lama);
            $path_tanggapan_1a = $this->uploadFile($this->tanggapan_1a, 'kkprnb/'.$permohonan->registrasi->kode.'/tanggapan_1a', $this->tanggapan_1a_lama);
            $path_tanggapan_1b = $this->uploadFile($this->tanggapan_1b, 'kkprnb/'.$permohonan->registrasi->kode.'/tanggapan_1b', $this->tanggapan_1b_lama);
            $path_tanggapan_2 = $this->uploadFile($this->tanggapan_2, 'kkprnb/'.$permohonan->registrasi->kode.'/tanggapan_2', $this->tanggapan_2_lama);
            $path_ceklis = $this->uploadFile($this->ceklis, 'kkprnb/'.$permohonan->registrasi->kode.'/ceklis', $this->ceklis_lama);
            $path_surat_pengantar_kelengkapan = $this->uploadFile($this->surat_pengantar_kelengkapan, 'kkprnb/'.$permohonan->registrasi->kode.'/surat_pengantar_kelengkapan', $this->surat_pengantar_kelengkapan_lama);
            $kkprnb = Kkprnb::where('permohonan_id', $permohonan->id)->first();
            $kkprnb->update([
                'tgl_validasi' => $this->tgl_validasi,
                'tgl_terima_ptp' => $this->tgl_terima_ptp,
                'tgl_ptp' => $this->tgl_ptp,
                'no_ptp' => $this->no_ptp,
                'berkas_ptp' => $path_berkas_ptp,
                'rdtr_rtrw' => $this->rdtr_rtrw,
                'tanggapan_1a' => $path_tanggapan_1a,
                'tanggapan_1b' => $path_tanggapan_1b,
                'tanggapan_2' => $path_tanggapan_2,
                'ceklis' => $path_ceklis,
                'surat_pengantar_kelengkapan' => $path_surat_pengantar_kelengkapan,
            ]);
        }

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

        $this->redirectRoute('permohonan.edit', $permohonan->id);
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

            $filename = $registrasi->kode .'_'.$registrasi->nama. '.' . $file->getClientOriginalExtension();

            return $file->storeAs($folder, $filename, 'public');
        }
        else
        {
            return $old_file;
        }


        return null;
    }

    public function download1a()
    {        
        $data = [
            'nama_pemohon' => $this->nama,            
            'fungsi_bangunan' => $this->fungsi_bangunan,
            'kode_registrasi' => $this->kode_registrasi,
            'tgl_registrasi' => $this->tgl_registrasi,
        ];

        return $this->generateDocument('1A_TANGGAPAN_1A.docx', $data);
    }

    public function download1b()
    {        
        $data = [
            'nama_pemohon' => $this->nama,            
            'fungsi_bangunan' => $this->fungsi_bangunan,
            'kode_registrasi' => $this->kode_registrasi,
            'tgl_registrasi' => $this->tgl_registrasi,
        ];

        return $this->generateDocument('1B_TANGGAPAN_1B.docx', $data);
    }

    public function download2()
    {        
        $data = [
            'nama_pemohon' => $this->nama,            
            'fungsi_bangunan' => $this->fungsi_bangunan,
            'kode_registrasi' => $this->kode_registrasi,
            'tgl_registrasi' => $this->tgl_registrasi,
        ];

        return $this->generateDocument('2_TANGGAPAN_2.docx', $data);
    }

    public function downloadSuratPengantarKelengkapan()
    {        
        $data = [
            'nama_pemohon' => $this->nama,            
        ];

        if($this->rdtr_rtrw == 'RTRW')
        {
            return $this->generateDocument('SURAT_PENGANTAR_TANGGAPAN_KELENGKAPAN_BERKAS_DENGAN_PERTEK.docx', $data);
        }
        elseif($this->rdtr_rtrw == 'RDTR')
        {
            return $this->generateDocument('SURAT_PENGANTAR_TANGGAPAN_KELENGKAPAN_BERKAS_NON_PERTEK.docx', $data);
        }
        else
        {
            session()->flash('error', 'Silakan pilih RDTR/RTRW terlebih dahulu.');
            return redirect()->back();
        }
    }

    public function downloadCeklis()
    {
        
        $data = [
            'nama_pemohon' => $this->nama,            
        ];

        return $this->generateDocument('Ceklist.docx', $data);
    }   

    private function generateDocument($templatePath, $data)
    {
        $templateProcessor = new TemplateProcessor(public_path('templates/kkprnb/'.$templatePath));

        foreach ($data as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }

        $fileName = str_replace('.docx', '', basename($templatePath)).'_'.$data['nama_pemohon'].'.docx';
        $tempPath = storage_path("app/public/{$fileName}");

        $templateProcessor->saveAs($tempPath);

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }
}
