@extends('layouts.main')

@section('container')

<style>
body {
    background-color: #f1f1f1;
}
.card-blank{
    width: 100%;
    height: 500px;
    padding: 50px;
    align-content: center;
    justify-content: center;
    align-items: center;
}
.body-blank{
    text-align: center;
    margin: auto;
    color: #048292;
    width: auto;
    height: auto;

}
.body-blank img {
    width: 200px;
    height: auto;
    margin-bottom: 20px;
}

</style>


<div class="card-blank">
    <div class="body-blank">
        <img src="img/maintenance.png" alt="">
        <h1>MAINTENANCE WEB</h1>
        <p>Saat ini halaman masih dalam tahap pengembangan</p>
    </div>
</div>


@endsection