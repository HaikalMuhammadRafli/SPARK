<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Prestasi Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
        }

        .header p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Prestasi Mahasiswa</h1>
        <p>Tanggal: {{ date('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Prestasi</th>
                <th>Juara</th>
                <th>Status</th>
                <th>Catatan</th>
                <th>Nama Kelompok</th>
                <th>Tanggal Validasi</th>
                <th>Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporans as $index => $laporan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $laporan->prestasi_id }}</td>
                    <td>{{ $laporan->prestasi_juara }}</td>
                    <td>{{ $laporan->prestasi_status }}</td>
                    <td>{{ $laporan->prestasi_catatan }}</td>
                    <td>{{ $laporan->kelompok->kelompok_nama ?? '-' }}</td>
                    <td>{{ $laporan->validated_at ? (is_string($laporan->validated_at) ? $laporan->validated_at : $laporan->validated_at->format('d/m/Y H:i:s')) : '-' }}
                    </td>
                    <td>{{ is_string($laporan->created_at) ? $laporan->created_at : $laporan->created_at->format('d/m/Y H:i:s') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh sistem</p>
        <p>&copy; {{ date('Y') }} Sistem Informasi Prestasi Mahasiswa</p>
    </div>
</body>

</html>
