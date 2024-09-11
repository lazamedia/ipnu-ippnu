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
    .swal2-styled:focus {
        box-shadow: none !important;
        outline: none !important;
        border: none !important;
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

    .modal {
        display: none;
        position: fixed;
        z-index: 99992000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }
    
    .modal-content {
        background-color: #fff;
        color: #000;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 500px;
        border-radius: 8px;
    }
    
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .close {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }
    
    .close:hover, .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
    .error {
        color: red;
        display: none;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card pt-4">
            <div class="card-header set-tabel">
                <div class="h-header">
                    <h4>Data Pengguna</h4>
                </div>
                <div class="d-flex flex-wrap align-items-center justify-content-end">
                    <div class="btn-actions d-flex mr-3">
                        <button id="openCreateModalBtn" class="btn btn-primary mr-2">
                            <i class="fas fa-plus"></i> Tambah Pengguna
                        </button>
                        <button id="bulk-delete-btn" class="btn btn-danger" disabled>
                            <i class="fas fa-trash"></i> Hapus Terpilih
                        </button>
                    </div>
                    <div class="search-box">
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari Nama Pengguna">
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
                        <table class="table table-striped" id="userTable">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAllCheckbox"></th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td><input type="checkbox" class="checkbox-auth" value="{{ $user->id }}"></td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>
                                        @if($user->roles->isNotEmpty())
                                            {{ $user->roles->pluck('name')->join(', ') }}
                                        @else
                                            <span class="text-muted">No Role Assigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-warning btn-sm openEditModalBtn" 
                                                data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}"
                                                data-username="{{ $user->username }}"
                                                data-email="{{ $user->email }}"
                                                data-role="{{ $user->roles->pluck('name')->first() }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('auth.destroy', $user->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm btn-delete">Delete</button>
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

<!-- Modal Create -->
<div id="createUserModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Tambah Pengguna</h5>
            <span id="closeCreateModalBtn" class="close">&times;</span>
        </div>
        <div class="modal-body">
            <!-- Form Input Create -->
            <form id="createUserForm" action="{{ route('auth.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="createName" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="createName" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="createUsername" class="form-label">Username</label>
                    <input type="text" class="form-control" id="createUsername" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="createEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="createEmail" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                
                <div class="mb-3">
                    <label for="createRole" class="form-label">Role</label>
                    <select class="form-control" id="createRole" name="role" required>
                        <option value="">Pilih Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <span id="passwordError" class="error">Password tidak cocok!</span>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div id="editUserModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Pengguna</h5>
            <span id="closeEditModalBtn" class="close">&times;</span>
        </div>
        <div class="modal-body">
            <!-- Form Input Edit -->
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="editUserId" name="id">
                <div class="mb-3">
                    <label for="editName" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="editName" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="editUsername" class="form-label">Username</label>
                    <input type="text" class="form-control" id="editUsername" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="editEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="editEmail" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="editRole" class="form-label">Role</label>
                    <select class="form-control" id="editRole" name="role" required>
                        <option value="">Pilih Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Create Modal
document.getElementById('openCreateModalBtn').addEventListener('click', function() {
    document.getElementById('createUserModal').style.display = 'block';
});

document.getElementById('closeCreateModalBtn').addEventListener('click', function() {
    document.getElementById('createUserModal').style.display = 'none';
});

// Validate Password in Create Form
document.getElementById('createUserForm').addEventListener('submit', function(event) {
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('password_confirmation').value;

    if (password !== confirmPassword) {
        event.preventDefault();
        document.getElementById('passwordError').style.display = 'block';
    }
});

// Edit Modal
document.querySelectorAll('.openEditModalBtn').forEach(button => {
    button.addEventListener('click', function() {
        var id = this.getAttribute('data-id');
        var name = this.getAttribute('data-name');
        var username = this.getAttribute('data-username');
        var email = this.getAttribute('data-email');
        var role = this.getAttribute('data-role');

        // Fill form with user data
        document.getElementById('editUserId').value = id;
        document.getElementById('editName').value = name;
        document.getElementById('editUsername').value = username;
        document.getElementById('editEmail').value = email;
        document.getElementById('editRole').value = role;

        // Set form action to the user ID being edited
        document.getElementById('editUserForm').action = `/dashboard/auth/${id}`;

        // Show edit modal
        document.getElementById('editUserModal').style.display = 'block';
    });
});

document.getElementById('closeEditModalBtn').addEventListener('click', function() {
    document.getElementById('editUserModal').style.display = 'none';
});

// SweetAlert2 for delete confirmation
document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak akan dapat mengembalikan data ini!",
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

// Memilih atau membatalkan semua checkbox
document.getElementById('selectAllCheckbox').addEventListener('change', function() {
    const isChecked = this.checked;
    document.querySelectorAll('.checkbox-auth').forEach(checkbox => {
        checkbox.checked = isChecked;
    });
    toggleBulkDeleteButton();
});

// Aktifkan tombol hapus massal jika ada yang dipilih
document.querySelectorAll('.checkbox-auth').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        toggleBulkDeleteButton();
    });
});

function toggleBulkDeleteButton() {
    const selected = document.querySelectorAll('.checkbox-auth:checked').length > 0;
    document.getElementById('bulk-delete-btn').disabled = !selected;
}

// Konfirmasi hapus massal
document.getElementById('bulk-delete-btn').addEventListener('click', function() {
    const selectedIds = Array.from(document.querySelectorAll('.checkbox-auth:checked')).map(cb => cb.value);

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
            fetch('{{ route('auth.bulk-delete') }}', {
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

// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('#userTable tbody tr');
    
    rows.forEach((row) => {
        const namaPengguna = row.querySelectorAll('td')[1].textContent.toLowerCase();
        row.style.display = namaPengguna.includes(searchValue) ? '' : 'none';
    });
});
</script>

@endsection
