<?php

namespace App\Livewire\Admin\Permohonan\Kkprnb\Final;

use App\Models\Kkprnb;
use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use App\Models\Tahapan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use PhpOffice\PhpWord\TemplateProcessor;

class KkprnbFinalDetail extends Component
{
    public $kkprnb;
    public $berkas_final;
    public $count_final;

    public function render()
    {
        return view('livewire.admin.permohonan.kkprnb.final.kkprnb-final-detail');
    }

    public function mount($kkprnb_id)
    {
        $this->kkprnb = Kkprnb::find($kkprnb_id);
        $this->berkas_final = $this->kkprnb->permohonan->berkas->where('versi', 'final');                
    }

    #[On('refresh-kkprnb-final-list')]
    public function refresh()
    {
        $this->kkprnb->refresh();
        $this->berkas_final = $this->kkprnb->permohonan->berkas->where('versi', 'final');
    }

    public function downloadSuratPengantar()
    {        
        $data = [
            'nama_pemohon' => $this->kkprnb->permohonan->registrasi->nama,                        
        ];

        if($this->kkprnb->rdtr_rtrw == 'RTRW')
        {
            return $this->generateDocument('SURAT_PENGANTAR_PERSETUJUAN_KKPR_NB_DENGAN_PERTEK.docx', $data);
        }
        elseif($this->kkprnb->rdtr_rtrw == 'RDTR')
        {
            return $this->generateDocument('SURAT_PENGANTAR_PERSETUJUAN_KKPR_NB_NON_PERTEK.docx', $data);
        }        
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

    public function deleteBerkas($berkas_id)
    {
        $berkas = \App\Models\PermohonanBerkas::findOrFail($berkas_id);

        // Delete file from storage
        if ($berkas->file_path && Storage::disk('public')->exists($berkas->file_path)) {
            Storage::disk('public')->delete($berkas->file_path);
        }

        // Delete from database
        $berkas->delete();

        $this->refresh();

        $this->dispatch('toast', [
            'type'    => 'success',
            'message' => 'Berkas berhasil dihapus!'
        ]);
    }

    public function selesaiFinalisasi()
    {
        if(Auth::user()->role == 'supervisor' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'data-entry') {
            
            $persyaratan = $this->kkprnb->permohonan->persyaratanBerkas->where('wajib', true);
            $this->count_final = 0;
            foreach ($persyaratan as $syarat) {
                $berkas_uploaded = $this->berkas_final->where('persyaratan_berkas_id', $syarat->id)->first();
                if (!$berkas_uploaded) {
                    $this->count_final++;
                }
            }

            if($this->count_final == 0) {
                $this->kkprnb->permohonan->update([
                    'is_done' => true,
                    'status' => 'completed',
                ]);                 

                // Find and update the disposisi for the 'Cetak' stage
                $tahapanCetakId = $this->kkprnb->permohonan->layanan->tahapan->where('nama', 'Cetak')->value('id');
                if ($tahapanCetakId) {
                    $this->kkprnb->permohonan->disposisi()->where('tahapan_id', $tahapanCetakId)
                    ->where('is_done', false)
                    ->update([
                        'is_done' => true,
                        'tgl_selesai' => now()
                    ]);
                    $this->createRiwayat($this->kkprnb->permohonan, 'Permohonan KKPR Non Berusaha selesai!');
                }

                session()->flash('success', 'Permohonan KKPR Non Berusaha selesai!');
            }
            else
            {
                session()->flash('error', 'ERROR: Permohonan KKPR Non Berusaha belum selesai! Mohon cek kembali kelengkapan/validasi berkas!');
            }
        }

        return redirect()->route('kkprnb.detail', ['id' => $this->kkprnb->id]);
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
