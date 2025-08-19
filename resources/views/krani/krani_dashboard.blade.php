@extends('template.master')

@section('content')
<div class="container-fluid">
    <h2 class="mb-3 font-weight-bold" style="font-size: 25px; ">Beranda Krani</h2>

    <form method="GET" class="form-inline mb-4">
        <label class="mr-2">Dari:</label>
        <input type="date" name="start_date" class="form-control mr-3" value="{{ request('start_date') }}">
        <label class="mr-2">Sampai:</label>
        <input type="date" name="end_date" class="form-control mr-3" value="{{ request('end_date') }}">
        <button type="submit" class="btn btn-primary">Terapkan</button>
    </form>
    @if ($startDate && $endDate)
    <div class="alert alert-info">
        Menampilkan laporan dari <strong>{{ $startDate }}</strong> sampai <strong>{{ $endDate }}</strong>.
    </div>
    @endif

    <div class="row">
        <div class="col-md-3">
            <div class="small-box bg-light">
                <div class="inner text-center">
                    <h3>{{ $totalLaporan }}</h3>
                    <p>Total Laporan</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-light">
                <div class="inner text-center">
                    <h3>{{ $totalSelesai }}</h3>
                    <p>Total Laporan Selesai</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-light">
                <div class="inner text-center">
                    <h3>{{ $totalAntrian }}</h3>
                    <p>Total Dalam Antrian</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-light">
                <div class="inner text-center">
                    <h3>{{ $totalDiproses }}</h3>
                    <p>Total Sedang Diproses</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection