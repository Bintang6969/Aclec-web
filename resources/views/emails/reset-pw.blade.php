<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <style>
        body { font-family: sans-serif; background: #F5EFE6; padding: 50px; }
        .card { max-width: 400px; margin: auto; background: white; padding: 20px; border-radius: 10px; }
        .form-group { margin-bottom: 15px; }
        input { width: 100%; padding: 10px; margin-top: 5px; }
        button { width: 100%; padding: 10px; background: #C0392B; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>

<div class="card">
    <h3>Lupa Password</h3>
    
    <div class="form-group">
        <label>Email</label>
        <input type="email" id="email" placeholder="email@anda.com">
        <button onclick="sendOtp()" style="margin-top:10px; background:#3E2011;">Kirim Kode OTP</button>
    </div>

    <div class="form-group">
        <label>Masukkan Kode OTP</label>
        <input type="text" id="otpInput" placeholder="6 digit kode">
    </div>

    <div class="form-group">
        <label>Password Baru</label>
        <input type="password" id="newPassword" placeholder="Min. 8 karakter">
    </div>

    <button onclick="verifyOtp()">Simpan Password Baru</button>
</div>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>

<script type="text/javascript">
    const CONFIG = {
        publicKey: "R0UzgXsVVaddINieD",
        serviceId: "service_w4omikj",
        templateId: "template_p6a0nnp"
    };

    emailjs.init(CONFIG.publicKey);

    let generatedOtp = "";

    function sendOtp() {
        const email = document.getElementById('email').value;
        if(!email) return alert("Masukkan email!");
        
        generatedOtp = Math.floor(100000 + Math.random() * 900000).toString();
        
        emailjs.send(CONFIG.serviceId, CONFIG.templateId, {
            to_email: email,
            otp_code: generatedOtp
        }).then(() => {
            alert("Kode OTP telah dikirim ke email!");
        }).catch(err => alert("Gagal: " + JSON.stringify(err)));
    }

    async function verifyOtp() {
        const email = document.getElementById('email').value;
        const inputOtp = document.getElementById('otpInput').value;
        const newPassword = document.getElementById('newPassword').value;

        // Validasi Sederhana
        if (inputOtp !== generatedOtp) return alert("OTP Salah!");
        if (newPassword.length < 8) return alert("Password minimal 8 karakter!");

        // Kirim ke Controller
        const response = await fetch('/reset-password-process', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ 
                email: email, 
                password: newPassword 
            })
        });

        const data = await response.json();

        if (data.status === 'success') {
            alert("Password berhasil diubah!");
            window.location.href = "/login"; // Redirect ke halaman login setelah berhasil
        } else {
            alert("Gagal memperbarui password.");
        }
    }
</script>
</body>
</html>