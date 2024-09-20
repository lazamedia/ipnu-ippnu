@extends('layouts.main')

@section('container')
<link rel="stylesheet" href="css/anggota.css">    

<style>


/* Animasi kemunculan elemen */
@keyframes fadeInUp {
  0% {
    opacity: 0;
    transform: translateY(20px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>  

    <section class="judul">
      <h3>Pengurus IPNU - IPPNU Ranting Pujut 01</h3>
      <p>"Tim pengurus IPNU - IPPNU Pujut 01 adalah individu-individu yang berdedikasi untuk memajukan organisasi dan membina pelajar NU di wilayah Pujut."</p>
      <p class="periode">Masa Khidmat 2024 - 2025 </p>
    </section>

    <section class="section-pengajar">
        <div class="box-pengajar">
            @foreach ($pengurus as $ketua) 
                @if ($ketua->divisi == 'ketua')
                    <div class="profile-card" onclick="showPopup('{{ asset('storage/' . $ketua->foto) }}')">
                        @if ($ketua->foto)
                            <img src="{{ asset('storage/' . $ketua->foto) }}" alt="{{ $ketua->nama_lengkap }}" class="profile-pic">
                        @else
                            <img src="img/logo.jpg" alt="Profile 1" class="profile-pic">
                        @endif
                        
                        <h3 class="name">{{ $ketua->nama_lengkap }}</h3>
                        <p class="position">{{ $ketua->divisi }}</p>
                        <div class="semester"> {{ $ketua->pelajar }}</div>
                    </div>
                @endif
            @endforeach
        </div>
    </section>

    <section class="section-pengajar">
        <div class="box-pengajar">
            @foreach ($pengurus as $anggota) 
                @if ($anggota->divisi != 'ketua')
                    <div class="profile-card" onclick="showPopup('{{ asset('storage/' . $anggota->foto) }}')">
                        @if ($anggota->foto)
                            <img src="{{ asset('storage/' . $anggota->foto) }}" alt="{{ $anggota->nama_lengkap }}" class="profile-pic">
                        @else
                            <img src="img/logo.jpg" alt="Profile 1" class="profile-pic">
                        @endif
                        
                        <h3 class="name">{{ $anggota->nama_lengkap }}</h3>
                        <p class="position">{{ $anggota->divisi }}</p>
                        <div class="semester"> {{ $anggota->pelajar }}</div>
                    </div>
                @endif
            @endforeach
        </div>
    </section>

    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closePopup()">&times;</span>
            <img id="popup-foto" src="" alt="Popup foto">
        </div>
    </div>

    <script>
        function showPopup(fotoSrc) {
            document.getElementById('popup-foto').src = fotoSrc;
            document.getElementById('popup').style.display = "block";
        }

        function closePopup() {
            document.getElementById('popup').style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('popup')) {
                closePopup();
            }
        }
    </script>
@endsection
