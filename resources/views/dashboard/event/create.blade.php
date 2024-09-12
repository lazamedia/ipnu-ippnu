@extends('dashboard.layouts.main')

@section('content')
<style>
        /* CSS untuk menampilkan tombol di pojok kanan input manual */
        .input-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    /* Atur input manual */
    .input-wrapper input {
        width: 100%;
        padding-right: 40px; /* Memberikan ruang untuk tombol di kanan */
    }

    /* Atur tombol tambah */
    .add-button {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background-color: #46d3c0;
        color: white;
        border: none; 
        padding: 5px 10px;
        cursor: pointer;
        outline: none !important;
        font-size: 16px;
        display: none;
        border:none !important; /* Tombol disembunyikan secara default */
    }
    .add-button:focus {
    outline: none !important; /* Pastikan tidak ada outline saat tombol dalam state focus */
    }
    /* Tampilkan tombol "Tambah" di mode mobile saat input manual dipilih */
    @media (max-width: 768px) {
        .add-button.active {
            display: inline-block; /* Tampil di mobile saat input manual dipilih */
        }
    }


.tag-input-container {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    padding: 5px;
    border-radius: 4px;
}

.tag {
    display: inline-flex;
    align-items: center;
    background-color: #ffffff;
    padding: 1px 6px;
    border-radius: 20px;
    margin-right: 5px;
    color: #464646;
    border: 1px solid #464646;
}

.tag span {
    margin-right: 5px;
}

.tag button {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 16px;
    color: #812626;
    line-height: 1;
    background-color: #ffffff;
    border-radius: 50%;
    outline: none !important;
}
.tag-button:focus {
    outline: none !important; /* Pastikan tidak ada outline saat tombol dalam state focus */
    }

.tag-input-container input {
    flex-grow: 1;
    border: none;
    outline: none;
}
.select2-container .select2-selection--multiple {
    border: 1px solid #ccc;
    border-radius: 4px;
    min-height: 38px;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #007bff;
    border: 1px solid #007bff;
    color: white;
    padding: 5px;
    margin: 3px;
}


</style>
<link rel="stylesheet" href="{{ asset('assets/dashboard/makesta.css') }}">

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
                <h4>Tambah Data Event</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="nama_event" class="col-sm-3 col-form-label">Nama Event</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama_event" name="nama_event" value="{{ old('nama_event') }}" required>
                                    @error('nama_event')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                             <!-- Ketua Pelaksana -->
                            <div class="form-group row">
                                <label for="ketua_pelaksana" class="col-sm-3 col-form-label">Ketua Pelaksana</label>
                                <div class="col-sm-9">
                                    <select class="form-control " id="ketua_pelaksana" name="ketua_pelaksana">
                                        <option value="">Pilih Ketua Pelaksana</option>
                                        @foreach($penguruses as $pengurus)
                                            <option value="{{ $pengurus->nama_lengkap }}">{{ $pengurus->nama_lengkap }}</option>
                                        @endforeach
                                    </select>
                                    @error('ketua_pelaksana')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Sekretaris -->
                            <div class="form-group row">
                                <label for="sekretaris" class="col-sm-3 col-form-label">Sekretaris</label>
                                <div class="col-sm-9">
                                    <select class="form-control " id="sekretaris" name="sekretaris">
                                        <option value="">Pilih Sekretaris</option>
                                        @foreach($penguruses as $pengurus)
                                            <option value="{{ $pengurus->nama_lengkap }}">{{ $pengurus->nama_lengkap }}</option>
                                        @endforeach
                                    </select>
                                    @error('sekretaris')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Bendahara -->
                            <div class="form-group row">
                                <label for="bendahara" class="col-sm-3 col-form-label">Bendahara</label>
                                <div class="col-sm-9">
                                    <select class="form-control " id="bendahara" name="bendahara">
                                        <option value="">Pilih Bendahara</option>
                                        @foreach($penguruses as $pengurus)
                                            <option value="{{ $pengurus->nama_lengkap }}">{{ $pengurus->nama_lengkap }}</option>
                                        @endforeach
                                    </select>
                                    @error('bendahara')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
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
                            @error('foto')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                
                    
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="tempat">Tempat</label>
                                <input type="text" class="form-control" id="tempat" name="tempat" value="{{ old('tempat') }}" required>
                                @error('tempat')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Anggaran</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp
                                        </div>
                                    </div>
                                    <input type="text" class="form-control currency" name="anggaran" value="{{ old('anggaran') }}" required>
                                    @error('anggaran')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Tanggal & Jam</label>
                                <input type="datetime-local" class="form-control" name="tanggal" value="{{ old('tanggal') }}" required>
                                @error('tanggal')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    
                
                                       
                            <!-- Input Tamu Undangan -->
                            <div class="form-group row">
                                <label for="tamuUndangan" class="col-sm-3 col-form-label">Tamu Undangan</label>
                                <div class="col-sm-9">
                                    <div class="tag-input-container" id="tamuUndanganContainer">
                                        <!-- Dropdown -->
                                        <select class="form-control" id="tamuUndanganSelect">
                                            <option value="">Pilih Tamu Undangan</option>
                                            <option value="PAC IPNU IPPNU Tersono">PAC IPNU IPPNU Tersono</option>
                                            <option value="Kepala Desa Pujut">Kepala Desa Pujut</option>
                                            <option value="Banom NU">Banom NU</option>
                                            <option value="manual">Input Manual</option>
                                        </select>

                                        <!-- Input manual (tersembunyi secara default) -->
                                        <input type="text" id="tamuUndanganManualInput" class="form-control" placeholder="Masukkan nama manual" style="display:none;">
                                        
                                        <!-- Hidden input untuk menyimpan hasil -->
                                        <input type="hidden" name="tamu_undangan[]" id="tamuUndanganHidden" value="{{ old('tamu_undangan') }}">
                                    </div>
                                </div>
                            </div>

                        
                            <!-- Divisi Acara -->
                            <div class="form-group row">
                                <label for="divisiAcara" class="col-sm-3 col-form-label">Divisi Acara</label>
                                <div class="col-sm-9">
                                    <div class="tag-input-container" id="divisiAcaraContainer">
                                        <select class="form-control" id="divisiAcaraSelect">
                                            <option value="">Pilih Nama Pengurus</option>
                                            @foreach($penguruses as $pengurus)
                                                <option value="{{ $pengurus->nama_lengkap }}">{{ $pengurus->nama_lengkap }}</option>
                                            @endforeach
                                            <option value="manual">Input Manual</option>
                                        </select>
                                        <input type="text" id="divisiAcaraManualInput" class="form-control" placeholder="Masukkan nama manual" style="display:none;">
                                        <input type="hidden" name="divisi_acara[]" id="divisiAcaraHidden"  value="{{ old('divisi_acara') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Divisi Humas -->
                            <div class="form-group row">
                                <label for="divisiHumas" class="col-sm-3 col-form-label">Divisi Humas</label>
                                <div class="col-sm-9">
                                    <div class="tag-input-container" id="divisiHumasContainer">
                                        <select class="form-control" id="divisiHumasSelect">
                                            <option value="">Pilih Nama Pengurus</option>
                                            @foreach($penguruses as $pengurus)
                                                <option value="{{ $pengurus->nama_lengkap }}">{{ $pengurus->nama_lengkap }}</option>
                                            @endforeach
                                            <option value="manual">Input Manual</option>
                                        </select>
                                        <input type="text" id="divisiHumasManualInput" class="form-control" placeholder="Masukkan nama manual" style="display:none;">
                                        <input type="hidden" name="divisi_humas[]" id="divisiHumasHidden"  value="{{ old('divisi_humas') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Divisi Perkap -->
                            <div class="form-group row">
                                <label for="divisiPerkap" class="col-sm-3 col-form-label">Divisi Perkap</label>
                                <div class="col-sm-9">
                                    <div class="tag-input-container" id="divisiPerkapContainer">
                                        <select class="form-control" id="divisiPerkapSelect">
                                            <option value="">Pilih Nama Pengurus</option>
                                            @foreach($penguruses as $pengurus)
                                                <option value="{{ $pengurus->nama_lengkap }}">{{ $pengurus->nama_lengkap }}</option>
                                            @endforeach
                                            <option value="manual">Input Manual</option>
                                        </select>
                                        <input type="text" id="divisiPerkapManualInput" class="form-control" placeholder="Masukkan nama manual" style="display:none;">
                                        <input type="hidden" name="divisi_perkap[]" id="divisiPerkapHidden"  value="{{ old('divisi_perkap') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Divisi Dekdok -->
                            <div class="form-group row">
                                <label for="divisiDekdok" class="col-sm-3 col-form-label">Divisi Dekdok</label>
                                <div class="col-sm-9">
                                    <div class="tag-input-container" id="divisiDekdokContainer">
                                        <select class="form-control" id="divisiDekdokSelect">
                                            <option value="">Pilih Nama Pengurus</option>
                                            @foreach($penguruses as $pengurus)
                                                <option value="{{ $pengurus->nama_lengkap }}">{{ $pengurus->nama_lengkap }}</option>
                                            @endforeach
                                            <option value="manual">Input Manual</option>
                                        </select>
                                        <input type="text" id="divisiDekdokManualInput" class="form-control" placeholder="Masukkan nama manual" style="display:none;">
                                        <input type="hidden" name="divisi_dekdok[]" id="divisiDekdokHidden"  value="{{ old('divisi_dekdok') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Divisi Konsumsi -->
                            <div class="form-group row">
                                <label for="divisiKonsumsi" class="col-sm-3 col-form-label">Divisi Konsumsi</label>
                                <div class="col-sm-9">
                                    <div class="tag-input-container" id="divisiKonsumsiContainer">
                                        <select class="form-control" id="divisiKonsumsiSelect">
                                            <option value="">Pilih Nama Pengurus</option>
                                            @foreach($penguruses as $pengurus)
                                                <option value="{{ $pengurus->nama_lengkap }}">{{ $pengurus->nama_lengkap }}</option>
                                            @endforeach
                                            <option value="manual">Input Manual</option>
                                        </select>
                                        <input type="text" id="divisiKonsumsiManualInput" class="form-control" placeholder="Masukkan nama manual" style="display:none;">
                                        <input type="hidden" name="divisi_konsumsi[]" id="divisiKonsumsiHidden"  value="{{ old('divisi_konsumsi') }}">
                                    </div>
                                </div>
                            </div>                        
                        
                        
                        <!-- Input File Dokumen -->
                        
                            <div class="form-group">
                                <label for="file_dokumen">File Dokumen (Word, Excel, PDF, PowerPoint)</label>
                                <div class="file-drop-area" id="file-drop-area">
                                    Seret & Lepas file di sini atau klik untuk mengunggah
                                    <input type="file" class="form-control" id="file_dokumen" name="file_dokumen" accept=".doc,.docx,.xls,.xlsx,.pdf,.ppt,.pptx" >
                                </div>
                                <div class="uploaded-file" id="uploaded-file" style="display: none;">
                                    <span id="file-name"></span>
                                    <button type="button" id="remove-file">×</button>
                                </div>
                            </div>                    
                        
                    
                    <!-- SweetAlert for validation errors -->
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
                    
                    <button id="shareWhatsapp" class="btn btn-success">Share via WhatsApp</button>

                    <button class="btn btn-primary mr-auto" type="submit">Submit</button>
                </form>
                
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/dashboard/bulkdelete.js') }}"></script>  
<script src="{{ asset('assets/dashboard/makesta.js') }}"></script>
<script>

    document.getElementById('shareWhatsapp').addEventListener('click', function() {
    // Ambil nilai dari form
    const ketuaPelaksana = document.getElementById('ketua_pelaksana').value;
    const wakil = document.getElementById('wakil').value;
    const sekretaris = document.getElementById('sekretaris').value;
    const bendahara = document.getElementById('bendahara').value;
    const tempat = document.getElementById('tempat').value;
    const anggaran = document.querySelector('input[name="anggaran"]').value;
    const tanggal = document.querySelector('input[name="tanggal"]').value;

    // Ambil nilai dari input list
    const tamuUndangan = [...document.querySelectorAll('#listTamuUndangan div span')].map(el => el.textContent).join(', ');
    const divisiHumas = [...document.querySelectorAll('#listDivisiHumas div span')].map(el => el.textContent).join(', ');
    const divisiPerkap = [...document.querySelectorAll('#listDivisiPerkap div span')].map(el => el.textContent).join(', ');
    const divisiDekdok = [...document.querySelectorAll('#listDivisiDekdok div span')].map(el => el.textContent).join(', ');
    const divisiKonsumsi = [...document.querySelectorAll('#listDivisiKonsumsi div span')].map(el => el.textContent).join(', ');
    const divisiAcara = [...document.querySelectorAll('#listDivisiAcara div span')].map(el => el.textContent).join(', ');

    // Ambil nilai dari "Keperluan Divisi"
    const keperluanDivisiWrapper = document.getElementById('hasilInput').querySelectorAll('div h5');
    let keperluanDivisi = '';

    keperluanDivisiWrapper.forEach((divisiItem, index) => {
        const divisiTitle = divisiItem.textContent;
        const keperluanList = divisiItem.nextElementSibling.querySelectorAll('li');
        const keperluanText = [...keperluanList].map(keperluan => keperluan.textContent).join(', ');

        keperluanDivisi += `${divisiTitle}: ${keperluanText}\n`;
    });

    // Format pesan WhatsApp dengan teks yang rapi
    const message = `
        *Data Event:*\n
        *Ketua Pelaksana:* ${ketuaPelaksana}\n
        *Wakil:* ${wakil}\n
        *Sekretaris:* ${sekretaris}\n
        *Bendahara:* ${bendahara}\n
        *Tempat:* ${tempat}\n
        *Anggaran:* Rp${anggaran}\n
        *Tanggal:* ${tanggal}\n\n
        *Tamu Undangan:* ${tamuUndangan}\n\n
        *Divisi Humas:* ${divisiHumas}\n
        *Divisi Perkap:* ${divisiPerkap}\n
        *Divisi Dekdok:* ${divisiDekdok}\n
        *Divisi Konsumsi:* ${divisiKonsumsi}\n
        *Divisi Acara:* ${divisiAcara}\n\n
        *Keperluan Divisi:*\n
        ${keperluanDivisi}
    `;

    // Encode URI untuk WhatsApp (format yang rapi)
    const whatsappURL = `https://api.whatsapp.com/send?phone=6282134749670&text=${encodeURIComponent(message)}`;

    // Buka tautan WhatsApp dengan nomor yang diinginkan
    window.open(whatsappURL, '_blank');
});




document.addEventListener('DOMContentLoaded', () => {
    const divisiSelectors = [
        { selectId: 'divisiAcaraSelect', inputId: 'divisiAcaraManualInput', containerId: 'divisiAcaraContainer', hiddenInputId: 'divisiAcaraHidden' },
        { selectId: 'divisiHumasSelect', inputId: 'divisiHumasManualInput', containerId: 'divisiHumasContainer', hiddenInputId: 'divisiHumasHidden' },
        { selectId: 'divisiPerkapSelect', inputId: 'divisiPerkapManualInput', containerId: 'divisiPerkapContainer', hiddenInputId: 'divisiPerkapHidden' },
        { selectId: 'divisiDekdokSelect', inputId: 'divisiDekdokManualInput', containerId: 'divisiDekdokContainer', hiddenInputId: 'divisiDekdokHidden' },
        { selectId: 'divisiKonsumsiSelect', inputId: 'divisiKonsumsiManualInput', containerId: 'divisiKonsumsiContainer', hiddenInputId: 'divisiKonsumsiHidden' },
        { selectId: 'tamuUndanganSelect', inputId: 'tamuUndanganManualInput', containerId: 'tamuUndanganContainer', hiddenInputId: 'tamuUndanganHidden' },
    ];

    divisiSelectors.forEach(divisi => {
        setupTagInput(divisi.selectId, divisi.inputId, divisi.containerId, divisi.hiddenInputId);
    });

    function setupTagInput(selectId, inputId, containerId, hiddenInputId) {
        const select = document.getElementById(selectId);
        const manualInput = document.getElementById(inputId);
        const container = document.getElementById(containerId);
        const hiddenInput = document.getElementById(hiddenInputId);

        // Buat wrapper untuk input dan tombol tambah
        const wrapper = document.createElement('div');
        wrapper.classList.add('input-wrapper');
        manualInput.parentNode.insertBefore(wrapper, manualInput);
        wrapper.appendChild(manualInput);

        // Buat tombol tambah
        const addButton = document.createElement('button');
        addButton.textContent = 'Tambah';
        addButton.classList.add('add-button');
        wrapper.appendChild(addButton); // Tambahkan tombol di dalam wrapper

        let tags = hiddenInput.value ? hiddenInput.value.split(',') : [];

        // Update hidden input dari array tags setiap kali ada perubahan
        function updateHiddenInput() {
            hiddenInput.value = tags.join(','); // Update nilai hidden input dengan tag yang terpilih
        }

        // Fungsi untuk menambahkan tag
        function addTag(value) {
            const tag = document.createElement('div');
            tag.classList.add('tag');

            const nameSpan = document.createElement('span');
            nameSpan.textContent = value;

            const removeButton = document.createElement('button');
            removeButton.textContent = '×';

            removeButton.addEventListener('click', () => {
                tag.remove(); // Hapus tag dari tampilan
                tags = tags.filter(tagValue => tagValue !== value); // Hapus dari array tags
                updateHiddenInput(); // Perbarui hidden input
            });

            tag.appendChild(nameSpan);
            tag.appendChild(removeButton);
            container.insertBefore(tag, select); // Tambahkan tag ke container
        }

        // Tambahkan nama dari input manual
        function handleManualInput() {
            const manualValues = manualInput.value.split(',').map(v => v.trim()).filter(v => v !== "");

            manualValues.forEach(value => {
                if (!tags.includes(value)) {
                    tags.push(value); // Tambahkan setiap nilai unik ke tags
                    addTag(value); // Tampilkan tag
                }
            });

            updateHiddenInput(); // Perbarui hidden input setelah semua nama manual ditambahkan
            manualInput.value = ''; // Kosongkan input manual
        }

        // Ketika tombol "Tambah" diklik di mode mobile, tambahkan nama dari input manual
        addButton.addEventListener('click', function (e) {
            e.preventDefault(); // Cegah tombol dari menyebabkan form submit
            handleManualInput();
        });

        // Jika input manual diisi dan Enter ditekan di desktop
        manualInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && manualInput.value.trim() !== "") {
                handleManualInput();
                e.preventDefault(); // Cegah halaman dari submit
            }
        });

        // Ketika dropdown berubah
        select.addEventListener('change', function () {
            const selectedValue = this.value;

            if (selectedValue === "manual") {
                manualInput.style.display = 'block';
                addButton.classList.add('active'); // Tampilkan tombol saat input manual dipilih
                manualInput.focus();
            } else {
                // Sembunyikan input manual dan tombol tambah jika item lain dipilih
                manualInput.style.display = 'none';
                addButton.classList.remove('active'); // Sembunyikan tombol tambah
                addButton.style.display = 'none';

                if (selectedValue !== "" && !tags.includes(selectedValue)) {
                    // Jika item belum ada di tags, tambahkan
                    tags.push(selectedValue);
                    addTag(selectedValue);
                    updateHiddenInput(); // Perbarui hidden input
                    select.value = ''; // Reset dropdown
                }
            }
        });

        // Inisialisasi tag dari hidden input (jika sudah ada sebelumnya)
        tags.forEach(tag => addTag(tag));
    }
});


</script>
@endsection