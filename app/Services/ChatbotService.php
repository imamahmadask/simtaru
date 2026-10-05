<?php

namespace App\Services;

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
            return "Silakan ketikkan pertanyaan seputar tata ruang atau sebutkan nomor registrasi permohonan Anda.";
        }

        // 1. Periksa apakah pengguna menanyakan status nomor registrasi ke database SIMTARU
        $trackingResult = $this->checkRegistrationStatus($cleanMessage);

        // 2. Jika API Key Groq dan Gemini belum diset
        if (empty($this->groqApiKey) && empty($this->geminiApiKey)) {
            if ($trackingResult['found']) {
                return $trackingResult['direct_response'];
            }

            return "Halo! Saya adalah **Asisten AI SIMTARU Kota Mataram**.\n\n" .
                "Sistem telah dikonfigurasi untuk menggunakan **Groq Cloud (LPU)**. Kunci API belum ditambahkan pada file `.env` (`GROQ_API_KEY`).\n\n" .
                "👉 Dapatkan API key gratis dalam 30 detik di [console.groq.com/keys](https://console.groq.com/keys).\n\n" .
                "💡 **Fitur Lacak Berkas Tetap Aktif:** Anda dapat langsung mengetikkan nomor registrasi permohonan Anda (contoh: `0196-ITR-09-2026`) untuk memeriksa status berkas dari database SIMTARU.";
        }

        // 3. Muat Dokumen Pengetahuan Resmi (Knowledge Base)
        $knowledgePath = resource_path('data/knowledge_simtaru.md');
        $knowledge = File::exists($knowledgePath) ? File::get($knowledgePath) : 'Pengetahuan tata ruang Kota Mataram mencakup layanan SKRK, ITR, KKPR-B, dan KKPR-NB.';

        // 4. Susun System Prompt
        $systemInstruction = <<<INSTRUCTION
Anda adalah "Asisten AI SIMTARU Kota Mataram", perwakilan resmi dari Dinas Pekerjaan Umum dan Penataan Ruang (DPUPR) Kota Mataram.

PERAN & TUGAS UTAMA:
1. Memberikan informasi dan panduan akurat mengenai pelayanan tata ruang:
   - SKRK (Surat Keterangan Rencana Kota) - 20 Hari Kerja, Gratis, Map Kuning rangkap 2.
   - ITR (Informasi Tata Ruang) - 14 Hari Kerja, Gratis, Map Hijau.
   - KKPR Non-Berusaha - 24 Hari Kerja, PNBP, Map Kuning rangkap 2.
   - KKPR Berusaha - Melalui sistem OSS RBA & verifikasi teknis daerah, Map Kuning.
2. Membantu warga memahami alur pendaftaran, persyaratan berkas, ketentuan zonasi wilayah 6 kecamatan di Kota Mataram, serta garis sempadan sungai (Jangkok, Ancar, Meninting) dan sempadan pantai.
3. KONEKSI DATABASE REAL-TIME:
   Jika pada bagian bawah instruksi terdapat data [DATA STATUS & RIWAYAT PERMOHONAN DARI DATABASE SIMTARU], Anda WAJIB menyampaikan data tersebut secara transparan dan detail kepada pemohon:
   - Sebutkan Nomor Registrasi, Pemohon (gunakan nama tersensor yang diberikan), dan Jenis Layanan.
   - Sajikan Runtutan Kronologi / Riwayat Perjalanan Berkas dari awal pendaftaran hingga tahapan saat ini lengkap dengan tanggal dan keterangan petugasnya.
   - Jelaskan posisi tahapan berkas saat ini dan petugas yang menangani.
   - Jika terdapat catatan kekurangan berkas, ingatkan pemohon secara tegas dan sopan untuk segera memperbaikinya.
4. PANDUAN FORMAT TAMPILAN COMPACT:
   - Jendela obrolan berukuran ringkas (compact chat widget).
   - DILARANG menggunakan heading besar (# atau ##). Gunakan teks tebal seperti **1. Tahapan Saat Ini** atau heading kecil ###.
   - Sajikan rincian tahapan/riwayat dalam bentuk daftar berbutir (bullet points) atau tabel ramping 2-3 kolom agar pas di layar tanpa terpotong.
5. Gunakan gaya bahasa resmi, ramah, santun, dan mudah dimengerti.
6. Jika pengguna hanya bertanya cara cek berkas tanpa menyebut nomor, berikan contoh nomor registrasi (seperti `0196-ITR-09-2026`) dan minta mereka mengetikkan nomornya.
7. Berikan catatan bahwa informasi ini adalah asistensi awal, dan penetapan izin sah tetap merujuk pada dokumen resmi yang ditandatangani pejabat berwenang DPUPR Kota Mataram.

REFERENSI PENGETAHUAN RESMI SIMTARU:
{$knowledge}

{$trackingResult['context_for_ai']}
INSTRUCTION;

        // 5. Coba panggil Groq Cloud (Prioritas Utama: Sangat Cepat & Bebas Antrean)
        if (!empty($this->groqApiKey)) {
            $groqReply = $this->callGroqApi($systemInstruction, $chatHistory, $cleanMessage);
            if (!empty($groqReply)) {
                return $groqReply;
            }
        }

        // 6. Cadangan Sekunder: Jika Groq bermasalah, gunakan Gemini
        if (!empty($this->geminiApiKey)) {
            $geminiReply = $this->callGeminiApi($systemInstruction, $chatHistory, $cleanMessage);
            if (!empty($geminiReply)) {
                return $geminiReply;
            }
        }

        // 7. Fallback jika semua API AI mengalami kendala
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

        // Format history
        foreach ($chatHistory as $item) {
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
                    'temperature' => 0.3,
                    'max_tokens' => 1500,
                ]);

                if ($response->successful()) {
                    $reply = $response->json('choices.0.message.content');
                    if (!empty($reply)) {
                        return $reply;
                    }
                }

                $status = $response->status();
                Log::warning("Groq API Error with model [{$targetModel}] (HTTP {$status}): " . $response->body());

                if (in_array($status, [404, 429, 500, 503])) {
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
        foreach ($chatHistory as $item) {
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
            'gemini-3.8-flash',
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
                        'temperature' => 0.3,
                        'maxOutputTokens' => 1200,
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
     * Memeriksa keberadaan kode registrasi dari input pengguna dan memuat riwayat berkas lengkap
     */
    protected function checkRegistrationStatus(string $message): array
    {
        $registrasi = null;
        $potentialCode = null;

        // 1. Pola kode lengkap SIMTARU: 0196-ITR-09-2026, 0197-KKPRNB-09-2026, REG-xxxx, dsb.
        if (preg_match('/([0-9]{2,5}[-_][A-Za-z0-9]+[-_][0-9]{1,2}[-_][0-9]{2,4}|REG[-_A-Za-z0-9]+|[0-9]{4,}[-_][0-9]+)/i', $message, $matches)) {
            $potentialCode = trim($matches[0]);
            $registrasi = Registrasi::with([
                'layanan',
                'riwayat.user',
                'permohonan.disposisi.tahapan',
                'permohonan.disposisi.penerima'
            ])
            ->where('kode', $potentialCode)
            ->first();
        }

        // 2. Jika belum ditemukan, coba deteksi nomor urut registrasi (misal: "0196" atau "196")
        if (!$registrasi && preg_match('/\b([0-9]{3,5})\b/', $message, $numMatches)) {
            $num = trim($numMatches[1]);
            $padded = str_pad($num, 4, '0', STR_PAD_LEFT);
            $potentialCode = $num;

            $registrasi = Registrasi::with([
                'layanan',
                'riwayat.user',
                'permohonan.disposisi.tahapan',
                'permohonan.disposisi.penerima'
            ])
            ->where('kode', 'like', "{$padded}-%")
            ->orWhere('kode', 'like', "{$num}-%")
            ->orWhere('kode', 'like', "%{$num}%")
            ->first();
        }

        if ($registrasi) {
            // Sensor nama pemohon untuk keamanan privasi (contoh: "Ahmad" -> "A***d")
            $maskedName = $this->maskName($registrasi->nama);

            // Riwayat pergerakan berkas
            $riwayatList = [];
            $riwayats = $registrasi->riwayat->sortBy('created_at');
            foreach ($riwayats as $r) {
                $petugas = $r->user->name ?? 'Petugas Loket/Admin';
                $waktu = $r->created_at ? $r->created_at->format('d/m/Y H:i') : '-';
                $riwayatList[] = "- **[{$waktu}]** {$r->keterangan} *(Oleh: {$petugas})*";
            }
            $riwayatStr = count($riwayatList) > 0 ? implode("\n", $riwayatList) : "- Berkas baru terdaftar di sistem SIMTARU.";

            // Disposisi teknis & tahapan saat ini
            $disposisiList = [];
            $currentStage = 'Verifikasi Berkas Administrasi';
            if ($registrasi->permohonan && $registrasi->permohonan->disposisi->count() > 0) {
                foreach ($registrasi->permohonan->disposisi as $disp) {
                    $tahapan = $disp->tahapan->nama ?? 'Pemeriksaan Teknis';
                    $penerima = $disp->penerima->name ?? 'Tim Teknis Tata Ruang';
                    $statusDisp = $disp->is_done ? 'Selesai' : ($disp->status ?? 'Sedang Berjalan');
                    $disposisiList[] = "- Tahapan: **{$tahapan}** | Status: **{$statusDisp}** | Petugas Analis: {$penerima}";
                    if (!$disp->is_done) {
                        $currentStage = $tahapan;
                    }
                }
            }

            $disposisiStr = count($disposisiList) > 0 ? implode("\n", $disposisiList) : "- Berkas dalam antrean disposisi tim teknis.";

            $catatan = !empty($registrasi->alasan_tidak_lengkap)
                ? "⚠️ CATATAN KEKURANGAN: " . $registrasi->alasan_tidak_lengkap
                : "✅ Berkas administrasi lengkap / tidak ada catatan kekurangan.";

            $statusText = !empty($registrasi->status) ? $registrasi->status : 'Dalam Proses (' . $currentStage . ')';

            $tglDaftar = $registrasi->created_at ? $registrasi->created_at->format('d F Y H:i') : ($registrasi->tanggal ?? '-');

            $contextForAi = <<<CTX

[DATA STATUS & RIWAYAT PERMOHONAN DARI DATABASE SIMTARU]
- Nomor Registrasi: {$registrasi->kode}
- Nama Pemohon: {$maskedName}
- Jenis Layanan: {$registrasi->layanan->nama}
- Tanggal Registrasi: {$tglDaftar}
- Lokasi Permohonan: Kelurahan {$registrasi->kel_tanah}, Kecamatan {$registrasi->kec_tanah}
- Tahapan Saat Ini: {$currentStage}
- Status Berkas: {$statusText}
- Catatan Petugas: {$catatan}

- Kronologi / Riwayat Perjalanan Berkas:
{$riwayatStr}

- Informasi Disposisi Teknis:
{$disposisiStr}

INSTRUKSI KHUSUS UNTUK DATA INI:
Sampaikan informasi di atas dengan ramah, rapi, dan terstruktur kepada pemohon. Rincikan tanggal dan setiap tahapan yang sudah dilewati hingga posisi berkas saat ini. Jika ada catatan kekurangan berkas, ingatkan pemohon untuk segera melengkapinya.
CTX;

            $directResponse = "Berikut adalah riwayat berkas permohonan Anda di SIMTARU Kota Mataram:\n\n" .
                "📋 **Nomor Registrasi:** `{$registrasi->kode}`\n" .
                "👤 **Nama Pemohon:** {$maskedName}\n" .
                "📂 **Layanan:** " . ($registrasi->layanan->nama ?? '-') . "\n" .
                "📍 **Lokasi:** Kel. " . ($registrasi->kel_tanah ?? '-') . ", Kec. " . ($registrasi->kec_tanah ?? '-') . "\n" .
                "⏳ **Tahapan Saat Ini:** **{$currentStage}**\n" .
                "📌 **Status:** **{$statusText}**\n\n" .
                (!empty($registrasi->alasan_tidak_lengkap) ? "⚠️ **Catatan Petugas:** " . $registrasi->alasan_tidak_lengkap . "\n\n" : "") .
                "📜 **Kronologi Riwayat Berkas:**\n" . $riwayatStr;

            return [
                'found' => true,
                'context_for_ai' => $contextForAi,
                'direct_response' => $directResponse,
            ];
        }

        // Jika pengguna mencoba mengetik kode tapi tidak ditemukan di DB
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
