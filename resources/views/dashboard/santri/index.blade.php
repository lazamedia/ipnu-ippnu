@extends('dashboard.layouts.main')

@section('content')

<link rel="stylesheet" href="{{ asset('assets/css/customtabel.css') }}">

<div class="card pt-4">
    <div class="card-header set-tabel">
        <div class="h-header">
            <h4>Data Santri Pujut</h4>
        </div>
        <div class="d-flex flex-wrap align-items-center justify-content-end">
            <div class="btn-actions d-flex mr-3">
                <a href="{{ route('santri.create') }}" class="btn btn-primary mr-2">
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
                <table class="table table-striped" id="santriTable">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Nama Pesantren</th>
                            <th>Kabupaten</th>
                            <th>RT/RW</th>
                            <th>Nama Orangtua</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($santris as $santri)
                            <tr>
                                <td><input type="checkbox" class="checkbox-santri" value="{{ $santri->id }}"></td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $santri->nama }}</td>
                                <td>{{ $santri->pesantren }}</td>
                                <td>{{ $santri->alamat }}</td>
                                <td>{{ $santri->rt }}</td>
                                <td>{{ $santri->nama_orangtua }}</td>
                                <td>
                                    <div class="badge 
                                        {{ $santri->status == 'Aktif' ? 'badge-primary' : ($santri->status == 'Lulus' ? 'badge-success' : 'badge-danger') }} 
                                        badge-shadow">
                                        {{ $santri->status }}
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('santri.edit', $santri->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $santri->id }}">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
        document.querySelectorAll('.checkbox-santri').forEach(checkbox => {
            checkbox.checked = isChecked;
        });
        toggleBulkDeleteButton();
    });

    // Aktifkan tombol hapus massal jika ada yang dipilih
    document.querySelectorAll('.checkbox-santri').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            toggleBulkDeleteButton();
        });
    });

    function toggleBulkDeleteButton() {
        const selected = document.querySelectorAll('.checkbox-santri:checked').length > 0;
        document.getElementById('bulk-delete-btn').disabled = !selected;
    }

    // Konfirmasi hapus massal
    document.getElementById('bulk-delete-btn').addEventListener('click', function() {
        const selectedIds = Array.from(document.querySelectorAll('.checkbox-santri:checked')).map(cb => cb.value);

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
                fetch('{{ route('santri.bulk-delete') }}', {
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
        const rows = document.querySelectorAll('#santriTable tr');
        
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