@extends('layouts.app')
@section('title', 'Masuk')

@section('content')
<div class="container py-5" style="min-height:80vh; display:flex; align-items:center; justify-content:center;">
    <div class="card border-0 shadow-sm rounded-4" style="width:100%; max-width:440px;">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <a href="{{ route('home') }}" class="text-decoration-none">
                    <h3 class="fw-bold" style="color:#2ecc71;"><i class="bi bi-activity"></i> FitLife</h3>
                </a>
                <p class="text-muted small">Masuk ke akun Anda</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger py-2">
                    @foreach($errors->all() as $e)<div class="small">{{ $e }}</div>@endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-medium">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="nama@email.com">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">Password</label>
                    <input type="password" name="password" required
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Masukkan password">
                </div>
                <div class="mb-4 d-flex align-items-center">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input me-2">
                    <label for="remember" class="form-check-label small">Ingat saya</label>
                </div>
                <button type="submit" class="btn w-100 text-white fw-semibold" style="background:#2ecc71;">
                    Masuk
                </button>
            </form>

            <hr class="my-4">
            <p class="text-center text-muted small mb-0">
                Belum punya akun? <a href="{{ route('register') }}" class="fw-semibold" style="color:#2ecc71;">Daftar sekarang</a>
            </p>
        </div>
    </div>
</div>
@endsection
