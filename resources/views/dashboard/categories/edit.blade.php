@extends('dashboard.layouts.main')

@section('container')


<section class="judul">
  <h4>Edit Kategori </h4>
</section>
<section class="isi">


  <form method="post" action="/dashboard/categories/{{ $category->slug }}" class="mb-5" enctype="multipart/form-data">
    @method('put')
    @csrf
    <div class="mb-3">
      <label for="name" class="form-label">name</label>
      <input type="text" class="form-control @error ('name') is-invalid @enderror" id="name" name="name" required autofocus value="{{ old('name', $category->name) }}">
      @error('name')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
      @enderror
      
    </div>

    
    
    <div class="mb-3">
        <label for="slug" class="form-label">Slug</label>
        <input type="text" class="form-control @error ('slug') is-invalid @enderror" id="slug" name="slug" required value="{{ old('slug', $category->slug) }}">
        @error('slug')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
      @enderror
    </div>


    <div class="mb-3">
      <label for="image" class="form-label">Input Gambar</label>
      <input type="hidden" name="oldImage" value="{{ $category->image }}">
      @if ($category->image)
      <img src="{{ asset('storage/'. $category->image) }}" class="img-preview img-fluid mb-3 col-sm-5 d-block" alt="">
      @else
      <img class="img-preview img-fluid mb-3 col-sm-5" alt="">
      @endif
      
      <input class="form-control  @error ('image') is-invalid @enderror" type="file" id="image" name="image" onchange="previewImage()">
      <p class="text-primary">Rekomendasi ukuran gambar 3:4</p>
      @error('image')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
      @enderror
    </div>




    <button type="submit" class="btn btn-primary">Update</button>
  </form>
</section>

    <script>
        const title = document.querySelector ('#name');
        const title = document.querySelector ('#slug');

        title.addEvenListener('change', function() {
            fetch('/dashboard/categories/checkSlug?title=' + title.value)
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