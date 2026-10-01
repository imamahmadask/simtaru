<?php

namespace App\Livewire\Concerns;

use App\Models\Permohonan;
use Carbon\Carbon;

trait HasPermohonanTimeline
{
    public $showTimelineModal = false;
    public $timelineData = [];
    public $timelineTitle = '';
    public $permohonanIsDone = false;
    public $permohonanWaktuPekerjaan = null;

    protected function loadTimelineForPermohonan(Permohonan $permohonan, ?string $title = null): void
    {
        $permohonan->loadMissing(['registrasi', 'disposisi.tahapan', 'disposisi.penerima']);

        $this->permohonanIsDone = (bool) $permohonan->is_done;
        $this->permohonanWaktuPekerjaan = $permohonan->waktu_pengerjaan;
        $this->timelineTitle = $title ?? (($permohonan->registrasi->kode ?? '-') . ' - ' . ($permohonan->registrasi->nama ?? '-'));

        $disposisis = $permohonan->disposisi
            ->sortByDesc('tanggal_disposisi')
            ->values();

        $grouped = [];

        foreach ($disposisis as $disposisi) {
            $tahapanName = $disposisi->tahapan ? $disposisi->tahapan->nama : 'Unknown';

            $startTime = Carbon::parse($disposisi->tanggal_disposisi);
            $mulaiKerja = $disposisi->tgl_mulai_kerja ? Carbon::parse($disposisi->tgl_mulai_kerja) : null;
            $endTime = $disposisi->tgl_selesai ? Carbon::parse($disposisi->tgl_selesai) : null;

            $durationText = 'Belum selesai';
            $days = null;

            $workStart = $mulaiKerja ?? $startTime;
            if ($endTime) {
                $diffInMinutes = $workStart->diffInMinutes($endTime);
                $days = floor($diffInMinutes / (60 * 24));
                $hours = floor(($diffInMinutes % (60 * 24)) / 60);
                $minutes = $diffInMinutes % 60;

                $parts = [];
                if ($days > 0) {
                    $parts[] = $days . ' hari';
                }
                if ($hours > 0) {
                    $parts[] = $hours . ' jam';
                }
                if ($minutes > 0) {
                    $parts[] = $minutes . ' menit';
                }
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
}
