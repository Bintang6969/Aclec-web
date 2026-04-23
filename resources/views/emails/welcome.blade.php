<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Helvetica Neue', Arial, sans-serif; background: #F5EFE6; color: #2C1A0E; padding: 40px 16px; }
    .wrapper { max-width: 560px; margin: 0 auto; }
    
    .header { text-align: center; padding: 32px 40px 24px; background: #3E2011; border-radius: 20px 20px 0 0; }
    .logo { font-size: 26px; font-weight: 800; color: #FEFCF9; }
    .logo span { color: #C8A882; }
    
    .card { background: #fff; padding: 40px; border: 1px solid #DDD0C0; border-top: none; }
    .title { font-size: 22px; font-weight: 700; color: #3E2011; margin-bottom: 20px; }
    
    .btn { display: block; text-align: center; background: #C0392B; color: #fff !important; text-decoration: none; font-weight: 700; padding: 14px; border-radius: 12px; margin: 30px 0; }
    
    .warning { background: #FFF8F4; padding: 15px; border-radius: 8px; font-size: 13px; color: #8B6343; line-height: 1.5; border: 1px solid #DDD0C0; }
    .footer { text-align: center; padding: 20px; color: #9a8070; font-size: 11px; }
  </style>
</head>
<body>
<div class="wrapper">

  <div class="header">
    <div class="logo">Healthy<span>Care</span></div>
  </div>

  <div class="card">
    <div class="title">Reset Kata Sandi</div>
    <p style="font-size: 14px; line-height: 1.6; color: #5a3e2b;">
      Halo, {{ $user->name }}. Kami menerima permintaan untuk mereset kata sandi akun Anda. 
      Klik tombol di bawah ini untuk membuat kata sandi baru:
    </p>

    <a href="{{ url('/reset-password/' . $token) }}" class="btn">Reset Kata Sandi</a>

    <div class="warning">
      <strong>Catatan Keamanan:</strong> Jika Anda tidak merasa melakukan permintaan ini, silakan abaikan email ini. Kata sandi Anda tetap aman dan tidak ada perubahan yang dilakukan.
    </div>
  </div>

  <div class="footer">
    © {{ date('Y') }} HealthyCare. Semua hak dilindungi.
  </div>

</div>
</body>
</html>