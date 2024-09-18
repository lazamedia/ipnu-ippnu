@extends('dashboard.layouts.main')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/customtabel.css') }}">
<style>
    .tombol {
        padding: 20px;
        text-align: right;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Edit Data Santri</h4>
            </div>
            <div class="card-body">
                <form id="editSantriForm">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label for="nama" class="col-sm col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ $santri->nama }}" required>
                            <div class="invalid-feedback" id="error-nama"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_orangtua" class="col-sm col-form-label">Nama Orangtua</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_orangtua" name="nama_orangtua" value="{{ $santri->nama_orangtua }}" required>
                            <div class="invalid-feedback" id="error-nama_orangtua"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="rt" class="col-sm col-form-label">RT</label>
                        <div class="col-sm-9">
                            <select id="rt" name="rt" class="form-control">
                                <option selected>Pilih RT...</option>
                                @for ($i = 1; $i <= 9; $i++)
                                    <option {{ $santri->rt == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                        {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="pesantren">Nama Pesantren</label>
                            <input type="text" class="form-control" id="pesantren" name="pesantren" value="{{ $santri->pesantren }}" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $santri->alamat }}" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="status">Status Santri</label>
                            <select id="status" name="status" class="form-control">
                                <option {{ $santri->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option {{ $santri->status == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                                <option {{ $santri->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="tombol">
                        <a href="/dashboard/santri"  class="btn btn-primary" style="text-decoration: none;">Back</a>
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('editSantriForm').addEventListener('submit', function(event) {
        event.preventDefault();
        let formData = new FormData(this);

        fetch('{{ route('santri.update', $santri->id) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.success,
                    confirmButtonText: 'Oke'
                }).then(() => {
                    window.location.href = '{{ route('santri.index') }}';
                });
            } else {
                // Tampilkan error validasi
                Object.keys(data.errors).forEach(key => {
                    document.getElementById(`error-${key}`).innerText = data.errors[key][0];
                });
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat mengupdate data.'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Terjadi kesalahan pada server.'
            });
        });
    });
</script>

@endsection
