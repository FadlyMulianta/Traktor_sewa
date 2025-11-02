<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $fillable = ['kode_unit', 'nama_unit', 'harga_sewa_per_hari', 'stok',];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_unit');
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function getStokTersediaAttribute()
    {
        // Hitung berapa unit ini yang sedang 'dipinjam'
        $dipinjam = Peminjaman::where('unit_id', $this->id)
            ->where('status', 'dipinjam')
            ->count();

        // Stok tersedia = Stok total - yang dipinjam
        $stokTersedia = $this->stok - $dipinjam;

        // Pastikan tidak negatif
        return $stokTersedia > 0 ? $stokTersedia : 0;
    }

}
