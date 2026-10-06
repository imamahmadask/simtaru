<?php

namespace Tests\Feature;

use App\Livewire\Guest\ChatbotWidget;
use App\Models\Layanan;
use App\Models\Registrasi;
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
            ->assertSee('Asisten Virtual')
            ->assertSee('SIMTARU HARUM');
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

    public function test_database_tracking_masks_name_and_never_leaks_sensitive_personal_data()
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
        $result = $service->generateReply([], "cek berkas 0999-SKRK-10-2026");

        // Verifikasi bahwa permintaan yang dikirim ke AI memuat data publik tersensor dan TIDAK PERNAH memuat data rahasia
        Http::assertSent(function (Request $request) {
            $body = json_encode($request->data());

            // 1. Data publik terkirim ke konteks AI
            $hasPublicData = str_contains($body, '0999-SKRK-10-2026')
                && str_contains($body, 'Mataram Barat')
                && str_contains($body, 'A***d')
                && str_contains($body, 'S*****i');

            // 2. Data sensitif NIK, Nomor HP, Email, dan Nama Asli TIDAK PERNAH dikirim ke luar
            $noLeak = !str_contains($body, 'Ahmad Subandi')
                && !str_contains($body, '5271019998880001')
                && !str_contains($body, '081234567899')
                && !str_contains($body, 'ahmad.rahasia@pemerintah.id');

            return $hasPublicData && $noLeak;
        });

        $this->assertNotEmpty($result);
    }
}
