@extends('layouts.main')

@section('container')

<link rel="stylesheet" href="css/home.css">
<script src="js/home.js"></script>
    
<style>
h3 {
    font-family: 'Poppins';
    color: #317671;
}
h4{
    margin-bottom: -2px;
}



</style>

{{-- SLIDER --}}
    <section class="hero1">
            
        <div class="box-hero hero-kiri">
            <h4>PR IPNU & IPPNU Pujut 01</h4>
            <p>Berjuang demi kejayaan NU</p>
        </div>

        <div class="box-hero hero-kanan">
            <div class="slider">
                <div class="slide active">
                    <img src="img/s-1.jpg"  loading="lazy"  alt="Slide 1">
                    <div class="content">
                        <h4>PR IPNU & IPPNU Pujut 01</h4>
                        <p>Berjuang demi kejayaan NU</p>
                    </div>
                </div>
                <div class="slide">
                    <img src="img/s-2.jpg"  loading="lazy"  alt="Slide 2">
                    <div class="content">
                        <h4>Buka Bersama</h4>
                        <p>Kegiatan rutin ramadhan</p>
                    </div>
                </div>
                <div class="slide">
                    <img src="img/s-3.jpg"  loading="lazy"  alt="Slide 3">
                    <div class="content">
                        <h4>ZARKASI</h4>
                        <p>Ziarah dan Rekreasi IPNU - IPPNU</p>
                    </div>
                </div>
                <div class="slide">
                    <img src="img/s-4.jpg"  loading="lazy"  alt="Slide 4">
                    <div class="content">
                        <h4>MAKESTA</h4>
                        <p>Masa Kesetiaan Anggota</p>
                    </div>
                </div>
                {{-- Buttons --}}
                <div class="buttons">
                    <button id="prev"><</button>
                    <button id="next">></button>
                </div>
                {{-- Dots --}}
                <ul class="dots">
                    <li class="active"></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>
        </div>
        <div class="custom-shape-divider-bottom-1725276230">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M649.97 0L550.03 0 599.91 54.12 649.97 0z" class="shape-fill"></path>
            </svg>
        </div>
    </section>
{{-- --- --}}

{{-- BOX-1 --}}
    <section class="box-1">
        <div class="text-box-1">
            <h3>Welcome</h3>
            <p>Selamat datang di halaman resmi IPNU IPPNU Pujut 01, ruang digital yang kami dedikasikan untuk berbagi informasi, inspirasi, dan perkembangan terbaru dari organisasi kami. Di sini, kami merayakan semangat kebersamaan dan pembelajaran, sebagai bagian dari komitmen kami untuk mendukung pengembangan diri dan potensi generasi muda.</p>
        </div>
    </section>
{{-- --- --}}


{{-- VISI MISI --}}
<section class="visi-misi">
    <div class="vmbox vmboxkiri">
        <img src="img/vs.jpg"   loading="lazy" alt="Visi Misi Image" style="width: 300px; height: auto">
    </div>
    <div class="vmbox vmboxkanan">
        <h3 class="vm-title">Visi</h3>
        <p class="visi-content">
            Menjadikan generasi muda yang berilmu, berakhlak mulia, dan mampu memberikan manfaat nyata bagi masyarakat.
        </p>
        <h3 class="vm-title">Misi</h3>
        <ol class="misi-list">
            <li>Membentuk generasi muda yang berilmu, berakhlak mulia, dan mampu memberikan manfaat nyata bagi masyarakat.</li>
            <li>Mendorong pengembangan keterampilan dan pengetahuan melalui pendidikan yang berkesinambungan.</li>
            <li>Mengembangkan program-program yang berfokus pada pengembangan karakter dan kepemimpinan.</li>
            <li>Memfasilitasi peluang bagi generasi muda untuk berkontribusi dalam proyek-proyek sosial dan komunitas.</li>
        </ol>
    </div>
</section>
{{-- --- --}}

<style>
    /* Style untuk container dan layout responsif */
    .container-event {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 20px;
        padding: 20px;
    }

    .box-event {
        position: relative;
        flex-basis: calc(20% - 20px); /* 3 kolom dalam satu baris */
        background-color: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .box-event:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .box-event img {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-bottom: 1px solid #e0e0e0;
    }

    .box-event h4 {
        margin: 10px;
        font-size: 1.2rem;
        color: #333;
        font-weight: bold;
    }

    .box-event p {
        margin: 10px;
        font-size: 0.95rem;
        color: #666;
    }


    .box-event .date {
        padding: 10px;
        width: auto;
        background-color: #ffffff;
        color: #858585;
        font-size: 10pt;
        text-align: right;
    }


    .box-event .box-content {
        padding-bottom: 30px; /* Menyediakan ruang untuk kotak tanggal */
    }


    /* Responsif untuk tampilan tablet */
    @media (max-width: 1024px) {
        .box-event {
            flex-basis: calc(50% - 20px); /* 2 kolom dalam satu baris */
        }
    }

    /* Responsif untuk tampilan ponsel */
    @media (max-width: 768px) {
        .box-event {
            flex-basis: 100%; /* 1 kolom penuh dalam satu baris */
        }
    }

    /* Judul Event */
    .judul-event {
        text-align: center;
        margin-bottom: 20px;
    }

</style>

<section>
    <div class="judul-event">
        <h3>Event Terbaru</h3>
        <p>Ikuti terus website kami untuk melihat info terbaru</p>
    </div>
    <div class="container-event">
        <!-- Box Event 1 -->
        <div class="box-event">
            <img src="img/slide1.png" alt="Event 1">
            
                <h4>Buka Bersama</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                
        
            <div class="date">10 Januari 2024</div>
        
        </div>
        

       
    </div>
</section>


@endsection
