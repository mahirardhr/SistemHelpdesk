@extends('template.master')

@section('content')
<div class="container-fluid py-4">
    <h2 class="mb-4 font-weight-bold" style="font-size: 25px;">
        <i class="fas fa-file-alt mr-2"></i> Detail Laporan
    </h2>


    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow rounded-3">
                <div class="card-body p-4">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label><strong>No. Tiket</strong></label>
                            <input type="text" class="form-control" value="{{ $laporan->ticket_number }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label><strong>Nama Pelapor</strong></label>
                            <input type="text" class="form-control" value="{{ $laporan->pelapor->name ?? '-' }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label><strong>Kategori</strong></label>
                            <input type="text" class="form-control" value="{{ $laporan->kategori->nama_kategori ?? '-' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label><strong>No. HP</strong></label>
                            <input type="text" class="form-control" value="{{ $laporan->pelapor->no_hp }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label><strong>Email</strong></label>
                            <input type="text" class="form-control" value="{{ $laporan->pelapor->email }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label><strong>Departemen</strong></label>
                            <input type="text" class="form-control" value="{{ $laporan->pelapor->departemen->nama_departemen ?? '-' }}" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label><strong>Deskripsi</strong></label>
                        <textarea class="form-control" rows="4" readonly>{{ $laporan->description }}</textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label><strong>Tanggal Laporan</strong></label>
                            <input type="text" class="form-control" value="{{ $laporan->created_at->format('d/m/Y') }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label><strong>Lampiran</strong></label><br>
                            @if ($laporan->attachment)
                            @php
                            $ext = pathinfo($laporan->attachment, PATHINFO_EXTENSION);
                            $previewable = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'pdf']);
                            @endphp

                            @if ($previewable)
                            <button type="button" class="btn btn-outline-primary btn-sm file-preview-trigger"
                                data-url="{{ asset('storage/' . $laporan->attachment) }}">
                                <i class="fas fa-eye"></i> Lihat Lampiran
                            </button>
                            @else
                            <a href="{{ asset('storage/' . $laporan->attachment) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-download"></i> Unduh Lampiran
                            </a>
                            @endif
                            @else
                            <span class="text-muted">Tidak ada lampiran</span>
                            @endif
                        </div>

                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label><strong>PIC Penanggung Jawab</strong></label>
                            <input type="text" class="form-control" value="{{ $laporan->pic->name ?? '-' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label><strong>Prioritas</strong></label>
                            <input type="text" class="form-control" value="{{ ucfirst($laporan->prioritas) ?? '-' }}" readonly>
                            <small class="form-text text-muted mt-1">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#prioritasModal">
                                    Lihat aturan penentuan prioritas
                                </a>
                            </small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label><strong>SLA Close</strong></label>
                            <input type="text" class="form-control"
                                value="{{ $laporan->sla_close ? \Carbon\Carbon::parse($laporan->sla_close)->format('d/m/Y') : '-' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label><strong>Status</strong></label>
                            <input type="text" class="form-control" value="{{ ucfirst(str_replace('_', ' ', $laporan->status)) }}" readonly>
                        </div>
                    </div>

                    <!-- Tambahkan bagian ini setelah semua informasi laporan -->
                    @if($laporan->status == 'closed' && $laporan->catatan_selesai)
                    <div class="card border-success mt-4">
                        <div class="card-header bg-success text-white">
                            <strong>Catatan Penyelesaian</strong>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $laporan->catatan_selesai }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Aturan Penentuan Prioritas -->
<div class="modal fade" id="prioritasModal" tabindex="-1" aria-labelledby="prioritasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: fit-content;">
        <div class="modal-content shadow rounded-3 border-0">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold" id="prioritasModalLabel">
                    <i class="fas fa-info-circle me-2"></i>Aturan Penentuan Prioritas
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body bg-light text-center p-0">
                <img src="{{ asset('images/aturan_prioritas.jpg') }}"
                    alt="Aturan Prioritas"
                    class="rounded"
                    style="display: block; max-width: 100%; height: auto;">
            </div>
        </div>
    </div>
</div>


<!-- Modal Preview Lampiran -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content shadow rounded-3 border-0">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold" id="previewModalLabel">
                    <i class="fas fa-eye me-2"></i>Preview Lampiran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body bg-light d-flex justify-content-center align-items-center" style="min-height: 300px;">
                <img id="previewImage" class="rounded shadow-sm d-none" style="max-width: 100%; max-height: 80vh; object-fit: contain;" />
                <iframe id="previewPdf" class="w-100 rounded shadow-sm" style="height: 80vh;" hidden></iframe>
            </div>

        </div>
    </div>
</div>


@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.file-preview-trigger').forEach(button => {
            button.addEventListener('click', function() {
                const url = this.getAttribute('data-url');
                const isPdf = url.toLowerCase().endsWith(".pdf");

                const img = document.getElementById('previewImage');
                const pdf = document.getElementById('previewPdf');

                if (isPdf) {
                    img.classList.add('d-none');
                    pdf.hidden = false;
                    pdf.src = url;
                } else {
                    pdf.hidden = true;
                    img.src = url;
                    img.classList.remove('d-none');
                }

                const modal = new bootstrap.Modal(document.getElementById('previewModal'));
                modal.show();
            });
        });
    });
</script>
@endsection