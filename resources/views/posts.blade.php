@extends('layouts.main')

@section('container')
<link rel="stylesheet" href="css/about.css">
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f7f9fb;
    }

    /* Judul Section */
    .judulpost {
        width: 100%;
        text-align: center;
        margin-bottom: 20px;
        animation: fadeIn 0.8s ease-out;
    }

    .text1 {
        font-size: 24pt;
        font-weight: 600;
        color: #ffffff;
    }

    /* Post Container */
    .postt {
        width: 100%;
        padding: 30px;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    /* Box Post */
    .boxpost {
        border-radius: 9px;
        border: 1px solid #cecece;
        padding: 20px;
        width: 300px;
        max-height: 450px;
        background-color: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        position: relative;
        overflow: hidden;
    }

    .boxpost:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    /* Gambar Post */
    .post-img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 5px;
    }

    /* Kategori Tag */
    .kategori {
        background-color: #005d8b;
        padding: 5px 10px;
        color: white;
        border-radius: 10px;
        font-size: small;
        position: absolute;
        top: 10px;
        left: 10px;
    }

    /* Waktu Posting */
    .time {
        font-size: 12px;
        color: #797b7c;
        position: absolute;
        top: 10px;
        right: 10px;
    }

    /* Judul Post */
    .judul {
        font-size: 15pt;
        font-weight: 600;
        color: #1d1d1d;
        margin: 15px 0 10px 0;
        text-align: left;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
    }

    /* Author dan Link */
    .author {
        color: #005d8b;
        margin-top: -10px;
        font-size: 11pt;
    }

    .read {
        text-align: right;
        text-decoration: none;
        display: block;
        margin-top: 20px;
        color: #005d8b;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .read:hover {
        color: #005b4f;
    }

    /* Isi Singkat */
    .isi-singkat {
        font-size: 10pt;
        line-height: 1.6;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
    }

    /* Artikel Utama (Terbaru) */
    .featured-post {
        display: flex;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        transition: transform 0.3s, box-shadow 0.3s;
        position: relative;
    }

    .featured-post:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .featured-img {
        width: 50%;
        border-radius: 10px;
        object-fit: cover;
        max-height: 300px;
    }

    .featured-content  h2 {
      font-weight: 400;
    }
    .featured-content p{
      font-size: 1rem;
    }
    .featured-content {
        width: 50%;
        padding-left: 20px;
    }

    .featured-title {
        font-size: 24pt;
        font-weight: 600;
        color: #005d8b;
        margin-bottom: 15px;
    }

    .featured-excerpt {
        font-size: 14pt;
        color: #333;
        line-height: 1.6;
    }

    /* Animasi */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    /* Responsif untuk Mobile */
    @media (max-width: 768px) {
        .text1 {
            font-size: 20pt;
        }

        .boxpost {
            width: 100%;
            margin-bottom: 20px;
        }

        .featured-post {
            flex-direction: column;
        }

        .featured-img {
            width: 100%;
            max-height: 250px;
        }

        .featured-content {
            width: 100%;
            padding-left: 0;
            padding-top: 20px;
        }

        .judul {
            font-size: 14pt;
        }

        .author {
            font-size: 10pt;
        }

        .isi-singkat {
            font-size: 10pt;
        }
        .artikel-utama{
          padding: 20px;
        }
    }
    .artikel-utama{
      width: 100%;
      padding: 50px;
    }
    .judul-box{
      background-color: #317671;
      width: 100%;
      color: #ffffff; 
      padding: 30px;
      min-height: 200px;
    }
    .box-404{
      width: 100%;
      align-content: center;
      align-items: center;
      justify-content: center;
      text-align: center;
      margin-top:20px;
      padding: 20px;
      gap: 20px; 
      color: #777777;
    }
</style>

<div class="judul-box">
        <div class="judulpost">
          <span class="text1">{{ $title }}</span>
      </div>

      <div class="row mb-3 justify-content-center">
        <div class="col-md-6">
            <form action="/posts">
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif

                @if (request('author'))
                    <input type="hidden" name="author" value="{{ request('author') }}">
                @endif

                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search.." name="search" value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
            </form>
        </div>
      </div>
</div>

{{-- <div class="artikel-utama">
        <!-- Artikel Utama Terbaru -->
      @if($posts->count())
      <div class="featured-post">
          @if ($posts[0]->image)
              <img src="{{ asset('storage/' . $posts[0]->image) }}" class="featured-img" alt="{{ $posts[0]->title }}">
          @else
              <img src="https://source.unsplash.com/1200x400?{{ $posts[0]->category->name }}" class="featured-img" alt="{{ $posts[0]->title }}">
          @endif
          <div class="featured-content">
              <h2 class="featured-title">{{ $posts[0]->title }}</h2>
              <p class="featured-excerpt">{{ $posts[0]->excerpt }}</p>
              <a href="/posts/{{ $posts[0]->slug }}" class="read">Read More...</a>
          </div>
      </div>
      @endif
</div> --}}



<!-- Post List -->
<section class="postt">
    @if($posts->count())
        @foreach ($posts as $post)
            <div class="boxpost fade-in">
                <span class="kategori"><a href="/posts?category={{ $post->category->slug }}" class="text-white text-decoration-none">{{ $post->category->name }}</a></span>
                <span class="time">{{ $post->created_at->diffForHumans() }}</span>
                @if ($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" class="post-img mt-4" alt="{{ $post->title }}">
                @else
                    <img src="https://source.unsplash.com/500x400?{{ $post->category->name }}" class="post-img" alt="{{ $post->title }}">
                @endif
                <h4 class="judul">{{ $post->title }}</h4>
                <span class="author">By. <a href="/posts?author={{ $post->author->username }}" class="text-decoration-none">{{ $post->author->name }}</a></span>
                <p class="isi-singkat mt-2">{{ $post->excerpt }}</p>
                <a class="read" href="/posts/{{ $post->slug }}">Read More..</a>
            </div>
        @endforeach
    @else
        <div class="box-404">
          <img src="img/notfound.png" style="width:100px; height:auto;" alt="">
          <p class="text-center fs-4 mt-3">Postingan tidak ditemukan</p>
        </div>
    @endif
</section>

<div class="d-flex justify-content-end">
    {{ $posts->links() }}
</div>

@endsection
