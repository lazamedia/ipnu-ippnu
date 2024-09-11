@extends('dashboard.layouts.main')

@section('content')

<style>
    .box-card {
        padding: 20px;
    }
    .qr-code {
        text-align: center;
        padding: 20px;
    }
    .form-send {
        margin-top: 20px;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>WhatsApp Bot</h4>
            </div>
            <div class="box-card">
                @if($status['status'] === 'qr')
                    <div class="qr-code">
                        <h5>Scan QR Code di bawah ini untuk login ke WhatsApp:</h5>
                        <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ $status['qr'] }}&size=200x200" alt="QR Code">
                    </div>
                @else
                    <h5>Anda sudah terhubung ke WhatsApp!</h5>
                    <form action="{{ route('whatsapp-bot.send') }}" method="POST" class="form-send">
                        @csrf
                        <div class="form-group">
                            <label for="number">Nomor WhatsApp</label>
                            <input type="text" class="form-control" id="number" name="number" placeholder="Masukkan nomor WhatsApp" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Pesan</label>
                            <textarea class="form-control" id="message" name="message" placeholder="Masukkan pesan" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
