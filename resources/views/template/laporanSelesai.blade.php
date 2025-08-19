@extends('template.master')

@section('content')
<div class="container-fluid">

    <!-- Form Pencarian -->
    <form method="GET" action="{{ route('laporanSelesai') }}">
        <div class="row mb-3 align-items-center">
            <div class="col-md-6">
                <h1 class="mb-0 font-weight-bold" style="font-size: 25px;">Laporan Selesai</h1>
            </div>

            <div class="col-md-6">
                <div class="d-flex gap-2">
                    <!-- Dropdown PIC -->
                    <select name="pic_id" class="form-control w-50">
                        <option value="">-- Semua PIC --</option>
                        @foreach($daftarPic as $pic)
                        <option value="{{ $pic->id }}" {{ $selectedPicId == $pic->id ? 'selected' : '' }}>
                            {{ $pic->name }} ({{ $pic->role }})
                        </option>
                        @endforeach
                    </select>

                    <!-- Input Pencarian Tiket -->
                    <div class="input-group w-50">
                        <input type="text" name="search" class="form-control" placeholder="Cari nomor tiket" value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <!-- Tabel Laporan Selesai -->
    <table class="table table-bordered mt-4">
        <thead class="thead-dark">
            <tr class="text-center">
                <th>No. Tiket</th>
                <th>Tanggal Dibuat</th>
                <th>Batas SLA</th>
                <th>Tanggal Selesai</th>
                <th>Nama Pelapor</th>
                <th>PIC</th>
                <th>Kategori Masalah</th>
                <th>Status</th>
                <th>SLA</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporanSelesai as $laporan)
            <tr class="text-center">
                <td>{{ $laporan->ticket_number }}</td>
                <td>{{ \Carbon\Carbon::parse($laporan->created_at)->format('d/m/y') }}</td>
                <td>
                    {{ $laporan->sla_close ? \Carbon\Carbon::parse($laporan->sla_close)->format('d/m/y') : '-' }}
                </td>
                <td>{{ $laporan->tanggal_selesai ? \Carbon\Carbon::parse($laporan->tanggal_selesai)->format('d/m/y') : '-' }}</td>
                <td>{{ $laporan->pelapor->name ?? '-' }}</td>
                <td>{{ $laporan->pic->name ?? '-' }}</td>
                <td>{{ $laporan->kategori->nama_kategori ?? '-' }}</td>
                <td><span class="badge badge-success">{{ ucfirst($laporan->status) }}</span></td>
                <td>
                    <span class="badge 
        @if($laporan->status_sla === 'Tepat Waktu') bg-success text-white
        @elseif($laporan->status_sla === 'Terlambat') bg-danger text-white
        @elseif($laporan->status_sla === 'Melewati Batas Waktu') bg-warning text-dark
        @else bg-secondary
        @endif">
                        {{ $laporan->status_sla }}
                    </span>
                </td>

                <td><a href="{{ route('laporan.show', $laporan->id) }}" class="btn btn-sm btn-info">Detail</a></td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada laporan selesai ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-end">
        {{ $laporanSelesai->withQueryString()->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection