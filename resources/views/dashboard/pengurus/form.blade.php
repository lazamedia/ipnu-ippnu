<div class="form-group">
    <label for="foto">Foto</label>
    <input type="file" class="form-control" name="foto" id="foto">
</div>

<div class="form-group">
    <label for="nama_lengkap">Nama Lengkap</label>
    <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $pengurus->nama_lengkap ?? '') }}">
</div>

<div class="form-group">
    <label for="divisi">Divisi</label>
    <select class="form-control" name="divisi" id="divisi">
        <option value="ketua" {{ old('divisi', $pengurus->divisi ?? '') == 'ketua' ? 'selected' : '' }}>Ketua</option>
        <option value="sekretaris" {{ old('divisi', $pengurus->divisi ?? '') == 'sekretaris' ? 'selected' : '' }}>Sekretaris</option>
        <option value="anggota" {{ old('divisi', $pengurus->divisi ?? '') == 'anggota' ? 'selected' : '' }}>Anggota</option>
    </select>
</div>

<div class="form-group">
    <label for="no_wa">No Whatsapp</label>
    <input type="text" class="form-control" name="no_wa" id="no_wa" value="{{ old('no_wa', $pengurus->no_wa ?? '') }}">
</div>

<div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $pengurus->email ?? '') }}">
</div>

<div class="form-group">
    <label for="pelajar">Pelajar</label>
    <select class="form-control" name="pelajar" id="pelajar">
        <option value="ipnu" {{ old('pelajar', $pengurus->pelajar ?? '') == 'ipnu' ? 'selected' : '' }}>IPNU</option>
        <option value="ippnu" {{ old('pelajar', $pengurus->pelajar ?? '') == 'ippnu' ? 'selected' : '' }}>IPPNU</option>
    </select>
</div>
