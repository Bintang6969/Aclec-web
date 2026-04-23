{{-- ═══ KONSULTASI AI SECTION ═══ --}}
<div class="grid-2">

  {{-- Left: Doctor List + Appointment --}}
  <div>
    <div class="card" style="margin-bottom:1rem">
      <div class="card-header">
        <div class="card-title">Konsultasi Dokter</div>
        <span class="badge badge-green">3 Online</span>
      </div>

      @php
        $doctors = [
          ['👨‍⚕️', 'dr. Ahmad Fauzi, Sp.GK',  'Gizi Klinik · Nutrisi Olahraga',    'online',  'rgba(192,57,43,0.1)'],
          ['👩‍⚕️', 'dr. Sari Dewi, M.Kes',     'Kedokteran Olahraga · Fisioterapi',  'online',  'rgba(139,99,67,0.1)'],
          ['👨‍⚕️', 'dr. Budi Santoso, Sp.KJ',  'Psikiatri · Kesehatan Mental',       'online',  'rgba(200,168,130,0.2)'],
          ['👩‍⚕️', 'dr. Lia Permata, M.Gizi',  'Dietisien · Meal Planning',          'besok',   'rgba(0,0,0,0.05)'],
        ];
      @endphp

      @foreach($doctors as [$emoji, $name, $spec, $status, $bg])
        <div class="doctor-card {{ $status === 'besok' ? '' : '' }}" style="{{ $status === 'besok' ? 'opacity:0.6' : '' }}">
          <div class="doctor-avatar" style="background:{{ $bg }}">{{ $emoji }}</div>
          <div>
            <div class="doctor-name">{{ $name }}</div>
            <div class="doctor-spec">{{ $spec }}</div>
          </div>
          @if($status === 'online')
            <div class="doctor-avail">Online</div>
          @else
            <div style="margin-left:auto;font-size:0.72rem;color:var(--muted)">Besok 09:00</div>
          @endif
        </div>
      @endforeach
    </div>

    {{-- Appointment Form --}}
    <div class="card">
      <div class="card-title" style="margin-bottom:0.8rem">Buat Janji Konsultasi</div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">📅 Tanggal</label>
          <input type="date" class="form-input">
        </div>
        <div class="form-group">
          <label class="form-label">⏰ Jam</label>
          <select class="form-input form-select">
            <option>09:00</option>
            <option>10:00</option>
            <option>13:00</option>
            <option>14:00</option>
            <option>15:00</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">📝 Keluhan / Topik</label>
        <input type="text" class="form-input" placeholder="Contoh: Program diet defisit kalori untuk pemula">
      </div>
      <button class="btn btn-primary">📅 Buat Janji</button>
    </div>
  </div>

  {{-- Right: AI Chat --}}
  <div>
    <div class="card-title" style="margin-bottom:0.8rem;font-family:'Playfair Display',serif;font-size:1.05rem;font-weight:700;color:var(--brown-dark)">
      🤖 AI Mental Support — HealthyBot
    </div>

    <div class="chat-wrap">
      <div class="chat-header">
        <div class="chat-ai-dot"></div>
        <div>
          <div style="font-weight:600;font-size:0.88rem">HealthyBot AI</div>
          <div style="font-size:0.7rem;opacity:0.6">Asisten kesehatan &amp; mental Anda</div>
        </div>
      </div>

      <div class="chat-body" id="chat-body">
        {{-- Initial greeting --}}
        <div class="chat-msg">
          <div class="msg-avatar ai-av">🤖</div>
          <div class="msg-bubble ai">
            Halo! Saya HealthyBot 👋 Saya siap membantu perjalanan kesehatan kamu.
            Mau cerita soal apa hari ini? Bisa soal nutrisi, workout, atau kalau kamu lagi butuh teman curhat juga boleh 😊
          </div>
        </div>
      </div>

      <div class="chat-input-wrap">
        <input type="text" class="chat-input" id="chat-input"
          placeholder="Ketik pesan..."
          onkeypress="if(event.key==='Enter') sendChat()">
        <button class="chat-send" onclick="sendChat()">➤</button>
      </div>
    </div>
  </div>
</div>
