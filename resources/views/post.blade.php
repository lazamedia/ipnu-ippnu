@extends ('layouts.main')

@section('container')

<style>
    .article-box {
        margin-top: 50px;
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }


    .article-box h1 {
        font-size: 21pt;
        font-weight: bold;
        color: #333;
    }

    .article-box p {
        font-size: 10pt;
        color: #777;
    }

    .article-box img {
        border-radius: 10px;
    }

    .back-btn {
        background-color: #007bff;
        border: none;
        padding: 10px 20px;
        border-radius: 50px;
        transition: background-color 0.3s;
    }

    .back-btn:hover {
        background-color: #0056b3;
    }

    .sidebar-box h5 {
        font-size: 13pt;
    }

    .sidebar-box p {
        font-size: 9pt;
    }

    .sidebar-box {
        margin-top: 50px;
        margin-left: 30px;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .sidebar-title {
        font-size: 1.5rem;
        color: #333;
        margin-bottom: 15px;
    }

    .latest-post {
        margin-bottom: 15px;
    }

    .latest-post-link {
        font-size: 1.2rem;
        color: #007bff;
        transition: color 0.3s;
    }

    .latest-post-link:hover {
        color: #0056b3;
    }

    .category-link {
        font-size: 1.2rem;
        color: #007bff;
        transition: color 0.3s;
    }

    .category-link:hover {
        color: #0056b3;
    }

    .isi-body {
        font-size: 12pt;
    }

    /* Media Query for Responsive Mode */
    @media (max-width: 768px) {
        .latest-post {
            background-color: #ffffff;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .sidebar-box {
            margin-left: 0px;
        }
        .latest-post h5 {
            font-size: 14pt;
        }

        .latest-post p {
            font-size: 10pt;
            color: #777;
        }
    }
</style>

<div class="container">
    <div class="row">
        <!-- Main Article Section -->
        <div class="col-md-8 article-box">
            <h1 class="mb-2">{{ $post->title }}</h1>
            <p>by. <a href="/posts?author={{ $post->author->username }}" class="text-decoration-none">{{ $post->author->name }}</a> - <a href="/posts?category={{ $post->category->slug }}" class="text-decoration-none">{{ $post->category->name }}</a></p>
            
            @if ($post->image)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid mt-3" alt="{{ $post->category->name }}">
                </div>
            @else
                <img src="https://source.unsplash.com/1200x400?{{ $post->category->name }}" alt="{{ $post->category->name }}" class="img-fluid mt-3 mb-3">
            @endif
            
            <article class="isi-body my-3">
                <p>{!! $post->body !!}</p>
            </article>
            
            <a href="/posts" class="mt-3 text-decoration-none btn btn-primary back-btn">Kembali</a>
        </div>
        
        <!-- Sidebar Section -->
        <div class="col-md-3 sidebar-box">
            <!-- Latest Posts Section -->
            <div class="mb-4">
                <h3 class="sidebar-title">Postingan Terbaru</h3>
                @foreach($latestPosts as $latestPost)
                    <div class="latest-post">
                        <a href="/posts/{{ $latestPost->slug }}" class="text-decoration-none latest-post-link">
                            <h5>{{ $latestPost->title }}</h5>
                        </a>
                        <p class="text-muted">{{ $latestPost->created_at->format('d M, Y') }}</p>
                    </div>
                    <hr>
                @endforeach
            </div>
            
            <!-- Categories Section -->
            <div>
                <h3 class="sidebar-title">Kategori</h3>
                <ul class="list-unstyled">
                    @foreach($categories as $category)
                        <li>
                            <a href="/posts?category={{ $category->slug }}" class="text-decoration-none category-link">{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
