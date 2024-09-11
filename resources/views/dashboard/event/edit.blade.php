@extends('dashboard.layouts.main')

@section('content')

<form action="{{ route('dashboard.event.update', $event->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="nama_event">Nama Event</label>
        <input type="text" class="form-control" id="nama_event" name="nama_event" value="{{ $event->nama_event }}" required>
    </div>
    <div class="form-group">
        <label for="tanggal">Tanggal</label>
        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $event->tanggal }}" required>
    </div>
    <div class="form-group">
        <label for="lokasi">Lokasi</label>
        <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ $event->lokasi }}" required>
    </div>
    <div class="form-group">
        <label for="link_drive">Link Drive</label>
        <input type="url" class="form-control" id="link_drive" name="link_drive" value="{{ $event->link_drive }}" required>
    </div>
    <div class="form-group">
        <label for="file_dokumen">File Dokumen (PDF)</label>
        <input type="file" class="form-control" id="file_dokumen" name="file_dokumen">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>

@endsection
