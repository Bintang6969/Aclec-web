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

                <!-- Messages -->
                <div class="flex-grow-1 overflow-auto p-3" id="chatMessages" style="background:#f8f9fa;">
                    @if($messages->isEmpty())
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-chat-dots d-block mb-2" style="font-size:2rem; opacity:.3;"></i>
                        <p class="small">Halo! Saya FitBot. Tanyakan apa saja tentang kesehatan, diet, atau olahraga!</p>
                    </div>
                    @endif

                    @foreach($messages as $msg)
                    <div class="d-flex mb-3 {{ $msg->sender === 'user' ? 'justify-content-end' : 'justify-content-start' }}">
                        @if($msg->sender === 'ai')
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0"
                             style="width:32px; height:32px; font-size:.75rem; align-self:flex-end;">
                            <i class="bi bi-robot"></i>
                        </div>
                        @endif
                        <div class="rounded-4 px-3 py-2" style="max-width:75%; font-size:.88rem; white-space:pre-wrap;
                            {{ $msg->sender === 'user'
                                ? 'background:#2ecc71; color:#fff; border-bottom-right-radius:.25rem!important;'
                                : 'background:#fff; border:1px solid #dee2e6; border-bottom-left-radius:.25rem!important;' }}">
                            {{ $msg->message }}
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Input -->
                <div class="card-footer bg-white border-top p-3">
                    @if(session('error'))
                        <div class="alert alert-danger py-2 small mb-2">{{ session('error') }}</div>
                    @endif
                    <form method="POST" action="{{ route('consultation.send') }}" class="d-flex gap-2">
                        @csrf
                        <input type="text" name="message" required maxlength="500"
                               class="form-control rounded-pill" placeholder="Ketik pertanyaanmu..."
                               autofocus>
                        <button type="submit" class="btn btn-success rounded-pill px-4">
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto scroll to bottom of chat
    const chat = document.getElementById('chatMessages');
    if (chat) chat.scrollTop = chat.scrollHeight;
</script>
@endpush
