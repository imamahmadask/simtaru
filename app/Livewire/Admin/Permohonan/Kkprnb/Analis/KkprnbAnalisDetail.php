<?php

namespace App\Livewire\Admin\Permohonan\Kkprnb\Analis;

use App\Models\Kkprnb;
use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use App\Models\Tahapan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use PhpOffice\PhpWord\TemplateProcessor;

class KkprnbAnalisDetail extends Component
{
    public $kkprnb;

    public function render()
    {
        return view('livewire.admin.permohonan.kkprnb.analis.kkprnb-analis-detail');
    }

    public function mount($kkprnb_id)
    {
        $this->kkprnb = Kkprnb::find($kkprnb_id);
    }

    public function download3b()
    {
        $permohonan = $this->kkprnb->permohonan;        

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'jenis_kegiatan' => $permohonan->registrasi->fungsi_bangunan,
            'alamat_tanah' => $permohonan->registrasi->alamat_tanah,
            'kel_tanah' => $permohonan->registrasi->kel_tanah,
            'kec_tanah' => $permohonan->registrasi->kec_tanah         
        ];

        return $this->generateDocument('3B_BA_RAPAT_FPR_NON_BERUSAHA.docx', $data);
    }
    
    public function download3c()
    {
        $permohonan = $this->kkprnb->permohonan;        

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,                
        ];

        return $this->generateDocument('3C_NOTULENSI_RAPAT_FPR_NON_BERUSAHA.docx', $data);
    }
    
    public function download3d()
    {
        $permohonan = $this->kkprnb->permohonan;        

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'tgl_registrasi' => date('d F Y', strtotime($permohonan->registrasi->tanggal)),
            'tgl_validasi' => date('d F Y', strtotime($this->kkprnb->tgl_validasi)),
            'tgl_survey' => date('d F Y', strtotime($this->kkprnb->tgl_survey)),
            'tgl_ptp' => date('d F Y', strtotime($this->kkprnb->tgl_ptp)),
            'tgl_terima_ptp' => date('d F Y', strtotime($this->kkprnb->tgl_terima_ptp)),
            'no_ptp' => $this->kkprnb->no_ptp,
            'alamat_pemohon' => $permohonan->alamat_pemohon,
            'no_hp' => $permohonan->registrasi->no_hp,
            'email' => $permohonan->registrasi->email,
            'alamat_tanah' => $permohonan->registrasi->alamat_tanah,
            'kel_tanah' => $permohonan->registrasi->kel_tanah,
            'kec_tanah' => $permohonan->registrasi->kec_tanah,
            'jenis_kegiatan' => $permohonan->registrasi->fungsi_bangunan,
            'luas_permohonan' => $permohonan->luas_tanah,
            'penguasaan_tanah' => $this->kkprnb->penguasaan_tanah,
            'ada_bangunan' => $this->kkprnb->ada_bangunan,
            'jml_bangunan' => $this->kkprnb->jml_bangunan,
            'jml_lantai' => $this->kkprnb->jml_lantai,
            'luas_lantai' => $this->kkprnb->luas_lantai,
            'kedalaman_min' => $this->kkprnb->kedalaman_min,
            'kedalaman_max' => $this->kkprnb->kedalaman_max
        ];

        return $this->generateDocument('3D_KAJIAN_KKPR_NON_BERUSAHA.docx', $data);
    }
    
    public function download4()
    {
        $permohonan = $this->kkprnb->permohonan;        

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,     
            'jenis_kegiatan' => $permohonan->registrasi->fungsi_bangunan,
            'tgl_registrasi' => $permohonan->registrasi->tanggal,
            'no_registrasi' => $permohonan->kode,
            'tgl_validasi' => $this->kkprnb->tgl_validasi,   
            'tgl_survey' => $this->kkprnb->tgl_survey,   
            'tgl_ptp' => $this->kkprnb->tgl_ptp,   
            'tgl_terima_ptp' => $this->kkprnb->tgl_terima_ptp,   
            'no_ptp' => $this->kkprnb->no_ptp,   
            'alamat_pemohon' => $permohonan->alamat_pemohon,   
            'no_hp' => $permohonan->registrasi->no_hp,   
            'email' => $permohonan->registrasi->email,   
            'alamat_tanah' => $permohonan->registrasi->alamat_tanah,   
            'kel_tanah' => $permohonan->registrasi->kel_tanah,   
            'kec_tanah' => $permohonan->registrasi->kec_tanah,   
            'jenis_kegiatan' => $permohonan->registrasi->fungsi_bangunan,   
            'luas_permohonan' => $permohonan->luas_tanah,   
            'penguasaan_tanah' => $this->kkprnb->penguasaan_tanah,   
            'ada_bangunan' => $this->kkprnb->ada_bangunan,   
            'jml_bangunan' => $this->kkprnb->jml_bangunan,   
            'jml_lantai' => $this->kkprnb->jml_lantai,   
            'luas_lantai' => $this->kkprnb->luas_lantai,   
            'kedalaman_min' => $this->kkprnb->kedalaman_min,   
            'kedalaman_max' => $this->kkprnb->kedalaman_max   

        ];

        return $this->generateDocument('4_NOTA_DINAS_KKPR_NON_BERUSAHA.docx', $data);
    }
    
    public function download5()
    {
        $permohonan = $this->kkprnb->permohonan;        

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'no_ptp' => $this->kkprnb->no_ptp,   
            'tgl_ptp' => $this->kkprnb->tgl_ptp,
        ];

        return $this->generateDocument('5_REKOMENDASI_KKPR_NON_BERUSAHA.docx', $data);
    }

    public function download6()
    {
        $permohonan = $this->kkprnb->permohonan;        

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'alamat_pemohon' => $permohonan->alamat_pemohon,
            'no_hp' => $permohonan->registrasi->no_hp,
            'email' => $permohonan->registrasi->email,
            'alamat_tanah' => $permohonan->registrasi->alamat_tanah,
            'kel_tanah' => $permohonan->registrasi->kel_tanah,
            'kec_tanah' => $permohonan->registrasi->kec_tanah,
            'jenis_kegiatan' => $permohonan->registrasi->fungsi_bangunan,
            'luas_permohonan' => $permohonan->luas_tanah,
            'no_ptp' => $this->kkprnb->no_ptp,   
            'tgl_ptp' => $this->kkprnb->tgl_ptp,
            'kedalaman_min' => $this->kkprnb->kedalaman_min,
            'kedalaman_max' => $this->kkprnb->kedalaman_max,
            'kdb' => $this->kkprnb->kdb,
            'klb' => $this->kkprnb->klb,
            'indikasi_program' => $this->kkprnb->indikasi_program,
            'persyaratan_pelaksanaan' => $this->kkprnb->persyaratan_pelaksanaan,
            'gsb' => $this->kkprnb->gsb,
            'jbb' => $this->kkprnb->jbb,
            'kdh' => $this->kkprnb->kdh,
            'ktb' => $this->kkprnb->ktb,
            'jaringan_utilitas' => $this->kkprnb->jaringan_utilitas,
        ];

        return $this->generateDocument('6_FORMAT_PERSETUJUAN_KKPR_NON_BERUSAHA.docx', $data);
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

    public function selesaiAnalisa()
    {
        if(Auth::user()->role == 'analis' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'supervisor') {
            $this->itr->update([
                'is_analis' => true
            ]);

            $this->itr->permohonan->update([
                'status' => 'Proses Verifikasi'
            ]);

            // Find and update the disposisi for the 'Analisis' stage
            $tahapanAnalisId = $this->itr->permohonan->layanan->tahapan->where('nama', 'Analisis')->value('id');
            if ($tahapanAnalisId) {
                $this->itr->permohonan->disposisi()->where('tahapan_id', $tahapanAnalisId)
                ->where('is_done', false)
                ->update([
                    'is_done' => true,
                    'tgl_selesai' => now()
                ]);
                $this->createRiwayat($this->itr->permohonan, 'Selesai Analisa Data ITR');
            }

            // Create disposisi to supervisor for 'Verifikasi' tahapan
            $tahapanVerifikasi = Tahapan::where('layanan_id', $this->itr->permohonan->layanan_id)
                                        ->where('nama', 'Verifikasi')
                                        ->first();
            $supervisor = User::where('role', 'supervisor')->first();
            $pemberi_id = $this->itr->permohonan->disposisi()->where('tahapan_id', $tahapanAnalisId)->value('penerima_id') ?? Auth::user()->id;
            if ($tahapanVerifikasi && $supervisor) {
                $this->itr->disposisis()->create([
                    'permohonan_id' => $this->itr->permohonan->id,
                    'tahapan_id' => $tahapanVerifikasi->id,
                    'pemberi_id' => $pemberi_id,
                    'penerima_id' => $supervisor->id,
                    'tanggal_disposisi' => now(),
                    'catatan' => 'Mohon untuk melakukan verifikasi data hasil analisa.',
                ]);
            }

            $this->createRiwayat($this->itr->permohonan, 'Proses Verifikasi Data ITR');
        }

        session()->flash('success', 'Data Analis selesai!');

        return redirect()->route('itr.detail', ['id' => $this->itr->id]);
    }

    private function createRiwayat(Permohonan $permohonan, string $keterangan)
    {
        RiwayatPermohonan::create([
            'registrasi_id' => $permohonan->registrasi_id,
            'user_id' => Auth::user()->id,
            'keterangan' => $keterangan
        ]);
    }
}
