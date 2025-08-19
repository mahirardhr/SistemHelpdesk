@extends('template.master')

@section('content')
<div class="container mt-5">
    <h4 class="mb-4">Beri Penilaian untuk Penanganan Laporan</h4>

    <form action="{{ route('laporan.submitRating', $laporan->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="rating">Rating (1 = Buruk, 5 = Sangat Baik)</label>
            <select name="rating" id="rating" class="form-control" required>
                <option value="">-- Pilih Rating --</option>
                @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}">{{ $i }} ⭐</option>
                @endfor
            </select>
        </div>

        <button type="submit" class="btn btn-success mt-3">Kirim Rating</button>
    </form>
</div>
@endsection
