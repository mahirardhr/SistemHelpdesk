@extends('template.master')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0 font-weight-bold">Form Tambah Laporan</h5>
        </div>

        <div class="card-body">
            {{-- Pesan Berhasil --}}
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            {{-- Pesan Validasi --}}
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nama Pelapor --}}
                <div class="form-group">
                    <label for="reporter_name" class="font-weight-bold">Nama Pelapor</label>
                    <input type="text" name="reporter_name" class="form-control"
                        value="{{ Auth::user()->name }}" readonly>
                </div>


                {{-- Email & Telepon --}}
                <!-- <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email" class="font-weight-bold">Email Pelapor</label>
                        <input type="email" name="email" class="form-control" placeholder="contoh@email.com" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone" class="font-weight-bold">Nomor Telepon</label>
                        <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxxxx" required>
                    </div>
                </div> -->

                {{-- Kategori & Departemen --}}
                <div class="form-row">
                    <div class="form-group col-12">
                        <label for="kategori_id" class="font-weight-bold">Kategori Masalah</label>
                        <select name="kategori_id" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- <div class="form-group col-md-6">
                        <label for="department" class="font-weight-bold">Departemen Pelapor</label>
                        <select name="department" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Departemen --</option>
                            <option value="HRD">HRD</option>
                            <option value="Keuangan">Keuangan</option>
                            <option value="Produksi">Produksi</option>
                            <option value="Logistik">Logistik</option>
                            <option value="TI">TI</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div> -->
                </div>

                {{-- Deskripsi Masalah --}}
                <div class="form-group">
                    <label for="description" class="font-weight-bold">Deskripsi Masalah</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Jelaskan masalah secara rinci..." required></textarea>
                </div>

                {{-- File Pendukung --}}
                <div class="mb-3">
                    <label for="attachment" class="form-label fw-bold">Lampiran (PDF / Gambar)</label>
                    <input type="file" name="attachment" class="form-control" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" required>
                    <small class="form-text text-muted">Maksimal 20MB.</small>
                </div>


                {{-- Tombol Aksi --}}
                <div class="form-group d-flex justify-content-end">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary mr-2">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
            <!-- Modal Preview -->
            <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Preview File</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-center">
                            <img id="previewImage" class="img-fluid d-none" />
                            <iframe id="previewPdf" class="w-100" style="height: 500px;" hidden></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const fileInput = document.querySelector('input[name="attachments[]"]');
        fileInput.addEventListener('change', function() {
            Array.from(fileInput.files).forEach(file => {
                if (file.size > 5 * 1024 * 1024) {
                    alert(`File "${file.name}" melebihi ukuran 5MB.`);
                    fileInput.value = ""; // clear input
                }
            });
        });

        document.querySelectorAll('.file-preview-trigger').forEach(button => {
            button.addEventListener('click', function() {
                const url = this.getAttribute('data-url');
                const isPdf = url.toLowerCase().endsWith(".pdf");

                if (isPdf) {
                    document.getElementById('previewImage').classList.add('d-none');
                    document.getElementById('previewPdf').hidden = false;
                    document.getElementById('previewPdf').src = url;
                } else {
                    document.getElementById('previewPdf').hidden = true;
                    const img = document.getElementById('previewImage');
                    img.src = url;
                    img.classList.remove('d-none');
                }

                $('#previewModal').modal('show');
            });
        });
    });
</script>
@endsection
@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const fileInput = document.querySelector('input[name="attachments[]"]');
        const MAX_SIZE_MB = 20; // batas maksimal 20 MB
        const MAX_SIZE = MAX_SIZE_MB * 1024 * 1024;

        fileInput.addEventListener('change', function() {
            const files = fileInput.files;
            let oversizedFiles = [];

            for (let i = 0; i < files.length; i++) {
                if (files[i].size > MAX_SIZE) {
                    oversizedFiles.push(`${files[i].name} (${(files[i].size / 1024 / 1024).toFixed(2)} MB)`);
                }
            }

            if (oversizedFiles.length > 0) {
                alert("File berikut melebihi batas maksimum " + MAX_SIZE_MB + " MB:\n\n" + oversizedFiles.join("\n"));
                fileInput.value = ""; // hapus semua file yang sudah dipilih
            }
        });
    });
</script>
@endsection