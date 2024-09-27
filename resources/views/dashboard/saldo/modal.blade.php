<!-- Modal untuk Create -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createModalLabel">Create Data Keuangan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="createForm" action="{{ route('modul.store') }}" method="POST">
          @csrf
          <div class="modal-body">
            <!-- Input fields for create form -->
            <div class="form-group">
              <label for="tanggal">Tanggal</label>
              <input type="text" class="form-control" id="tanggal" name="tanggal" placeholder="3 Juli 2024">
            </div>
            <div class="form-group">
              <label for="nama">Nama</label>
              <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama transaksi">
            </div>
            <div class="form-group">
              <label for="uang_masuk">Uang Masuk</label>
              <input type="number" class="form-control" id="uang_masuk" name="uang_masuk">
            </div>
            <div class="form-group">
              <label for="uang_keluar">Uang Keluar</label>
              <input type="number" class="form-control" id="uang_keluar" name="uang_keluar">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <!-- Modal untuk Edit -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Data Keuangan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="editForm" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-body">
            <!-- Input fields for edit form -->
            <div class="form-group">
              <label for="editTanggal">Tanggal</label>
              <input type="text" class="form-control" id="editTanggal" name="tanggal">
            </div>
            <div class="form-group">
              <label for="editNama">Nama</label>
              <input type="text" class="form-control" id="editNama" name="nama">
            </div>
            <div class="form-group">
              <label for="editUangMasuk">Uang Masuk</label>
              <input type="number" class="form-control" id="editUangMasuk" name="uang_masuk">
            </div>
            <div class="form-group">
              <label for="editUangKeluar">Uang Keluar</label>
              <input type="number" class="form-control" id="editUangKeluar" name="uang_keluar">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  