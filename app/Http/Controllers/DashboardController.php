<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $start = $startDate ? $startDate . ' 00:00:00' : null;
        $end   = $endDate   ? $endDate . ' 23:59:59' : null;

        $baseQuery = Laporan::query();
        if ($start && $end) {
            $baseQuery->whereBetween('created_at', [$start, $end]);
        }

        $totalLaporan  = (clone $baseQuery)->count();
        $totalSelesai  = (clone $baseQuery)->where('status', 'closed')->count();
        $totalAntrian  = (clone $baseQuery)->where('status', 'open')->count();
        $totalDiproses = (clone $baseQuery)->where('status', 'in_progress')->count();

        $laporanPerPIC = User::withCount([
            'laporanPIC as laporan_pic_count' => function ($query) use ($start, $end) {
                $query->where('status', 'in_progress');
                if ($start && $end) {
                    $query->whereBetween('created_at', [$start, $end]);
                }
            }
        ])
            ->whereHas('laporanPIC', function ($query) use ($start, $end) {
                $query->where('status', 'in_progress');
                if ($start && $end) {
                    $query->whereBetween('created_at', [$start, $end]);
                }
            })
            ->get();

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
