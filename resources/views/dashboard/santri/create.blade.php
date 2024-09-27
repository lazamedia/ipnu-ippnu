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
                <h4>Tambah data Santri</h4>
            </div>
            <div class="card-body">
                <form id="createSantriForm">
                    @csrf
                    <div class="form-group row">
                        <label for="nama" class="col-sm col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama" name="nama" required>
                            <div class="invalid-feedback" id="error-nama"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_orangtua" class="col-sm col-form-label">Nama Orangtua</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_orangtua" name="nama_orangtua" required>
                            <div class="invalid-feedback" id="error-nama_orangtua"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="rt" class="col-sm col-form-label">RT</label>
                        <div class="col-sm-9">
                            <select id="rt" name="rt" class="form-control">
                                <option selected>Pilih RT...</option>
                                @for ($i = 1; $i <= 9; $i++)
                                    <option>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status" class="col-sm col-form-label">Status Santri</label>
                        <div class="col-sm-9">
                            <select id="status" name="status" class="form-control">
                                <option selected>Pilih...</option>
                                <option>Aktif</option>
                                <option>Lulus</option>
                                <option>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    {{-- INPUT MANUAL --}}
                    <div class="form-row">
                        <!-- Tambahkan Dropdown Provinsi dan Kota -->
                        <div class="form-group col-md-6">
                            <label for="pesantren" class=" col-form-label">Nama pesantren</label>
                            <input type="text" class="form-control" id="pesantren" name="pesantren" placeholder="Nama Pesantren">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="alamat" class="col-form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="alamat">
                        </div>

                    </div>

                    <div class="tombol">
                        <a href="{{ route('santri.index') }}" class="btn btn-success" >Back</a>
                        <button class="btn btn-primary" type="submit">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    // Handle form submit
    document.getElementById('createSantriForm').addEventListener('submit', function(event) {
        event.preventDefault();
        let formData = new FormData(this);

        fetch('{{ route('santri.store') }}', {
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
                    confirmButtonText: 'Tambah Lagi'
                }).then(() => {
                    this.reset(); // Reset form setelah berhasil ditambahkan
                });
            } else {
                // Tampilkan error validasi
                Object.keys(data.errors).forEach(key => {
                    document.getElementById(`error-${key}`).innerText = data.errors[key][0];
                });
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat menambah data.'
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
