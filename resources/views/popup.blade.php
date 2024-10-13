<style>
    /* Gaya untuk pop-up */
    #demo-popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.7);
        z-index: 9999;
        display: flex;
        align-items: center;
        align-content: center;
        justify-content: center;
    }

    /* Gaya untuk konten pop-up */
    .popup-content {
        background: white;
        padding: 30px;
        border-radius: 15px;
        width: 50%;
        margin: auto;
        max-width: 600px;
        text-align: center;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        animation: popup-appear 0.5s ease-out;
    }

    @media screen and (max-width: 600px) {
        .popup-content {
            width: 92%;
        }
    }

    /* Gaya untuk gambar */
    .popup-content img {
        max-width: 100%;
        border-radius: 10px;
        margin-bottom: 20px;
        height: 200px;
    }

    /* Gaya untuk judul */
    .popup-content h4 {
        font-size: 24px;
        margin-bottom: 10px;
        color: #333;
    }

    /* Gaya untuk deskripsi */
    .popup-content p {
        font-size: 16px;
        color: #555;
        margin: 0%;
    }

    /* Gaya untuk data login */
    .login-info {
        font-size: 14px;
        color: #666;
        margin-bottom: 20px;
        margin-top: 10px;
        text-align: center;
    }

    .login-info strong {
        display: inline-block;
        width: 100px;
    }

    /* Gaya untuk tombol dengan animasi */
    .close-popup {
        background-color: #4c6baf;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .close-popup:hover {
        background-color: #076e8d;
        transform: scale(1.05);
    }

    .close-popup:active {
        transform: scale(0.98);
    }

    /* Animasi untuk pop-up muncul */
    @keyframes popup-appear {
        from {
            transform: scale(0.8);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>

<!-- HTML untuk Pop-up -->
<div id="demo-popup">
    <div class="popup-content">
        <!-- Gambar demo -->
        <img src="{{ asset('img/mt.png') }}" alt="Demo Image">

        <!-- Judul -->
        <h4>Demo Website by.Mixucode</h4>

        <!-- Deskripsi singkat -->
        <p>Developed by.Lazuardi Mandegar</p>
       
        <!-- Informasi login demo -->
        <div class="login-info">
            <p><strong>Username  :</strong> superadmin</p>
            <p><strong>Password  :</strong> password123</p>
            <p style="color: red; font-size:9pt; margin-top:4px;">Dilarang Mengubah Akun Demo</p>
        </div>

        <!-- Tombol tutup -->
        <button id="close-popup" class="close-popup">Tutup</button>
        
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cek apakah pop-up sudah ditampilkan sebelumnya
        if (!sessionStorage.getItem('popupShown')) {
            document.getElementById('demo-popup').style.display = 'block';
        }

        // Event listener untuk tombol tutup
        document.getElementById('close-popup').addEventListener('click', function() {
            document.getElementById('demo-popup').style.display = 'none';
            // Simpan status di sessionStorage agar pop-up tidak muncul lagi di sesi ini
            sessionStorage.setItem('popupShown', 'true');
        });
    });

</script>
