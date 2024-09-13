<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event PDF Output</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 10px;
        }

        h1 {
            text-align: center;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            padding: 10px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #f4f4f4;
            border: 1px solid #ccc;
        }

        .details {
            margin-bottom: 20px;
        }

        .details p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Detail Event</h1>

    <div class="details">
        <p><strong>Nama Event:</strong> [Nama Event]</p>
        <p><strong>Tempat:</strong> [Tempat]</p>
        <p><strong>Tanggal:</strong> [Tanggal]</p>
        <p><strong>Anggaran:</strong> Rp. [Anggaran]</p>
    </div>

    <table>
        <tr>
            <th>Ketua</th>
            <th>Sekretaris</th>
            <th>Bendahara</th>
        </tr>
        <tr>
            <td>[Nama Ketua]</td>
            <td>[Nama Sekretaris]</td>
            <td>[Nama Bendahara]</td>
        </tr>
    </table>

    <table>
        <tr>
            <th>Divisi Humas</th>
            <th>Divisi Perkap</th>
            <th>Divisi Acara</th>
        </tr>
        <tr>
            <td>[Nama Divisi Humas]</td>
            <td>[Nama Divisi Perkap]</td>
            <td>[Nama Divisi Acara]</td>
        </tr>
    </table>

    <table>
        <tr>
            <th>Divisi Dekdok</th>
            <th>Divisi Konsumsi</th>
        </tr>
        <tr>
            <td>[Nama Divisi Dekdok]</td>
            <td>[Nama Divisi Konsumsi]</td>
        </tr>
    </table>

    <div class="details">
        <p><strong>Tamu Undangan:</strong> [Nama Tamu Undangan]</p>
    </div>
</div>

<script>
    // Optional: Use jsPDF or print-to-PDF functionality
    // Example: window.print();
</script>

</body>
</html>
