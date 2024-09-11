<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .email-header {
            background-color: #317671;
            padding: 20px;
            text-align: center;
            color: #fff;
            border-bottom: 4px solid #004741;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 30px;
            color: #004741;
        }
        .email-body p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .email-body strong {
            font-size: 18px;
            color: #317671;
        }
        .email-footer {
            text-align: center;
            padding: 20px;
            background-color: #f4f4f4;
            font-size: 14px;
            color: #999;
        }
        .email-footer a {
            color: #317671;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="email-container">
        <div class="email-header">
            <h1>Reset Kata Sandi Anda</h1>
        </div>
        <div class="email-body">
            <p>Halo,</p>
            <p>Anda telah meminta untuk mereset kata sandi Anda. Silakan gunakan token berikut untuk mereset kata sandi Anda:</p>
            <p><strong>{{ $token }}</strong></p>
            <p>Token ini hanya berlaku selama 5 menit.</p>
            <p>Jika Anda tidak meminta reset kata sandi, abaikan email ini.</p>
        </div>
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Perusahaan Anda. Hak cipta dilindungi.</p>
            <p><a href="{{ url('/') }}">Kunjungi situs kami</a></p>
        </div>
    </div>

</body>
</html>
