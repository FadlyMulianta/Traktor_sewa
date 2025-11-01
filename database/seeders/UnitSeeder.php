<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $unit1 = Unit::create([
            'kode_unit' => 'LP001',
            'nama_unit' => 'mitsubishi traktor',
            'harga_sewa_per_hari' => 500000,
            'status' => 'tersedia'
        ]);
        $unit1->categories()->attach(1); // Laptop

        $unit2 = Unit::create([
            'kode_unit' => 'PR001',
            'nama_unit' => 'honda traktor 120hp',
            'harga_sewa_per_hari' => 750000,
            'status' => 'tersedia'
        ]);
        $unit2->categories()->attach(2); // Proyektor

        $unit3 = Unit::create([
            'kode_unit' => 'KB001',
            'nama_unit' => 'yamaha traktor mini 50hp',
            'harga_sewa_per_hari' => 100000,
            'status' => 'tersedia'
        ]);
        $unit3->categories()->attach(3); // Kabel
    }
}
