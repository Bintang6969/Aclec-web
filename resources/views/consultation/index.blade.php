@extends('layouts.app')
@section('title', 'Konsultasi FitBot')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4" style="height:calc(100vh - 140px); display:flex; flex-direction:column;">
                <!-- Header -->
                <div class="card-header bg-transparent border-bottom d-flex align-items-center gap-3 py-3">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width:38px; height:38px;">
                        <i class="bi bi-robot"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">FitBot AI</div>
                        <div class="text-muted" style="font-size:.75rem;">Didukung Gemini AI &bull; Siap 24/7</div>
                    </div>
                    <form method="POST" action="{{ route('consultation.clear') }}" class="ms-auto" onsubmit="return confirm('Hapus riwayat chat?')">
                        @csrf
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Hapus Chat</button>
                    </form>
                </div>

            <div>
                <div class="card-title" style="margin-bottom:0.8rem;font-family:'Playfair Display',serif;font-size:1.05rem;font-weight:700;color:var(--brown-dark)">
                    🤖 AI Mental Support
                </div>
                <div class="chat-wrap">
                    <div class="chat-header">
                        <div class="chat-ai-dot"></div>
                        <div>
                            <div style="font-weight:600;font-size:0.88rem">HealthyBot AI</div>
                            <div style="font-size:0.7rem;opacity:0.6">Asisten kesehatan & mental Anda</div>
                        </div>
                    </div>

                    <div class="chat-body" id="chat-body">
                        <div class="chat-msg">
                            <div class="msg-avatar ai-av">🤖</div>
                            <div class="msg-bubble ai">Halo! Saya HealthyBot 👋 Saya siap membantu perjalanan kesehatan kamu. Mau cerita soal apa hari ini?</div>
                        </div>
                    </div>

                    <div class="chat-input-wrap">
                        <input type="text" class="chat-input" id="chat-input" placeholder="Ketik pesan..." onkeypress="if(event.key==='Enter')sendChat()">
                        <button class="chat-send" onclick="sendChat()">➤</button>
                    </div>
                </div>
            </div>

        </div> </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto scroll to bottom of chat
    const chat = document.getElementById('chatMessages');
    if (chat) chat.scrollTop = chat.scrollHeight;
</script>
@endpush
