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
        .h-header {
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
                    <h4>Data Event</h4>
                </div>
                <div class="d-flex flex-wrap align-items-center justify-content-end">
                    <div class="btn-actions d-flex mr-3">
                        <a href="{{ route('event.create') }}" class="btn btn-primary mr-2">
                            <i class="fas fa-plus"></i> Create
                        </a>
                        <button id="bulk-delete-btn" class="btn btn-danger mr-2" disabled>
                            <i class="fas fa-trash"></i> Hapus Terpilih
                        </button>
                    </div>
                    <div class="search-box">
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search by Event Name">
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
                        <table class="table table-striped" id="eventTable">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="select-all"></th>
                                    <th>No</th>
                                    <th>Nama Acara</th>
                                    <th>Tempat</th>
                                    <th>Tanggal</th>
                                    <th>Anggaran</th>
                                    
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($events as $event)
                                <tr>
                                    <td><input type="checkbox" class="checkbox-event" value="{{ $event->id }}"></td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $event->nama_event }}</td>
                                    <td>{{ $event->tempat }}</td>
                                    <td>{{ $event->tanggal }}</td>
                                    <td>{{ $event->anggaran }}</td>
                                    
                                    
                                    <td>
                                        <a href="" class="btn btn-primary btn-sm">Detail</a>
                                        <a href="{{ route('event.edit', $event->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('event.destroy', $event->id) }}" method="POST" class="delete-form d-inline">
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

<script src="{{ asset('assets/dashboard/bulkdelete.js') }}"></script>
<!-- Script untuk bulk delete dan delete individual -->
<script>
    // Memilih atau membatalkan semua checkbox
    document.getElementById('select-all').addEventListener('change', function() {
    const isChecked = this.checked;
    document.querySelectorAll('.checkbox-event').forEach(checkbox => {
        checkbox.checked = isChecked;
    });
    toggleBulkDeleteButton();
});

// Aktifkan tombol hapus massal jika ada yang dipilih
document.querySelectorAll('.checkbox-event').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        toggleBulkDeleteButton();
    });
});

function toggleBulkDeleteButton() {
    const selected = document.querySelectorAll('.checkbox-event:checked').length > 0;
    document.getElementById('bulk-delete-btn').disabled = !selected;
}

document.getElementById('bulk-delete-btn').addEventListener('click', function() {
const selectedIds = Array.from(document.querySelectorAll('.checkbox-event:checked')).map(cb => cb.value);

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
        fetch('{{ route('dashboard.event.bulk-delete') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ ids: selectedIds })
        }).then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire('Berhasil!', data.message, 'success')
                .then(() => location.reload());
            } else {
                Swal.fire('Gagal!', data.message, 'error');
            }
        }).catch(error => {
            Swal.fire('Gagal!', 'Terjadi kesalahan koneksi.', 'error');
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
                this.closest('form').submit();
            }
        });
    });
});

// Script untuk filter pencarian nama pada tabel
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('#eventTable tbody tr');
    
    rows.forEach((row) => {
        const eventName = row.querySelectorAll('td')[2].textContent.toLowerCase();
        if (eventName.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

@endsection
