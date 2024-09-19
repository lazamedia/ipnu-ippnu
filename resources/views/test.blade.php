@extends('layouts.main')

@section('container')

<style>
  /* HEADER */
  @media (max-width: 768px) {
    .artikel{
      padding: 30px;
      padding-right: 0px;
      padding-left: 0px;
    }
  }
  .artikel{
    padding: 30px;
  }
  .artikel-header {
    display: flex;
    justify-content: space-between;
    align-items: center; 
    min-height: 300px;
    background-color: #005d92;
    padding: 20px;
  }

  .box-judul {
    flex-basis: 45%; 
    display: flex;
    flex-direction: column; 
    justify-content: center;
    align-items: flex-start; 
    padding: 80px;
  }

  .artikel-kanan {
    text-align: left;
  }

  .artikel-kanan h3 {
    color: white;
    font-size: 2rem;
    margin-bottom: 10px;
    animation: fadeInLeft 1s ease;
  }

  .artikel-kanan p {
    color: white;
    font-size: 1rem;
    animation: fadeInLeft 1.2s ease; 
  }

  .input-cari {
    display: flex;
    justify-content: center;
    align-items: center;
    animation: fadeInRight 1s ease;
  }

  .input-cari input {
    margin-right: 10px;
  }

  /* Animasi Fade In */
  @keyframes fadeInLeft {
    from {
      opacity: 0;
      transform: translateX(-100px);
    }
    to {
      opacity: 1;
      transform: translateX(0);
    }
  }

  @keyframes fadeInRight {
    from {
      opacity: 0;
      transform: translateX(100px);
    }
    to {
      opacity: 1;
      transform: translateX(0);
    }
  }

 
  @media (max-width: 768px) {
    .artikel-header {
      flex-direction: column; 
      justify-content: center;
    }

    .box-judul {
      flex-basis: 100%; 
      margin-bottom: 20px; 
      padding: 0;
    }

    .input-cari {
      justify-content: center;
    }
  }
  /* END --- */

  /* BOX ARTIKEL UTAMA */
  /* Gaya untuk artikel utama */
  .artikel-utama{
    background-color: #ffffff;
    width: 100%;
    min-height: 400px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Perbaiki shadow untuk kesan 3D */
    margin-top: -6%;
    border-radius: 20px; 
    display: flex;
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* Transisi untuk hover */
  }

  .artikel-utama:hover {
    transform: translateY(-5px); /* Efek hover untuk menarik perhatian */
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
  }

  /* Konten kiri artikel */
  .utama-kiri {
    padding: 20px;
    justify-content: center;
    width: 70%;
    background-color: #f0f0f0; /* Ganti warna background untuk kontras */
    border-top-left-radius: 20px;
    border-bottom-left-radius: 20px;
  }

  .utama-kiri h4 {
    font-size: 1.5rem; /* Ukuran font yang lebih besar dan readable */
    font-weight: bold;
    margin-top: 10px;
    color: #333;
  }

  .utama-kiri p {
    font-size: 1rem;
    color: #555;
    margin-bottom: 20px;
  }

  .utama-kiri a {
    font-size: 1rem;
    color: #005d92;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s ease;
  }

  .utama-kiri a:hover {
    color: #ff6600; /* Efek hover untuk link */
  }

  .img-utama{
    width: 100%;
    height: auto;
    object-fit: cover;
    border-radius: 10px;
  }

  /* Konten kanan artikel */
  .utama-kanan {
    background-color: #005d92;
    width: 30%;
    padding: 20px;
    border-top-right-radius: 20px;
    border-bottom-right-radius: 20px;
  }

  .utama-kanan h5 {
    font-size: 1.2rem;
    font-weight: bold;
    color: white;
  }

  .utama-kanan p {
    font-size: 0.9rem;
    color: #ddd;
  }

  .box-kecil {
    display: flex;
    gap: 10px;
    align-items: flex-start;
    margin-bottom: 20px;
  }

  .box-kecil img {
    border-radius: 10px;
    transition: transform 0.3s ease;
  }

  .box-kecil img:hover {
    transform: scale(1.1); /* Efek hover pada gambar kecil */
  }

  .conten-box-kecil a {
    color: #ffcc00; 
    font-size: 0.9rem;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .conten-box-kecil a:hover {
    color: #ffffff; /* Efek hover untuk link kecil */
  }

  /* Responsivitas */
  @media (max-width: 768px) {
    .artikel-utama {
      flex-direction: column;
    }

    .utama-kiri, .utama-kanan {
      width: 100%;
      border-radius: 20px;
    }

    .utama-kiri {
      border-bottom-left-radius: 0;
      border-bottom-right-radius: 20px;
    }

    .utama-kanan {
      border-top-right-radius: 0;
      border-bottom-left-radius: 0;
    }
  }

  /* END --- */

</style>

<section class="artikel-header">

  <div class="artikel-kanan box-judul">
    <h3>Artikel Terbaru</h3>
    <p>Semua Postingan Terbaru</p> <!-- Deskripsi di bawah judul -->
  </div>

  <div class="artikel-kiri box-judul">
    <div class="input-group input-cari">
      <input type="text" class="form-control" placeholder="Search.." name="search" value="{{ request('search') }}">
      <button class="btn btn-primary" type="submit">Cari</button>
    </div>
  </div>

</section>

<div class="artikel">
    <div class="artikel-utama">
      <div class="utama-kiri">
        <img src="img/s-1.jpg" class="img-utama" alt="">
        <div class="kategori"><p>IPNU-IPPNU</p></div>
        <h4>Judul</h4>
        <p>Deskripsi</p>
        <a href="">Reamore</a>
      </div>
      <div class="utama-kanan">
        <div class="box-kecil">
          <img src="img/s-1.jpg" style="width: 100px; height:auto;" alt="">
          <div class="conten-box-kecil">
            <h5>Judul</h5>
            <p>Kategori</p>
            <p>deskripsi</p>
            <a href="">Readmore..</a>
          </div>
        </div>
      </div>
    </div>





</div>




@endsection
