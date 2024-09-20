@extends('dashboard.layouts.main')

@section('content')

<style>
    .drag-drop-area {
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px dashed #ccc;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        font-size: 16px;
        color: #aaa;
        cursor: pointer;
        height: 200px;
        transition: border-color 0.3s ease;
        position: relative;
        background-color: #fafafa;
    }

    .drag-drop-area img {
        display: none;
        max-width: 100%;
        height: auto;
        border-radius: 10px;
    }

    .drag-drop-area.dragover {
        border-color: #4caf50;
        color: #4caf50;
    }

    .image-preview-wrapper {
        position: relative;
        width: 100%;
        max-width: 300px;
        margin: 0 auto;
        display: none;
    }

    .image-preview-wrapper img {
        width: 100%;
        height: auto;
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
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Tambah Data Pengurus</h4>
            </div>
            <div class="card-body">
                <form id="createForm" method="POST" action="{{ route('pengurus.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Kolom untuk input data pengurus -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_lengkap">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama_lengkap" required>
                            </div>

                            <div class="form-group">
                                <label for="no_wa">Nomor Whatsapp</label>
                                <input type="text" class="form-control" name="no_wa" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email">
                            </div>

                            <div class="form-group">
                                <label for="divisi">Divisi</label>
                                <select class="form-control" name="divisi" required>
                                    <option value="ketua">Ketua</option>
                                    <option value="sekretaris">Sekretaris</option>
                                    <option value="anggota">Anggota</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="pelajar">Pelajar</label>
                                <select class="form-control" name="pelajar" required>
                                    <option value="IPNU">IPNU</option>
                                    <option value="IPPNU">IPPNU</option>
                                </select>
                            </div>
                        </div>

                        <!-- Kolom untuk upload gambar (drag & drop) -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="foto">Foto</label>
                                <div class="drag-drop-area" id="dragDropArea">
                                    Drop your image here or click to upload
                                    <input type="file" id="fileInput" name="foto" style="display:none;" accept="image/*">
                                </div>
                                <div class="image-preview-wrapper" id="imagePreviewWrapper">
                                    <img id="imagePreview" alt="Preview Gambar" />
                                    <button type="button" class="remove-image" id="removeImage">&times;</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                        <button class="btn btn-secondary" id="createAnother" type="button">Create and Create Another</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk Drag and Drop Gambar -->
<script>
// Drag and Drop Script
const dragDropArea = document.getElementById('dragDropArea');
const fileInput = document.getElementById('fileInput');
const imagePreviewWrapper = document.getElementById('imagePreviewWrapper');
const imagePreview = document.getElementById('imagePreview');
const removeImageButton = document.getElementById('removeImage');
const createAnotherButton = document.getElementById('createAnother'); // Pastikan tombol diinisialisasi
const createForm = document.getElementById('createForm'); // Pastikan form diinisialisasi

// Handle Drag and Drop
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

removeImageButton.addEventListener('click', function() {
    fileInput.value = ""; // Clear the input value
    imagePreview.src = ""; // Remove the image source
    imagePreviewWrapper.style.display = "none"; // Hide the image preview wrapper
    dragDropArea.style.display = "flex"; // Show drag-drop area again
});

function previewImage(file) {
    const reader = new FileReader();
    reader.onload = (e) => {
        imagePreview.src = e.target.result; // Set image source to uploaded file
        imagePreviewWrapper.style.display = "block"; // Show image preview wrapper
        dragDropArea.style.display = "none"; // Hide drag-drop area when image is loaded
    };
    reader.readAsDataURL(file);
}

// Handle 'Create and Create Another' button
createAnotherButton.addEventListener('click', function(e) {
    e.preventDefault(); // Prevent default form submission

    // Ganti tombol dengan loading spinner
    createAnotherButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    createAnotherButton.disabled = true;

    // Collect form data
    const formData = new FormData(createForm);

    // Send form data via AJAX
    fetch("{{ route('pengurus.store') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: formData
    })
    .then(response => {
        if (response.redirected) {
            // Jika ada redirect, lakukan redirect manual ke URL baru
            window.location.href = response.url;
        } else {
            return response.json();  // Jika tidak ada redirect, parsing JSON
        }
    })
    .then(data => {
        if (data.success) {
            createForm.reset(); // Reset form setelah sukses
            imagePreview.innerHTML = '';  // Clear image preview

            Swal.fire({
                title: 'Berhasil!',
                text: 'Data pengurus berhasil disimpan.',
                icon: 'success',
                confirmButtonText: 'OK'
            });

        } else {
            Swal.fire({
                title: 'Gagal!',
                text: 'Terjadi kesalahan dalam menyimpan data.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            title: 'Error!',
            text: 'Terjadi kesalahan jaringan. Silakan coba lagi.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        console.error('Error:', error);
    })
    .finally(() => {
        createAnotherButton.innerHTML = 'Create and Create Another';
        createAnotherButton.disabled = false;
    });
});


</script>

@endsection
