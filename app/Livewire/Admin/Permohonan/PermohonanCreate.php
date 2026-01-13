<?php

namespace App\Livewire\Admin\Permohonan;

use App\Models\Disposisi;
use App\Models\Itr;
use App\Models\Kkprb;
use App\Models\Kkprnb;
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
use PhpOffice\PhpWord\TemplateProcessor;

#[Title('Tambah Permohonan')]
class PermohonanCreate extends Component
{
    use WithFileUploads;

    public $layanans, $registrasis, $users, $kode_layanan;
    public $tahapans = [];

    #[Validate('required')]
    public $registrasi_id, $layanan_id, $nama, $nik, $no_hp, $email, $alamat_pemohon, $alamat_tanah, $kel_tanah, $kec_tanah, $fungsi_bangunan, $luas_tanah, $tahapan_id, $penerima_id;
    public $npwp, $keterangan, $status, $pemberi_id, $catatan, $status_modal, $kbli, $judul_kbli;

    #[Validate('nullable|mimes:pdf|max:10240')]
    public $berkas_ktp, $berkas_nib, $berkas_penguasaan, $berkas_permohonan, $berkas_kuasa;

    // PTP
    public $tgl_ptp, $tgl_terima_ptp, $tgl_validasi, $no_ptp, $rdtr_rtrw, $tgl_pnbp;
    public $kode_registrasi, $tgl_registrasi;

    #[Validate('nullable|mimes:pdf|max:10240')]
    public $berkas_ptp, $tanggapan_1a, $tanggapan_1b, $tanggapan_2, $ceklis, $surat_pengantar_kelengkapan, $akta_pendirian, $gambar_teknis, $sket_lokasi;

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
        $serviceModel = null;

        if ($layanan->kode == 'SKRK') {
            $path_akta_pendirian = $this->uploadFile($this->akta_pendirian, 'skrk/'.$permohonan->registrasi->kode.'/akta_pendirian');
            $path_sket_lokasi = $this->uploadFile($this->sket_lokasi, 'skrk/'.$permohonan->registrasi->kode.'/sket_lokasi');
            $serviceModel = Skrk::create([
                'permohonan_id' => $permohonan->id,
                'layanan_id' => $this->layanan_id,
                'akta_pendirian' => $path_akta_pendirian,
                'sket_lokasi' => $path_sket_lokasi,
            ]);
        } elseif ($layanan->kode == 'ITR') {
            $serviceModel = Itr::create([
                'permohonan_id' => $permohonan->id,
                'layanan_id' => $this->layanan_id,
            ]);
        } elseif ($layanan->kode == 'KKPRNB') {
            $path_berkas_ptp = $this->uploadFile($this->berkas_ptp, 'kkprnb/'.$permohonan->registrasi->kode.'/berkas_ptp');
            $path_ceklis = $this->uploadFile($this->ceklis, 'kkprnb/'.$permohonan->registrasi->kode.'/ceklis');
            $path_tanggapan_1a = $this->uploadFile($this->tanggapan_1a, 'kkprnb/'.$permohonan->registrasi->kode.'/tanggapan_1a');
            $path_tanggapan_1b = $this->uploadFile($this->tanggapan_1b, 'kkprnb/'.$permohonan->registrasi->kode.'/tanggapan_1b');
            $path_tanggapan_2 = $this->uploadFile($this->tanggapan_2, 'kkprnb/'.$permohonan->registrasi->kode.'/tanggapan_2');
            $path_surat_pengantar_kelengkapan = $this->uploadFile($this->surat_pengantar_kelengkapan, 'kkprnb/'.$permohonan->registrasi->kode.'/surat_pengantar_kelengkapan');
            $path_akta_pendirian = $this->uploadFile($this->akta_pendirian, 'kkprnb/'.$permohonan->registrasi->kode.'/akta_pendirian');
            $path_gambar_teknis = $this->uploadFile($this->gambar_teknis, 'kkprnb/'.$permohonan->registrasi->kode.'/gambar_teknis');
            $serviceModel = Kkprnb::create([
                'permohonan_id' => $permohonan->id,
                'layanan_id' => $this->layanan_id,
                'tgl_validasi' => $this->tgl_validasi,
                'tgl_terima_ptp' => $this->tgl_terima_ptp,
                'tgl_ptp' => $this->tgl_ptp,
                'no_ptp' => $this->no_ptp,
                'berkas_ptp' => $path_berkas_ptp,
                'ceklis' => $path_ceklis,
                'tanggapan_1a' => $path_tanggapan_1a,
                'tanggapan_1b' => $path_tanggapan_1b,
                'tanggapan_2' => $path_tanggapan_2,
                'surat_pengantar_kelengkapan' => $path_surat_pengantar_kelengkapan,
                'akta_pendirian' => $path_akta_pendirian,
                'gambar_teknis' => $path_gambar_teknis,
                'rdtr_rtrw' => $this->rdtr_rtrw,
            ]);
        } elseif($layanan->kode == 'KKPRB') {
            $path_berkas_ptp = $this->uploadFile($this->berkas_ptp, 'kkprb/'.$permohonan->registrasi->kode.'/berkas_ptp');
            $serviceModel = Kkprb::create([
                'tgl_validasi' => $this->tgl_validasi,
                'permohonan_id' => $permohonan->id,
                'layanan_id' => $this->layanan_id,
                'tgl_pnbp' => $this->tgl_pnbp,
                'tgl_ptp' => $this->tgl_ptp,
                'no_ptp' => $this->no_ptp,
                'berkas_ptp' => $path_berkas_ptp,
            ]);            
        }

        if ($serviceModel) {
            $serviceModel->disposisis()->create([
                'permohonan_id' => $permohonan->id,
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

            $filename = $registrasi->kode .'_'.$registrasi->nama. '.' . $file->getClientOriginalExtension();

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

    public function updatedRegistrasiId($value)
    {                
        if ($value != "") {
            $registrasi = Registrasi::find($value);
            $this->layanan_id = $registrasi->layanan_id;
            $this->nama = $registrasi->nama;
            $this->nik = $registrasi->nik;
            $this->no_hp = $registrasi->no_hp;
            $this->email = $registrasi->email;
            $this->alamat_tanah = $registrasi->alamat_tanah;
            $this->kel_tanah = $registrasi->kel_tanah;
            $this->kec_tanah = $registrasi->kec_tanah;
            $this->fungsi_bangunan = $registrasi->fungsi_bangunan;
            $this->kode_registrasi = $registrasi->kode;
            $this->tgl_registrasi = $registrasi->tanggal;
            $this->tahapans = Tahapan::where('layanan_id', $this->layanan_id)->where('urutan', 1)->get();

            $layanans = Layanan::find($this->layanan_id);
            $this->kode_layanan = $layanans->kode;            
        }
        else
        {
            $this->layanan_id = "";
            $this->nama = "";
            $this->nik = "";
            $this->no_hp = "";
            $this->email = "";
            $this->alamat_tanah = "";
            $this->kel_tanah = "";
            $this->kec_tanah = "";
            $this->fungsi_bangunan = "";
            $this->tahapans = [];
        }
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

        // Sanitize filename by removing special characters
        $baseName = str_replace('.docx', '', basename($templatePath));
        $sanitizedName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $data['nama_pemohon']);
        $fileName = $baseName . '_' . $sanitizedName . '.docx';
        $tempPath = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $fileName);

        $templateProcessor->saveAs($tempPath);

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }
}
