@extends('dashboard.layouts.main')

@section('content')

<style>
    .set-tabel {
        width: 100%;
        padding: 10px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }
    .aksi {
        color: #000000;
    }
    .aksi-edit {
        color: #777777;
        font-size: 1rem;
        margin-right: 10px;
    }
    .aksi-delete {
        color: #777777;
        font-size: 1rem;
    }
    .box-tabel {
        padding: 10px;
    }

    @media (max-width: 768px) {
        .set-tabel {
            flex-direction: column;
            align-items: flex-start;
        }
        .btn-actions, .search-box {
            width: 100%;
            margin-bottom: 15px;
            display: flex;
            justify-content: flex-end;
        }
        .h-header{
            padding: 10px;
        }
    }

    /* Menghilangkan shadow dan border outline pada tombol SweetAlert */
    .swal2-styled:focus {
        box-shadow: none !important;
        outline: none !important;
        border: none !important;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card pt-4">
            <div class="card-header set-tabel">
                <div class="h-header">
                    <h4>Data Pengurus</h4>
                </div>
                <div class="d-flex flex-wrap align-items-center justify-content-end">
                    <div class="btn-actions d-flex mr-3">
                        <a href="{{ route('pengurus.create') }}" class="btn btn-primary mr-2">
                            <i class="fas fa-plus"></i> Create
                        </a>
                        <button id="bulk-delete-btn" class="btn btn-danger mr-2" disabled>
                            <i class="fas fa-trash"></i> Hapus Terpilih
                        </button>
                    </div>
                    <div class="search-box">
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search by Name">
                            <div class="input-group-btn">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <div class="box-tabel">
                        <table class="table table-striped" id="pengurusTable">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="select-all"></th>
                                    <th>Foto</th>
                                    <th>Nama Lengkap</th>
                                    <th>Divisi</th>
                                    <th>No Whatsapp</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengurus as $item)
                                <tr>
                                    <td><input type="checkbox" class="checkbox-pengurus" value="{{ $item->id }}"></td>
                                    <td>
                                        <img alt="image" src="{{ asset('storage/' . $item->foto) }}" class="rounded-circle" width="35" height="35"
                                        data-toggle="tooltip" title="{{ $item->nama_lengkap }}">
                                    </td>
                                    <td>{{ $item->nama_lengkap }}</td>
                                    <td>{{ $item->divisi }}</td>
                                    <td>{{ $item->no_wa }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                        <a href="{{ route('pengurus.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('pengurus.destroy', $item->id) }}" method="POST" class="delete-form d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- CSS untuk menghapus outline border pada SweetAlert -->
<style>
.swal2-styled:focus {
    box-shadow: none !important;
    outline: none !important;
}
</style>

<!-- Script untuk bulk delete dan delete individual -->
<script>
    // Memilih atau membatalkan semua checkbox
    document.getElementById('select-all').addEventListener('change', function() {
        const isChecked = this.checked;
        document.querySelectorAll('.checkbox-pengurus').forEach(checkbox => {
            checkbox.checked = isChecked;
        });
        toggleBulkDeleteButton();
    });

    // Aktifkan tombol hapus massal jika ada yang dipilih
    document.querySelectorAll('.checkbox-pengurus').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            toggleBulkDeleteButton();
        });
    });

    function toggleBulkDeleteButton() {
        const selected = document.querySelectorAll('.checkbox-pengurus:checked').length > 0;
        document.getElementById('bulk-delete-btn').disabled = !selected;
    }

    // Konfirmasi hapus massal
    document.getElementById('bulk-delete-btn').addEventListener('click', function() {
        const selectedIds = Array.from(document.querySelectorAll('.checkbox-pengurus:checked')).map(cb => cb.value);

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang terpilih akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim data ke server untuk dihapus
                fetch('{{ route('pengurus.bulk-delete') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ ids: selectedIds })
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Berhasil!', 'Data telah dihapus.', 'success')
                        .then(() => location.reload());
                    } else {
                        Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
                    }
                });
            }
        });
    });

    // SweetAlert untuk hapus individual
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form jika dikonfirmasi
                    this.closest('form').submit();
                }
            });
        });
    });

    // Script untuk filter pencarian nama pada tabel
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('#pengurusTable tr');
        
        rows.forEach((row, index) => {
            if (index === 0) return; // Skip the header row
            const namaLengkap = row.querySelectorAll('td')[2].textContent.toLowerCase();
            if (namaLengkap.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

@endsection