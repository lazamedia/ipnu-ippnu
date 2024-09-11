@extends('layouts.main')

@section('container')

<style>
    /* Styling untuk kontainer anggota */
    .section-anggota {
        text-align: center;
        padding: 20px;
        margin-top: 60px;
        border-top: 2px solid #317671;
        border-bottom: 2px solid #317671;
    }

    .section-anggota h2 {
        margin: 0;
        font-family: 'poppins';
    }

    .box-anggota {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .profile-card-anggota {
        background-color: #fafcfc;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(2, 147, 180, 0.589);
        padding: 20px;
        text-align: center;
        width: 200px;
        position: relative;
        transition: transform 0.3s ease-in-out;
        cursor: pointer;
        flex: 1 1 calc(20% - 20px);
        max-width: 200px;
    }

    .profile-card-anggota:hover {
        transform: translateY(-5px);
    }

    .profile-pic-anggota {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border-radius: 50%;
        margin-bottom: 10px;
    }

    @media (max-width: 800px) {
        .profile-card-anggota {
            flex: 1 1 calc(50% - 20px);
        }
    }

    .name-anggota {
        margin-bottom: 5px;
        font-size: 18px;
    }

    .position-anggota {
        color: #666666;
        font-size: 14px;
    }

    .semester-anggota {
        position: absolute;
        bottom: 0;
        right: 0;
        background-color: #028090;
        color: white;
        padding: 5px 10px;
        border-bottom-right-radius: 8px;
        border-top-left-radius: 8px;
        font-size: 12px;
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
        background-color: rgba(0, 0, 0, 0.4);
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

<section class="section-anggota">
    <h4>Ketua</h4>
    <div class="box-anggota">
        @for ($i = 0; $i < 5; $i++)
        <div class="profile-card-anggota" onclick="showPopup('img/me.jpg')">
            <img src="img/me.jpg" alt="Profile {{ $i + 1 }}" class="profile-pic-anggota">
            <h3 class="name-anggota">Lazuardi Mandegar {{ $i + 1 }}</h3>
            <p class="position-anggota">Sekretaris</p>
            <div class="semester-anggota">IPNU</div>
        </div>
        @endfor
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
