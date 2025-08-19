@extends('template.master')

@section('content')
<div class="container-fluid py-4">
    <h4 class="mb-4 fw-bold">
        <i class="fas fa-file-alt"></i> Detail Laporan Masuk
    </h4>

    <form action="{{ route('laporan.update', $laporan->id) }}" method="POST">
        @csrf
        @method('PUT')

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
                                <label><strong>Nama</strong></label>
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
                                <button type="button" class="btn btn-sm btn-outline-primary file-preview-trigger"
                                    data-url="{{ asset('storage/' . $laporan->attachment) }}">
                                    <i class="fas fa-eye"></i> Lihat Lampiran
                                </button>
                                @else
                                <span class="text-muted">Tidak ada file</span>
                                @endif
                            </div>
                        </div>

                        {{-- Editable fields --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label><strong>Ditangani oleh (PIC)</strong></label>
                                <select name="pic_id" class="form-control">
                                    @foreach ($listPIC as $pic)
                                    <option value="{{ $pic->id }}" {{ $laporan->pic_id == $pic->id ? 'selected' : '' }}>
                                        {{ $pic->name }} ({{ $pic->role }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label><strong>Prioritas</strong></label>
                                <select name="prioritas" class="form-control">
                                    <option value="rendah" {{ $laporan->prioritas == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                    <option value="sedang" {{ $laporan->prioritas == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                    <option value="tinggi" {{ $laporan->prioritas == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                </select>
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
                                <input type="date" name="sla_close" class="form-control" value="{{ $laporan->sla_close }}">
                            </div>
                            <div class="col-md-6">
                                <label><strong>Status</strong></label>
                                <!-- Pilihan Status -->
                                <select name="status" id="statusDropdown" class="form-control" onchange="handleStatusChange()">
                                    <option value="open" {{ $laporan->status == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="in_progress" {{ $laporan->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="closed" {{ $laporan->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                            <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Modal Popup untuk Catatan -->
<div class="modal fade" id="catatanModal" tabindex="-1" role="dialog" aria-labelledby="catatanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ route('laporan.updateCatatan', $laporan->id) }}">
            <input type="hidden" name="status" value="closed"> {{-- Tambahkan ini --}}
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">Catatan Penyelesaian</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea name="catatan_selesai" class="form-control" rows="4" required></textarea>
                </div>
                <div class="form-group mt-2">
                    <label>
                        <input type="checkbox" name="tampilkan_di_kb" value="1"
                            {{ $laporan->tampilkan_di_kb ? 'checked' : '' }}>
                        Tampilkan solusi ini di Knowledge Base
                    </label>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // modal catatan
        const statusDropdown = document.querySelector('select[name="status"]');
        if (statusDropdown) {
            statusDropdown.addEventListener('change', function() {
                if (this.value === 'closed') {
                    $('#catatanModal').modal('show');
                }
            });
        }

        // modal preview lampiran
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
            <div class="modal-body bg-light text-center">
                <img id="previewImage" class="img-fluid rounded shadow-sm d-none" style="max-height: 700px;" />
                <iframe id="previewPdf" class="w-100 rounded shadow-sm" style="height: 600px;" hidden></iframe>
            </div>
        </div>
    </div>
</div>


@endsection