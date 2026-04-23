@extends('layouts.app')
@section('title', 'Daftar Akun')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <a href="{{ route('home') }}" class="text-decoration-none">
                            <h3 class="fw-bold" style="color:#2ecc71;"><i class="bi bi-activity"></i> FitLife</h3>
                        </a>
                        <p class="text-muted small">Buat akun baru dan mulai perjalanan sehatmu</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger py-2">
                            @foreach($errors->all() as $e)<div class="small">{{ $e }}</div>@endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row g-3">
                            <!-- Nama & Email -->
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Nama lengkap">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="nama@email.com">
                            </div>

                            <!-- Password -->
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Password</label>
                                <input type="password" name="password" required
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Min. 8 karakter">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" required
                                       class="form-control"
                                       placeholder="Ulangi password">
                            </div>

                            <div class="col-12"><hr class="my-1"><p class="text-muted small fw-medium mb-0">Profil Kesehatan</p></div>

                            <!-- Jenis Kelamin & Usia -->
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Jenis Kelamin</label>
                                <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                    <option value="">Pilih...</option>
                                    <option value="male" {{ old('gender')=='male'?'selected':'' }}>Laki-laki</option>
                                    <option value="female" {{ old('gender')=='female'?'selected':'' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Usia (tahun)</label>
                                <input type="number" name="age" value="{{ old('age') }}" required min="10" max="100"
                                       class="form-control @error('age') is-invalid @enderror" placeholder="25">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Target</label>
                                <select name="goal" class="form-select @error('goal') is-invalid @enderror" required>
                                    <option value="maintenance" {{ old('goal','maintenance')=='maintenance'?'selected':'' }}>Maintenance</option>
                                    <option value="bulking" {{ old('goal')=='bulking'?'selected':'' }}>Bulking</option>
                                    <option value="diet" {{ old('goal')=='diet'?'selected':'' }}>Diet</option>
                                </select>
                            </div>

                            <!-- Tinggi & Berat -->
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Tinggi (cm)</label>
                                <input type="number" name="height_cm" value="{{ old('height_cm') }}" required min="100" max="250"
                                       class="form-control @error('height_cm') is-invalid @enderror" placeholder="170">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Berat (kg)</label>
                                <input type="number" name="weight_kg" value="{{ old('weight_kg') }}" required min="20" max="300"
                                       class="form-control @error('weight_kg') is-invalid @enderror" placeholder="65">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Level Aktivitas</label>
                                <select name="activity_level" class="form-select @error('activity_level') is-invalid @enderror" required>
                                    <option value="sedentary" {{ old('activity_level')=='sedentary'?'selected':'' }}>Sangat Jarang</option>
                                    <option value="light" {{ old('activity_level')=='light'?'selected':'' }}>Ringan</option>
                                    <option value="moderate" {{ old('activity_level','moderate')=='moderate'?'selected':'' }}>Sedang</option>
                                    <option value="active" {{ old('activity_level')=='active'?'selected':'' }}>Aktif</option>
                                    <option value="very_active" {{ old('activity_level')=='very_active'?'selected':'' }}>Sangat Aktif</option>
                                </select>
                            </div>

                            <div class="col-12 mt-2">
                                <button type="submit" class="btn w-100 text-white fw-semibold py-2" style="background:#2ecc71;">
                                    Buat Akun
                                </button>
                            </div>
                        </div>
                    </form>

                    <hr class="my-4">
                    <p class="text-center text-muted small mb-0">
                        Sudah punya akun? <a href="{{ route('login') }}" class="fw-semibold" style="color:#2ecc71;">Masuk sekarang</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
