@extends('dashboard.layouts.main')

@section('container')

<div class="container">
    <div class="row my-3">
        <div class="col-lg-9">
            <h1 class="mb-2">{{ $category->title }}</h1>
            <article>
               
                <a href="/dashboard/categories" class="btn btn-success">Back to category</a>
                <a href="/dashboard/categories/{{ $category->slug }}/edit" class="btn btn-warning"><i class="bi bi-pencil-square"></i> Edit</a>
                

                <form action="/dashboard/posts/{{ $category->slug }}" method="post" class="d-inline">
                    @method ('delete')
                    @csrf
                    <button class="btn btn-danger " onclick="return confirm('Apakah Kamu Ingin Hapus?')"><i class="bi bi-x-circle"></i> Delete</button>
                  </form>
                    @if ($category->image)
                        <div style="max-height:auto; max-with:300px; overflow:hidden;">
                            <img src="{{ asset('storage/' . $category->image) }}" class="img-fluid mt-3" alt="{{ $category->name }}">
                        </div>
                          
                      @else
                         <img src="https://source.unsplash.com/1200x400?{{ $category->name }}" alt="{{ $category->name }}" class="img-fluid mt-3">
                     @endif
                                    
                    
                
        
            </article>
        
            
        </div>
    </div>
</div>

@endsection