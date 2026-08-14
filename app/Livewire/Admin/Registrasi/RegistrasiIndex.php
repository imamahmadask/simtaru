<?php

namespace App\Livewire\Admin\Registrasi;

use App\Models\Itr;
use App\Models\Kkprb;
use App\Models\Kkprnb;
use App\Models\Layanan;
use App\Models\Permohonan;
use App\Models\Registrasi;
use App\Models\Skrk;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use PhpOffice\PhpWord\TemplateProcessor;
use Livewire\WithPagination;

#[Title('Registrasi')]
class RegistrasiIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $filterLayanan = '';
    public $viewTrash = false;
    public $layanans;

    #[On('refresh-registrasi-list')]
    public function refresh()
    {}

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterLayanan()
    {
        $this->resetPage();
    }

    public function toggleTrashView($val)
    {
        $this->viewTrash = (bool) $val;
        $this->resetPage();
    }

    public function render()
    {
        $query = Registrasi::with('layanan');

        if ($this->viewTrash) {
            $query->onlyTrashed();
        }

        $registrasis = $query
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
            ->paginate(10);

        return view('livewire.admin.registrasi.registrasi-index', [
            'registrasis' => $registrasis
        ]);
    }

    /**
     * Soft Delete registrasi dan permohonan terkait
     */
    public function deleteRegistrasi($id)
    {
        if (Auth::user()->role != 'superadmin' && Auth::user()->role != 'supervisor') {
            abort(403);
        }

        try {
            DB::beginTransaction();

            $registrasi = Registrasi::findOrFail($id);
            $permohonan = $registrasi->permohonan;

            if ($permohonan) {
                if ($permohonan->skrk) {
                    $permohonan->skrk->delete();
                }
                if ($permohonan->kkprb) {
                    $permohonan->kkprb->delete();
                }
                if ($permohonan->kkprnb) {
                    $permohonan->kkprnb->delete();
                }
                if ($permohonan->itr) {
                    $permohonan->itr->delete();
                }
                $permohonan->delete();
            }

            $registrasi->delete();

            DB::commit();

            $this->dispatch('toast', [
                'type'    => 'success',
                'message' => 'Data registrasi berhasil dipindahkan ke Sampah (Trash).'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('toast', [
                'type'    => 'error',
                'message' => 'Gagal menghapus registrasi: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Restore registrasi dari Sampah (Trash)
     */
    public function restoreRegistrasi($id)
    {
        if (Auth::user()->role != 'superadmin' && Auth::user()->role != 'supervisor') {
            abort(403);
        }

        try {
            DB::beginTransaction();

            $registrasi = Registrasi::onlyTrashed()->findOrFail($id);
            $registrasi->restore();

            $permohonan = Permohonan::onlyTrashed()->where('registrasi_id', $id)->first();
            if ($permohonan) {
                $permohonan->restore();

                $skrk = Skrk::onlyTrashed()->where('permohonan_id', $permohonan->id)->first();
                if ($skrk) {
                    $skrk->restore();
                }

                $kkprb = Kkprb::onlyTrashed()->where('permohonan_id', $permohonan->id)->first();
                if ($kkprb) {
                    $kkprb->restore();
                }

                $kkprnb = Kkprnb::onlyTrashed()->where('permohonan_id', $permohonan->id)->first();
                if ($kkprnb) {
                    $kkprnb->restore();
                }

                $itr = Itr::onlyTrashed()->where('permohonan_id', $permohonan->id)->first();
                if ($itr) {
                    $itr->restore();
                }
            }

            DB::commit();

            $this->dispatch('toast', [
                'type'    => 'success',
                'message' => 'Data registrasi berhasil dipulihkan dari Sampah.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('toast', [
                'type'    => 'error',
                'message' => 'Gagal memulihkan registrasi: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Force Delete (Hapus Permanen data & berkas fisik dari disk)
     */
    public function forceDeleteRegistrasi($id)
    {
        if (Auth::user()->role != 'superadmin') {
            abort(403);
        }

        try {
            DB::beginTransaction();

            $registrasi = Registrasi::withTrashed()->findOrFail($id);
            $permohonan = Permohonan::withTrashed()->where('registrasi_id', $id)->first();

            if ($permohonan) {
                // Delete files and records from PermohonanBerkas
                $permohonanBerkas = $permohonan->berkas;
                foreach ($permohonanBerkas as $berkas) {
                    if ($berkas->file_path && Storage::disk('public')->exists($berkas->file_path)) {
                        Storage::disk('public')->delete($berkas->file_path);
                    }
                }
                $permohonan->berkas()->delete();

                // Delete files and records from service-specific tables
                $skrk = Skrk::withTrashed()->where('permohonan_id', $permohonan->id)->first();
                if ($skrk) {
                    $this->deleteFileIfExists($skrk->gambar_peta);
                    $this->deleteFileIfExists($skrk->foto_survey);
                    $skrk->forceDelete();
                }

                $kkprb = Kkprb::withTrashed()->where('permohonan_id', $permohonan->id)->first();
                if ($kkprb) {
                    $this->deleteFileIfExists($kkprb->berkas_ptp);
                    $this->deleteFileIfExists($kkprb->gambar_peta);
                    $this->deleteFileIfExists($kkprb->foto_survey);
                    $kkprb->forceDelete();
                }

                $kkprnb = Kkprnb::withTrashed()->where('permohonan_id', $permohonan->id)->first();
                if ($kkprnb) {
                    $this->deleteFileIfExists($kkprnb->berkas_ptp);
                    $this->deleteFileIfExists($kkprnb->gambar_peta);
                    $this->deleteFileIfExists($kkprnb->foto_survey);
                    $this->deleteFileIfExists($kkprnb->ceklis);
                    $this->deleteFileIfExists($kkprnb->surat_pengantar_kelengkapan);
                    $this->deleteFileIfExists($kkprnb->tanggapan_1a);
                    $this->deleteFileIfExists($kkprnb->tanggapan_1b);
                    $this->deleteFileIfExists($kkprnb->tanggapan_2);
                    $kkprnb->forceDelete();
                }

                $itr = Itr::withTrashed()->where('permohonan_id', $permohonan->id)->first();
                if ($itr) {
                    $this->deleteFileIfExists($itr->dokumen_kkkpr);
                    $this->deleteFileIfExists($itr->gambar_peta);
                    $this->deleteFileIfExists($itr->foto_survey);
                    $itr->forceDelete();
                }

                $permohonan->disposisi()->delete();
                $permohonan->saran()->delete();

                $this->deleteFileIfExists($permohonan->berkas_ktp);
                $this->deleteFileIfExists($permohonan->berkas_nib);
                $this->deleteFileIfExists($permohonan->berkas_penguasaan);
                $this->deleteFileIfExists($permohonan->berkas_permohonan);
                $this->deleteFileIfExists($permohonan->berkas_kuasa);

                $permohonan->forceDelete();
            }

            $registrasi->riwayat()->delete();
            $registrasi->forceDelete();

            DB::commit();

            $this->dispatch('toast', [
                'type'    => 'success',
                'message' => 'Registrasi dan semua data terkait berhasil dihapus permanen.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch('toast', [
                'type'    => 'error',
                'message' => 'Gagal menghapus registrasi secara permanen: ' . $e->getMessage()
            ]);
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

        // Sanitize filename by removing special characters
        $baseName = str_replace('.docx', '', basename($templatePath));
        $sanitizedName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $data['nama_pemohon']);
        $fileName = $baseName . '_' . $sanitizedName . '.docx';
        $tempPath = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $fileName);

        $templateProcessor->saveAs($tempPath);

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }

}
