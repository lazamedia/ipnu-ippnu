@extends('dashboard.layouts.main')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/customtabel.css') }}">

<!-- Custom CSS untuk Popup -->
<style>

      /* Style untuk area drag & drop */
      .drag-drop-area {
        border: 2px dashed #ccc;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        margin-bottom: 10px;
    }

    /* Border hijau untuk preview gambar yang berhasil diupload */
    .preview-border-green {
        border: 2px solid green;
        padding: 5px;
        display: inline-block;
        margin-bottom: 10px;
    }

    /* Style untuk tombol hapus gambar */
    .delete-btn {
        background-color: red;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        margin-left: 10px;
    }
    
    /* Backdrop */
    .custom-popup-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9998;
        display: none;
    }

    /* Popup Box */
    .custom-popup {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        z-index: 9999;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 450px;
        display: none;
    }

    /* Tombol Close Popup */
    .custom-popup-close {
        float: right;
        cursor: pointer;
        font-size: 20px;
    }
</style>

<section class="isi">
  @if (session()->has('success'))
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
          icon: 'success',
          title: 'Success!',
          text: '{{ session('success') }}',
        });
      });
    </script>
  @endif

  <div class="card">
    <div class="card-header set-tabel">
        <div class="h-header">
            <h4>Data Kategori Artikel</h4>
        </div>
        <div class="d-flex flex-wrap align-items-center justify-content-end">
            <div class="btn-actions d-flex mr-3">
                <button id="open-popup-btn" class="btn btn-primary mr-2">
                    <i class="fas fa-plus"></i> Create
                </button>
                <button id="bulk-delete-btn" class="btn btn-danger mr-2" disabled>
                    <i class="fas fa-trash"></i> Hapus Terpilih
                </button>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <div class="box-tabel">
            <table class="table table-striped" id="categoryTable">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>No</th>
                        <th>Image</th>
                        <th>Category Name</th>
                        <th>Slug</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($categories as $category) 
                  <tr>
                    <td><input type="checkbox" class="checkbox-category" value="{{ $category->id }}"></td>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                      <img alt="image" src="{{ asset('storage/' . $category->image) }}" height="35" width="35">
                    </td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->slug }}</td>
                    <td>
                      <button class="btn btn-warning btn-sm" onclick="openPopup('edit', '{{ $category->id }}', '{{ $category->name }}', '{{ $category->slug }}', '{{ $category->image }}')" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                      </button>
                      <form action="/dashboard/categories/{{ $category->id }}" method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <button class="btn btn-danger btn-sm delete-btn" title="Delete">
                          <i class="bi bi-trash"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
  </div>

  <!-- Custom Popup HTML -->
  <div class="custom-popup-backdrop" id="popup-backdrop"></div>
  <div class="custom-popup" id="custom-popup">
    <span class="custom-popup-close" id="close-popup">&times;</span>
    <h4 id="popup-title">Create Category</h4>
    <form id="popup-form" action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="_method" id="popup-method" value="POST">

      <div class="form-group">
        <label for="name">Nama Kategori</label>
        <input type="text" name="name" id="name" class="form-control" required oninput="generateSlug()">
      </div>

      <div class="form-group">
        <label for="slug">Slug</label>
        <input type="text" name="slug" id="slug" class="form-control" required readonly>
      </div>

      <div class="form-group">
        <label for="image">Gambar</label>
        <input type="file" name="image" id="image" class="form-control">
      </div>

      <button type="submit" class="btn btn-primary" id="submit-btn">Create</button>
    </form>
  </div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/dashboard/makesta.js') }}"></script>

<script>
    // Event listener untuk tombol 'Create'
    document.getElementById('open-popup-btn').addEventListener('click', function() {
        openPopup('create');
    });

    // Buka Popup untuk Create atau Edit
    function openPopup(type, id = null, name = '', slug = '', image = '') {
        const popupTitle = document.getElementById('popup-title');
        const form = document.getElementById('popup-form');
        const methodInput = document.getElementById('popup-method');
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        const imageInput = document.getElementById('image');
        const submitBtn = document.getElementById('submit-btn');

        if (type === 'edit') {
            popupTitle.textContent = 'Edit Category';
            form.action = `/dashboard/categories/${id}`;
            methodInput.value = 'PUT';
            submitBtn.textContent = 'Update';

            // Isi form dengan data yang ada
            nameInput.value = name;
            slugInput.value = slug;
            imageInput.value = ''; // Reset input gambar
        } else {
            popupTitle.textContent = 'Create Category';
            form.action = '{{ route("categories.store") }}';
            methodInput.value = 'POST';
            submitBtn.textContent = 'Create';

            // Reset form
            nameInput.value = '';
            slugInput.value = '';
            imageInput.value = '';
        }

        document.getElementById('popup-backdrop').style.display = 'block';
        document.getElementById('custom-popup').style.display = 'block';
    }

    // Tutup Popup
    document.getElementById('close-popup').addEventListener('click', function() {
        document.getElementById('popup-backdrop').style.display = 'none';
        document.getElementById('custom-popup').style.display = 'none';
    });

    // Tutup Popup saat klik di luar
    document.getElementById('popup-backdrop').addEventListener('click', function() {
        document.getElementById('popup-backdrop').style.display = 'none';
        document.getElementById('custom-popup').style.display = 'none';
    });

    // Generate slug otomatis
    function generateSlug() {
        const nameInput = document.getElementById('name').value;
        const slugInput = document.getElementById('slug');
        slugInput.value = nameInput.toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)/g, '');
    }

    // Konfirmasi hapus dengan SweetAlert
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



    // Memilih atau membatalkan semua checkbox
    document.getElementById('select-all').addEventListener('change', function() {
        const isChecked = this.checked;
        document.querySelectorAll('.checkbox-category').forEach(checkbox => {
            checkbox.checked = isChecked;
        });
        toggleBulkDeleteButton();
    });

    // Aktifkan tombol hapus massal jika ada yang dipilih
    document.querySelectorAll('.checkbox-category').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            toggleBulkDeleteButton();
        });
    });

    function toggleBulkDeleteButton() {
        const selected = document.querySelectorAll('.checkbox-category:checked').length > 0;
        document.getElementById('bulk-delete-btn').disabled = !selected;
    }

    // Konfirmasi hapus massal
    document.getElementById('bulk-delete-btn').addEventListener('click', function() {
        const selectedIds = Array.from(document.querySelectorAll('.checkbox-category:checked')).map(cb => cb.value);

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
                fetch('{{ route('category.bulk-delete') }}', {
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


    
</script>

@endsection
