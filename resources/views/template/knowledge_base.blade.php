@extends('template.master')

@section('content')
<div class="container">
    <h4 class="mb-4 fw-bold" style="font-size: 25px;">
        <i class="nav-icon fas fa-book mr-2"></i>Solusi Masalah Umum
    </h4>

    <form method="GET" class="mb-2">
        <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan tiket, masalah, atau kategori..." value="{{ request('search') }}">
    </form>

    @if($laporans->count())
    <div class="faq-list">
        @foreach ($laporans as $laporan)
        <div class="faq-item mb-3 p-3 border rounded shadow-sm">
            <div
                class="faq-question fw-bold d-flex justify-content-between align-items-center"
                onclick="toggleAnswer(this)"
                style="cursor: pointer;">
                <span>
                    <i class="fas fa-ticket-alt text-primary"></i>
                    [{{ $laporan->ticket_number }}]
                    <i class="badge bg-info text-dark">
                        {{ $laporan->kategori->nama_kategori }}
                    </i>
                    - {{ Str::limit($laporan->description, 50) }}
                </span>
                <i class="fas fa-chevron-down toggle-icon text-muted"></i>
            </div>
            <div class="faq-answer mt-3" style="display: none;">
                <p class="mb-2"><strong>Masalah:</strong><br>{{ $laporan->description }}</p>
                <p class="mb-2"><strong>Solusi:</strong><br>{{ $laporan->catatan_selesai }}</p>

                @if (!empty($laporan->attachment))
                <button type="button"
                    class="btn btn-dark btn-sm mt-2 file-preview-trigger"
                    data-url="{{ asset('storage/' . $laporan->attachment) }}">
                    <i class="fas fa-paperclip"></i> Lihat Lampiran
                </button>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $laporans->links() }}
    </div>
    @else
    <p class="text-muted">Tidak ada data solusi yang ditemukan.</p>
    @endif
</div>

<!-- Modal Preview Lampiran (Shared by all items) -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview File</h5>
                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">
                    &times;
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" class="img-fluid d-none" />
                <iframe id="previewPdf" class="w-100" style="height: 500px;" hidden></iframe>
            </div>
        </div>
    </div>
</div>

<!-- Script Toggle Jawaban -->
<script>
    function toggleAnswer(element) {
        const answer = element.nextElementSibling;
        const icon = element.querySelector('.toggle-icon');
        if (answer.style.display === 'none' || answer.style.display === '') {
            answer.style.display = 'block';
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        } else {
            answer.style.display = 'none';
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    }
</script>
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