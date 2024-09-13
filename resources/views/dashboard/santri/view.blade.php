@extends('dashboard.layouts.main')

@section('content')

<link rel="stylesheet" href="{{ asset ('assets/css/customtabel.css') }}">
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
                    <h4 style="font-size: 16pt;">Data Santri Pujut</h4>
                </div>
                <div class="d-flex flex-wrap align-items-center justify-content-end">
                    <div class="btn-actions d-flex mr-3">
                        <a href="#" class="btn btn-primary mr-2">
                            <i class="fas fa-plus"></i> Create
                        </a>
                        <button id="bulk-delete-btn" class="btn btn-danger mr-2" disabled>
                            <i class="fas fa-trash"></i> Hapus Terpilih
                        </button>
                    </div>
                </div>
            </div>
            
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                      <thead>
                        <tr>
                          <th>Nama Lengkap</th>
                          <th>Nama Pesantren</th>
                          <th>Kota Pesantren</th>
                          <th>RT/RW</th>
                          <th>Nama Orang Tua</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Tiger Nixon</td>
                          <td>System Architect</td>
                          <td>Edinburgh</td>
                          <td>01/02</td>
                          <td>John Doe</td>
                          <td><div class="badge badge-success badge-shadow">Completed</div></td>
                        </tr>
                        <tr>
                            <td>Tiger Nixon</td>
                            <td>System Architect</td>
                            <td>Edinburgh</td>
                            <td>01/02</td>
                            <td>John Doe</td>
                            <td><div class="badge badge-success badge-shadow">Completed</div></td>
                          </tr>
                          <tr>
                            <td>Tiger Nixon</td>
                            <td>System Architect</td>
                            <td>Edinburgh</td>
                            <td>01/02</td>
                            <td>John Doe</td>
                            <td><div class="badge badge-success badge-shadow">Completed</div></td>
                          </tr>
                          <tr>
                            <td>Tiger Nixon</td>
                            <td>System Architect</td>
                            <td>Edinburgh</td>
                            <td>01/02</td>
                            <td>John Doe</td>
                            <td><div class="badge badge-success badge-shadow">Completed</div></td>
                          </tr>
                          <tr>
                            <td>Tiger Nixon</td>
                            <td>System Architect</td>
                            <td>Edinburgh</td>
                            <td>01/02</td>
                            <td>John Doe</td>
                            <td><div class="badge badge-success badge-shadow">Completed</div></td>
                          </tr>
                          <tr>
                            <td>Tiger Nixon</td>
                            <td>System Architect</td>
                            <td>Edinburgh</td>
                            <td>01/02</td>
                            <td>John Doe</td>
                            <td><div class="badge badge-success badge-shadow">Completed</div></td>
                          </tr>
                       
                       
                      </tbody>
                    </table>
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

    
</script>

@endsection