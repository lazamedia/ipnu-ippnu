@extends('dashboard.layouts.main')

@section('content')

<style>
    /* Style yang sudah ada */
    .backup{
        align-content: center;
        justify-content: center;
        align-items: center;
        text-align: center;
        margin-bottom: 50px;

    }
    .backup img{
        width: 350px;
        height: auto;
    }
    .backup button{
        margin: auto;
        
    }

    .file-drop-area {
    border: 2px dashed #808285;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: background-color 0.2s ease, border-color 0.2s ease;
    color: #6c757d;
    border-radius: 10px;
    margin-top: 15px;
}

.file-drop-area.dragover {
    background-color: #e2eefd;
    color: #007bff;
    border-color: #28a745; /* Ubah garis putus-putus menjadi hijau saat ada file di-drag */
}

.uploaded-file {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px;
    border: 1px solid #00305f;
    border-radius: 5px;
    margin-top: 15px;
}

#file-name {
    font-weight: 500;
    color: #383838;
}

.remove-file-button {
    background: none;
    border: none;
    color: #8a000e;
    font-size: 20px;
    cursor: pointer;
}

.remove-file-button:hover {
    color: #a71d2a;
}

</style>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="card">
   <div class="card-body">
    <h3>Backup</h3>
    <p>Cadangkan atau pulihkan data dari sistem ini</p>
   </div>
   <div class="card-body">
    <div class="backup">
        <img src="{{ asset('img/backup.png') }}" alt="">
        <div class="col mt-3">
            <form action="{{ route('backup.database') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Backup Database </button>
                <p style="color: #6c757d;">Download file backup dan simpan yang aman</p>
            </form>
        </div>
    </div>
   </div>

   <div class="card-body">
        <form action="{{ route('backup.restore') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file_dokumen">Upload Data</label>
                <div class="file-drop-area" id="file-drop-area">
                    Seret & Lepas file di sini atau klik untuk mengunggah
                    <input type="file" class="form-control" id="file_dokumen" name="file_dokumen" accept=".sql" style="display:none;">
                </div>
                <div class="uploaded-file" id="uploaded-file" style="display: none;">
                    <span id="file-name"></span>
                    <button type="button" id="remove-file" class="remove-file-button">×</button>
                </div>
            </div>  
            <button type="submit" class="btn btn-success">Upload Database</button>
        </form>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const fileDropArea = document.getElementById('file-drop-area');
    const fileInput = document.getElementById('file_dokumen');
    const uploadedFile = document.getElementById('uploaded-file');
    const fileNameDisplay = document.getElementById('file-name');
    const removeFileButton = document.getElementById('remove-file');

    // Menangani event klik pada area drag & drop
    fileDropArea.addEventListener('click', function () {
        fileInput.click();
    });

    // Menangani drag over (ketika file di-drag di atas area)
    fileDropArea.addEventListener('dragover', function (e) {
        e.preventDefault();
        fileDropArea.classList.add('dragover');
    });

    // Menangani drag leave (ketika file keluar dari area)
    fileDropArea.addEventListener('dragleave', function () {
        fileDropArea.classList.remove('dragover');
    });

    // Menangani file drop (ketika file dilepas di area)
    fileDropArea.addEventListener('drop', function (e) {
        e.preventDefault();
        fileDropArea.classList.remove('dragover');

        // Mendapatkan file yang di-drag
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files; // Mengatur file input dengan file yang di-drag
            handleFileUpload(files[0]); // Menampilkan nama file
        }
    });

    // Menangani input file ketika pengguna memilih file
    fileInput.addEventListener('change', function () {
        if (fileInput.files.length > 0) {
            handleFileUpload(fileInput.files[0]);
        }
    });

    // Menampilkan nama file yang diunggah dan menyembunyikan area drag-and-drop
    function handleFileUpload(file) {
        uploadedFile.style.display = 'flex';
        fileNameDisplay.textContent = file.name;
        fileDropArea.style.display = 'none'; // Sembunyikan area drag-and-drop
    }

    // Menangani penghapusan file yang diunggah dan menampilkan kembali area drag-and-drop
    removeFileButton.addEventListener('click', function () {
        fileInput.value = ''; // Menghapus file dari input
        uploadedFile.style.display = 'none'; // Menyembunyikan tampilan file yang diunggah
        fileNameDisplay.textContent = ''; // Mengosongkan nama file
        fileDropArea.style.display = 'block'; // Menampilkan kembali area drag-and-drop
    });
});

</script>

@endsection
