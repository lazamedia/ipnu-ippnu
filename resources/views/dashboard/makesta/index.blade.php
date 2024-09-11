@extends('dashboard.layouts.main')

@section('content')
<style>

</style>
<link rel="stylesheet" href="{{ asset('assets/dashboard/makesta.css') }}">


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Tambah Data Event</h4>
            </div>
            <div class="card-body">
                <form action="">
                    <div class="row">
                        <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="text" class="col-sm-3 col-form-label">Ketua Pelaksana</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" id="text" >
                                </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-3 col-form-label">Wakil</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" id="text" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-3 col-form-label">Sekretaris</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" id="text" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="text" class="col-sm-3 col-form-label">Bendahara</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" id="text" >
                                    </div>
                                </div>
                        </div>

                         <!-- Kolom untuk upload gambar (drag & drop) -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="foto">Foto Poster Event</label>
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
                    
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                <label for="text">Tempat</label>
                                <input type="text" class="form-control" id="text" >
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Anggaran</label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        Rp
                                        </div>
                                    </div>
                                    <input type="text" class="form-control currency">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Tanggal & Jam</label>
                                    <input type="datetime-local" class="form-control">
                                  </div>
                            </div>
                        </div>


                        <div class="card-body">
                            <!-- Input Tamu Undangan -->
                                <div class="form-group row">
                                    <label for="tamuUndangan" class="col-sm-3 col-form-label">Tamu Undangan</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="tamuUndangan" placeholder="Masukkan nama tamu undangan, tekan Enter">
                                        <div id="listTamuUndangan" class="list-horizontal"></div> <!-- Daftar nama tamu -->
                                    </div>
                                </div>
                                                       
                                <!-- Input Divisi Humas -->
                                <div class="form-group row">
                                    <label for="divisiHumas" class="col-sm-3 col-form-label">Divisi Humas</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="divisiHumas" placeholder="Masukkan nama, tekan Enter">
                                        <div id="listDivisiHumas" class="list-horizontal"></div> <!-- Daftar nama divisi humas -->
                                    </div>
                                </div>

                                <!-- Input Divisi Acara -->
                                <div class="form-group row">
                                    <label for="divisiAcara" class="col-sm-3 col-form-label">Divisi Acara</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="divisiAcara" placeholder="Masukkan nama, tekan Enter">
                                        <div id="listDivisiAcara" class="list-horizontal"></div> <!-- Daftar nama divisi Acara -->
                                    </div>
                                </div>

                                <!-- Input Divisi Perkap -->
                                <div class="form-group row">
                                    <label for="divisiPerkap" class="col-sm-3 col-form-label">Divisi Perkap</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="divisiPerkap" placeholder="Masukkan nama, tekan Enter">
                                        <div id="listDivisiPerkap" class="list-horizontal"></div> <!-- Daftar nama divisi Perkap -->
                                    </div>
                                </div>

                                <!-- Input Divisi Dekdok -->
                                <div class="form-group row">
                                    <label for="divisiDekdok" class="col-sm-3 col-form-label">Divisi Dekdok</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="divisiDekdok" placeholder="Masukkan nama, tekan Enter">
                                        <div id="listDivisiDekdok" class="list-horizontal"></div> <!-- Daftar nama divisi Dekdok -->
                                    </div>
                                </div>

                                <!-- Input Divisi Konsumsi -->
                                <div class="form-group row">
                                    <label for="divisiKonsumsi" class="col-sm-3 col-form-label">Divisi Konsumsi</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="divisiKonsumsi" placeholder="Masukkan nama, tekan Enter">
                                        <div id="listDivisiKonsumsi" class="list-horizontal"></div> <!-- Daftar nama divisi Konsumsi -->
                                    </div>
                                </div>

                        </div>
                    

                    <div class="card-body">
                        <!-- Input Keperluan Divisi -->
                        <div class="form-group ">
                            <label for="divisiKeperluanDropdown" class="form-label">Keperluan Divisi</label>
                            <div class="select">
                                <select id="divisiKeperluanDropdown" class="form-control">
                                    <option value="" disabled selected>Pilih divisi</option>
                                    <option value="Humas">Humas</option>
                                    <option value="Perkap">Perkap</option>
                                    <option value="Dekdok">Dekdok</option>
                                    <option value="Konsumsi">Konsumsi</option>
                                    <option value="Acara">Acara</option>
                                    <option value="Sekretaris">Sekretaris</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                <input type="text" class="form-control mt-2" id="keperluanDivisiInput" style="display:none;" placeholder="Masukkan keperluan divisi">
                                <div id="keperluanDivisiWrapper"></div>
                            </div>
                        </div>

                        <!-- Box untuk menampilkan hasil inputan -->
                        <div class="form-group ">
                            <label for="hasilInput" class="form-label">Hasil Input Divisi</label>
                            <div class="">
                                <div id="hasilInput" class="list-hasil border p-3" style="min-height: 100px; background-color: #ffffff;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group">
                            <label for="file_dokumen">File Dokumen (Word, Excel, PDF, PowerPoint)</label>
                            <div class="file-drop-area" id="file-drop-area">
                                <p>Seret & Lepas file di sini atau klik untuk mengunggah</p>
                                <input type="file" class="form-control" id="file_dokumen" name="file_dokumen" accept=".doc,.docx,.xls,.xlsx,.pdf,.ppt,.pptx" required>
                            </div>
                            <div class="uploaded-file" id="uploaded-file" style="display: none;">
                                <span id="file-name"></span>
                                <button type="button" id="remove-file">×</button>
                            </div>
                        </div>
                    </div>
                                        
                    <button class="btn btn-primary mr-auto" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
    
{{-- <script src="{{ asset('assets/dashboard/makesta.js') }}"></script> --}}
<script>

        document.addEventListener('DOMContentLoaded', () => {
            const divisiDropdown = document.getElementById('divisiKeperluanDropdown');
            const keperluanInput = document.getElementById('keperluanDivisiInput');
            const keperluanWrapper = document.getElementById('keperluanDivisiWrapper');
            const hasilInputDiv = document.getElementById('hasilInput'); // Box hasil input

            const keperluanDivisi = {};

            // Event saat divisi dipilih
            divisiDropdown.addEventListener('change', (e) => {
                const selectedDivisi = divisiDropdown.value;

                keperluanInput.style.display = 'block';
                keperluanInput.focus();

                updateKeperluanList(selectedDivisi);
            });

            keperluanInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' && keperluanInput.value.trim() !== "") {
                    const selectedDivisi = divisiDropdown.value;
                    const keperluan = keperluanInput.value.trim();

                    if (!keperluanDivisi[selectedDivisi]) {
                        keperluanDivisi[selectedDivisi] = [];
                    }
                    keperluanDivisi[selectedDivisi].push(keperluan);

                    keperluanInput.value = '';
                    updateKeperluanList(selectedDivisi);
                    updateHasilInput(); // Update hasil input di box
                    e.preventDefault();
                }
            });

            function updateKeperluanList(divisi) {
                keperluanWrapper.innerHTML = '';

                if (keperluanDivisi[divisi]) {
                    keperluanDivisi[divisi].forEach((keperluan, index) => {
                        const listItem = document.createElement('div');
                        const nameSpan = document.createElement('span');
                        nameSpan.textContent = keperluan;

                        const removeButton = document.createElement('button');
                        removeButton.textContent = '×';
                        removeButton.addEventListener('click', () => {
                            keperluanDivisi[divisi].splice(index, 1);
                            updateKeperluanList(divisi);
                            updateHasilInput(); // Update hasil input di box setelah hapus
                        });

                        listItem.appendChild(nameSpan);
                        listItem.appendChild(removeButton);
                        listItem.classList.add('list-horizontal-item');
                        keperluanWrapper.appendChild(listItem);
                    });
                }
            }

            // Fungsi untuk menampilkan hasil input di dalam box
            function updateHasilInput() {
                hasilInputDiv.innerHTML = ''; // Kosongkan konten box

                Object.keys(keperluanDivisi).forEach(divisi => {
                    if (keperluanDivisi[divisi].length > 0) {
                        const divisiWrapper = document.createElement('div');

                        const divisiHeading = document.createElement('h5');
                        divisiHeading.textContent = `Divisi. ${divisi}`;

                        const keperluanList = document.createElement('ul');
                        keperluanDivisi[divisi].forEach(keperluan => {
                            const listItem = document.createElement('li');
                            listItem.textContent = keperluan;
                            keperluanList.appendChild(listItem);
                        });

                        divisiWrapper.appendChild(divisiHeading);
                        divisiWrapper.appendChild(keperluanList);
                        hasilInputDiv.appendChild(divisiWrapper);
                    }
                });
            }
        });

            
        // script untuk input masal 
        document.addEventListener('DOMContentLoaded', () => {
                // Fungsi untuk menambah nama ke daftar
                function addToList(inputId, listId) {
                    const input = document.getElementById(inputId);
                    const list = document.getElementById(listId);

                    input.addEventListener('keypress', (e) => {
                        if (e.key === 'Enter' && input.value.trim() !== "") {
                            createListItem(input.value, list);
                            input.value = ''; // Kosongkan input setelah menambah nama
                            e.preventDefault(); // Mencegah form submit saat Enter ditekan
                        }
                    });
                }

                // Fungsi untuk membuat item daftar dengan tombol hapus
                function createListItem(value, list) {
                    const listItem = document.createElement('div');
                    const nameSpan = document.createElement('span');
                    nameSpan.textContent = value;

                    const removeButton = document.createElement('button');
                    removeButton.textContent = '×';
                    removeButton.addEventListener('click', () => listItem.remove());

                    listItem.appendChild(nameSpan);
                    listItem.appendChild(removeButton);
                    list.appendChild(listItem);
                }

                // Fungsi untuk dropdown divisi dengan input manual
                function handleDropdownWithManualInput(dropdownId, manualInputId, listId) {
                    const dropdown = document.getElementById(dropdownId);
                    const manualInput = document.getElementById(manualInputId);
                    const list = document.getElementById(listId);

                    dropdown.addEventListener('change', (e) => {
                        if (dropdown.value === 'other') {
                            manualInput.style.display = 'block';
                            manualInput.focus();
                        } else if (dropdown.value !== '') {
                            createListItem(dropdown.value, list);
                            dropdown.value = ''; // Reset dropdown setelah memilih
                        }
                    });

                    manualInput.addEventListener('keypress', (e) => {
                        if (e.key === 'Enter' && manualInput.value.trim() !== "") {
                            createListItem(manualInput.value, list);
                            manualInput.value = ''; // Kosongkan input setelah menambah nama
                            manualInput.style.display = 'none'; // Sembunyikan input manual setelah penggunaan
                            dropdown.value = ''; // Reset dropdown
                            e.preventDefault();
                        }
                    });
                }

                // Panggil fungsi untuk masing-masing input dan daftar
                addToList('tamuUndangan', 'listTamuUndangan');
                addToList('divisiHumas', 'listDivisiHumas');
                addToList('divisiPerkap', 'listDivisiPerkap');
                addToList('divisiDekdok', 'listDivisiDekdok');
                addToList('divisiKonsumsi', 'listDivisiKonsumsi');
                addToList('divisiAcara', 'listDivisiAcara');
                handleDropdownWithManualInput('divisiPerlengkapanDropdown', 'divisiPerlengkapanManual', 'listDivisiPerlengkapan');
        });

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

        // File Upload Script
        const fileDropArea = document.getElementById('file-drop-area');
            const fileInputDokumen = document.getElementById('file_dokumen');
            const uploadedFile = document.getElementById('uploaded-file');
            const fileNameSpan = document.getElementById('file-name');
            const removeFileButton = document.getElementById('remove-file');
            const maxSize = 5 * 1024 * 1024;
            
            fileDropArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                fileDropArea.classList.add('dragover');
            });

            fileDropArea.addEventListener('dragleave', () => fileDropArea.classList.remove('dragover'));

            fileDropArea.addEventListener('drop', (e) => {
                e.preventDefault();
                fileDropArea.classList.remove('dragover');
                const file = e.dataTransfer.files[0];
                
                if (validateFile(file)) {
                    fileInputDokumen.files = e.dataTransfer.files;
                    fileNameSpan.textContent = file.name;
                    fileDropArea.style.display = 'none';
                    uploadedFile.style.display = 'flex';
                }
            });

            fileDropArea.addEventListener('click', () => fileInputDokumen.click());

            fileInputDokumen.addEventListener('change', () => {
                const file = fileInputDokumen.files[0];
                if (validateFile(file)) {
                    fileNameSpan.textContent = file.name;
                    fileDropArea.style.display = 'none';
                    uploadedFile.style.display = 'flex';
                }
            });

            removeFileButton.addEventListener('click', () => {
                fileInputDokumen.value = '';
                fileDropArea.style.display = 'block';
                uploadedFile.style.display = 'none';
            });

            function validateFile(file) {
                const allowedExtensions = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'];

                if (file.size > maxSize) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ukuran File Terlalu Besar',
                        text: 'Ukuran file melebihi 5MB. Silakan unggah file yang lebih kecil.',
                    });
                    return false;
                }

                if (!allowedExtensions.includes(file.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format File Tidak Valid',
                        text: 'Harap unggah file dengan format Word, Excel, PDF, atau PowerPoint.',
                    });
                    return false;
                }

                return true;
            }
</script>
@endsection