<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;
use App\Models\User;  // Jangan lupa import ini

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporans';

    protected $fillable = [
        'ticket_number',
        // 'email',
        // 'phone',
        'kategori_id',
        // 'department',
        'description',
        'status',
        'pelapor_id',
        'attachment',
        'pic_id',
        'sla_close',
        'prioritas',
        'user_confirmed',
        'catatan_selesai',
        'tampilkan_di_kb',
        'tanggal_mulai',
        'tanggal_selesai',
        'rating'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'processed_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public $timestamps = true;

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function pelapor()
    {
        return $this->belongsTo(User::class, 'pelapor_id');
    }
    // Laporan.php
    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }
    public function timeline()
    {
        return $this->hasMany(Timeline::class);
    }
    public function departemen()
{
    return $this->belongsTo(Departemen::class, 'department_id');
}

}
