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
        text-align: center;
    }
  
    .preview img {
        max-width: 100%;
        height: auto;
        max-height: 300px;
        border-radius: 10px;
        cursor: pointer;
        margin: auto;
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
        <h4>Edit Transaksi</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('saldo.update', $saldo->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <!-- Nama Transaksi -->
                    <div class="form-group row">
                        <label for="nama" class="col-sm-3 col-form-label">Nama Transaksi</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama" name="nama_transaksi" value="{{ old('nama_transaksi', $saldo->nama_transaksi) }}" required>
                        </div>
                    </div>

                    <!-- Tipe Transaksi -->
                    <div class="form-group row">
                        <label for="tipe_transaksi" class="col-sm-3 col-form-label">Tipe Transaksi</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="tipe_transaksi" name="tipe_transaksi" required>
                                <option value="pemasukan" {{ $saldo->tipe_transaksi == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                                <option value="pengeluaran" {{ $saldo->tipe_transaksi == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tanggal -->
                    <div class="form-group row">
                        <label for="tanggal" class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal', $saldo->tanggal) }}" required>
                        </div>
                    </div>

                    <!-- Jumlah -->
                    <div class="form-group row">
                        <label for="jumlah" class="col-sm-3 col-form-label">Jumlah</label>
                        <div class="col-sm-9">
                            <!-- Jumlah disesuaikan dari pemasukan/pengeluaran -->
                            <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ old('jumlah', $saldo->tipe_transaksi == 'pemasukan' ? $saldo->pemasukan : $saldo->pengeluaran) }}" placeholder="Masukkan Jumlah Nominal" required>
                        </div>
                    </div>
                </div>

                <!-- Kolom untuk upload gambar (drag & drop) -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image">Bukti Transaksi</label>
                        <!-- Ganti tampilan Drag and Drop jika gambar sudah diupload -->
                        <div id="drag-drop-area" class="drag-drop-area" style="display: {{ $saldo->image ? 'none' : 'block' }}">
                            Drop your image here or click to upload
                            <input type="file" id="fileInput" name="image" style="display:none;" accept="image/*">
                        </div>

                        <div class="preview" id="imagePreview">
                            @if($saldo->image)
                                <img src="{{ Storage::url($saldo->image) }}" alt="Current Image" id="uploadedImage">
                                <button type="button" class="remove-image" id="removeImage">&times;</button>
                            @endif
                        </div>    
                        <label class="mt-3">max size 2MB</label>                            
                    </div>
                </div>
            </div>

            <button class="btn btn-primary mr-auto" type="submit">Update</button>
        </form>
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
            imagePreview.innerHTML = `<img src="${e.target.result}" alt="Image Preview">`;
            dragDropArea.style.display = 'none'; // Sembunyikan drag-drop area setelah gambar diupload
        };
        reader.readAsDataURL(file);
    }
</script>
@endsection
