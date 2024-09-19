@extends('dashboard.layouts.main')

@section('content')

<script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/dashboard/makesta.css') }}">



<div class="card">
    <div class="card-header">
        <h4>Create Artikel</h4>
    </div>
    <div class="card-body">
        <form method="post" action="/dashboard/posts" class="mb-5" enctype="multipart/form-data">
            @csrf

            <div class="row">
              <div class="col-md-6">
                  <div class="form-group row">
                      <label for="title" class="col-sm-3 col-form-label">Title</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>                          @error('title')
                              <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>

                  <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                 </div>

                <div class="form-group row">
                  <label for="slug" class="col-sm-3 col-form-label">slug</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}" required>                      @error('slug')
                          <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                </div>

                <div class="form-group row">
                  <label for="category" class="col-sm-3 col-form-label">Category</label>
                  <div class="col-sm-9">
                  <select class="form-control" name="category_id">
                      @foreach ($categories as $category)
                          @if(old('category_id') == $category->id)
                          <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                          @else 
                          <option value="{{ $category->id }}">{{ $category->name }}</option>
                          @endif
                      @endforeach
                      
                    </select>
                  </div>
                  
              </div>
                   
              </div>
      
              <!-- Kolom untuk upload gambar (drag & drop) -->
              <div class="col-md-6">
                  <div class="form-group">
                      <label for="image">Gambar Artikel</label>
                      <div class="drag-drop-area" id="dragDropArea">
                          Drop your image here or click to upload
                          <input type="file" id="fileInput" name="image" style="display:none;" accept="image/*">
                      </div>
                      <div class="image-preview-wrapper" id="imagePreviewWrapper">
                          <img id="imagePreview" alt="Preview Gambar" />
                          <button type="button" class="remove-image" id="removeImage">&times;</button>
                      </div>
                  </div>
                  @error('image')
                      <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
              </div>
          </div>
        
            <div class="mb-3">
                <label for="body" class="form-label">Body</label>
                <textarea name="body" class="ckeditor" id="editor" value="{{ old('body') }}"></textarea>
                @error('body')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        
        
        
            <button type="submit" class="btn btn-primary">Create Post</button>
          </form>
    </div>
</div>

<script src="{{ asset('assets/dashboard/makesta.js') }}"></script>
<script>
  CKEDITOR.replace('editor');

  const title = document.querySelector('#title');
    const slug = document.querySelector('#slug');

    title.addEventListener('input', function() {
        let slugText = title.value.toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '') // Hapus karakter non-alphanumeric dan non-spasi
                        .replace(/\s+/g, '-') // Ganti spasi dengan tanda hubung
                        .replace(/-+/g, '-'); // Hapus tanda hubung berlebih
        slug.value = slugText;
    });
</script>
    
@endsection