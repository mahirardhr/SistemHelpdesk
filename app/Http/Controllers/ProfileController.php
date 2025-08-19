<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Laporan;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        $totalLaporan = $laporanSelesai = $totalAntrian = $totalDiproses = $rating = null;

        if (in_array($user->role, ['asisten', 'krani'])) {
            $totalLaporan = Laporan::where('pic_id', $user->id)->count();
            $laporanSelesai = Laporan::where('pic_id', $user->id)->where('status', 'closed')->count();
            $totalAntrian = Laporan::where('pic_id', $user->id)->where('status', 'open')->count();
            $totalDiproses = Laporan::where('pic_id', $user->id)->where('status', 'in_progress')->count();
            $rating = round(Laporan::where('pic_id', $user->id)->whereNotNull('rating')->avg('rating'), 1) ?? 0;
        }

        return view('template.profile', compact(
            'user',
            'totalLaporan',
            'laporanSelesai',
            'totalAntrian',
            'totalDiproses',
            'rating'
        ));
    }
}
