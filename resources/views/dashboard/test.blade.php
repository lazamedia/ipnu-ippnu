@extends('dashboard.layouts.main')

@section('content')

<!-- Tambahkan link ke DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4>Basic DataTables</h4>
          <!-- Tombol Create -->
          <a href="{{ route('pengurus.create') }}" class="btn btn-primary">
              <i class="fas fa-plus"></i> Create
          </a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped" id="table-1">
              <thead>
                <tr>
                  <th class="text-center"> 
                    #
                  </th>
                  <th>Foto</th>
                  <th>Nama Lengkap</th>
                  <th>No WhatsApp</th>
                  <th>Email</th>
                  <th>Pelajar</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($pengurus as $key => $p)
                <tr>
                  <td class="text-center">{{ $key + 1 }}</td>
                  <td>
                    <img alt="image" src="{{ asset('storage/' . $p->foto) }}" class="rounded-circle" width="35" height="35">
                  </td>
                  <td>{{ $p->nama_lengkap }}</td>
                  <td>{{ $p->no_wa }}</td>
                  <td>{{ $p->email }}</td>
                  <td>{{ $p->pelajar }}</td>
                  <td>
                    <a href="{{ route('pengurus.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('pengurus.destroy', $p->id) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-danger btn-sm delete-btn" type="submit">Delete</button>
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

<!-- Tambahkan link ke DataTables JavaScript -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
  $(document).ready(function() {
    // Inisialisasi DataTables
    $('#table-1').DataTable();
  });
</script>

@endsection
