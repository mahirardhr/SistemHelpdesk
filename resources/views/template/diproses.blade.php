@extends('template.master')

@section('content')
<div class="container-fluid">
    <!-- Form Pencarian -->
    <form method="GET" action="{{ route('proses') }}">
        <div class="row mb-3 align-items-center">
            <div class="col-md-6">
                <h1 class="mb-0 font-weight-bold" style="font-size: 25px;">Laporan Sedang Diproses</h1>
            </div>
            <div class="col-md-4 offset-md-2">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nomor tiket" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Tabel Laporan -->
    <table class="table table-bordered mt-4">
        <thead class="thead-dark">
            <tr class="text-center">
                <th>No. Tiket</th>
                <th>Tanggal Dibuat</th>
                <th>Nama Pelapor</th>
                <th>PIC</th>
                <th>Kategori Masalah</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporans as $laporan)
            <tr class="text-center">
                <td>{{ $laporan->ticket_number }}</td>
                <td>{{ \Carbon\Carbon::parse($laporan->created_at)->format('d-m-Y') }}</td>
                <td>{{ $laporan->pelapor->name ?? '-' }}</td>
                <td>{{ $laporan->pic->name ?? '-' }}</td>
                <td>{{ $laporan->kategori->nama_kategori ?? '-' }}</td>
                <td>
                    <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $laporan->status)) }}</span>
                </td>
                <td>
                    <a href="{{ route('laporan.show', $laporan->id) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                    <a href="{{ route('laporan.edit', $laporan->id) }}" class="btn btn-sm btn-success">
                        <i class="fas fa-reply"></i> Respon
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada laporan yang sedang diproses.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    {{ $laporans->withQueryString()->links() }}
</div>
@endsection