@extends('dashboard.layouts.main')

@section('content')


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
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        cursor: pointer;
    }
  
    .remove-image {
        position: absolute;
        top: 10px;
        right: 10px;
        border: 1px solid #007286;
        border: none;
        border-radius: 50%;
        padding: 3px 10px;
        cursor: pointer;
        font-size: 16px;
        color: #333;
        transition: background-color 0.3s ease;
    }
  
    .remove-image:hover {
        background-color: rgba(0, 48, 77, 0.8);
        color: #fff;
    }
  </style>

    <style>
        .image-profile{
            text-align: center;
            align-items: center;
            justify-content: center;
            align-content: center;
        }
        .image-profile img{
            border: 1px solid #015766;
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 200px;
            
            height: 200px;
            
        }
        .card-body h4 {
            font-size: 12pt;
            color: black;
            font-weight: bold;
        }
    </style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ $errors->first() }}',
        })
    </script>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Edit Profile</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Name -->
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                </div>
                            </div>
                
                            <!-- Username -->
                            <div class="form-group row">
                                <label for="username" class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->username) }}" required>
                                </div>
                            </div>
                
                            <!-- Email -->
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>
                        </div>
                
                        <!-- Kolom untuk upload foto profil dengan icon edit -->
                        <div class="col-md-6 image-profile">
                            <div class="form-group">
                                

                                <!-- Ganti tampilan Drag and Drop jika gambar sudah diupload -->
                                <div id="drag-drop-area" class="drag-drop-area" style="display: {{ $user->foto ? 'none' : 'block' }}">
                                    Drop your image here or click to upload
                                    <input type="file" id="fileInput" name="foto" style="display:none;" accept="image/*">
                                </div>

                                <div class="preview" id="imagePreview">
                                    @if($user->foto)
                                        <img src="{{ Storage::url($user->foto) }}" alt="Current Image" id="uploadedImage">
                                        <button type="button" class="remove-image" id="removeImage">&times;</button>
                                    @endif
                                </div>    
                                <label class="mt-3">max size 2MB</label>                            
                            </div>
                        </div>
                    </div>
                
                    <!-- Edit Password -->
                    <h4>Edit Password</h4>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="old_password">Password Lama</label>
                            <input type="password" class="form-control" id="old_password" name="old_password">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="password">Password Baru</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>
                
                    <!-- Tombol Update -->
                    <button class="btn btn-primary mr-auto" type="submit">Update</button>
                </form>
                
            </div>
        </div>
    </div>
</div>

<script>
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
        imagePreview.innerHTML = `
            <img src="${e.target.result}" alt="Image Preview" id="uploadedImage">
            <button type="button" class="remove-image" id="removeImage">&times;</button>
        `;
        dragDropArea.style.display = 'none'; // Sembunyikan drag-drop area setelah gambar diupload

        // Tambahkan kembali event listener untuk tombol remove-image setelah diubah
        const removeImageButton = document.getElementById('removeImage');
        if (removeImageButton) {
            removeImageButton.addEventListener('click', function() {
                imagePreview.innerHTML = ''; // Hapus preview gambar
                dragDropArea.style.display = 'block'; // Tampilkan kembali area drag and drop
                fileInput.value = ''; // Kosongkan input file
            });
        }
    };
    reader.readAsDataURL(file);
}

</script>


@endsection
