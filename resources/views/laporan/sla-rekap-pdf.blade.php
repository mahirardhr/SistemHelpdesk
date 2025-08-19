<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 5px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Rekap SLA Laporan Helpdesk</h2>
    <p>Periode: {{ $start }} s/d {{ $end }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Tiket</th>
                <th>Unit</th>
                <th>Nama</th>
                <th>Jenis Masalah</th>
                <th>Masalah</th>
                <th>Waktu SLA</th>
                <th>PIC</th>
                <th>Status SLA</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporans as $i => $laporan)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $laporan->ticket_number }}</td>
                <td>{{ $laporan->pelapor->departemen->nama_departemen ?? '-' }}</td>
                <td>{{ $laporan->pelapor->name ?? '-' }}</td>
                <td>{{ $laporan->kategori->nama_kategori ?? '-' }}</td>
                <td>{{ $laporan->description }}</td>
                <td>{{ $laporan->sla_close ? \Carbon\Carbon::parse($laporan->sla_close)->format('d-m-Y') : '-' }}</td>
                <td>{{ $laporan->pic->name ?? '-' }}</td>
                <td>{{ $laporan->sla_status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>