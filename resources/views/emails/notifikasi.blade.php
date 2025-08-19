<!DOCTYPE html>
<html>
<head>
    <title>Laporan Selesai</title>
</head>
<body>
    <p>Yth. {{ $laporan->pelapor->name }},</p>

    <p>Laporan Anda dengan nomor tiket <strong>{{ $laporan->ticket_number }}</strong> telah ditangani dan diselesaikan oleh tim kami.</p>

    <p>Silakan tinjau dan beri respon jika Anda merasa laporan sudah selesai atau masih ada hal yang perlu ditindaklanjuti.</p>

    <p>
        <a href="https://reg3.ptpn4helpdesk.pocari.id/">
            Lihat Laporan
        </a>
    </p>

    <p>Terima kasih.</p>
</body>
</html>
