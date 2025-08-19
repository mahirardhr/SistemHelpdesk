<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Laporan;
use Carbon\Carbon;

class AutoCloseLaporan extends Command
{
    protected $signature = 'laporan:auto-close';
    protected $description = 'Menutup laporan yang melebihi waktu SLA Close';

    public function handle()
    {
        $now = Carbon::now();

        $laporanTerlambat = Laporan::where('status', '!=', 'closed')
            ->where('sla_close', '<', $now)
            ->get();

        foreach ($laporanTerlambat as $laporan) {
            $laporan->status = 'closed';
            $laporan->save();

            $this->info("Laporan ID {$laporan->id} di-close otomatis.");
        }

        return 0;
    }
}
