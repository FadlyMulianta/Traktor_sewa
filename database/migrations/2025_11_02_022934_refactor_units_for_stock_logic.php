<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('units', function (Blueprint $table) {
            // 1. Hapus kolom 'status'
            if (Schema::hasColumn('units', 'status')) {
                $table->dropColumn('status');
            }

            // 2. Tambahkan kolom 'stok' (setelah harga)
            // Pastikan kode_unit sudah ada dan unik (sesuai migrasi lama)
            $table->integer('stok')->default(0)->after('harga_sewa_per_hari');
        });
    }

    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            // Kebalikan dari 'up'
            $table->enum('status', ['tersedia', 'dipinjam'])->default('tersedia');
            $table->dropColumn('stok');
        });
    }
};
