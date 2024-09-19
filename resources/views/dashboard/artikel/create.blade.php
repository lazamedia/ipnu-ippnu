@extends('dashboard.layouts.main')

@section('content')

<script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>

<div class="card">
    <div class="card-header">
        <h4>Create Artikel</h4>
    </div>
    <div class="card-body">
        <form method="post" action="/dashboard/posts" class="mb-5" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control @error ('title') is-invalid @enderror" id="title" name="title" required autofocus value="{{ old('title') }}">
              @error('title')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
              @enderror
              
            </div>
        
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control @error ('name') is-invalid @enderror" id="name" name="name" required autofocus value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                @enderror
                
              </div>
            
            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control @error ('slug') is-invalid @enderror" id="slug" name="slug" required value="{{ old('slug') }}">
                @error('slug')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
              @enderror
            </div>
        
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" name="category_id">
                    @foreach ($categories as $category)
                        @if(old('category_id') == $category->id)
                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                        @else 
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endif
                    @endforeach
                    
                  </select>
                
            </div>
        
            <div class="mb-3">
              <label for="image" class="form-label">Input Gambar</label>
              <img class="img-preview img-fluid mb-3 col-sm-5" alt="">
              <input class="form-control  @error ('image') is-invalid @enderror" type="file" id="image" name="image" onchange="previewImage()">
              <p class="text-primary">Rekomendasi ukuran gambar 3:4</p>
              @error('image')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
              @enderror
            </div>
        
            <div class="mb-3">
                <label for="body" class="form-label">Body</label>
                <input id="body" type="hidden" name="body" value="{{ old('body') }}">
                <trix-editor input="body"></trix-editor>
                @error('body')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        
        
        
            <button type="submit" class="btn btn-primary">Create Post</button>
          </form>
    </div>
</div>

<script>
    const title = document.querySelector ('#title');
    const title = document.querySelector ('#slug');

    title.addEvenListener('change', function() {
        fetch('/dashboard/posts/checkSlug?title=' + title.value)
        .then(response => response.json())
        .then(data => slug.value = data.slug)
    });

    function previewImage() {
    const image = document.querySelector('#image');
    const img-preview = document.querySelector('.img-preview');

    imagePreview.style.display = 'block';

    const oFReader = new FileReader();
    oFReader.readAsDataURL(image.files[0]);

    oFReader.onload = function(oFREvent){
      imagePreview.src = oFREvent.target.result;
    }
    }
    
</script>

@endsection
