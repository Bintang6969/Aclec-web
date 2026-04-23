@extends('layouts.app')

@section('title', 'Selamat Datang')

@section('content')
<!-- Hero -->
<section class="py-5 text-white" style="background: linear-gradient(135deg,#1a1a2e 0%,#16213e 60%,#0f3460 100%); min-height: 80vh; display:flex; align-items:center;">
    <div class="container text-center">
        <span class="badge bg-success mb-3 px-3 py-2" style="font-size:.85rem;">Platform Kesehatan Holistik</span>
        <h1 class="display-4 fw-bold mb-3">Raih Target Fisikmu <br><span style="color:#2ecc71;">Bersama FitLife</span></h1>
        <p class="lead text-white-50 mb-4 mx-auto" style="max-width:560px;">
            Asisten digital personalmu untuk bulking, diet, atau maintenance � dilengkapi dukungan kesehatan mental lewat AI.
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('register') }}" class="btn btn-success btn-lg px-5">Mulai Gratis</a>
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-5">Masuk</a>
        </div>
    </div>
</section>

<!-- Features -->
<section class="py-5 bg-white">
    <div class="container">
        <h2 class="text-center fw-bold mb-2">Fitur Unggulan</h2>
        <p class="text-center text-muted mb-5">Semua yang kamu butuhkan dalam satu platform</p>
        <div class="row g-4">
            @foreach([
                ['bi-journal-check','success','Life Tracker','Catat kalori, air minum, tidur, dan olahraga harian � semua otomatis terhitung.'],
                ['bi-lightning-charge','warning','Workout Planner','Pilih jenis olahraga & durasi. Kalori terbakar otomatis tersinkron ke Life Tracker.'],
                ['bi-trophy','danger','Lifestyle Score','Dapatkan poin dari kebiasaan sehatmu. Kompetisi di Leaderboard bersama pengguna lain.'],
                ['bi-newspaper','info','Artikel & Berita','Konten kesehatan yang dikurasi � nutrisi, olahraga, kesehatan mental, dan lebih banyak lagi.'],
                ['bi-people','primary','Komunitas','Bagikan cerita, pengalaman, dan motivasi bersama sesama pengguna FitLife.'],
                ['bi-chat-dots','secondary','Konsultasi AI','Curhat & tanya saran kesehatan ke FitBot � tersedia 24/7 dengan dukungan Gemini AI.'],
            ] as [$icon, $color, $title, $desc])
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100 rounded-4 p-1">
                    <div class="card-body p-4">
                        <div class="bg-{{ $color }} bg-opacity-10 text-{{ $color }} rounded-3 d-inline-flex p-3 mb-3">
                            <i class="bi {{ $icon }} fs-4"></i>
                        </div>
                        <h5 class="fw-semibold">{{ $title }}</h5>
                        <p class="text-muted small mb-0">{{ $desc }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5 text-white text-center" style="background:#2ecc71;">
    <div class="container">
        <h2 class="fw-bold mb-2">Siap memulai perjalanan sehatmu?</h2>
        <p class="mb-4">Bergabung dengan ribuan pengguna yang sudah merasakan manfaatnya.</p>
        <a href="{{ route('register') }}" class="btn btn-dark btn-lg px-5">Daftar Sekarang � Gratis!</a>
    </div>
</section>

<footer class="py-3 text-center text-muted small bg-white border-top">
    &copy; {{ date('Y') }} FitLife. Dibuat dengan penuh semangat untuk kesehatan Anda.
</footer>
@endsection
