<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<style>
    .footer {
        background-color: #317671;
        box-shadow: 0 -3px 15px rgba(0, 0, 0, 0.1);
        color: #ffffff;
        padding: 40px 80px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        position: relative;
        margin-top:100px ;
    }

    .footer p {
        font-size: 11pt;
    }

    .footer .footer-kiri, .footer .footer-tengah, .footer .footer-kanan {
        flex: 1;
        min-width: 250px;
        margin-bottom: 20px;
    }

    .footer .footer-kiri {
        width: 350px;
    }

    .footer .footer-kiri img {
        width: 180px;
        margin-bottom: 15px;
    }

    .footer .footer-kiri p {
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .footer .social-icons {
        list-style-type: none;
        padding-left: 0;
        display: flex;
        gap: 15px;
    }

    .footer .social-icons li {
        display: inline-block;
    }

    .footer .social-icons li a {
    color: #ffffff;
    font-size: 1.2rem;
    display: inline-block; /* Pastikan elemen dapat ditransformasi */
    transition: color 0.3s ease, transform 0.3s ease;
    }

    .footer .social-icons li a:hover {
        color: #FFFF00;
        transform: translateY(-5px); /* Menggerakkan elemen ke atas */
    }

    .footer h4 {
        font-family: "Kanit", sans-serif;
        font-weight: 500 !important;
        color: #FFFF00;
    }

    .footer .footer-tengah {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
        margin-left: 150px;
    }

    .footer .footer-tengah .tengah-link {
        min-width: 150px;
    }

    .footer .footer-tengah h4, .footer .footer-kanan h4 {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .footer .footer-tengah ul, .footer .footer-kanan ul {
        list-style-type: none;
        padding-left: 0;
        margin-bottom: 0;
    }

    .footer .footer-tengah ul li, .footer .footer-kanan ul li {
        margin-bottom: 4px;
        padding-left: 10px;
    }

    .footer-kanan {
        padding: 0px 30px;
        text-align: left;
    }

    .footer .footer-tengah ul li a, .footer .footer-kanan ul li a {
    color: #ffffff;
    text-decoration: none;
    font-size: 10.5pt;
    display: inline-block; /* Mengubah elemen menjadi inline-block agar transformasi bekerja */
    transition: color 0.3s ease-in-out, transform 0.3s ease-in-out; /* Menambahkan transisi untuk transform */
    }

    .footer .footer-tengah ul li a:hover, .footer .footer-kanan ul li a:hover {
        color: #f39c12;
        transform: translateX(5px);
    }


    .copyright-section {
        border-top: 1px solid #ffffff;
        padding-top: 20px;
        text-align: center;
        font-size: 0.875rem;
        color: #ffffff;
        background-color: #2c5d55;
        padding: 10px 0;
    }

    @media (max-width: 768px) {
        .footer p {
            font-size: 10pt;
        }
        .footer {
            flex-direction: column;
            text-align: center;
            padding: 30px 5px 10px 5px;
        }

        .footer-kiri {
            padding: 0px 30px;
        }

        .footer .footer-kiri, .footer .footer-tengah, .footer .footer-kanan {
            justify-content: center;
            text-align: center;
            align-items: center;
            width: 100%;
            margin: 0%;
            margin-bottom: 30px;
        }

        .social-icons {
            justify-content: center;
        }

        .footer .footer-tengah {
            justify-content: center;
        }
    }
</style>

<footer>
    <div class="footer">
        <div class="footer-kiri">
            <img src="{{ asset('img/logo.png') }}?v={{ time() }}" alt="Logo">
            <p>Dengan semangat kebersamaan dan nilai-nilai Islam, kami berkomitmen membentuk generasi yang berilmu, berakhlak mulia, dan mampu memberikan manfaat nyata bagi masyarakat.</p>
            <ul class="social-icons">
                <li><a href="https://wa.me/6282134749670" target="_blank"><i class="fab fa-whatsapp"></i></a></li>
                {{-- <li><a href="#" target="_blank"><i class="fab fa-youtube"></i></a></li> --}}
                <li><a href="https://www.instagram.com/pripnuippnu.pujut01/" target="_blank"><i class="fab fa-instagram"></i></a></li>
                {{-- <li><a href="#" target="_blank"><i class="fab fa-facebook"></i></a></li> --}}
                <li><a href="mailto:your-email@example.com" target="_blank"><i class="fas fa-envelope"></i></a></li>
            </ul>
        </div>

        <div class="footer-tengah">
            <div class="tengah-link">
                <h4>Highlight</h4>
                <ul>
                    <li><a href="#home">Makesta</a></li>
                    <li><a href="#about">Kaderisasi</a></li>
                    <li><a href="#services">Ramadhan</a></li>
                    <li><a href="#contact">Bakti sosial</a></li>
                </ul>
            </div>
            <div class="tengah-link">
                <h4>Navigasi</h4>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-kanan">
            <h4>Narahubung</h4>
            <ul class="mb-3">
                <li>IPNU <a href="#" target="_blank"><i class="fab fa-whatsapp"></i>  0821 1234 5678</a></li>
                <li>IPPNU <a href="#" target="_blank"><i class="fab fa-whatsapp"></i>  0821 1234 5678</a></li>
            </ul>
            <h4>Sekretariat</h4>
            <p>Mushola Masyitoh - Rt.04 Rw.02 Desa Pujut, kec. Tersono, kab. Batang, Prov. JAWA TENGAH  Kode pos [ 59272 ]</p>
        </div>
    </div>

    <div class="copyright-section">
        &copy; IPNU - IPPNU   ||   Berhidmah Lillah Berkah.
    </div>
</footer>
