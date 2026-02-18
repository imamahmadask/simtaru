<?php

namespace App\Livewire\Admin\Permohonan\Kkprnb;

use App\Models\Kkprnb;
use Carbon\Carbon;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Permohonan KKPR Non Berusaha')]
class KkprnbIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $showTimelineModal = false;
    public $timelineData = [];
    public $timelineTitle = '';
    public $permohonanIsDone = false;
    public $permohonanWaktuPekerjaan = null;

    public function showTimeline($kkprnbId)
    {
        $kkprnb = Kkprnb::with(['permohonan.disposisi.tahapan', 'permohonan.disposisi.penerima'])->findOrFail($kkprnbId);
        $permohonan = $kkprnb->permohonan;
        $this->permohonanIsDone = $permohonan->is_done;
        $this->permohonanWaktuPekerjaan = $permohonan->waktu_pengerjaan;

        $this->timelineTitle = $kkprnb->registrasi->kode . ' - ' . $kkprnb->registrasi->nama;

        // Get all disposisi for this permohonan, grouped by tahapan
        $disposisis = $permohonan->disposisi()
            ->with(['tahapan', 'penerima'])
            ->orderBy('tanggal_disposisi', 'desc')
            ->get();

        $grouped = [];

        foreach ($disposisis as $disposisi) {
            $tahapanName = $disposisi->tahapan ? $disposisi->tahapan->nama : 'Unknown';

            $startTime = Carbon::parse($disposisi->tanggal_disposisi);
            $mulaiKerja = $disposisi->tgl_mulai_kerja ? Carbon::parse($disposisi->tgl_mulai_kerja) : null;
            $endTime = $disposisi->tgl_selesai ? Carbon::parse($disposisi->tgl_selesai) : null;

            $durationText = 'Belum selesai';
            $days = null;

            // Calculate working duration (from mulai_kerja if available, otherwise from disposisi date)
            $workStart = $mulaiKerja ?? $startTime;
            if ($endTime) {
                $diffInMinutes = $workStart->diffInMinutes($endTime);
                $days = floor($diffInMinutes / (60 * 24));
                $hours = floor(($diffInMinutes % (60 * 24)) / 60);
                $minutes = $diffInMinutes % 60;

                $parts = [];
                if ($days > 0) $parts[] = $days . ' hari';
                if ($hours > 0) $parts[] = $hours . ' jam';
                if ($minutes > 0) $parts[] = $minutes . ' menit';
                $durationText = count($parts) > 0 ? implode(' ', $parts) : '< 1 menit';
            }

            $grouped[] = [
                'tahapan' => $tahapanName,
                'penerima' => $disposisi->penerima ? $disposisi->penerima->name : '-',
                'role' => $disposisi->penerima ? $disposisi->penerima->role : '-',
                'tanggal_disposisi' => $startTime->format('d-m-Y H:i'),
                'tgl_mulai_kerja' => $mulaiKerja ? $mulaiKerja->format('d-m-Y H:i') : '-',
                'tgl_selesai' => $endTime ? $endTime->format('d-m-Y H:i') : '-',
                'durasi' => $durationText,
                'is_done' => $disposisi->is_done,
                'is_revisi' => $disposisi->is_revisi ?? false,
                'status' => $disposisi->status ?? 'pending',
                'days' => $days,
            ];
        }

        $this->timelineData = $grouped;
        $this->showTimelineModal = true;

        $this->dispatch('open-timeline-modal');
    }

    public function render()
    {
        $kkprnb = Kkprnb::with('layanan.permohonan.registrasi')
            ->whereHas('layanan', function($query) {
                        $query->where('kode', 'KKPRNB');
            })
            ->whereHas('registrasi', (function($query) {
                $query->where('kode', 'LIKE', '%'.$this->search.'%')
                ->orWhere('nama', 'LIKE', '%'.$this->search.'%');
            }))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.permohonan.kkprnb.kkprnb-index', [
            'kkprnb' => $kkprnb,
        ]);
    }
}
