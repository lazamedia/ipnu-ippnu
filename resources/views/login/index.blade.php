@extends('layouts.main')

@section('container')

<style>
/* CSS untuk login box dan tombol */
body {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    background: #e2e2e270;
}
.login-box {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 400px;
    padding: 40px;
    transform: translate(-50%, -50%);
    background: rgb(250, 248, 248);
    box-sizing: border-box;
    box-shadow: 0 15px 25px rgba(0, 126, 184, 0.6);
    border-radius: 10px;
    border: 1px solid #9be7e1;
    margin-top: 20px;
}
@media (max-width: 768px) {
    .login-box {
        width: 80%;
        height: auto;
    }
}

.login-box h2 {
    margin: 20px 0 30px;
    padding: 0;
    color: #004741;
    text-align: center;
}

.login-box .user-box {
    position: relative;
}

.login-box .user-box input {
    width: 100%;
    padding: 10px 0;
    font-size: 16px;
    color: #004741;
    margin-bottom: 30px;
    border: none;
    border-bottom: 1px solid #004741;
    outline: none;
    background: transparent;
    margin-left: 5px;
}

/* Hilangkan shadow biru */
.login-box .user-box input:focus {
    outline: none;
    box-shadow: none;
    border-bottom: 2px solid #004741;
}

.login-box .user-box label {
    position: absolute;
    top: 0;
    left: 0;
    padding: 10px 0;
    font-size: 13px;
    color: #004741;
    pointer-events: none;
    transition: .5s;
    margin-left: 10px;
}

.login-box .user-box input:focus ~ label,
.login-box .user-box input:valid ~ label {
    top: -20px;
    left: 0;
    color: #004741;
    font-size: 12px;
}

/* Tombol login yang ada di sebelah kanan */
.login-box form button {
    float: right; /* Memposisikan tombol login ke kanan */
    padding: 10px 20px;
    color: #317671;
    border: 1px solid #317671;
    font-size: 16px;
    text-decoration: none;
    text-transform: uppercase;
    overflow: hidden;
    transition: .5s;
    margin-top: 20px;
    letter-spacing: 4px;
    border: none;
    background-color: transparent;
    cursor: pointer;
}

.login-box button:hover {
    background: #317671;
    color: #fff;
    border-radius: 5px;
}

/* Tombol login disabled */
.login-box button:disabled {
    background-color: #c7c7c7;
    border:1px solid #5f5f5f;
    color: #ffffff;
    cursor: not-allowed;
}

/* Link forgot password di sebelah kanan */
.login-box .forgot-password {
    display: block;
    text-align: right; /* Memposisikan ke kanan */
    font-size: 12px;
    margin-top: -20px;
    color: #317671;
    text-decoration: none;
    transition: color 0.3s;
}

.login-box .forgot-password:hover {
    color: #004741;
}

/* Box untuk countdown login */
.countdown-box {
    margin-top: 30px;
    padding: 15px;
    width: 400px;
    background-color: #f8f9fa;
    border: 1px solid #ffffff;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    color: red;
    font-size: 14px;
    transform: translate(-50%, 0);
    left: 50%;
    position: absolute;
}
@media (max-width: 768px) {
    .countdown-box {
        width: 80%;
    }
}

.alert{
    margin: auto;
    width: 400px;
    text-align: center;
    justify-content: center;
    margin-top: 30px;
}

</style>
 <!-- Notifikasi error jika ada -->
 @if(session()->has('loginError'))
 <div class="alert alert-danger alert-dismissible fade show small-text text-align-center " role="alert">
     {{ session('loginError') }}
 </div>
 @endif
<div class="login-box">
   

    <h2>Login</h2>

    <form action="/login" method="post">
        @csrf
        <div class="user-box">
            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username"  autofocus required value="{{ old('username') }}">
            @error('username')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
            <label>Username</label>
        </div>

        <div class="user-box">
            <input type="password" name="password" class="form-control" id="password"  required>
            <label>Password</label>

            <!-- Forgot Password di sebelah kanan -->
            <a href="/forgot-password" class="forgot-password">Forgot Password?</a>
        </div>

        <button id="login-btn" class="btn" type="submit" {{ session()->has('retryAfter') ? 'disabled' : '' }}>Login</button>
    </form>
</div>

<!-- Box untuk countdown waktu login, diletakkan di bawah box login -->
@if(session()->has('retryAfter'))
<div class="countdown-box" id="countdown-box">
    Coba lagi dalam {{ session('retryAfter') }} detik
</div>
@endif

<!-- Script untuk menghilangkan notifikasi error dalam 3 detik -->
<script>
    setTimeout(function() {
        let alertBox = document.querySelector('.alert');
        if (alertBox) {
            alertBox.classList.add('fade');
            setTimeout(function() {
                alertBox.remove();
            }, 500); // Waktu untuk transisi
        }
    }, 3000); // Hapus setelah 3 detik
</script>

<!-- Script untuk menghitung mundur waktu login -->
@if(session()->has('retryAfter'))
<script>
    let retryAfter = {{ session('retryAfter') }}; // waktu tunggu dalam detik
    let countdownBox = document.getElementById('countdown-box');
    let loginButton = document.getElementById('login-btn');

    // Hitung mundur hingga tombol kembali aktif
    let interval = setInterval(() => {
        retryAfter--;

        // Jika waktu habis, aktifkan kembali tombol login
        if (retryAfter <= 0) {
            clearInterval(interval);
            countdownBox.innerText = ""; // Hapus teks countdown
            countdownBox.style.display = 'none'; // Sembunyikan box countdown
            loginButton.removeAttribute('disabled'); // Hapus atribut disabled pada tombol
        } else {
            countdownBox.innerText = "Coba lagi dalam " + retryAfter + " detik";
        }
    }, 1000); // Hitung mundur setiap detik
</script>
@endif

@endsection
