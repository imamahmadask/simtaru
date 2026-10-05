<div id="simtaru-chatbot-root">
    <style>
        .simtaru-chat-fab {
            position: fixed;
            bottom: 25px;
            right: 25px;
            z-index: 9999;
            box-shadow: 0 8px 24px rgba(13, 110, 253, 0.35);
            transition: all 0.3s ease;
        }

        .simtaru-chat-fab:hover {
            transform: scale(1.08);
            box-shadow: 0 12px 28px rgba(13, 110, 253, 0.45);
        }

        .simtaru-chat-window {
            position: fixed;
            bottom: 95px;
            right: 25px;
            width: 410px;
            max-width: calc(100vw - 30px);
            height: 580px;
            max-height: calc(100vh - 120px);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.18);
            border: 1px solid rgba(0, 0, 0, 0.08);
            background-color: #ffffff;
            animation: simtaruChatSlideUp 0.25s ease-out;
        }

        @keyframes simtaruChatSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Body Chat - TIDAK AKAN PERNAH SCROLL HORIZONTAL */
        .simtaru-chat-body {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden !important;
            padding: 14px;
            background-color: #f8fafc;
            scroll-behavior: smooth;
        }

        /* Bubble Chat */
        .simtaru-bubble {
            max-width: 88%;
            padding: 10px 14px;
            border-radius: 14px;
            font-size: 0.86rem;
            line-height: 1.5;
            position: relative;
            word-wrap: break-word !important;
            word-break: break-word !important;
            overflow-wrap: break-word !important;
            box-sizing: border-box;
        }

        .simtaru-bubble p:last-child {
            margin-bottom: 0;
        }

        .simtaru-bubble-model {
            max-width: 96% !important;
            background-color: #ffffff;
            color: #1e293b;
            border: 1px solid #e2e8f0;
            border-top-left-radius: 4px;
        }

        .simtaru-bubble-user {
            background-color: #0d6efd;
            color: #ffffff;
            border-top-right-radius: 4px;
        }

        .simtaru-bubble-user code {
            background-color: rgba(255,255,255,0.2);
            color: #ffffff;
        }

        /* Markdown Styling Khusus Tampilan Compact */
        .simtaru-content {
            font-size: 0.86rem;
            line-height: 1.5;
            color: #1e293b;
        }

        .simtaru-content h1,
        .simtaru-content h2,
        .simtaru-content h3,
        .simtaru-content h4 {
            font-size: 0.95rem !important;
            font-weight: 700 !important;
            margin-top: 12px !important;
            margin-bottom: 6px !important;
            line-height: 1.35 !important;
            color: #0f172a !important;
        }

        .simtaru-content hr {
            margin: 10px 0 !important;
            border: 0;
            border-top: 1px solid #e2e8f0;
            opacity: 1;
        }

        .simtaru-content p {
            margin-bottom: 6px !important;
        }

        .simtaru-content ul, .simtaru-content ol {
            padding-left: 18px !important;
            margin-bottom: 6px !important;
        }

        .simtaru-content li {
            margin-bottom: 3px !important;
        }

        .simtaru-content code {
            background-color: #f1f5f9;
            color: #0d6efd;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.82rem;
            font-family: monospace;
        }

        .simtaru-content blockquote {
            border-left: 3px solid #0d6efd;
            padding-left: 8px;
            margin: 8px 0;
            color: #64748b;
            font-style: italic;
            font-size: 0.82rem;
        }

        /* TABEL RESPONSIF AGAR RAPI DAN TIDAK MELEWATI BATAS */
        .simtaru-content table {
            width: 100% !important;
            max-width: 100% !important;
            display: block !important;
            overflow-x: auto !important;
            border-collapse: collapse !important;
            font-size: 0.76rem !important;
            margin: 8px 0 !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            background: #ffffff !important;
            white-space: nowrap !important;
            -webkit-overflow-scrolling: touch;
        }

        .simtaru-content table::-webkit-scrollbar {
            height: 4px;
        }

        .simtaru-content table::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .simtaru-content table th {
            background-color: #f1f5f9 !important;
            color: #334155 !important;
            font-weight: 600 !important;
            padding: 6px 8px !important;
            border: 1px solid #e2e8f0 !important;
            text-align: left !important;
        }

        .simtaru-content table td {
            padding: 6px 8px !important;
            border: 1px solid #e2e8f0 !important;
            color: #475569 !important;
            vertical-align: top !important;
        }

        .simtaru-content table tr:nth-child(even) td {
            background-color: #f8fafc !important;
        }

        /* PILLS SCROLL CONTAINER */
        .simtaru-pills-wrapper {
            position: relative;
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 6px 4px;
            display: flex;
            align-items: center;
        }

        .simtaru-pills-bar {
            display: flex;
            gap: 6px;
            overflow-x: auto;
            scroll-behavior: smooth;
            white-space: nowrap;
            padding: 2px 4px;
            cursor: grab;
            user-select: none;
            scrollbar-width: thin;
        }

        .simtaru-pills-bar::-webkit-scrollbar {
            height: 3px;
        }

        .simtaru-pills-bar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .simtaru-pill-btn {
            font-size: 0.76rem;
            white-space: nowrap;
            border-radius: 20px;
            padding: 4px 10px;
            transition: all 0.2s;
            cursor: pointer;
            flex-shrink: 0;
        }

        .simtaru-pill-btn:hover {
            transform: translateY(-1px);
        }

        .simtaru-scroll-arrow {
            width: 24px;
            height: 24px;
            min-width: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            color: #475569;
            box-shadow: 0 2px 4px rgba(0,0,0,0.06);
            transition: all 0.2s;
            z-index: 2;
            cursor: pointer;
        }

        .simtaru-scroll-arrow:hover {
            background-color: #0d6efd;
            color: #ffffff;
            border-color: #0d6efd;
        }

        /* Typing Dots Animation */
        .typing-dots span {
            display: inline-block;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: #0d6efd;
            animation: simtaruBounce 1.4s infinite ease-in-out both;
        }
        .typing-dots span:nth-child(1) { animation-delay: -0.32s; }
        .typing-dots span:nth-child(2) { animation-delay: -0.16s; }
        @keyframes simtaruBounce {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1); }
        }
    </style>

    <!-- Floating Action Button -->
    <button wire:click="toggleChat" type="button" 
        class="btn btn-primary rounded-circle p-0 simtaru-chat-fab d-flex align-items-center justify-content-center"
        style="width: 58px; height: 58px;"
        aria-label="Tanya Asisten AI SIMTARU"
        title="Konsultasi Tata Ruang & Cek Berkas">
        @if($isOpen)
            <i class="bi bi-x-lg fs-4 text-white"></i>
        @else
            <i class="bi bi-chat-dots-fill fs-4 text-white"></i>
        @endif
    </button>

    <!-- Chat Window Container -->
    @if($isOpen)
        <div class="simtaru-chat-window">
            <!-- Header -->
            <div class="bg-primary text-white px-3 py-2 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-white rounded-circle p-1 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <img src="{{ asset('assets/img/favicon/fav.svg') }}" alt="Logo" width="22" onerror="this.src='{{ asset('assets/img/logo/simtaru2.png') }}'">
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold fs-6">Asisten AI SIMTARU</h6>
                        <small class="text-white-50" style="font-size: 0.72rem;">
                            <span class="d-inline-block rounded-circle bg-success me-1" style="width: 7px; height: 7px;"></span>
                            DPUPR Kota Mataram • Online
                        </small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-1">
                    <button wire:click="resetChat" class="btn btn-sm text-white-50 hover-white p-1" title="Mulai ulang chat">
                        <i class="bi bi-arrow-counterclockwise fs-6"></i>
                    </button>
                    <button wire:click="toggleChat" class="btn btn-sm text-white-50 hover-white p-1" title="Tutup">
                        <i class="bi bi-dash-lg fs-5"></i>
                    </button>
                </div>
            </div>

            <!-- Quick Action Recommendations (Pills dengan Scroll Horizontal & Tombol Panah) -->
            <div class="simtaru-pills-wrapper">
                <button type="button" id="simtaru-pill-prev" class="simtaru-scroll-arrow me-1" title="Geser ke kiri">
                    <i class="bi bi-chevron-left" style="font-size: 0.7rem;"></i>
                </button>

                <div id="simtaru-pills-bar" class="simtaru-pills-bar">
                    <button wire:click="sendQuickPrompt('Apa saja syarat pengajuan SKRK?')" class="btn btn-outline-primary btn-sm simtaru-pill-btn">
                        📋 Syarat SKRK
                    </button>
                    <button wire:click="sendQuickPrompt('Bagaimana prosedur dan syarat ITR?')" class="btn btn-outline-success btn-sm simtaru-pill-btn">
                        🌿 Syarat ITR
                    </button>
                    <button wire:click="sendQuickPrompt('Apa itu KKPR Non-Berusaha?')" class="btn btn-outline-info btn-sm simtaru-pill-btn">
                        🏛️ KKPR Non-Berusaha
                    </button>
                    <button wire:click="sendQuickPrompt('Bagaimana cara mengecek riwayat berkas permohonan saya?')" class="btn btn-outline-secondary btn-sm simtaru-pill-btn">
                        🔍 Lacak Berkas
                    </button>
                    <button wire:click="sendQuickPrompt('Jelaskan batas garis sempadan sungai di Kota Mataram')" class="btn btn-outline-warning btn-sm simtaru-pill-btn text-dark">
                        🌊 Sempadan Sungai
                    </button>
                </div>

                <button type="button" id="simtaru-pill-next" class="simtaru-scroll-arrow ms-1" title="Geser ke kanan">
                    <i class="bi bi-chevron-right" style="font-size: 0.7rem;"></i>
                </button>
            </div>

            <!-- Chat Messages Body -->
            <div id="simtaru-chat-container" class="simtaru-chat-body">
                @foreach($messages as $index => $msg)
                    @if($msg['role'] === 'user')
                        <div class="d-flex justify-content-end mb-3">
                            <div class="simtaru-bubble simtaru-bubble-user shadow-sm">
                                <div>{!! nl2br(e($msg['content'])) !!}</div>
                                <div class="text-end text-white-50 mt-1" style="font-size: 0.68rem;">{{ $msg['time'] ?? '' }}</div>
                            </div>
                        </div>
                    @else
                        <div class="d-flex justify-content-start mb-3">
                            <div class="simtaru-bubble simtaru-bubble-model shadow-sm">
                                <div class="simtaru-content">
                                    {!! \Illuminate\Support\Str::markdown($msg['content']) !!}
                                </div>
                                <div class="text-end text-muted mt-1" style="font-size: 0.68rem;">{{ $msg['time'] ?? '' }}</div>
                            </div>
                        </div>
                    @endif
                @endforeach

                <!-- Typing / Loading Indicator -->
                <div wire:loading wire:target="sendMessage, sendQuickPrompt" class="mb-3">
                    <div class="simtaru-bubble simtaru-bubble-model shadow-sm d-inline-block">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted" style="font-size: 0.8rem;">Asisten sedang mengetik</span>
                            <div class="typing-dots d-inline-flex gap-1">
                                <span></span><span></span><span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer / Input Form -->
            <div class="p-2 bg-white border-top">
                <form wire:submit="sendMessage" class="d-flex gap-2 align-items-center">
                    <input type="text" 
                        id="simtaru-chat-input"
                        wire:model="inputMessage" 
                        placeholder="Ketik pertanyaan atau nomor registrasi..." 
                        class="form-control form-control-sm rounded-pill px-3 py-2 border" 
                        style="font-size: 0.86rem;"
                        wire:loading.attr="disabled"
                        wire:target="sendMessage, sendQuickPrompt">
                    <button type="submit" 
                        class="btn btn-primary rounded-circle p-0 d-flex align-items-center justify-content-center flex-shrink-0" 
                        style="width: 38px; height: 38px;"
                        wire:loading.attr="disabled"
                        wire:target="sendMessage, sendQuickPrompt">
                        <i class="bi bi-send-fill text-white" style="font-size: 0.85rem; transform: translateX(1px);"></i>
                    </button>
                </form>
                <div class="text-center mt-1">
                    <small class="text-muted" style="font-size: 0.65rem;">
                        SIMTARU AI dapat membuat kekeliruan. Verifikasi informasi penting ke DPUPR Mataram.
                    </small>
                </div>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('livewire:initialized', () => {
            const scrollToBottom = () => {
                const container = document.getElementById('simtaru-chat-container');
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            };

            Livewire.on('scroll-chat-to-bottom', () => {
                setTimeout(() => {
                    scrollToBottom();
                    const chatInput = document.getElementById('simtaru-chat-input');
                    if (chatInput) {
                        chatInput.focus();
                    }
                }, 60);
            });

            // Inisialisasi Kontrol Scroll Horizontal Pills
            const initPillsControl = () => {
                const pillsBar = document.getElementById('simtaru-pills-bar');
                const btnPrev = document.getElementById('simtaru-pill-prev');
                const btnNext = document.getElementById('simtaru-pill-next');

                if (!pillsBar) return;

                // 1. Klik tombol panah kiri / kanan
                if (btnPrev) {
                    btnPrev.onclick = (e) => {
                        e.preventDefault();
                        pillsBar.scrollBy({ left: -150, behavior: 'smooth' });
                    };
                }
                if (btnNext) {
                    btnNext.onclick = (e) => {
                        e.preventDefault();
                        pillsBar.scrollBy({ left: 150, behavior: 'smooth' });
                    };
                }

                // 2. Putar scroll mouse vertical jadi scroll horizontal pada pills
                pillsBar.onwheel = (e) => {
                    if (e.deltaY !== 0) {
                        e.preventDefault();
                        pillsBar.scrollLeft += e.deltaY;
                    }
                };

                // 3. Drag to scroll (klik dan tarik dengan mouse)
                let isDown = false;
                let startX, scrollLeft;

                pillsBar.onmousedown = (e) => {
                    isDown = true;
                    pillsBar.style.cursor = 'grabbing';
                    startX = e.pageX - pillsBar.offsetLeft;
                    scrollLeft = pillsBar.scrollLeft;
                };

                pillsBar.onmouseleave = () => {
                    isDown = false;
                    pillsBar.style.cursor = 'grab';
                };

                pillsBar.onmouseup = () => {
                    isDown = false;
                    pillsBar.style.cursor = 'grab';
                };

                pillsBar.onmousemove = (e) => {
                    if (!isDown) return;
                    e.preventDefault();
                    const x = e.pageX - pillsBar.offsetLeft;
                    const walk = (x - startX) * 1.5;
                    pillsBar.scrollLeft = scrollLeft - walk;
                };
            };

            // Jalankan saat pertama kali dan saat Livewire update DOM
            initPillsControl();
            Livewire.hook('morph.updated', () => {
                setTimeout(initPillsControl, 50);
            });
        });
    </script>
</div>
