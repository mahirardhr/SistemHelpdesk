<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Laporan;

class PelaporController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id(); // ID user yang sedang login

        // Ambil tanggal dari request
        $startDate = $request->start_date;
        $endDate   = $request->end_date;

        // Format ke datetime lengkap
        $start = $startDate ? $startDate . ' 00:00:00' : now()->startOfMonth()->startOfDay();
        $end   = $endDate   ? $endDate . ' 23:59:59' : now()->endOfMonth()->endOfDay();

        // Filter laporan berdasarkan user dan tanggal
        $baseQuery = Laporan::where('pelapor_id', $userId)
                            ->whereBetween('created_at', [$start, $end]);

        $totalLaporan   = (clone $baseQuery)->count();
        $totalSelesai   = (clone $baseQuery)->where('status', 'closed')->count();
        $totalAntrian   = (clone $baseQuery)->where('status', 'open')->count();
        $totalDiproses  = (clone $baseQuery)->where('status', 'in_progress')->count();

        return view('pelapor.pelapor_dashboard', compact(
            'totalLaporan',
            'totalSelesai',
            'totalAntrian',
            'totalDiproses',
            'startDate',
            'endDate'
        ));
    }
}
