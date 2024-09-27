@extends('dashboard.layouts.main')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>Buat Surat Undangan</h4>
    </div>

    <div class="card-body">
        <form action="">
            <div class="form-group">
                <label for="nama">Nama Undangan</label>
                <input type="text" class="form-control" name="nama" required>
            </div>

            <div class="form-group">
                <label for="penerima">Nama Penerima</label>
                <input type="text" class="form-control" name="penerima" required>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="nomor">Nomor Surat</label>
                    <input type="text" class="form-control" id="nomor" name="nomor" value="{{ old('nomor') }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="lampiran">Lampiran</label>
                    <select class="form-control" id="lampiran">
                        <option value="-">-</option>
                        @for ($i = 1; $i <= 6; $i++)
                        <option>{{ str_pad($i,  STR_PAD_LEFT) }}</option>
                        @endfor
                    </select>
                </div>
                
                <div class="form-group col-md-4">
                    <label for="perihal">perihal</label>
                    <input type="text" class="form-control" id="perihal" name="perihal" value="{{ old('perihal') }}" required>
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
                    <label>Acara</label>
                    <div class="input-group">
                        <input type="text" class="form-control currency" name="acara" value="{{ old('acara') }}" required>
                        @error('acara')
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

            <button class="btn btn-primary">Print</button>
        </form>
    </div>
</div>
    
@endsection