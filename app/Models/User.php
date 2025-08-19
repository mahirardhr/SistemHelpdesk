<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'no_sap',
        'no_hp',
        'departemen_id',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn(string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    // Gunakan satu relasi saja agar tidak bingung
    public function laporan()
    {
        return $this->hasMany(\App\Models\Laporan::class, 'pelapor_id');
    }


    public function laporanPIC()
    {
        return $this->hasMany(\App\Models\Laporan::class, 'pic_id');
    }
    // Di model User.php
    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }
}
