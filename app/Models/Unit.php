<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $fillable = ['kode_unit', 'nama_unit', 'status'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_unit');
    }
}
