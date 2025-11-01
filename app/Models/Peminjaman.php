<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // Tentukan tabel jika nama model & tabel berbeda (Peminjaman -> peminjamans)
    protected $table = 'peminjamans';

    // Kolom yang boleh diisi
    protected $fillable = [
        'user_id',
        'unit_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_pengembalian_sebenarnya',
        'denda',
        'status',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Unit
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
