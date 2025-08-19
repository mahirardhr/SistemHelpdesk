@extends('template.master')

@section('content')
<div class="container py-4">
    <h4 class="mb-4 fw-bold">
        <i class="fas fa-info-circle"></i> Aturan Penentuan Prioritas
    </h4>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white">
            Gambar Aturan Prioritas
        </div>
        <div class="card-body text-center">
            <img src="{{ asset('storage/aturan_prioritas.jpg') }}" alt="Aturan Prioritas" class="img-fluid rounded" style="max-height: 600px;">
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white">
            Dokumen PDF Aturan Prioritas
        </div>
        <div class="card-body">
            <iframe src="{{ asset('storage/aturan_prioritas.pdf') }}" width="100%" height="600px" style="border: none;"></iframe>
        </div>
    </div>

    <!-- Tombol Kembali -->
    <div class="mt-4 text-end">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
