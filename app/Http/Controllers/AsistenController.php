<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\User;

class AsistenController extends Controller
{
    public function index(Request $request)
    {
        // Default: ambil bulan dan tahun sekarang jika tidak ada input tanggal
        $startDate = $request->start_date ?? now()->startOfMonth()->toDateString();
        $endDate   = $request->end_date ?? now()->endOfMonth()->toDateString();

        $start = $startDate . ' 00:00:00';
        $end   = $endDate . ' 23:59:59';

        // Total laporan
        $totalLaporan = Laporan::whereBetween('created_at', [$start, $end])->count();
        $totalSelesai = Laporan::whereBetween('created_at', [$start, $end])->where('status', 'closed')->count();
        $totalAntrian = Laporan::whereBetween('created_at', [$start, $end])->where('status', 'open')->count();
        $totalDiproses = Laporan::whereBetween('created_at', [$start, $end])->where('status', 'in_progress')->count();

        // Grafik laporan per PIC
        $laporanPerPIC = User::withCount(['laporanPIC as laporan_pic_count' => function ($query) use ($start, $end) {
            $query->where('status', 'in_progress')->whereBetween('created_at', [$start, $end]);
        }])->whereHas('laporanPIC', function ($query) use ($start, $end) {
            $query->where('status', 'in_progress')->whereBetween('created_at', [$start, $end]);
        })->get();

        return view('template.menu', compact(
            'totalLaporan',
            'totalSelesai',
            'totalAntrian',
            'totalDiproses',
            'laporanPerPIC',
            'startDate',
            'endDate'
        ));
    }
}
