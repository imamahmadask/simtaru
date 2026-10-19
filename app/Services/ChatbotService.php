<?php

namespace App\Services;

use App\Models\Pelanggaran;
use App\Models\Registrasi;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ChatbotService
{
    protected string $groqApiKey;
    protected string $groqModel;
    protected string $geminiApiKey;
    protected string $geminiModel;

    public function __construct()
    {
        $this->groqApiKey = (string) config('services.groq.api_key', '');
        $this->groqModel = (string) config('services.groq.model', 'openai/gpt-oss-120b');

        $this->geminiApiKey = (string) config('services.gemini.api_key', '');
        $this->geminiModel = (string) config('services.gemini.model', 'gemini-flash-latest');
    }

    /**
     * Memproses percakapan dan menghasilkan respons dari AI (Groq / Gemini) atau database SIMTARU
     *
     * @param array $chatHistory Array percakapan sebelumnya [ ['role' => 'user'|'model', 'content' => '...'] ]
     * @param string $userMessage Pesan terkini dari pemohon
     * @return string
     */
    public function generateReply(array $chatHistory, string $userMessage): string
    {
        $cleanMessage = trim($userMessage);
        if (empty($cleanMessage)) {
            return "Silakan ketikkan pertanyaan seputar tata ruang Kota Mataram.";
        }

        // 1. Periksa apakah pengguna menanyakan statistik kasus pelanggaran tata ruang
        $pelanggaranResult = $this->checkPelanggaranStats($cleanMessage);

        // 2. Periksa apakah pengguna menanyakan status nomor registrasi spesifik (hanya jika bukan pertanyaan statistik pelanggaran)
        $trackingResult = $pelanggaranResult['found']
            ? ['found' => false, 'context_for_ai' => '', 'direct_response' => '']
            : $this->checkRegistrationStatus($cleanMessage);

        // 3. Jika API Key Groq dan Gemini belum diset
        if (empty($this->groqApiKey) && empty($this->geminiApiKey)) {
            if ($pelanggaranResult['found']) {
                return $pelanggaranResult['direct_response'];
            }
            if ($trackingResult['found']) {
                return $trackingResult['direct_response'];
            }

            return "Halo! Saya adalah **Asisten AI SIMTARU Kota Mataram**.\n\n" .
                "Sistem telah dikonfigurasi untuk menggunakan **Groq Cloud (LPU)**. Kunci API belum ditambahkan pada file `.env` (`GROQ_API_KEY`).\n\n" .
                "👉 Dapatkan API key gratis dalam 30 detik di [console.groq.com/keys](https://console.groq.com/keys).\n\n" .
                "💡 **Fitur Lacak Berkas & Statistik Aktif:** Anda tetap dapat menanyakan jumlah kasus pelanggaran tata ruang atau mengetikkan nomor registrasi permohonan sesuai tanda terima Anda.";
        }

        // 4. Muat Dokumen Pengetahuan Resmi (Knowledge Base)
        $knowledgePath = resource_path('data/knowledge_simtaru.md');
        $knowledge = File::exists($knowledgePath) ? File::get($knowledgePath) : 'Pengetahuan tata ruang Kota Mataram mencakup layanan SKRK, ITR, KKPR-B, dan KKPR-NB.';

        // 5. Susun System Prompt Ringkas (Seluruh detail aturan & regulasi sudah termuat di dalam $knowledge)
        $systemInstruction = <<<INSTRUCTION
Anda adalah "Asisten AI SIMTARU HARUM Kota Mataram", asisten resmi Dinas Pekerjaan Umum dan Penataan Ruang (DPUPR) Kota Mataram.

ATURAN WAJIB:
1. JAWAB SPESIFIK & DILARANG MELEBAR: Jawab HANYA apa yang ditanyakan pengguna secara lugas (to-the-point). Jangan melebar ke layanan, zona, atau pasal lain yang tidak ditanyakan.
2. LARANGAN KERAS RIWAYAT BERKAS & NOMOR BERKAS:
   - DILARANG memberikan riwayat/kronologi perjalanan berkas jika tidak diminta secara eksplisit oleh pengguna.
   - DILARANG mencantumkan atau menyebutkan nomor berkas / nomor registrasi apa pun (termasuk contoh nomor berkas) jika pengguna tidak sedang menanyakan nomor berkas tersebut.
   - Jika ditanya jumlah/statistik kasus pelanggaran tata ruang, jawab HANYA berdasarkan [DATA STATISTIK PELANGGARAN TATA RUANG DARI DATABASE SIMTARU] tanpa mencantumkan nomor berkas atau riwayat berkas.
3. FORMAT COMPACT: Gunakan teks tebal (**Judul**) atau heading kecil (###), daftar berbutir singkat, dan bahasa resmi yang santun. Tutup dengan maks 1 kalimat bahwa informasi ini adalah asistensi awal DPUPR Kota Mataram.

REFERENSI PENGETAHUAN RESMI SIMTARU:
{$knowledge}
{$pelanggaranResult['context_for_ai']}
{$trackingResult['context_for_ai']}
INSTRUCTION;

        // 6. Coba panggil Groq Cloud (Prioritas Utama: Sangat Cepat & Bebas Antrean)
        if (!empty($this->groqApiKey)) {
            $groqReply = $this->callGroqApi($systemInstruction, $chatHistory, $cleanMessage);
            if (!empty($groqReply)) {
                return $groqReply;
            }
        }

        // 7. Cadangan Sekunder: Jika Groq bermasalah, gunakan Gemini
        if (!empty($this->geminiApiKey)) {
            $geminiReply = $this->callGeminiApi($systemInstruction, $chatHistory, $cleanMessage);
            if (!empty($geminiReply)) {
                return $geminiReply;
            }
        }

        // 8. Fallback jika semua API AI mengalami kendala
        if ($pelanggaranResult['found']) {
            return $pelanggaranResult['direct_response'];
        }

        if ($trackingResult['found']) {
            return $trackingResult['direct_response'];
        }

        return "Mohon maaf, layanan konsultasi AI sedang sibuk. Silakan coba kembali beberapa saat lagi atau hubungi loket pelayanan DPUPR Kota Mataram.";
    }

    /**
     * Panggilan ke Groq Cloud API (LPU Inference - Super Cepat)
     */
    protected function callGroqApi(string $systemInstruction, array $chatHistory, string $cleanMessage): ?string
    {
        $messages = [
            [
                'role' => 'system',
                'content' => $systemInstruction,
            ],
        ];

        // Batasi riwayat percakapan yang dikirim ke API (maks 4 pesan terakhir agar hemat token)
        $recentHistory = array_slice($chatHistory, -4);
        foreach ($recentHistory as $item) {
            $role = ($item['role'] === 'user') ? 'user' : 'assistant';
            $text = trim($item['content'] ?? '');
            if (!empty($text)) {
                $messages[] = [
                    'role' => $role,
                    'content' => $text,
                ];
            }
        }

        // Pastikan pesan terakhir adalah user message terkini
        $lastMsg = end($messages);
        if ($lastMsg['role'] !== 'user' || $lastMsg['content'] !== $cleanMessage) {
            $messages[] = [
                'role' => 'user',
                'content' => $cleanMessage,
            ];
        }

        // Model candidates aktif di Groq
        $candidateModels = array_unique(array_filter([
            $this->groqModel,
            'openai/gpt-oss-120b',
            'openai/gpt-oss-20b',
            'qwen/qwen3.8-27b',
        ]));

        foreach ($candidateModels as $targetModel) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $this->groqApiKey,
                    'Content-Type' => 'application/json',
                ])->timeout(25)->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => $targetModel,
                    'messages' => $messages,
                    'temperature' => 0.2,
                    'max_tokens' => 700,
                ]);

                if ($response->successful()) {
                    $reply = $response->json('choices.0.message.content');
                    if (!empty($reply)) {
                        return $reply;
                    }
                }

                $status = $response->status();
                Log::warning("Groq API Error with model [{$targetModel}] (HTTP {$status}): " . $response->body());

                if (in_array($status, [400, 404, 413, 429, 500, 503])) {
                    continue;
                }
            } catch (\Throwable $e) {
                Log::error("Groq API Exception with model [{$targetModel}]: " . $e->getMessage());
            }
        }

        return null;
    }

    /**
     * Panggilan Cadangan ke Google Gemini API
     */
    protected function callGeminiApi(string $systemInstruction, array $chatHistory, string $cleanMessage): ?string
    {
        $contents = [];
        $historyTurns = [];
        $recentHistory = array_slice($chatHistory, -6);
        foreach ($recentHistory as $item) {
            $role = ($item['role'] === 'user') ? 'user' : 'model';
            $text = trim($item['content'] ?? '');
            if (!empty($text)) {
                $historyTurns[] = ['role' => $role, 'text' => $text];
            }
        }

        $firstUserIdx = -1;
        foreach ($historyTurns as $idx => $turn) {
            if ($turn['role'] === 'user') {
                $firstUserIdx = $idx;
                break;
            }
        }

        if ($firstUserIdx !== -1) {
            $lastRole = null;
            for ($i = $firstUserIdx; $i < count($historyTurns); $i++) {
                $currentRole = $historyTurns[$i]['role'];
                if ($currentRole !== $lastRole) {
                    $contents[] = [
                        'role' => $currentRole,
                        'parts' => [['text' => $historyTurns[$i]['text']]],
                    ];
                    $lastRole = $currentRole;
                }
            }
        }

        $needsCurrentMessage = true;
        if (!empty($contents)) {
            $lastContent = end($contents);
            if ($lastContent['role'] === 'user' && ($lastContent['parts'][0]['text'] ?? '') === $cleanMessage) {
                $needsCurrentMessage = false;
            }
        }

        if ($needsCurrentMessage) {
            if (!empty($contents) && end($contents)['role'] === 'user') {
                array_pop($contents);
            }
            $contents[] = [
                'role' => 'user',
                'parts' => [['text' => $cleanMessage]],
            ];
        }

        $candidateModels = array_unique(array_filter([
            $this->geminiModel,
            'gemini-flash-latest',
            'gemini-2.5-flash-lite',
        ]));

        foreach ($candidateModels as $targetModel) {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$targetModel}:generateContent?key={$this->geminiApiKey}";

            try {
                $response = Http::timeout(20)->post($url, [
                    'system_instruction' => [
                        'parts' => [['text' => $systemInstruction]],
                    ],
                    'contents' => $contents,
                    'generationConfig' => [
                        'temperature' => 0.2,
                        'maxOutputTokens' => 1000,
                    ],
                ]);

                if ($response->successful()) {
                    $replyText = $response->json('candidates.0.content.parts.0.text');
                    if (!empty($replyText)) {
                        return $replyText;
                    }
                }
            } catch (\Throwable $e) {
                Log::error("Gemini fallback exception [{$targetModel}]: " . $e->getMessage());
            }
        }

        return null;
    }

    /**
     * Memeriksa apakah pengguna menanyakan data/jumlah kasus pelanggaran tata ruang dari database SIMTARU
     */
    protected function checkPelanggaranStats(string $message): array
    {
        if (!preg_match('/\b(pelanggaran|kasus|penertiban|pengawasan|wasdal|melanggar|indikasi)\b/i', $message)) {
            return [
                'found' => false,
                'context_for_ai' => '',
                'direct_response' => '',
            ];
        }

        try {
            // Ambil hanya kolom agregat non-sensitif (TANPA nomor berkas dan TANPA nama pelanggar/pelapor)
            $records = Pelanggaran::select([
                'tgl_laporan',
                'tanggal_pengawasan',
                'kec_pelanggaran',
                'status',
                'jenis_indikasi_pelanggaran',
                'temuan_pelanggaran',
                'created_at',
            ])->get();

            $requestedYear = null;
            if (preg_match('/\b(20[1-3][0-9])\b/', $message, $yearMatch)) {
                $requestedYear = $yearMatch[1];
            }

            $withYear = $records->map(function ($row) {
                $dateStr = $row->tgl_laporan ?: ($row->tanggal_pengawasan ?: ($row->created_at ? $row->created_at->format('Y-m-d') : null));
                $year = $dateStr ? substr((string) $dateStr, 0, 4) : 'Tidak Diketahui';
                return [
                    'year' => $year,
                    'kecamatan' => !empty($row->kec_pelanggaran) ? trim($row->kec_pelanggaran) : 'Tidak Tercantum',
                    'status' => !empty($row->status) ? trim($row->status) : 'Dalam Proses',
                    'indikasi' => !empty($row->jenis_indikasi_pelanggaran) ? trim($row->jenis_indikasi_pelanggaran) : 'Lainnya',
                ];
            });

            $filtered = $requestedYear
                ? $withYear->where('year', $requestedYear)
                : $withYear;

            $totalFiltered = $filtered->count();
            $totalAll = $withYear->count();

            $byYear = $withYear->groupBy('year')->map->count()->sortKeysDesc();
            $byYearStr = $byYear->map(fn ($count, $yr) => "- Tahun {$yr}: **{$count} kasus**")->implode("\n");

            $byKec = $filtered->groupBy('kecamatan')->map->count()->sortDesc();
            $byKecStr = $byKec->count() > 0
                ? $byKec->map(fn ($count, $kec) => "- Kecamatan {$kec}: **{$count} kasus**")->implode("\n")
                : "- Belum ada data per kecamatan.";

            $byStatus = $filtered->groupBy('status')->map->count()->sortDesc();
            $byStatusStr = $byStatus->count() > 0
                ? $byStatus->map(fn ($count, $st) => "- {$st}: **{$count} kasus**")->implode("\n")
                : "- Belum ada rincian status.";

            $byIndikasi = $filtered->groupBy('indikasi')->map->count()->sortDesc();
            $byIndikasiStr = $byIndikasi->count() > 0
                ? $byIndikasi->map(fn ($count, $ind) => "- {$ind}: **{$count} kasus**")->implode("\n")
                : "- Belum ada rincian jenis indikasi.";

            $periodeLabel = $requestedYear ? "Tahun {$requestedYear}" : "Seluruh Periode";

            $contextForAi = <<<CTX

[DATA STATISTIK PELANGGARAN TATA RUANG DARI DATABASE SIMTARU]
- Periode yang Ditanyakan: {$periodeLabel}
- Total Kasus Pelanggaran ({$periodeLabel}): {$totalFiltered} kasus
- Total Keseluruhan Kasus di Database: {$totalAll} kasus

Rincian Jumlah Kasus per Tahun:
{$byYearStr}

Rincian per Kecamatan ({$periodeLabel}):
{$byKecStr}

Rincian Status Penanganan ({$periodeLabel}):
{$byStatusStr}

Rincian Jenis Indikasi Pelanggaran ({$periodeLabel}):
{$byIndikasiStr}

INSTRUKSI KHUSUS UNTUK DATA PELANGGARAN INI:
Jawab pertanyaan pengguna secara spesifik, ringkas, dan akurat menggunakan angka di atas (sebutkan total kasus beserta ringkasan singkat status penanganan atau sebaran kecamatannya). DILARANG KERAS menyebutkan nomor berkas, nomor registrasi, atau riwayat berkas apa pun.
CTX;

            $directResponse = "Berdasarkan data resmi **SIMTARU Kota Mataram**, tercatat sebanyak **{$totalFiltered} kasus pelanggaran tata ruang** pada **{$periodeLabel}**.\n\n" .
                "**1. Rincian per Kecamatan ({$periodeLabel}):**\n{$byKecStr}\n\n" .
                "**2. Status Penanganan:**\n{$byStatusStr}\n\n" .
                "**3. Jenis Indikasi Pelanggaran:**\n{$byIndikasiStr}\n\n" .
                "*Catatan: Informasi ini merupakan data statistik pengawasan tata ruang DPUPR Kota Mataram.*";

            return [
                'found' => true,
                'context_for_ai' => $contextForAi,
                'direct_response' => $directResponse,
            ];
        } catch (\Throwable $e) {
            Log::error("Error querying Pelanggaran stats: " . $e->getMessage());
            return [
                'found' => false,
                'context_for_ai' => '',
                'direct_response' => '',
            ];
        }
    }

    /**
     * Memeriksa keberadaan kode registrasi eksplisit dari input pengguna.
     * Hanya mencocokkan format kode registrasi resmi SIMTARU (misal: 0001-SKRK-01-2026) dan TIDAK PERNAH mencocokkan angka tahun 4 digit.
     * Riwayat berkas HANYA disertakan jika pengguna memintanya secara eksplisit.
     */
    protected function checkRegistrationStatus(string $message): array
    {
        $registrasi = null;
        $potentialCode = null;

        // Hanya deteksi pola kode registrasi lengkap SIMTARU (Contoh: XXXX-ITR-MM-YYYY, XXXX-SKRK-MM-YYYY, XXXX-KKPRNB-MM-YYYY, REG-XXXX)
        if (preg_match('/\b([0-9]{3,5}[-_](?:ITR|SKRK|KKPR|KKPRB|KKPRNB)[-_][0-9]{1,2}[-_][0-9]{4}|REG[-_][A-Za-z0-9-]+)\b/i', $message, $matches)) {
            $potentialCode = trim($matches[1]);
            $registrasi = Registrasi::with([
                'layanan',
                'riwayat.user',
                'permohonan.disposisi.tahapan',
                'permohonan.disposisi.penerima'
            ])
            ->where('kode', $potentialCode)
            ->first();
        }

        if ($registrasi) {
            // Sensor nama pemohon untuk keamanan privasi
            $maskedName = $this->maskName($registrasi->nama);

            // Cek apakah pengguna secara eksplisit meminta riwayat / kronologi berkas
            $wantsHistory = (bool) preg_match('/\b(riwayat|kronologi|perjalanan|histori|history|jejak)\b/i', $message);

            // Disposisi teknis & tahapan saat ini
            $currentStage = 'Verifikasi Berkas Administrasi';
            if ($registrasi->permohonan && $registrasi->permohonan->disposisi->count() > 0) {
                foreach ($registrasi->permohonan->disposisi as $disp) {
                    $tahapan = $disp->tahapan->nama ?? 'Pemeriksaan Teknis';
                    if (!$disp->is_done) {
                        $currentStage = $tahapan;
                    }
                }
            }

            $catatan = !empty($registrasi->alasan_tidak_lengkap)
                ? "⚠️ CATATAN KEKURANGAN: " . $registrasi->alasan_tidak_lengkap
                : "✅ Berkas administrasi lengkap / tidak ada catatan kekurangan.";

            $statusText = !empty($registrasi->status) ? $registrasi->status : 'Dalam Proses (' . $currentStage . ')';
            $tglDaftar = $registrasi->created_at ? $registrasi->created_at->format('d F Y H:i') : ($registrasi->tanggal ?? '-');

            // Susun riwayat HANYA jika diminta secara eksplisit
            $riwayatSectionAi = '';
            $riwayatSectionDirect = '';
            if ($wantsHistory) {
                $riwayatList = [];
                $riwayats = $registrasi->riwayat->sortBy('created_at');
                foreach ($riwayats as $r) {
                    $petugas = $r->user->name ?? 'Petugas Loket/Admin';
                    $waktu = $r->created_at ? $r->created_at->format('d/m/Y H:i') : '-';
                    $riwayatList[] = "- **[{$waktu}]** {$r->keterangan} *(Oleh: {$petugas})*";
                }
                $riwayatStr = count($riwayatList) > 0 ? implode("\n", $riwayatList) : "- Berkas baru terdaftar di sistem SIMTARU.";
                $riwayatSectionAi = "\n- Kronologi / Riwayat Perjalanan Berkas:\n{$riwayatStr}\n";
                $riwayatSectionDirect = "\n\n📜 **Kronologi Riwayat Berkas:**\n" . $riwayatStr;
            }

            $instruksiRiwayat = $wantsHistory
                ? "Sampaikan status terkini beserta kronologi riwayat perjalanan berkas di atas karena pemohon memintanya."
                : "Sampaikan HANYA status terkini, tahapan saat ini, dan catatan petugas di atas secara ringkas. DILARANG menampilkan daftar kronologi/riwayat perjalanan berkas karena tidak diminta.";

            $contextForAi = <<<CTX

[DATA STATUS PERMOHONAN DARI DATABASE SIMTARU]
- Nomor Registrasi: {$registrasi->kode}
- Nama Pemohon: {$maskedName}
- Jenis Layanan: {$registrasi->layanan->nama}
- Tanggal Registrasi: {$tglDaftar}
- Lokasi Permohonan: Kelurahan {$registrasi->kel_tanah}, Kecamatan {$registrasi->kec_tanah}
- Tahapan Saat Ini: {$currentStage}
- Status Berkas: {$statusText}
- Catatan Petugas: {$catatan}{$riwayatSectionAi}
INSTRUKSI KHUSUS UNTUK DATA INI:
{$instruksiRiwayat}
CTX;

            $directResponse = "Berikut adalah informasi status berkas permohonan Anda di SIMTARU Kota Mataram:\n\n" .
                "📋 **Nomor Registrasi:** `{$registrasi->kode}`\n" .
                "👤 **Nama Pemohon:** {$maskedName}\n" .
                "📂 **Layanan:** " . ($registrasi->layanan->nama ?? '-') . "\n" .
                "📍 **Lokasi:** Kel. " . ($registrasi->kel_tanah ?? '-') . ", Kec. " . ($registrasi->kec_tanah ?? '-') . "\n" .
                "⏳ **Tahapan Saat Ini:** **{$currentStage}**\n" .
                "📌 **Status:** **{$statusText}**" .
                (!empty($registrasi->alasan_tidak_lengkap) ? "\n⚠️ **Catatan Petugas:** " . $registrasi->alasan_tidak_lengkap : "") .
                $riwayatSectionDirect;

            return [
                'found' => true,
                'context_for_ai' => $contextForAi,
                'direct_response' => $directResponse,
            ];
        }

        // Jika pengguna mengetik format kode lengkap namun tidak ditemukan di DB
        if (!empty($potentialCode)) {
            return [
                'found' => false,
                'context_for_ai' => "\n[INFO SISTEM]: Pengguna mencari berkas dengan nomor '{$potentialCode}', namun data tidak ditemukan dalam database SIMTARU. Sampaikan dengan santun agar pemohon memeriksa kembali penulisan nomor registrasinya sesuai bukti tanda terima.",
                'direct_response' => "Nomor registrasi `{$potentialCode}` tidak ditemukan di database SIMTARU Kota Mataram. Mohon periksa kembali nomor registrasi yang tercantum pada tanda terima permohonan Anda.",
            ];
        }

        return [
            'found' => false,
            'context_for_ai' => '',
            'direct_response' => '',
        ];
    }

    /**
     * Menyamarkan nama untuk perlindungan privasi publik
     */
    protected function maskName(?string $name): string
    {
        if (empty($name)) {
            return 'Pemohon';
        }

        $words = explode(' ', trim($name));
        $maskedWords = [];

        foreach ($words as $word) {
            $len = mb_strlen($word);
            if ($len <= 2) {
                $maskedWords[] = $word;
            } else {
                $maskedWords[] = mb_substr($word, 0, 1) . str_repeat('*', $len - 2) . mb_substr($word, -1, 1);
            }
        }

        return implode(' ', $maskedWords);
    }
}
