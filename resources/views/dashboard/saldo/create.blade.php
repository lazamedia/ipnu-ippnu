@extends('dashboard.layouts.main')

@section('content')
    
<link rel="stylesheet" href="{{ asset('assets/dashboard/makesta.css') }}">

<div class="card">
    <div class="card-header">
        <h4>Tambah Saldo</h4>
    </div>
    <div class="card-body">

        <form action="{{ route('saldo.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label for="nama" class="col-sm-3 col-form-label">Nama Transaksi</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama" name="nama_transaksi" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tipe_transaksi" class="col-sm-3 col-form-label">Tipe Transaksi</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="tipe_transaksi" name="tipe_transaksi" required>
                                <option value="">Pilih Transaksi</option>
                                <option value="pengeluaran">Pengeluaran</option>
                                <option value="pemasukan">Pemasukan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tanggal" class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jumlah" class="col-sm-3 col-form-label">Jumlah</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Masukkan Jumlah Nominal" required>
                        </div>
                    </div>
                </div>

                <!-- Kolom untuk upload gambar (drag & drop) -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image">Bukti Transaksi</label>
                        <div class="drag-drop-area" id="dragDropArea">
                            Drop your image here or click to upload
                            <input type="file" id="fileInput" name="image" style="display:none;" accept="image/*">
                        </div>
                        <div class="image-preview-wrapper" id="imagePreviewWrapper">
                            <img id="imagePreview" alt="Preview Gambar" />
                            <button type="button" class="remove-image" id="removeImage">&times;</button>
                        </div>
                    </div>
                </div>
            </div>

            <button class="btn btn-primary mr-auto" type="submit">Submit</button>

        </form>

    </div>
</div>

<script src="{{ asset('assets/dashboard/makesta.js') }}"></script>

@endsection
