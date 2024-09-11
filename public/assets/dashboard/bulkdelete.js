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