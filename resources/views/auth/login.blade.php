@extends('layouts.app')
@section('title', 'Masuk')

@section('content')

<style>
  :root{
    --cream: #f6e8db;
    --brown-light: #f6e4ce;
    --brown-medium: #b36b00;
    --brown-dark: #7a3e00;
    --white: #ffffff;
    --muted: #9a8070;
    --input-bg: #f5f0eb;
    --border: #e2d9cf;

  }

  body{
    background-color: var(--cream);
    font-family: 'jos', sans-serif;

  }

  .brand-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 28px;
    font-weight: 700;
    color: var(--brown-dark);

  }

  .brand-icon {
    width: 40px;
    height: 40px;
    background: var(--brown-dk);
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-bottom: 10px;
  }

  .login-card {
    background: var(--white);
    border-radius: 24px;
    box-shadow: 0 20px 60px rgba(62,34,9,0.08);
    padding: 44px 40px;
  }

  .page-eye{
    background: var(--white);
    border-radius: 24px;
    border: 1px solid var(--border);
    box-shadow: 0 20px 60px rgba(62,34,9,0.08);
    padding: 44px 40px;
  }

  .card-titel{
    font-faminly: 'Cormorant Garamond', serif;
    font-size: 32px;
    forn-weight: 700;
    color: var(--brown-dark);
  }

  .form-label{
    font-size: 11px;
    font-weight: 600;
    color: var(--brown-dark);
    letter-spacing: 1px;
    text-transform: uppercase;
  }

  .form-control{
    background: var(--input-bg);
    border: 1.5px solid vartransparent;
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 14px;
    color: var(--brown-dark);
    transition: all 0.2s;

  }

.form-control:focus {
        background: var(--white);
        border-color: var(--brown-md);
        box-shadow: none;
    }

    .btn-main {
        background: var(--brown-dk);
        color: var(--white);
        border: none;
        border-radius: 14px;
        font-size: 15px;
        font-weight: 600;
        letter-spacing: 1px;
        padding: 14px;
        transition: all 0.2s;
        box-shadow: 0 10px 30px rgba(62, 34, 9, 0.2);
    }

    .btn-main:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 40px rgba(62, 34, 9, 0.3);
        color: white;
    }

    .accent-bar {
        width: 48px;
        height: 3px;
        background: linear-gradient(90deg, #C0392B, var(--brown-lt));
        border-radius: 2px;
        margin: 16px auto 24px;
    }

    .link-custom {
        color: var(--brown-md);
        text-decoration: none;
        font-weight: 600;
    }

    .link-custom:hover {
        color: var(--brown-dk);
    }
</style>

<div class="container py-5 d-flex flex-column align-items-center justify-content-center" style="min-height: 90vh;">
    
    <div class="text-center mb-5">
        <a href="{{ route('home') }}" class="text-decoration-none">
            <div class="brand-icon"><i class="bi bi-activity"></i></div>
            <div class="brand-name">HEALTYCARE</div>
        </a>
    </div>

    <div class="login-card w-100" style="max-width: 460px;">
        <div class="text-center">
            <div class="page-eye">Selamat Datang Kembali</div>
            <h2 class="card-title mt-2">Masuk ke Akun</h2>
            <div class="accent-bar"></div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger border-0 rounded-3 small py-2 mb-4" style="background-color: rgba(192, 57, 43, 0.1); color: #C0392B;">
                @foreach($errors->all() as $e)
                    <div><i class="bi bi-exclamation-circle me-1"></i> {{ $e }}</div>
                @endforeach
            </div>
        @endif

       <form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">Alamat Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required
               class="form-control @error('email') is-invalid @enderror"
               placeholder="nama@email.com">
    </div>

    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" required
               class="form-control @error('password') is-invalid @enderror"
               placeholder="Masukkan password">
    </div>

    <div class="d-flex justify-content-end mb-3" style="margin-top: -10px;">
    <a href="{{ route('reset-pw') }}" class="link-custom" style="font-size: 12px; font-weight: 500;">
        Lupa Password?
    </a>
</div>

    <div class="mb-4 d-flex align-items-center">
        <input type="checkbox" name="remember" id="remember" class="form-check-input me-2" style="cursor: pointer; border-color: var(--border);">
        <label for="remember" class="small text-muted" style="cursor: pointer;">Ingat perangkat ini</label>
    </div>

    <button type="submit" class="btn btn-main w-100 mb-3">
        MASUK SEKARANG ✓
    </button>
</form>

        <div class="text-center mt-4 pt-3 border-top" style="border-color: var(--border) !important;">
            <p class="text-muted small mb-0">
                Belum punya akun? <a href="{{ route('register') }}" class="link-custom">Daftar sekarang</a>
            </p>
        </div>
    </div>
</div>
@endsection