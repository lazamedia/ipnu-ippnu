@extends('layouts.main')

@section('container')

<style>
    body{
        background-color: #f3f3f3;
    }
    .card-body{
        padding: 0px;
        margin: 20px 0px;
    }
    .row {
        display: flex;
        justify-content: space-between;
        padding: 30px;
    }
    @media (max-width: 768px) {
        .row{
            padding: 10px;
        }
    }

    /* Style untuk dua kolom utama */
    .main-event, .other-event {
        background-color: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.322);
        border-radius: 8px;
        padding: 20px;
    }

    .main-event {
        flex: 0 0 70%;
        margin-right: 20px;
    }

    .event-details{
        display: flex;
        justify-content: space-between;
        margin: 20px;
        font-size: 14pt;
        font-weight: 600;
        color: #317671; 
    }

    .other-event {
        flex: 0 0 28%;
    }

    .event-banner {
        width: 100%;        /* Gambar akan mengambil seluruh lebar box */
        height: auto;       /* Menjaga rasio gambar */
        max-width: 100%;    /* Gambar tidak akan melebihi ukuran kontainer */
        border-radius: 8px; /* Opsional: memberikan sudut membulat */
    }

    /* Tabel untuk jadwal kegiatan */
    .schedule-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .schedule-table th, .schedule-table td {
        padding: 10px;
        border: 1px solid #7e7e7e;
        text-align: left;
    }

    .schedule-table th {
        background-color: #317671;
        color: white;
    }

    /* Tabel anggaran */
    .budget-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .budget-table th, .budget-table td {
        padding: 10px;
        border: 1px solid #7e7e7e;
        text-align: left;
    }

    .budget-table th {
        background-color: #317671;
        color: white;
    }

    .budget-table td {
        font-size: 12pt;
    }

    /* Responsif */
    @media (max-width: 768px) {
        .row {
            flex-direction: column;
        }

        .main-event, .other-event {
            flex: 100%;
            margin-bottom: 20px;
        }
    }
    .judul-event {
        width: 100%;
        padding: 20px 50px;
        background-color: #ffffff;
        box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1); /* Shadow hanya di bawah */
        color: #317671;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    /* Style Tamu undangan */
    .tamu-container {
        display: flex;
        flex-wrap: wrap;
    }
    .box-tamu {
        background-color: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border: 1px solid #317671;
        padding: 10px 10px 3px 10px;
        align-items: center;
        justify-content: center;
        align-content: center;
        border-radius: 8px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        text-align: center;
    }

    .box-tamu h5 {
        color: #317671;
        font-size: 12pt;
    }

    /* Hover effect */
    .box-tamu:hover {
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    /* Responsiveness */
    @media (min-width: 768px) {
        .box-tamu {
            max-width: 48%;
            margin: 10px auto;
        }
    }

    @media (min-width: 1024px) {
        .box-tamu {
            max-width: 30%;
        }
    }

    .tamu-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 20px;
    }


    /* Style untuk Divisi */
    .divisi-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 20px;
    }

    .divisi-box {
        background-color: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        border: 1px solid #d1d1d1;
        border-radius: 8px;
        width: 100%;
        max-width: 300px; /* Ukuran maksimal per divisi box */
        margin-bottom: 20px;
    }

    .divisi-box h4 {
        color: #317671;
        font-size: 16pt;
        margin-bottom: 10px;
    }

    .divisi-box p {
        margin: 5px 0;
        font-size: 12pt;
    }

    @media (min-width: 768px) {
        .divisi-box {
            width: 48%;
        }
    }

    @media (min-width: 1024px) {
        .divisi-box {
            width: 30%;
        }
    }

    .event-img{
        width: 200px;
        height: 25px;
        margin-bottom: 10px;
    }

/* CSS khusus untuk menyelaraskan teks sebelum dan sesudah titik dua */
.panitia-list {
        display: flex;
        flex-direction: column;
    }

    .panitia-item {
        display: flex;
        justify-content: space-between;
        padding-bottom: 5px; /* Jarak antar item */
        font-size: 13pt;    
        font-weight: 700;
        color: #627271;
        padding-left: 20px;
    }

    .panitia-label {
        flex: 0 0 150px; /* Lebar tetap untuk label sebelum titik dua */
    }

    .panitia-value {
        flex: 1;
    }

</style>

<div class="judul-event">
    <h4>Event Buka Bersama</h4>
</div>

<div class="row">
    <!-- Box utama untuk event -->
    <div class="main-event">
        

        <!-- Banner kegiatan -->
        <img src="img/s-2.jpg" alt="Banner Kegiatan" class="event-banner" >
        
        <!-- Tanggal, Anggaran, dan Lokasi -->
        <div class="event-details">
            <p><i class="bi bi-calendar"></i>  20-10-2022</p>
            {{-- <p><i class="bi bi-wallet2"></i>  Rp. 100.000</p> --}}
            <p><i class="bi bi-geo-alt"></i>  MITA SELATAN PUJUT 01</p>
        </div>

        <div class="ketua">
            <img src="img/label-ketupat.png" alt="" class="event-img">
                <div class="panitia-list">
                <div class="panitia-item">
                    <span class="panitia-label">Ketua</span>
                    <span class="panitia-value">: Lazuardi Mandegar</span>
                </div>
                <div class="panitia-item">
                    <span class="panitia-label">Wakil</span>
                    <span class="panitia-value">: Agus Setiawan</span>
                </div>
                <div class="panitia-item">
                    <span class="panitia-label">Sekretaris</span>
                    <span class="panitia-value">: Agus Setiawan</span>
                </div>
                <div class="panitia-item">
                    <span class="panitia-label">Bendahara</span>
                    <span class="panitia-value">: Agus Setiawan</span>
                </div>
            </div>
        </div>
        <!-- Tamu Undangan -->
        <div class="card-body">
            <img src="img/label-tamu.png" alt="" class="event-img">
            <div class="tamu-container">
                <div class="box-tamu">
                    <h5>PAC IPNU IPPNU TERSONO</h5>
                </div>
                <div class="box-tamu">
                    <h5>Banom NU Pujut</h5>
                </div>
                <div class="box-tamu">
                    <h5>Kepala Desa Pujut</h5>
                </div>
            </div>
        </div>

        <!-- Susunan Panitia -->
        <div class="card-body">
            <img src="img/label-panitia.png" alt="" class="event-img">
            <div class="divisi-container">
                <div class="divisi-box">
                    <h4>Divisi Acara</h4>
                    <p>- Lazuardi Mandegar</p>
                    <p>- Agus Setiawan</p>
                </div>
                <div class="divisi-box">
                    <h4>Divisi Humas</h4>
                    <p>- Lazuardi Mandegar</p>
                    <p>- Agus Setiawan</p>
                </div>
            </div>
        </div>

        <!-- Jadwal Kegiatan -->
        <div class="card-body">
            <img src="img/label-acara.png" alt="" class="event-img">
            <table class="schedule-table">
                <thead>
                    <tr>
                        <th>Jam</th>
                        <th>Nama Kegiatan</th>
                        <th>Penanggung Jawab</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>08:00 - 09:00</td>
                        <td>Pembukaan</td>
                        <td>Lazuardi Mandegar</td>
                        <td>Upacara Pembukaan Acara</td>
                    </tr>
                    <tr>
                        <td>09:00 - 10:00</td>
                        <td>Sesi 1: Pengenalan</td>
                        <td>Agus Setiawan</td>
                        <td>Presentasi tentang acara</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Deskripsi Kegiatan -->
        <div class="card-body">
            <img src="img/label-deskripsi.png" alt="" class="event-img">
            <p>Lorem ipsum dolor sit amet...</p>
        </div>

        <!-- Tabel Anggaran -->
        <div class="card-body">
            <img src="img/label-anggaran.png" alt="" class="event-img">
            <table class="budget-table">
                <thead>
                    <tr>
                        <th>Sub Anggaran</th>
                        <th>Item</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Buah-buahan</td>
                        <td>Apel, Jeruk</td>
                        <td>Rp. 200.000</td>
                    </tr>
                    <tr>
                        <td>Perlengkapan</td>
                        <td>Kursi, Meja</td>
                        <td>Rp. 300.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Box untuk event lainnya -->
    <div class="other-event">
        <h4>Event Lainnya</h4>
        <ul>
            <li>Event 1</li>
            <li>Event 2</li>
            <li>Event 3</li>
        </ul>
    </div>
</div>

@endsection