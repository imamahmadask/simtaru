<?php

namespace App\Livewire\Admin\Permohonan;

use App\Models\Layanan;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Permohonan')]
class PermohonanIndex extends Component
{
    public $search = '';
    public $filterLayanan = '';
    public $filterStatus = '';
    public $filterPrioritas = '';
    public $layanans;

    public function render()
    {
        $permohonans = Permohonan::with('layanan.registrasi')
                        ->whereHas('layanan', function($query) {
                            $query->where('id', 'like', '%'.$this->filterLayanan.'%');
                        })
                        ->whereHas('registrasi', function($query) {
                            $query->where('nama', 'like', '%' . $this->search . '%')
                                ->orWhere('kode', 'like', '%' . $this->search . '%');
                        })
                        ->where('is_prioritas', 'like', '%' . $this->filterPrioritas . '%')
                        ->where('status', 'like', '%' . $this->filterStatus . '%')
                        ->orderBy('is_prioritas', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('livewire.admin.permohonan.permohonan-index', [
            'permohonans' => $permohonans
        ]);
    }

    public function mount()
    {
        $this->layanans = Layanan::all();
    }

    public function deletePermohonan($id)
    {
        if (Auth::user()->role != 'superadmin' && Auth::user()->role != 'data-entry') {
            abort(403);
        }

        try {
            DB::beginTransaction();

            // Load the Permohonan with relationships
            $permohonan = Permohonan::findOrFail($id);

            // 1. Delete files and records from PermohonanBerkas
            $permohonanBerkas = $permohonan->berkas;
            foreach ($permohonanBerkas as $berkas) {
                $this->deleteFileIfExists($berkas->file_path);
            }
            $permohonan->berkas()->delete();

            // 2. Delete files and records from service-specific tables
            // SKRK
            if ($permohonan->skrk) {
                $skrk = $permohonan->skrk;
                $this->deleteFileIfExists($skrk->gambar_peta);
                $this->deleteFileIfExists($skrk->foto_survey);
                $this->deleteFileIfExists($skrk->akta_pendirian);
                $this->deleteFileIfExists($skrk->sket_lokasi);
                $skrk->delete();
            }

            // KKPRB
            if ($permohonan->kkprb) {
                $kkprb = $permohonan->kkprb;
                $this->deleteFileIfExists($kkprb->berkas_ptp);
                $this->deleteFileIfExists($kkprb->gambar_peta);
                $this->deleteFileIfExists($kkprb->foto_survey);
                $kkprb->delete();
            }

            // KKPRNB
            if ($permohonan->kkprnb) {
                $kkprnb = $permohonan->kkprnb;
                $this->deleteFileIfExists($kkprnb->berkas_ptp);
                $this->deleteFileIfExists($kkprnb->gambar_peta);
                $this->deleteFileIfExists($kkprnb->foto_survey);
                $this->deleteFileIfExists($kkprnb->ceklis);
                $this->deleteFileIfExists($kkprnb->surat_pengantar_kelengkapan);
                $this->deleteFileIfExists($kkprnb->tanggapan_1a);
                $this->deleteFileIfExists($kkprnb->tanggapan_1b);
                $this->deleteFileIfExists($kkprnb->tanggapan_2);
                $this->deleteFileIfExists($kkprnb->akta_pendirian);
                $this->deleteFileIfExists($kkprnb->gambar_teknis);
                $kkprnb->delete();
            }

            // ITR
            if ($permohonan->itr) {
                $itr = $permohonan->itr;
                $this->deleteFileIfExists($itr->dokumen_kkkpr);
                $this->deleteFileIfExists($itr->gambar_peta);
                $this->deleteFileIfExists($itr->foto_survey);
                $itr->delete();
            }

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

            DB::commit();

            session()->flash('success', 'Permohonan dan semua data terkait berhasil dihapus');

            return redirect()->route('permohonan.index');

        } catch (\Exception $e) {
            DB::rollBack();
            
            session()->flash('error', 'Gagal menghapus permohonan: ' . $e->getMessage());

            return redirect()->route('permohonan.index');
        }
    }

    private function deleteFileIfExists($filePath)
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }
}
