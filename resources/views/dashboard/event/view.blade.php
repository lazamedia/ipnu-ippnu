@extends('dashboard.layouts.main')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Event</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h3 {
            margin-top: 0;
        }
    </style>
</head>
<body>

    <h1>Daftar Event</h1>

    @if($events->isEmpty())
        <p>Tidak ada event yang tersedia.</p>
    @else
        @foreach($events as $event)
            <h3>Event: {{ $event->ketua_pelaksana }}</h3>
            <table>
                <tr>
                    <th>Ketua Pelaksana</th>
                    <td>{{ $event->ketua_pelaksana }}</td>
                </tr>
                <tr>
                    <th>Wakil</th>
                    <td>{{ $event->wakil }}</td>
                </tr>
                <tr>
                    <th>Sekretaris</th>
                    <td>{{ $event->sekretaris }}</td>
                </tr>
                <tr>
                    <th>Bendahara</th>
                    <td>{{ $event->bendahara }}</td>
                </tr>
                <tr>
                    <th>Tempat</th>
                    <td>{{ $event->tempat }}</td>
                </tr>
                <tr>
                    <th>Anggaran</th>
                    <td>{{ number_format($event->anggaran, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>{{ $event->tanggal }}</td>
                </tr>
                <tr>
                    <th>Tamu Undangan</th>
                    <td>{{ $event->tamu_undangan }}</td>
                </tr>

                <!-- Bagian untuk divisi-divisi -->
                <tr>
                    <th>Divisi Humas</th>
                    <td>
                        @if($event->divisi_humas)
                            <ol>
                                @foreach(explode(',', $event->divisi_humas) as $index => $divisiHumas)
                                    <li>{{ trim($divisiHumas) }}</li>
                                @endforeach
                            </ol>
                        @else
                            Tidak ada data
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Divisi Acara</th>
                    <td>
                        @if($event->divisi_acara)
                            <ol>
                                @foreach(explode(',', $event->divisi_acara) as $index => $divisiAcara)
                                    <li>{{ trim($divisiAcara) }}</li>
                                @endforeach
                            </ol>
                        @else
                            Tidak ada data
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Divisi Perkap</th>
                    <td>
                        @if($event->divisi_perkap)
                            <ol>
                                @foreach(explode(',', $event->divisi_perkap) as $index => $divisiPerkap)
                                    <li>{{ trim($divisiPerkap) }}</li>
                                @endforeach
                            </ol>
                        @else
                            Tidak ada data
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Divisi Dekdok</th>
                    <td>
                        @if($event->divisi_dekdok)
                            <ol>
                                @foreach(explode(',', $event->divisi_dekdok) as $index => $divisiDekdok)
                                    <li>{{ trim($divisiDekdok) }}</li>
                                @endforeach
                            </ol>
                        @else
                            Tidak ada data
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Divisi Konsumsi</th>
                    <td>
                        @if($event->divisi_konsumsi)
                            <ol>
                                @foreach(explode(',', $event->divisi_konsumsi) as $index => $divisiKonsumsi)
                                    <li>{{ trim($divisiKonsumsi) }}</li>
                                @endforeach
                            </ol>
                        @else
                            Tidak ada data
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Keperluan Divisi</th>
                    <td>
                        @if($event->keperluan_divisi)
                            <ol>
                                @foreach(explode(',', $event->keperluan_divisi) as $index => $keperluanDivisi)
                                    <li>{{ trim($keperluanDivisi) }}</li>
                                @endforeach
                            </ol>
                        @else
                            Tidak ada data
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Foto Poster</th>
                    <td>
                        @if($event->foto)
                            <img src="{{ Storage::url($event->foto) }}" alt="Foto Poster" style="max-width: 200px;">
                        @else
                            Tidak ada foto
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>File Dokumen</th>
                    <td>
                        @if($event->file_dokumen)
                            <a href="{{ Storage::url($event->file_dokumen) }}" download>Download Dokumen</a>
                        @else
                            Tidak ada dokumen
                        @endif
                    </td>
                </tr>
            </table>
        @endforeach
    @endif

</body>
</html>


@endsection
