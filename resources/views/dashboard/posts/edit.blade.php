@extends('dashboard.layouts.main')

@section('content')

<script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>

<style>
  .drag-drop-area {
      border: 2px dashed #ccc;
      border-radius: 10px;
      padding: 20px;
      text-align: center;
      font-size: 16px;
      color: #aaa;
      cursor: pointer;
      position: relative;
  }

  .drag-drop-area.dragover {
      border-color: #4caf50;
      color: #4caf50;
  }

  .preview {
      margin-top: 15px;
      position: relative;
  }

  .preview img {
    width: 100%;
    height: auto;
    max-height: 250px;
    border-radius: 10px;
    object-fit: cover;
  }

  .remove-image {
      position: absolute;
      top: 10px;
      right: 10px;
      background-color: rgba(255, 255, 255, 0.7);
      border: none;
      border-radius: 50%;
      padding: 5px 10px;
      cursor: pointer;
      font-size: 16px;
      color: #333;
      transition: background-color 0.3s ease;
  }

  .remove-image:hover {
      background-color: rgba(255, 0, 0, 0.8);
      color: #fff;
  }
</style>

<div class="card">
    <div class="card-header">
        <h4>Edit Artikel</h4>
    </div>
    <div class="card-body">
        <form id="editForm" action="{{ route('posts.update', $post->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Menambahkan method PUT untuk form edit -->

            <div class="row">
              <div class="col-md-6">
                  <div class="form-group row">
                      <label for="title" class="col-sm-3 col-form-label">Title</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title) }}" required>
                        @error('title')
                              <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>

                  <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $post->name) }}" required>
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                 </div>

                <div class="form-group row">
                  <label for="slug" class="col-sm-3 col-form-label">Slug</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $post->slug) }}" required>
                    @error('slug')
                          <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                  </div>
                </div>

                <div class="form-group row">
                  <label for="category" class="col-sm-3 col-form-label">Category</label>
                  <div class="col-sm-9">
                  <select class="form-control" name="category_id">
                      @foreach ($categories as $category)
                          <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                              {{ $category->name }}
                          </option>
                      @endforeach
                    </select>
                  </div>
              </div>
              </div>
      
              <div class="col-md-6">
                  <div class="form-group">
                      <label for="image">Gambar Artikel</label>
                      <div class="drag-drop-area" id="drag-drop-area" style="display: {{ $post->image ? 'none' : 'block' }}">
                          Drop your image here or click to upload
                          <input type="file" id="fileInput" name="image" style="display:none;" accept="image/*">
                      </div>
                      <div class="preview" id="imagePreview">
                          @if($post->image)
                              <img src="{{ Storage::url($post->image) }}" alt="Current Image" id="uploadedImage">
                              <button type="button" class="remove-image" id="removeImage">&times;</button>
                          @else
                              <img id="imagePreview" alt="Preview Gambar" />
                          @endif
                      </div>
                  </div>
                  @error('image')
                      <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
              </div>
          </div>
        
            <div class="mb-3">
                <label for="body" class="form-label">Body</label>
                <textarea name="body" class="ckeditor" id="editor">{{ old('body', $post->body) }}</textarea>
                @error('body')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        
            <button type="submit" class="btn btn-primary">Update Post</button>
          </form>
    </div>
</div>

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

    const dragDropArea = document.getElementById('drag-drop-area');
    const fileInput = document.getElementById('fileInput');
    const imagePreview = document.getElementById('imagePreview');
    const removeImageButton = document.getElementById('removeImage');
    const editForm = document.getElementById('editForm');

    // Tampilkan drag-drop area jika gambar dihapus
    if (removeImageButton) {
        removeImageButton.addEventListener('click', function() {
            imagePreview.innerHTML = ''; // Hapus preview gambar
            dragDropArea.style.display = 'block'; // Tampilkan kembali area drag and drop
            fileInput.value = ''; // Kosongkan input file
        });
    }

    // Fungsi klik pada gambar untuk mengganti gambar
    const uploadedImage = document.getElementById('uploadedImage');
    if (uploadedImage) {
        uploadedImage.addEventListener('click', () => {
            fileInput.click(); // Klik gambar untuk mengganti
        });
    }

    // Drag and drop functionality
    dragDropArea.addEventListener('click', () => fileInput.click());

    dragDropArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        dragDropArea.classList.add('dragover');
    });

    dragDropArea.addEventListener('dragleave', () => dragDropArea.classList.remove('dragover'));

    dragDropArea.addEventListener('drop', (e) => {
        e.preventDefault();
        dragDropArea.classList.remove('dragover');
        const file = e.dataTransfer.files[0];
        if (file) {
            fileInput.files = e.dataTransfer.files;
            previewImage(file);
        }
    });

    fileInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            previewImage(file);
        }
    });

    function previewImage(file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.innerHTML = `<img src="${e.target.result}" alt="Image Preview">`;
            dragDropArea.style.display = 'none'; // Sembunyikan drag-drop area setelah gambar diupload
        };
        reader.readAsDataURL(file);
    }

</script>

@endsection
