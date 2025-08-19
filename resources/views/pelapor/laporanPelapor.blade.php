@extends('template.master')

@section('content')
<div class="container-fluid">

    <div class="row align-items-center mb-3">
        <div class="col-md-8">
            <h2 class="font-weight-bold mb-0" style="font-size: xx-large;">Daftar Laporan</h2>
        </div>
        <div class="col-md-4 d-flex justify-content-end">
            <form method="GET" action="{{ route('laporan.pelapor') }}" class="w-100">
                <div class="input-group">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari berdasarkan nomor tiket" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search mr-1"></i> Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-dark text-center">
                <tr>
                    <th>Ticket No.</th>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>PIC</th>
                    <th>Status</th>
                    <th>Lacak</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporans as $laporan)
                <tr class="text-center align-middle">
                    <td>{{ $laporan->ticket_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($laporan->created_at)->format('d/m/y') }}</td>
                    <td>{{ $laporan->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $laporan->pic->name ?? '-' }}</td>
                    <td>
                        <span class="badge 
                            {{ $laporan->status == 'open' ? 'badge-warning' : 
                               ($laporan->status == 'in_progress' ? 'badge-info' : 'badge-success') }}">
                            {{ ucfirst(str_replace('_', ' ', $laporan->status)) }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-dark"
                            data-bs-toggle="modal"
                            data-bs-target="#timelineModal"
                            data-id="{{ $laporan->id }}"
                            onclick="loadTimeline(this)">
                            Lacak
                        </button>
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

<!-- Modal Timeline -->
<div class="modal fade" id="timelineModal" tabindex="-1" role="dialog" aria-labelledby="timelineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="timelineModalLabel">Timeline Laporan</h5>
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
/* Timeline vertical line */
.timeline::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0.75rem;
    width: 2px;
    height: 100%;
    background-color: #dee2e6;
}

/* Timeline dot */
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

/* Timeline card box */
.timeline li .box {
    background-color: #f8f9fa;
    padding: 1rem;
    border-left: 4px solid #dee2e6;
    border-radius: 0.5rem;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.timeline li:hover .box {
    background-color: #e9f3ff;
}
</style>
@endpush


