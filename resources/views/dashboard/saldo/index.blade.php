@extends('dashboard.layouts.main')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/customtabel.css') }}">

 <!-- Box untuk menampilkan total pemasukan, pengeluaran, dan saldo akhir -->

  <div class="alert alert-success text-center" style="font-size: 0.9rem;">
      <div class="row">
          <div class="col-md-4 col-12">
              <strong>Total Pemasukan:</strong> Rp. {{ number_format($total_pemasukan, 2, ',', '.') }}
          </div>
          <div class="col-md-4 col-12">
              <strong>Total Pengeluaran:</strong> Rp. {{ number_format($total_pengeluaran, 2, ',', '.') }}
          </div>
          <div class="col-md-4 col-12">
              <strong>Saldo Akhir:</strong> Rp. {{ number_format($sisa_saldo, 2, ',', '.') }}
          </div>
      </div>
  </div>



<div class="card pt-4">
    <div class="card-header set-tabel">
        <div class="h-header">
            <h4>Data Keuangan</h4>
        </div>
        <div class="d-flex flex-wrap align-items-center justify-content-end">
            <div class="btn-actions d-flex mr-3">
                <!-- Tombol Create mengarahkan ke route saldo.create -->
                <a href="{{ route('saldo.create') }}" class="btn btn-primary mr-2">
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
                <table class="table table-striped" id="saldoTable">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>Tanggal</th>
                            <th>Nama Transaksi</th>
                            <th>Pemasukan</th>
                            <th>Pengeluaran</th>
                            <th>Saldo Terakhir</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($saldo as $item)
                            <tr>
                                <td><input type="checkbox" class="checkbox-saldo" value="{{ $item['id'] }}"></td>
                                <td>{{ \Carbon\Carbon::parse($item['tanggal'])->format('d M Y') }}</td>
                                <td>{{ $item['nama_transaksi'] }}</td>
                                <td>Rp. {{ number_format($item['pemasukan'], 2, ',', '.') }}</td>
                                <td>Rp. {{ number_format($item['pengeluaran'], 2, ',', '.') }}</td>
                                <td>Rp. {{ number_format($item['saldo_terakhir'], 2, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('saldo.edit', $item['id']) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('saldo.destroy', $item['id']) }}" method="POST" class="delete-form d-inline">
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

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Script untuk memilih atau membatalkan semua checkbox
    document.getElementById('select-all').addEventListener('change', function() {
        const isChecked = this.checked;
        document.querySelectorAll('.checkbox-saldo').forEach(checkbox => {
            checkbox.checked = isChecked;
        });
        toggleBulkDeleteButton();
    });

    // Aktifkan tombol hapus massal jika ada yang dipilih
    document.querySelectorAll('.checkbox-saldo').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            toggleBulkDeleteButton();
        });
    });

    // Fungsi untuk mengaktifkan atau menonaktifkan tombol hapus massal
    function toggleBulkDeleteButton() {
        const selected = document.querySelectorAll('.checkbox-saldo:checked').length > 0;
        document.getElementById('bulk-delete-btn').disabled = !selected;
    }

    // Konfirmasi hapus massal dengan SweetAlert
    document.getElementById('bulk-delete-btn').addEventListener('click', function() {
        const selectedIds = Array.from(document.querySelectorAll('.checkbox-saldo:checked')).map(cb => cb.value);

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
                fetch('{{ route('saldo.bulk-delete') }}', {
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
                    // Kirim form jika dikonfirmasi
                    this.closest('form').submit();  // Kirim form saat konfirmasi
                }
            });
        });
    });

    // Script untuk filter pencarian nama pada tabel
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('#saldoTable tbody tr');

        rows.forEach((row) => {
            const namaTransaksi = row.querySelectorAll('td')[2].textContent.toLowerCase();
            if (namaTransaksi.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

@endsection
