@extends('layouts.main')

@section('container')

<style>
  /* HEADER */
  @media (max-width: 768px) {
    .artikel{
      padding: 0px;
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
    width: 100%;
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
      text-align: center; 
    }

    .box-judul {
      flex-basis: 100%; 
      margin-bottom: 20px; 
      padding: 0;
      align-items: center;
    }

    .input-cari {
      justify-content: center;
      min-width: 350px;
      width: 100%;
    }
  }
  /* END --- */

  /* BOX ARTIKEL UTAMA */
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

<div class="row">
   <div class="artikel-kiri">

   </div>
   <div class="artikel-kanan">
    
   </div>
</div>




@endsection
