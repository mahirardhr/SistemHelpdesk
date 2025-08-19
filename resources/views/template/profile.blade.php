@extends('template.master')

@section('content')
<div class="max-w-5xl mx-auto bg-white rounded-xl shadow px-8 py-6">

    {{-- Judul --}}
    <h2 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-3">Profil Pengguna</h2>

    {{-- Profil Utama --}}
    <div class="flex flex-col md:flex-row gap-6">
        {{-- Avatar --}}
        <div class="md:w-1/3 flex justify-center md:justify-start">
            <img
                src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=111827&color=fff&size=150"
                alt="Avatar"
                class="w-36 h-36 rounded-lg shadow-md border" />
        </div>

        {{-- Biodata --}}
        <div class="md:w-2/3 grid grid-cols-2 gap-y-4 text-gray-700 text-sm">
            <div class="font-semibold">Nama</div>
            <div>: {{ $user->name }}</div>
            <div class="font-semibold">No SAP</div>
            <div>: {{ $user->no_sap ?? '-' }}</div>
            <div class="font-semibold">Departemen</div>
            <div>: {{ $user->departemen->nama_departemen ?? '-' }}</div>
            <div class="font-semibold">No HP</div>
            <div>: {{ $user->no_hp ?? '-' }}</div>
            <div class="font-semibold">Email</div>
            <div>: {{ $user->email }}</div>
        </div>
    </div>

    {{-- Box Performa --}}
    @if (in_array($user->role, ['asisten', 'krani']))
    <div class="mt-8 p-6 bg-gray-100 rounded-lg shadow-inner border border-gray-200">
        <div class="flex justify-between items-center mb-3">
            <h3 class="text-xl font-semibold text-gray-800">Kinerja</h3>

            {{-- Form Export PDF --}}
            <form action="{{ route('laporan.export.sla') }}" method="GET" class="flex items-center gap-2">
                <label for="start" class="text-sm">Dari:</label>
                <input type="date" name="start" required class="border px-2 py-1 rounded text-sm">
                <label for="end" class="text-sm">Sampai:</label>
                <input type="date" name="end" required class="border px-2 py-1 rounded text-sm">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm transition">
                    Download PDF
                </button>
            </form>
        </div>

        {{-- Statistik Box --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
            <div class="bg-white p-4 shadow rounded-lg">
                <h4 class="text-xl font-bold text-blue-600">{{ $totalLaporan }}</h4>
                <p class="text-sm text-gray-600">Total Laporan</p>
            </div>
            <div class="bg-white p-4 shadow rounded-lg">
                <h4 class="text-xl font-bold text-green-600">{{ $laporanSelesai }}</h4>
                <p class="text-sm text-gray-600">Laporan Selesai</p>
            </div>
            <div class="bg-white p-4 shadow rounded-lg">
                <h4 class="text-xl font-bold text-yellow-600">{{ $totalAntrian }}</h4>
                <p class="text-sm text-gray-600">Dalam Antrian</p>
            </div>
            <div class="bg-white p-4 shadow rounded-lg">
                <h4 class="text-xl font-bold text-purple-600">{{ $totalDiproses }}</h4>
                <p class="text-sm text-gray-600">Sedang Diproses</p>
            </div>
        </div>

        {{-- Rating --}}
        <div class="mt-6 text-center">
            <strong>Rata-rata Rating:</strong>
            <span class="text-yellow-500 font-semibold">
                @if($rating > 0)
                    {{ number_format($rating, 1) }} / 5 <br>
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= floor($rating))
                            ★
                        @elseif ($i - $rating <= 0.5)
                            <span class="text-yellow-400">★</span>
                        @else
                            <span class="text-gray-300">★</span>
                        @endif
                    @endfor
                @else
                    <span class="text-gray-500">Belum ada penilaian</span>
                @endif
            </span>
        </div>
    </div>
    @endif

    {{-- Tombol Tutup --}}
    <div class="flex justify-end mt-3">
        <a href="{{ url()->previous() }}"
           class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded shadow transition duration-150">
            Tutup
        </a>
    </div>

</div>
@endsection
