<?php

namespace Tests\Feature;

use App\Livewire\Guest\ChatbotWidget;
use App\Models\Layanan;
use App\Models\Pelanggaran;
use App\Models\Registrasi;
use App\Models\RiwayatPermohonan;
use App\Services\ChatbotService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;
use Tests\TestCase;

class ChatbotFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Http::fake([
            'https://api.groq.com/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'Jawaban simulasi asisten AI SIMTARU Kota Mataram.',
                        ],
                    ],
                ],
            ], 200),
            'https://generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => 'Jawaban simulasi asisten AI SIMTARU Kota Mataram.'],
                            ],
                        ],
                    ],
                ],
            ], 200),
        ]);
    }

    public function test_chatbot_widget_renders_successfully()
    {
        Livewire::test(ChatbotWidget::class)
            ->set('isOpen', true)
            ->assertSee('Asisten AI SIMTARU HARUM');
    }

    public function test_chatbot_toggle_open_and_close()
    {
        Livewire::test(ChatbotWidget::class)
            ->assertSet('isOpen', false)
            ->call('toggleChat')
            ->assertSet('isOpen', true)
            ->call('toggleChat')
            ->assertSet('isOpen', false);
    }

    public function test_chatbot_rejects_excessively_long_messages()
    {
        $longMessage = str_repeat('pertanyaan tentang tata ruang ', 30); // > 500 chars

        Livewire::test(ChatbotWidget::class)
            ->set('isOpen', true)
            ->set('inputMessage', $longMessage)
            ->call('sendMessage')
            ->assertSee('Pesan Terlalu Panjang');
    }

    public function test_chatbot_rate_limiting_protects_against_spam()
    {
        RateLimiter::clear('chatbot-limiter:127.0.0.1');
        RateLimiter::clear('chatbot-daily:127.0.0.1');

        $component = Livewire::test(ChatbotWidget::class)
            ->set('isOpen', true);

        // Kirim hingga 15 pesan
        for ($i = 1; $i <= 15; $i++) {
            $component->set('inputMessage', 'Pertanyaan ke-' . $i)->call('sendMessage');
        }

        // Pesan ke-16 harus memicu throttle per menit
        $component->set('inputMessage', 'Pertanyaan ke-16')
            ->call('sendMessage')
            ->assertSee('Anda mengirimkan pesan terlalu cepat');
    }

    public function test_chatbot_daily_rate_limiting_protects_against_abuse()
    {
        RateLimiter::clear('chatbot-limiter:127.0.0.1');
        RateLimiter::clear('chatbot-daily:127.0.0.1');

        $component = Livewire::test(ChatbotWidget::class)
            ->set('isOpen', true);

        // Simulasikan batas kuota 50 pesan harian tercapai
        for ($i = 1; $i <= 50; $i++) {
            RateLimiter::hit('chatbot-daily:127.0.0.1', 86400);
        }

        // Pesan ke-51 harus diblokir oleh limit harian
        $component->set('inputMessage', 'Pertanyaan ke-51')
            ->call('sendMessage')
            ->assertSee('Batas Kuota Harian Tercapai')
            ->assertSee('50 pesan per hari');
    }

    public function test_database_tracking_masks_name_and_omits_history_unless_requested()
    {
        $layanan = Layanan::create([
            'nama' => 'Surat Keterangan Rencana Kota',
            'kode' => 'SKRK',
            'keterangan' => 'Layanan SKRK',
        ]);

        $reg = Registrasi::create([
            'kode' => '0999-SKRK-10-2026',
            'nama' => 'Ahmad Subandi',
            'nik' => '5271019998880001',
            'no_hp' => '081234567899',
            'email' => 'ahmad.rahasia@pemerintah.id',
            'fungsi_bangunan' => 'Hunian Tunggal',
            'tanggal' => now()->toDateString(),
            'layanan_id' => $layanan->id,
            'kel_tanah' => 'Mataram Barat',
            'kec_tanah' => 'Selaparang',
            'status' => 'Verifikasi Berkas',
        ]);

        $service = app(ChatbotService::class);

        // 1. Cek status biasa tanpa meminta riwayat -> TIDAK BOLEH menyertakan Kronologi / Riwayat Perjalanan Berkas
        $result = $service->generateReply([], "cek status 0999-SKRK-10-2026");

        Http::assertSent(function (Request $request) {
            $body = json_encode($request->data(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

            $hasPublicData = str_contains($body, '0999-SKRK-10-2026')
                && str_contains($body, 'Mataram Barat')
                && str_contains($body, 'A***d')
                && str_contains($body, 'S*****i');

            $noLeak = !str_contains($body, 'Ahmad Subandi')
                && !str_contains($body, '5271019998880001')
                && !str_contains($body, '081234567899')
                && !str_contains($body, 'ahmad.rahasia@pemerintah.id');

            $noHistoryWhenNotAsked = !str_contains($body, 'Kronologi / Riwayat Perjalanan Berkas:');

            return $hasPublicData && $noLeak && $noHistoryWhenNotAsked;
        });

        $this->assertNotEmpty($result);
    }

    public function test_pelanggaran_question_with_year_2026_never_triggers_berkas_lookup()
    {
        $layanan = Layanan::create([
            'nama' => 'KKPR Non-Berusaha',
            'kode' => 'KKPRNB',
            'keterangan' => 'Layanan KKPRNB',
        ]);

        // Buat berkas tahun 2026 yang sebelumnya sempat terpicu salah (false-positive) karena angka "2026"
        Registrasi::create([
            'kode' => '0001-KKPRNB-01-2026',
            'nama' => 'Ridwan Hadi',
            'nik' => '5271010001110002',
            'no_hp' => '081111222333',
            'email' => 'ridwan@example.com',
            'fungsi_bangunan' => 'Rumah Tinggal',
            'tanggal' => '2026-01-05',
            'layanan_id' => $layanan->id,
            'kel_tanah' => 'Pagesangan',
            'kec_tanah' => 'Mataram',
            'status' => 'Penerbitan Dokumen',
        ]);

        // Buat data kasus pelanggaran tahun 2026
        Pelanggaran::create([
            'no_pelanggaran' => 'PLG-001-2026',
            'tgl_laporan' => '2026-02-10',
            'sumber_informasi_pelanggaran' => 'Hasil Pengawasan dan Pemantauan',
            'nama_pelanggar' => 'Pelanggar Rahasia',
            'alamat_pelanggar' => 'Jl. Rahasia No. 1',
            'kel_pelanggar' => 'Kekalik Jaya',
            'kec_pelanggar' => 'Sekarbela',
            'kota_pelanggar' => 'Mataram',
            'prov_pelanggar' => 'NTB',
            'alamat_pelanggaran' => 'Jl. Pelanggaran No. 2',
            'kel_pelanggaran' => 'Kekalik Jaya',
            'kec_pelanggaran' => 'Sekarbela',
            'koordinat_pelanggaran' => '-8.5833, 116.1167',
            'status' => 'Selesai',
            'jenis_indikasi_pelanggaran' => 'Tidak Memiliki KKPR atau SKRK',
            'temuan_pelanggaran' => 'Ada Pelanggaran',
        ]);

        $service = app(ChatbotService::class);
        $reply = $service->generateReply([], "sudah berapa kasus pelanggaran di kota mataram tahun 2026");

        Http::assertSent(function (Request $request) {
            $body = json_encode($request->data(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

            // Harus memuat data statistik pelanggaran tahun 2026
            $hasPelanggaranStats = str_contains($body, 'DATA STATISTIK PELANGGARAN TATA RUANG')
                && str_contains($body, 'Kecamatan Sekarbela')
                && str_contains($body, 'Tidak Memiliki KKPR atau SKRK');

            // DILARANG KERAS memuat nomor berkas 0001-KKPRNB-01-2026, nomor pelanggaran, atau nama pelanggar
            $noBerkasOrPersonalLeak = !str_contains($body, '0001-KKPRNB-01-2026')
                && !str_contains($body, 'R****n H**i')
                && !str_contains($body, 'PLG-001-2026')
                && !str_contains($body, 'Pelanggar Rahasia');

            return $hasPelanggaranStats && $noBerkasOrPersonalLeak;
        });

        $this->assertNotEmpty($reply);
    }

    public function test_chatbot_knowledge_base_includes_all_six_regulatory_documents()
    {
        $service = app(ChatbotService::class);
        $reply = $service->generateReply([], "Jelaskan dasar hukum KKPR, LSD, RTRW, dan RDTR Kota Mataram");

        Http::assertSent(function (Request $request) {
            $body = json_encode($request->data(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

            return str_contains($body, 'Nomor 21 Tahun 2021')
                && str_contains($body, 'Nomor 28 Tahun 2025')
                && str_contains($body, '6/Juknis-PF.01/VIII/2023')
                && str_contains($body, '978,06 Ha')
                && str_contains($body, 'Nomor 5 Tahun 2019')
                && str_contains($body, 'Nomor 19 Tahun 2024');
        });

        $this->assertNotEmpty($reply);
    }

    public function test_chatbot_system_instruction_enforces_pupr_kota_mataram_domain()
    {
        $service = app(ChatbotService::class);
        $reply = $service->generateReply([], "Apa saja tugas dan layanan tata ruang?");

        Http::assertSent(function (Request $request) {
            $body = json_encode($request->data(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

            return str_contains($body, 'BATASAN DOMAIN KHUSUS (PUPR KOTA MATARAM)')
                && str_contains($body, 'Pekerjaan Umum dan Penataan Ruang (PUPR) di Kota Mataram')
                && str_contains($body, 'Batasan Domain Khusus PUPR Kota Mataram')
                && str_contains($body, 'TIDAK BOLEH keluar dari koridor tersebut');
        });

        $this->assertNotEmpty($reply);
    }

    public function test_chatbot_knowledge_base_covers_rumah_kos_zoning_rules_in_perwal_19_2024()
    {
        $service = app(ChatbotService::class);
        $reply = $service->generateReply([], "Boleh ga rumah kos dibangun di zona perumahan kepadatan tinggi?");

        Http::assertSent(function (Request $request) {
            $body = json_encode($request->data(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

            return str_contains($body, 'rumah kos')
                && str_contains($body, 'Sub-Zona Perumahan Kepadatan Tinggi (R-2)')
                && str_contains($body, 'berstatus X (TIDAK DIPERBOLEHKAN / DILARANG)')
                && str_contains($body, 'Perumahan Kepadatan Sedang (R-3)')
                && str_contains($body, 'T1, B1, B2');
        });

        $this->assertNotEmpty($reply);
    }
}

