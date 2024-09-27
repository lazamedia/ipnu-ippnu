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
      position: center;
      text-align: center;
  }

  .preview img {
      max-width: 100%;
      height: auto;
      max-height: 300px;
      border-radius: 10px;
      cursor: pointer;
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

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Edit Data Pengurus</h4>
            </div>
            <div class="card-body">
                <form id="editForm" method="POST" action="{{ route('pengurus.update', $pengurus->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h5 style="color: #000000; font-weight: 400; font-size: 1rem;">Upload foto (klik gambar untuk ganti)</h5>

                                <!-- Ganti tampilan Drag and Drop jika gambar sudah diupload -->
                                <div id="drag-drop-area" class="drag-drop-area" style="display: {{ $pengurus->foto ? 'none' : 'block' }}">
                                    Drop your image here or click to upload
                                    <input type="file" id="fileInput" name="foto" style="display:none;" accept="image/*">
                                </div>

                                <div class="preview" id="imagePreview">
                                    @if($pengurus->foto)
                                        <img src="{{ Storage::url($pengurus->foto) }}" alt="Current Image" id="uploadedImage">
                                        <button type="button" class="remove-image" id="removeImage">&times;</button>
                                    @endif
                                </div>    
                                <label class="mt-3">max size 2MB</label>                            
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Data input fields -->
                            <div class="form-group">
                                <label for="nama_lengkap">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama_lengkap" value="{{ $pengurus->nama_lengkap }}" required>
                            </div>

                            <div class="form-group">
                                <label for="no_wa">Nomor Whatsapp</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control phone-number" name="no_wa" value="{{ $pengurus->no_wa }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $pengurus->email }}">
                            </div>

                            <div class="form-group">
                                <label for="divisi">Divisi</label>
                                <select class="form-control" name="divisi" required>
                                    <option value="ketua" {{ $pengurus->divisi == 'ketua' ? 'selected' : '' }}>Ketua</option>
                                    <option value="sekretaris" {{ $pengurus->divisi == 'sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                                    <option value="anggota" {{ $pengurus->divisi == 'anggota' ? 'selected' : '' }}>Anggota</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="pelajar">Pelajar</label>
                                <select class="form-control" name="pelajar" required>
                                    <option value="ipnu" {{ $pengurus->pelajar == 'ipnu' ? 'selected' : '' }}>IPNU</option>
                                    <option value="ippnu" {{ $pengurus->pelajar == 'ippnu' ? 'selected' : '' }}>IPPNU</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Drag and Drop functionality and form behavior -->
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
            imagePreview.innerHTML = `<img src="${e.target.result}" alt="Image Preview">`;
            dragDropArea.style.display = 'none'; // Sembunyikan drag-drop area setelah gambar diupload
        };
        reader.readAsDataURL(file);
    }
</script>

@endsection
