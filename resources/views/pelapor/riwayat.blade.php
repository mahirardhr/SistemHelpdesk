@extends('template.master')

@section('content')
<div class="container-fluid">

    {{-- Header dan Pencarian --}}
    <div class="row align-items-center mb-3">
        <div class="col-md-8">
            <h2 class="font-weight-bold" style="font-size: xx-large;">Daftar Riwayat Laporan</h2>
        </div>
        <div class="col-md-4 d-flex justify-content-end">
            <form method="GET" action="{{ route('pelapor.riwayat') }}" class="w-100">
                <div class="input-group">
                    <input
                        type="text"
                        name="search"
                        id="search"
                        class="form-control"
                        placeholder="Cari ticket"
                        value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-dark">
                            <i class="fas fa-search mr-1"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
    <div class="alert alert-success mb-2">
        {{ session('success') }}
    </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr class="text-center">
                    <th>Ticket No.</th>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Ditangani</th>
                    <th>Tgl. Selesai</th>
                    <th>Aksi Pelapor</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporans as $laporan)
                <tr class="text-center align-middle">
                    <td>{{ $laporan->ticket_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($laporan->created_at)->format('d/m/y') }}</td>
                    <td>{{ $laporan->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $laporan->pic->name ?? '-' }}</td>
                    <td>{{ $laporan->tanggal_selesai ? \Carbon\Carbon::parse($laporan->tanggal_selesai)->format('d/m/y') : '-' }}</td>
                    <td>
                        @if($laporan->status === 'closed' && !$laporan->user_confirmed)
                        <a href="{{ route('laporan.ratingForm', $laporan->id) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-reply"></i> Respon
                        </a>
                        <!-- <a href="{{ route('laporan.ratingForm', $laporan->id) }}" class="btn btn-sm btn-primary">Respon</a> -->
                        @elseif($laporan->user_confirmed)
                        <span class="badge bg-success px-3 py-2">Selesai</span>
                        @else
                        <span class="badge bg-warning text-dark px-3 py-2">Menunggu</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('laporan.show', $laporan->id) }}" class="btn btn-sm btn-secondary">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Tidak ada data laporan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-2">
        {{ $laporans->withQueryString()->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection