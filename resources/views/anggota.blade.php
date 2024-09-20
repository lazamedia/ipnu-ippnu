@extends('layouts.main')

@section('container')
<style>

    .container-tabel h2{
        text-align: center;
        font-family: 'poppins';
    }
        .container-tabel {
            width: 80%;
            padding: 20px;
            font-family: 'poppins';
            background-color: #fff;
            align-content: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            animation: fadeIn 1s ease;
            margin: 100px auto;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #f2f2f2;
        }
        
        @media (max-width: 600px) {
            .container-tabel {
                width: 90%;
            }
        }
    
    /* PENGAJAR */
    .section-pengajar {
      text-align: center;
      padding: 20px;
      margin-top: 60px;
    }
    .section-pengajar h2 {
      margin: 0;
      position: relative;
      display: inline-block;
      padding-bottom: 10px;
    }
    .section-pengajar h2::after {
      content: "";
      display: block;
      width: 50px;
      height: 2px;
      background-color: black;
      margin: 10px auto 10px;
    }
    .box-pengajar {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 20px;
    }
    .profile-card {
      background-color: #fafcfc;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(2, 147, 180, 0.589);
      padding: 20px;
      border-color: #000000;
      text-align: center;
      margin-top: 0px;
      width: 200px;
      position: relative;
      transition: transform 0.3s ease-in-out;
      cursor: pointer;
    }
    
    .profile-card:hover {
      transform: translateY(-5px);
    }
    
    .profile-pic {
      width: 90px;
      height: 90px;
      object-fit: cover;
      border-radius: 50%;
      margin-bottom: 10px;
    }
    
    @media (max-width: 800px) {
      .box-pengajar {
          flex-direction: column;
          align-items: center;
      }
      
      .box-p {
          width: 100%;
          max-width: 300px;
      }
    }
    
    .name {
      margin-bottom: 5px;
      font-size: 18px;
    }
    
    .position {
      color: #666666;
      font-size: 14px;
    }
    .semester {
      position: absolute;
      bottom: 0;
      right: 0;
      background-color: #028090;
      color: white;
      padding: 5px 10px;
      border-bottom-right-radius: 8px;
      border-top-left-radius: 8px;
      font-size: 12px;
      margin: 0;
    }
    
    /* POPUP */
    .popup {
      display: none;
      position: fixed;
      z-index: 9999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgb(0,0,0);
      background-color: rgba(0,0,0,0.4);
    }
    
    .popup-content {
      background-color: #fefefe;
      margin: auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      max-width: 600px;
      border-radius: 10px;
      position: relative;
      top: 50%;
      transform: translateY(-50%);
      text-align: center;
    }
    
    .popup-content img {
      width: 100%;
      max-height: 550px;
      object-fit: cover;
      border-radius: 10px;
      overflow: hidden;
    }
    
    @media (max-width: 600px) {
      .popup-content {
        width: 95%;
      }
    }
    
    .close {
      position: absolute;
      top: 10px;
      right: 25px;
      color: #aaa;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }
    
    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }
    
    </style>

        
        <section class="section-pengajar">
            <h2>Ketua</h2>
            <div class="box-pengajar">
                @foreach ($mahasiswas as $mahasiswa) 
                    @if (in_array($mahasiswa->divisi, ['Ketua Umum', 'Ketua 1', 'Ketua 2']))
                        <div class="profile-card" onclick="showPopup('{{ asset('storage/' . $mahasiswa->image) }}')">
                            @if ($mahasiswa->image)
                                <img src="{{ asset('storage/' . $mahasiswa->image) }}" alt="{{ $mahasiswa->name }}" class="profile-pic">
                            @else
                                <img src="img/logo.jpg" alt="Profile 1" class="profile-pic">
                            @endif
                            
                            <h3 class="name">{{ $mahasiswa->nama }}</h3>
                            <p class="position">{{ $mahasiswa->divisi }}</p>
                            <div class="semester">Semester {{ $mahasiswa->semester }}</div>
                        </div>
                    @endif
                @endforeach
            </div>
        </section>
        
        <section class="section-pengajar">
            <h2>Team Member</h2>
            <div class="box-pengajar">
                @foreach ($mahasiswas as $mahasiswa) 
                    @if (!in_array($mahasiswa->divisi, ['Ketua Umum', 'Ketua 1', 'Ketua 2']))
                        <div class="profile-card" onclick="showPopup('{{ asset('storage/' . $mahasiswa->image) }}')">
                            @if ($mahasiswa->image)
                                <img src="{{ asset('storage/' . $mahasiswa->image) }}" alt="{{ $mahasiswa->name }}" class="profile-pic">
                            @else
                                <img src="img/logo.jpg" alt="Profile 1" class="profile-pic">
                            @endif
                            
                            <h3 class="name">{{ $mahasiswa->nama }}</h3>
                            <p class="position">{{ $mahasiswa->divisi }}</p>
                            <div class="semester">Semester {{ $mahasiswa->semester }}</div>
                        </div>
                    @endif
                @endforeach
            </div>
        </section>
    
        <div id="popup" class="popup">
            <div class="popup-content">
                <span class="close" onclick="closePopup()">&times;</span>
                <img id="popup-image" src="" alt="Popup Image">
            </div>
        </div>
    
        <script>
            function showPopup(imageSrc) {
                document.getElementById('popup-image').src = imageSrc;
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