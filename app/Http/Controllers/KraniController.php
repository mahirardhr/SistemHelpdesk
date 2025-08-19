<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\User;
use Carbon\Carbon;

class KraniController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id(); // ID krani yang login

         // Default: ambil bulan dan tahun sekarang jika tidak ada input tanggal
        $startDate = $request->start_date ?? now()->startOfMonth()->toDateString();
        $endDate   = $request->end_date ?? now()->endOfMonth()->toDateString();

        $start = $startDate . ' 00:00:00';
        $end   = $endDate . ' 23:59:59';

        // Hitung total laporan sesuai filter tanggal
        $totalLaporan = Laporan::where('pic_id', $userId)
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $totalSelesai = Laporan::where('pic_id', $userId)
            ->where('status', 'closed')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $totalAntrian = Laporan::where('pic_id', $userId)
            ->where('status', 'open')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $totalDiproses = Laporan::where('pic_id', $userId)
            ->where('status', 'in_progress')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        // Laporan per PIC (dalam hal ini hanya user yang sedang login)
        $laporanPerPIC = User::withCount(['laporanPIC as laporan_pic_count' => function ($query) use ($userId, $start, $end) {
            $query->where('status', 'in_progress')
                  ->where('pic_id', $userId)
                  ->whereBetween('created_at', [$start, $end]);
        }])
        ->where('id', $userId)
        ->get();

        return view('krani.krani_dashboard', compact(
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
