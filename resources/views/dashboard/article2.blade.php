{{-- ═══ ARTIKEL & KOMUNITAS SECTION ═══ --}}

{{-- Main Tabs --}}
<div class="filter-tabs" id="article-tabs">
  <div class="filter-tab active" onclick="switchTab(this,'articles-section')">📰 Artikel</div>
  <div class="filter-tab" onclick="switchTab(this,'community-section')">👥 Komunitas</div>
</div>

{{-- ── ARTICLES ── --}}
<div id="articles-section">
  <div class="filter-tabs">
    <div class="filter-tab active">Semua</div>
    <div class="filter-tab">Nutrisi</div>
    <div class="filter-tab">Olahraga</div>
    <div class="filter-tab">Mental Health</div>
    <div class="filter-tab">Diet</div>
    <div class="filter-tab">Bulking</div>
  </div>

  <div class="article-grid">
    @php
      $articles = [
        ['🥗', 'Nutrisi',       '5 Makanan Tinggi Protein untuk Mendukung Program Bulking',          '22 April 2026 · 5 mnt'],
        ['🧠', 'Mental Health', 'Mengatasi Emotional Eating: Strategi Mindful Eating yang Efektif',  '21 April 2026 · 7 mnt'],
        ['🏃', 'Olahraga',      'HIIT vs Cardio Steady-State: Mana yang Lebih Efektif untuk Lemak?', '20 April 2026 · 6 mnt'],
        ['😴', 'Recovery',      'Kenapa Tidur Berkualitas Sama Pentingnya dengan Olahraga',           '19 April 2026 · 4 mnt'],
      ];
    @endphp

    @foreach($articles as [$emoji, $cat, $title, $date])
      <div class="article-card">
        <div class="article-img">{{ $emoji }}</div>
        <div class="article-body">
          <div class="article-cat">{{ $cat }}</div>
          <div class="article-title">{{ $title }}</div>
          <div class="article-date">📅 {{ $date }} baca</div>
        </div>
      </div>
    @endforeach
  </div>
</div>

{{-- ── COMMUNITY ── --}}
<div id="community-section" style="display:none">

  {{-- Post input --}}
  <div class="card" style="margin-bottom:1rem">
    <div class="form-group" style="margin-bottom:0.7rem">
      <textarea class="form-input" id="post-input" rows="3"
        placeholder="Bagikan cerita, pengalaman, atau tips kesehatan kamu..."></textarea>
    </div>
    <div style="display:flex;justify-content:flex-end">
      <button class="btn btn-primary btn-sm" onclick="addPost()">📤 Posting</button>
    </div>
  </div>

  {{-- Posts list --}}
  <div id="posts-list">
    @php
      $posts = [
        ['RP', 'Rina P.',  '2 jam lalu',  'linear-gradient(135deg,#C0392B,#8B6343)', 'Hari ini berhasil lari 5km tanpa berhenti! Bulan lalu saya bahkan tidak bisa lari 1km. Konsistensi itu kuncinya teman-teman. Mulai dari yang kecil dan jangan bandingkan diri dengan orang lain. 💪🔥', 24, 8],
        ['DS', 'Dika S.',  '5 jam lalu',  'linear-gradient(135deg,#8B6343,#C8A882)', 'Tips untuk yang lagi bulking: makan porsi kecil tapi sering! Saya makan 5-6 kali sehari dengan protein tinggi. Sudah 3 bulan naik 4kg massa otot. 📊', 31, 12],
        ['SN', 'Syafa N.', '1 hari lalu', 'linear-gradient(135deg,#C8A882,#3E2011)', 'Minggu ini berhasil maintain Lifestyle Score di atas 90 selama 5 hari berturut-turut! Reward dari sistem — boleh makan es krim favorit besok 🍦', 47, 19],
      ];
    @endphp

    @foreach($posts as [$initials, $name, $time, $bg, $text, $likes, $comments])
      <div class="post-card">
        <div class="post-header">
          <div class="post-avatar" style="background:{{ $bg }}">{{ $initials }}</div>
          <div>
            <div class="post-name">{{ $name }}</div>
            <div class="post-time">{{ $time }}</div>
          </div>
        </div>
        <div class="post-text">{{ $text }}</div>
        <div class="post-actions">
          <div class="post-action">❤️ {{ $likes }} Suka</div>
          <div class="post-action">💬 {{ $comments }} Komentar</div>
        </div>
      </div>
    @endforeach
  </div>
</div>
