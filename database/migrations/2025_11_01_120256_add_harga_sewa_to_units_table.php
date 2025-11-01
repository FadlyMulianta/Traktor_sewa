<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('units', function (Blueprint $table) {
            // Tambahkan kolom ini setelah 'nama_unit'
            $table->integer('harga_sewa_per_hari')->default(0)->after('nama_unit');
        });
    }

    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            $table->dropColumn('harga_sewa_per_hari');
        });
    }
};
