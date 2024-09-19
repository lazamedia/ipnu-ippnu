@extends('dashboard.layouts.main')

@section('content')

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
                <h4>Edit Data Event</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('event.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="nama_event" class="col-sm-3 col-form-label">Nama Event</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama_event" name="nama_event" value="{{ old('nama_event', $event->nama_event) }}" required>
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
                                            <option value="{{ $pengurus->nama_lengkap }}" {{ $event->ketua_pelaksana == $pengurus->nama_lengkap ? 'selected' : '' }}>{{ $pengurus->nama_lengkap }}</option>
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
                                            <option value="{{ $pengurus->nama_lengkap }}" {{ $event->sekretaris == $pengurus->nama_lengkap ? 'selected' : '' }}>{{ $pengurus->nama_lengkap }}</option>
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
                                            <option value="{{ $pengurus->nama_lengkap }}" {{ $event->bendahara == $pengurus->nama_lengkap ? 'selected' : '' }}>{{ $pengurus->nama_lengkap }}</option>
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
                                    @if ($event->foto)
                                        <img id="imagePreview" src="{{ Storage::url($event->foto) }}" alt="Preview Gambar" />
                                    @else
                                        <img id="imagePreview" alt="Preview Gambar" />
                                    @endif
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
                            <input type="text" class="form-control" id="tempat" name="tempat" value="{{ old('tempat', $event->tempat) }}" required>
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
                                <input type="text" class="form-control currency" name="anggaran" value="{{ old('anggaran', $event->anggaran) }}" required>
                                @error('anggaran')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Tanggal & Jam</label>
                            <input type="datetime-local" class="form-control" name="tanggal" value="{{ old('tanggal', \Carbon\Carbon::parse($event->tanggal)->format('Y-m-d\TH:i')) }}" required>
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
                                <select class="form-control" id="tamuUndanganSelect">
                                    <option value="">Pilih Tamu Undangan</option>
                                    <option value="PAC IPNU IPPNU Tersono" {{ in_array('PAC IPNU IPPNU Tersono', explode(', ', $event->tamu_undangan)) ? 'selected' : '' }}>PAC IPNU IPPNU Tersono</option>
                                    <option value="Kepala Desa Pujut" {{ in_array('Kepala Desa Pujut', explode(', ', $event->tamu_undangan)) ? 'selected' : '' }}>Kepala Desa Pujut</option>
                                    <option value="Banom NU" {{ in_array('Banom NU', explode(', ', $event->tamu_undangan)) ? 'selected' : '' }}>Banom NU</option>
                                    <option value="manual">Input Manual</option>
                                </select>
                                <input type="text" id="tamuUndanganManualInput" class="form-control" placeholder="Masukkan nama manual" style="display:none;">
                                <input type="hidden" name="tamu_undangan[]" id="tamuUndanganHidden" value="{{ old('tamu_undangan', $event->tamu_undangan) }}">
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
                                <input type="hidden" name="divisi_acara[]" id="divisiAcaraHidden" value="{{ old('divisi_acara', $event->divisi_acara) }}">
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
                                        <option value="{{ $pengurus->nama_lengkap }}" {{ in_array($pengurus->nama_lengkap, explode(', ', $event->divisi_humas)) ? 'selected' : '' }}>{{ $pengurus->nama_lengkap }}</option>
                                    @endforeach
                                    <option value="manual">Input Manual</option>
                                </select>
                                <input type="text" id="divisiHumasManualInput" class="form-control" placeholder="Masukkan nama manual" style="display:none;">
                                <input type="hidden" name="divisi_humas[]" id="divisiHumasHidden" value="{{ old('divisi_humas', $event->divisi_humas) }}">
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
                                        <option value="{{ $pengurus->nama_lengkap }}" {{ in_array($pengurus->nama_lengkap, explode(', ', $event->divisi_perkap)) ? 'selected' : '' }}>{{ $pengurus->nama_lengkap }}</option>
                                    @endforeach
                                    <option value="manual">Input Manual</option>
                                </select>
                                <input type="text" id="divisiPerkapManualInput" class="form-control" placeholder="Masukkan nama manual" style="display:none;">
                                <input type="hidden" name="divisi_perkap[]" id="divisiPerkapHidden" value="{{ old('divisi_perkap', $event->divisi_perkap) }}">
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
                                        <option value="{{ $pengurus->nama_lengkap }}" {{ in_array($pengurus->nama_lengkap, explode(', ', $event->divisi_dekdok)) ? 'selected' : '' }}>{{ $pengurus->nama_lengkap }}</option>
                                    @endforeach
                                    <option value="manual">Input Manual</option>
                                </select>
                                <input type="text" id="divisiDekdokManualInput" class="form-control" placeholder="Masukkan nama manual" style="display:none;">
                                <input type="hidden" name="divisi_dekdok[]" id="divisiDekdokHidden" value="{{ old('divisi_dekdok', $event->divisi_dekdok) }}">
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
                                        <option value="{{ $pengurus->nama_lengkap }}" {{ in_array($pengurus->nama_lengkap, explode(', ', $event->divisi_konsumsi)) ? 'selected' : '' }}>{{ $pengurus->nama_lengkap }}</option>
                                    @endforeach
                                    <option value="manual">Input Manual</option>
                                </select>
                                <input type="text" id="divisiKonsumsiManualInput" class="form-control" placeholder="Masukkan nama manual" style="display:none;">
                                <input type="hidden" name="divisi_konsumsi[]" id="divisiKonsumsiHidden" value="{{ old('divisi_konsumsi', $event->divisi_konsumsi) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Upload File Dokumen -->
                    <div class="form-group">
                        <label for="file_dokumen">File Dokumen (Word, Excel, PDF, PowerPoint)</label>
                        <div class="file-drop-area" id="file-drop-area">
                            Seret & Lepas file di sini atau klik untuk mengunggah
                            <input type="file" class="form-control" id="file_dokumen" name="file_dokumen" accept=".doc,.docx,.xls,.xlsx,.pdf,.ppt,.pptx">
                        </div>
                        @if ($event->file_dokumen)
                            <div class="uploaded-file" id="uploaded-file">
                                <span id="file-name">{{ basename($event->file_dokumen) }}</span>
                                <button type="button" id="remove-file">×</button>
                            </div>
                        @endif
                        @error('file_dokumen')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button id="shareWhatsapp" class="btn btn-success">Share via WhatsApp</button>
                    <button class="btn btn-primary mr-auto" type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/dashboard/bulkdelete.js') }}"></script>  
<script src="{{ asset('assets/dashboard/makesta.js') }}"></script>

@endsection
