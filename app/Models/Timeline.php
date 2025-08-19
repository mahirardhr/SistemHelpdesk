<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    use HasFactory;

    protected $fillable = ['laporan_id', 'status', 'keterangan'];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }
}

