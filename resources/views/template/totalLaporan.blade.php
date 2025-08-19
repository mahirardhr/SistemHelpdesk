@extends('template.master')

@section('content')
<div class="container-fluid">
    <h2 class="mb-1 font-weight-bold" style="font-size: 25px;">Tabel Laporan</h2>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form method="GET" action="{{ route('totalLaporan') }}">
        <div class="row justify-content-between align-items-center mb-3">
            <div class="col-auto">
                <a href="{{ route('laporan.create') }}" class="btn btn-primary">
                    Tambah Laporan
                </a>
            </div>
            <div class="col-md-8">
                <div class="row gx-2 justify-content-end">
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nomor tiket" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-dark text-center">
                <tr>
                    <th>No. Tiket</th>
                    <th>Tanggal Dibuat</th>
                    <th>Nama Pelapor</th>
                    <th>PIC</th>
                    <th>Kategori Masalah</th>
                    <th>Status</th>
                    <th>Lacak</th>
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
                    @php
                    $statusClass = [
                    'open' => 'badge-warning',
                    'in_progress' => 'badge-info',
                    'closed' => 'badge-success',
                    'expired' => 'badge-danger font-weight-bold',
                    ];
                    @endphp

                    <td>
                        <span class="badge {{ $statusClass[$laporan->status] ?? 'badge-secondary' }}">
                            {{ ucfirst(str_replace('_', ' ', $laporan->status)) }}
                        </span>
                    </td>

                    <td>
                        <span class="badge 
        {{ 
            $laporan->status == 'open' ? 'badge-warning' : 
            ($laporan->status == 'in_progress' ? 'badge-info' : 
            ($laporan->status == 'closed' ? 'badge-success' : 
            ($laporan->status == 'expired' ? 'badge-danger font-weight-bold' : 'badge-secondary'))) 
        }}">
                            {{ ucfirst(str_replace('_', ' ', $laporan->status)) }}
                        </span>
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
                    <td colspan="8" class="text-center">Tidak ada data laporan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-end">
        {{ $laporans->withQueryString()->links('pagination::bootstrap-4') }}
    </div>
</div>

<!-- Modal Timeline -->
<div class="modal fade" id="timelineModal" tabindex="-1" role="dialog" aria-labelledby="timelineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Timeline Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body" id="timelineContent">
                <div class="text-center">Memuat data timeline...</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function loadTimeline(button) {
        const laporanId = button.getAttribute('data-id');
        const modalBody = document.querySelector('#timelineContent');
        modalBody.innerHTML = '<p>Loading...</p>';

        fetch(`/laporan/${laporanId}/timeline`)
            .then(response => response.json())
            .then(data => {
                if (!data || Object.keys(data).length === 0) {
                    modalBody.innerHTML = '<p>Timeline tidak tersedia.</p>';
                    return;
                }

                let html = `
                <ul class="timeline list-unstyled position-relative ps-4">
                    ${data.created_at ? `
                    <li class="mb-4 position-relative">
                        <div class="box">
                            <div class="fw-bold">📄 Laporan Dibuat</div>
                            <small class="text-muted">${new Date(data.created_at).toLocaleString('id-ID')}</small>
                        </div>
                    </li>` : ''}

                    ${data.tanggal_mulai ? `
                    <li class="mb-4 position-relative">
                        <div class="box border-start border-4 border-primary">
                            <div class="fw-bold">🚀 Mulai Dikerjakan</div>
                            <small class="text-muted">${new Date(data.tanggal_mulai).toLocaleString('id-ID')}</small>
                            ${data.nama_pic ? `<div class="text-secondary mt-1">👤 PIC: ${data.nama_pic}</div>` : ''}
                        </div>
                    </li>` : ''}

                    ${data.tanggal_selesai ? `
                    <li class="mb-4 position-relative">
                        <div class="box border-start border-4 border-success">
                            <div class="fw-bold">✅ Selesai</div>
                            <small class="text-muted">${new Date(data.tanggal_selesai).toLocaleString('id-ID')}</small>
                            ${data.catatan_selesai ? `<div class="mt-1 text-muted fst-italic">📝 ${data.catatan_selesai}</div>` : ''}
                        </div>
                    </li>` : ''}
                </ul>`;

                modalBody.innerHTML = html;
            })
            .catch(() => {
                modalBody.innerHTML = '<p>Error saat memuat timeline.</p>';
            });
    }
</script>

<style>
    .timeline::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0.75rem;
        width: 2px;
        height: 100%;
        background-color: #dee2e6;
    }

    .timeline li::before {
        content: '';
        position: absolute;
        left: -0.1rem;
        top: 0.5rem;
        width: 0.75rem;
        height: 0.75rem;
        background-color: #0d6efd;
        border-radius: 50%;
        z-index: 1;
    }

    .timeline li .box {
        background-color: #f8f9fa;
        padding: 1rem;
        border-left: 4px solid #dee2e6;
        border-radius: 0.5rem;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .timeline li:hover .box {
        background-color: #e9f3ff;
    }
</style>

@endpush