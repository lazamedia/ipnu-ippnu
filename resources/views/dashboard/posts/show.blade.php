@extends('dashboard.layouts.main')

@section('container')

<section class="judul">
    <h4>{{ $post->title }}</h4>
</section>
  
  <section class="isi">
  
    <article>
               
        <a href="/dashboard/posts" class="btn btn-success">Back to my Post</a>
        <a href="/dashboard/posts/{{ $post->slug }}/edit" class="btn btn-warning"><i class="bi bi-pencil-square"></i> Edit</a>
        

        <form action="/dashboard/posts/{{ $post->slug }}" method="post" class="d-inline">
            @method ('delete')
            @csrf
            <button class="btn btn-danger " onclick="return confirm('Apakah Kamu Ingin Hapus?')"><i class="bi bi-x-circle"></i> Delete</button>
          </form>
            @if ($post->image)
                <div style="max-height:auto; max-with:300px; overflow:hidden;">
                    <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid mt-3" alt="{{ $post->category->name }}">
                </div>
                  
              @else
                 <img src="https://source.unsplash.com/1200x400?{{ $post->category->name }}" alt="{{ $post->category->name }}" class="img-fluid mt-3">
             @endif
        <div>
            <article class="my-3 fs-5">
                {!! $post ->body !!}
            </article>
        
        </div>


    </article>


  </section>
  



@endsection