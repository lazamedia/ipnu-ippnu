<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verify Token</title>
    <script>
        (function() {
            emailjs.init("pQbXVpRuBu6ItQPr3");  // Ganti YOUR_USER_ID dengan User ID Anda
        })();
    </script>
    <style>
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
            box-shadow: 0 15px 25px rgba(0, 126, 184, 0.6);
            border-radius: 10px;
            border: 1px solid #9be7e1;
        }
        @media (max-width: 768px) {
            .login-box {
                width: 80%;
                height: auto;
            }
        }
        .login-box h2 {
            margin: 20px 0 30px;
            color: #004741;
            text-align: center;
        }
        .login-box input {
            width: 100%;
            padding: 10px 0;
            font-size: 16px;
            color: #004741;
            margin-bottom: 30px;
            border: none;
            border-bottom: 1px solid #004741;
            background: transparent;
            outline: none;
        }
        .login-box button {
            float: right;
            padding: 10px 20px;
            color: #317671;
            border: none;
            font-size: 16px;
            letter-spacing: 4px;
            background-color: transparent;
            cursor: pointer;
        }
        .login-box button:hover {
            background: #317671;
            color: #fff;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="login-box">
        <h2>Enter Token</h2>
        <form id="token-form" onsubmit="verifyToken(event)">
            <input type="text" name="token" id="token" required placeholder="Enter your token">
            <button type="submit">Verify Token</button>
        </form>
    </div>

    <script>
        function verifyToken(event) {
            event.preventDefault();
            const token = document.getElementById('token').value;

            // Kirim permintaan POST ke backend untuk verifikasi token
            fetch('/verify-token', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ token: token })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '/reset-password'; // Arahkan ke halaman reset password
                } else {
                    alert('Token tidak valid atau telah kadaluarsa.');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>

</body>
</html>
