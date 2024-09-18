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

                    {{-- INPUT DARI DATABASE --}}
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="provinsi" class=" col-form-label">Provinsi</label>
                                <select id="provinsi" name="provinsi" class="form-control" >
                                    <option selected>Pilih Provinsi...</option>
                                    <!-- Data Provinsi akan di-append di sini -->
                                </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="kabupaten" class="col-form-label">Kota/Kabupaten</label>
                                <select id="kabupaten" name="kabupaten" class="form-control" >
                                    <option selected>Pilih Kota/Kabupaten...</option>
                                    <!-- Data Kabupaten/Kota akan di-append di sini -->
                                </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="pesantren" class="col-form-label">Nama Pesantren</label>
                                <select id="pesantren" name="pesantren" class="form-control select2" >
                                    <option selected>Pilih Pesantren...</option>
                                    <!-- Data Pesantren akan di-append di sini -->
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
                            <label for="kabupaten" class="col-form-label">Alamat</label>
                            <input type="text" class="form-control" id="kabupaten" name="kabupaten" placeholder="alamat">
                        </div>

                    </div>

                    <div class="tombol">
                        <button class="btn btn-info mr-3" type="button">Back</button>
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


document.addEventListener('DOMContentLoaded', function() {
    // Ambil data provinsi dari API dan isi ke dalam dropdown
        // Fetch data provinsi
        fetch('https://api-pesantren-indonesia.vercel.app/provinsi.json')
        .then(response => response.json())
        .then(provinsiData => {
            const provinsiSelect = document.getElementById('provinsi');
            
            // Urutkan provinsi secara alfabetis
            provinsiData.sort((a, b) => a.nama.localeCompare(b.nama));

            provinsiData.forEach(provinsi => {
                const option = document.createElement('option');
                option.value = provinsi.id;
                option.textContent = provinsi.nama;
                provinsiSelect.appendChild(option);
            });

            // Ketika provinsi dipilih, ambil data kabupaten
            provinsiSelect.addEventListener('change', function() {
                const provinsiId = this.value;
                const kabupatenSelect = document.getElementById('kabupaten');
                kabupatenSelect.innerHTML = '<option selected>Pilih Kota/Kabupaten...</option>';
                document.getElementById('pesantren').value = '';

                if (provinsiId) {
                    fetch(`https://api-pesantren-indonesia.vercel.app/kabupaten/${provinsiId}.json`)
                        .then(response => response.json())
                        .then(kabupatenData => {
                            kabupatenData.sort((a, b) => a.nama.localeCompare(b.nama));

                            if (kabupatenData.length > 0) {
                                kabupatenData.forEach(kabupaten => {
                                    const option = document.createElement('option');
                                    option.value = kabupaten.id;
                                    option.textContent = kabupaten.nama;
                                    kabupatenSelect.appendChild(option);
                                });
                            } else {
                                kabupatenSelect.innerHTML = '<option selected>Tidak ada kabupaten tersedia</option>';
                            }
                        })
                        .catch(error => {
                            console.error('Gagal mengambil data kabupaten:', error);
                        });
                }
            });
        })
        .catch(error => {
            console.error('Gagal mengambil data provinsi:', error);
        });

    // Ketika kabupaten dipilih, ambil data pesantren
    document.getElementById('kabupaten').addEventListener('change', function() {
        const kabupatenId = this.value;
        console.log('ID Kabupaten dipilih:', kabupatenId); // Debug ID Kabupaten

        // Reset dropdown pesantren
        const pesantrenSelect = document.getElementById('pesantren');
        pesantrenSelect.innerHTML = '<option selected>Pilih Pesantren...</option>';

        if (kabupatenId) {
            fetch(`https://api-pesantren-indonesia.vercel.app/pesantren/${kabupatenId}.json`)
                .then(response => response.json())
                .then(pesantrenData => {
                    console.log('Data pesantren:', pesantrenData); // Debug data pesantren
                    if (pesantrenData.length > 0) {
                        pesantrenData.forEach(pesantren => {
                            const option = document.createElement('option');
                            option.value = pesantren.nama;
                            option.textContent = pesantren.nama;
                            pesantrenSelect.appendChild(option);
                        });
                    } else {
                        pesantrenSelect.innerHTML = '<option selected>Tidak ada pesantren tersedia</option>';
                    }
                })
                .catch(error => {
                    console.error('Gagal mengambil data pesantren:', error);
                });
        }
    });
});

    

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
