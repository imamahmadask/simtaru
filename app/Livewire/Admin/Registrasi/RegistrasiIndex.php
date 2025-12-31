<?php

namespace App\Livewire\Admin\Registrasi;

use App\Models\Layanan;
use App\Models\Registrasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use PhpOffice\PhpWord\TemplateProcessor;

#[Title('Registrasi')]
class RegistrasiIndex extends Component
{
    public $search = '';
    public $filterLayanan = '';    
    public $layanans;

    #[On('refresh-registrasi-list')]
    public function refresh()
    {}

    public function render()
    {
        $registrasis = Registrasi::with('layanan')
            ->when($this->filterLayanan, function ($query) {
                $query->whereHas('layanan', function ($subQuery) {
                    $subQuery->where('id', 'like', '%' . $this->filterLayanan . '%');
                });
            })
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('nama', 'like', '%' . $this->search . '%')
                             ->orWhere('kode', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.admin.registrasi.registrasi-index', [
            'registrasis' => $registrasis
        ]);
    }

    public function deleteRegistrasi(Registrasi $registrasi)
    {
        if (Auth::user()->role != 'superadmin') {
            abort(403);
        }

        try {
            DB::beginTransaction();

            // Get permohonan if exists
            $permohonan = $registrasi->permohonan;

            if ($permohonan) {
                // 1. Delete files and records from PermohonanBerkas
                $permohonanBerkas = $permohonan->berkas;
                foreach ($permohonanBerkas as $berkas) {
                    if ($berkas->file_path && Storage::disk('public')->exists($berkas->file_path)) {
                        Storage::disk('public')->delete($berkas->file_path);
                    }
                }
                $permohonan->berkas()->delete();

                // 2. Delete files and records from service-specific tables
                // SKRK
                $skrks = $permohonan->skrk;
                foreach ($skrks as $skrk) {
                    $this->deleteFileIfExists($skrk->gambar_peta);
                    $this->deleteFileIfExists($skrk->foto_survey);
                }
                $permohonan->skrk()->delete();

                // KKPRB
                $kkprbs = \App\Models\Kkprb::where('permohonan_id', $permohonan->id)->get();
                foreach ($kkprbs as $kkprb) {
                    $this->deleteFileIfExists($kkprb->berkas_ptp);
                    $this->deleteFileIfExists($kkprb->gambar_peta);
                    $this->deleteFileIfExists($kkprb->foto_survey);
                }
                \App\Models\Kkprb::where('permohonan_id', $permohonan->id)->delete();

                // KKPRNB
                $kkprnbs = \App\Models\Kkprnb::where('permohonan_id', $permohonan->id)->get();
                foreach ($kkprnbs as $kkprnb) {
                    $this->deleteFileIfExists($kkprnb->berkas_ptp);
                    $this->deleteFileIfExists($kkprnb->gambar_peta);
                    $this->deleteFileIfExists($kkprnb->foto_survey);
                    $this->deleteFileIfExists($kkprnb->ceklis);
                    $this->deleteFileIfExists($kkprnb->surat_pengantar_kelengkapan);
                    $this->deleteFileIfExists($kkprnb->tanggapan_1a);
                    $this->deleteFileIfExists($kkprnb->tanggapan_1b);
                    $this->deleteFileIfExists($kkprnb->tanggapan_2);
                }
                \App\Models\Kkprnb::where('permohonan_id', $permohonan->id)->delete();

                // ITR
                $itrs = \App\Models\Itr::where('permohonan_id', $permohonan->id)->get();
                foreach ($itrs as $itr) {
                    $this->deleteFileIfExists($itr->dokumen_kkkpr);
                    $this->deleteFileIfExists($itr->gambar_peta);
                    $this->deleteFileIfExists($itr->foto_survey);
                }
                \App\Models\Itr::where('permohonan_id', $permohonan->id)->delete();

                // 3. Delete Disposisi records
                $permohonan->disposisi()->delete();

                // 4. Delete files from Permohonan fields
                $this->deleteFileIfExists($permohonan->berkas_ktp);
                $this->deleteFileIfExists($permohonan->berkas_nib);
                $this->deleteFileIfExists($permohonan->berkas_penguasaan);
                $this->deleteFileIfExists($permohonan->berkas_permohonan);
                $this->deleteFileIfExists($permohonan->berkas_kuasa);

                // 5. Delete Permohonan record
                $permohonan->delete();
            }

            // 6. Delete RiwayatPermohonan records
            $registrasi->riwayat()->delete();

            // 7. Delete Registrasi record
            $registrasi->delete();

            DB::commit();

            session()->flash('success', 'Registrasi dan semua data terkait berhasil dihapus');

            return redirect()->route('registrasi.index');

        } catch (\Exception $e) {
            DB::rollBack();
            
            session()->flash('error', 'Gagal menghapus registrasi: ' . $e->getMessage());
            
            return redirect()->route('registrasi.index');
        }
    }

    private function deleteFileIfExists($filePath)
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }

    public function mount()
    {
        $this->layanans = Layanan::orderBy('nama', 'asc')->get();
    }

    public function printRegistrasi($id)
    {
        $data = Registrasi::with('layanan')->find($id);

        view()->share('data', $data);

        // $pdf = Pdf::loadView('pdf.tanda-terima-regis');
        $pdf = Pdf::loadView('pdf.bukti-regis');
        return $pdf->download($data['kode'].'.pdf');
    }

    public function downloadTandaTerima($id)
    {
        $data = Registrasi::with('layanan')->find($id);

        $data = [
            'kode_registrasi' => $data->kode,
            'nama_pemohon' => $data->nama,
            'alamat_tanah' => $data->alamat_tanah.', '.$data->kel_tanah.', '.$data->kec_tanah,
            'fungsi_bangunan' => $data->fungsi_bangunan,
            'tgl_permohonan' => date('d-m-Y', strtotime($data->tanggal)),
            'jenis_layanan' => $data->layanan->nama,
            'penerima' => $data->createdBy->name
        ];

        return $this->generateDocument('Tanda_terima_registrasi.docx', $data);
    }

    private function generateDocument($templatePath, $data)
    {
        $templateProcessor = new TemplateProcessor(storage_path('app/public/templates/skrk/'.$templatePath));

        foreach ($data as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }

        $fileName = str_replace('.docx', '', basename($templatePath)).'_'.$data['nama_pemohon'].'.docx';
        $tempPath = storage_path("app/public/{$fileName}");

        $templateProcessor->saveAs($tempPath);

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }

}
