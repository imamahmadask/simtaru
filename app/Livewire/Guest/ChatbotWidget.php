<?php

namespace App\Livewire\Guest;

use App\Services\ChatbotService;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class ChatbotWidget extends Component
{
    public bool $isOpen = false;
    public string $inputMessage = '';
    public array $messages = [];
    public bool $isLoading = false;

    public function mount()
    {
        $this->messages = [
            [
                'role' => 'model',
                'content' => "Halo! 👋 Selamat datang di **SIMTARU Kota Mataram**.\n\nSaya adalah Asisten Virtual yang siap membantu Anda seputar:\n- Persyaratan & alur pengajuan dokumen (**SKRK, ITR, KKPR**)\n- Informasi tata ruang & zonasi Kota Mataram\n- Pengecekan status berkas permohonan Anda (ketikkan nomor registrasi Anda)\n\nAda yang dapat saya bantu hari ini?",
                'time' => now()->format('H:i'),
            ],
        ];
    }

    public function toggleChat()
    {
        $this->isOpen = !$this->isOpen;
        if ($this->isOpen) {
            $this->dispatch('scroll-chat-to-bottom');
        }
    }

    public function sendQuickPrompt(string $prompt)
    {
        $this->inputMessage = $prompt;
        $this->sendMessage();
    }

    public function sendMessage()
    {
        $userText = trim($this->inputMessage);
        if (empty($userText)) {
            return;
        }

        // 1. Validasi Keamanan: Pembatasan Panjang Teks (Max 500 Karakter)
        if (mb_strlen($userText) > 500) {
            $this->messages[] = [
                'role' => 'user',
                'content' => mb_substr($userText, 0, 100) . '...',
                'time' => now()->format('H:i'),
            ];
            $this->messages[] = [
                'role' => 'model',
                'content' => "⚠️ **Pesan Terlalu Panjang:** Demi keamanan dan efisiensi, mohon persingkat pertanyaan Anda (maksimal 500 karakter).",
                'time' => now()->format('H:i'),
            ];
            $this->inputMessage = '';
            $this->dispatch('scroll-chat-to-bottom');
            return;
        }

        // 2. Proteksi Rate Limiting (Mencegah Spam / DDoS API: Max 15 Pesan per Menit per IP)
        $throttleKey = 'chatbot-limiter:' . (request()->ip() ?? 'guest');
        if (RateLimiter::tooManyAttempts($throttleKey, 15)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->messages[] = [
                'role' => 'model',
                'content' => "⏳ **Mohon Menunggu:** Anda mengirimkan pesan terlalu cepat. Silakan tunggu **{$seconds} detik** sebelum mengirim pesan kembali.",
                'time' => now()->format('H:i'),
            ];
            $this->dispatch('scroll-chat-to-bottom');
            return;
        }
        RateLimiter::hit($throttleKey, 60);

        // 3. Simpan pesan user
        $this->messages[] = [
            'role' => 'user',
            'content' => $userText,
            'time' => now()->format('H:i'),
        ];

        // Batasi memori riwayat chat sesi (maksimal 20 percakapan terakhir)
        if (count($this->messages) > 20) {
            $this->messages = array_slice($this->messages, -20);
        }

        $this->inputMessage = '';
        $this->dispatch('scroll-chat-to-bottom');

        // 4. Panggil ChatbotService
        $service = app(ChatbotService::class);
        $reply = $service->generateReply($this->messages, $userText);

        // 5. Simpan respons asisten
        $this->messages[] = [
            'role' => 'model',
            'content' => $reply,
            'time' => now()->format('H:i'),
        ];

        $this->dispatch('scroll-chat-to-bottom');
    }

    public function resetChat()
    {
        $this->mount();
        $this->dispatch('scroll-chat-to-bottom');
    }

    public function render()
    {
        return view('livewire.guest.chatbot-widget');
    }
}
