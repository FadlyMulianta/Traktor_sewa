<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Unit;
use App\Models\Peminjaman;
use Carbon\Carbon; // Penting untuk manajemen tanggal

class PeminjamanController extends Controller
{
    /**
     * Proses peminjaman unit (Poin 10 & 11)
     */
    public function store(Request $request)
    {
        $request->validate(['unit_id' => 'required|exists:units,id']);

        $user = Auth::user();
        $unit = Unit::findOrFail($request->unit_id);

        // Validasi 1: Cek apakah unit masih tersedia
        if ($unit->status != 'tersedia') {
            return redirect()->route('units.index')->with('error', 'Unit ini sudah tidak tersedia.');
        }

        // Validasi 2: Cek Poin 10 (Maksimal 2 unit)
        $jumlahPinjamanAktif = Peminjaman::where('user_id', $user->id)
            ->where('status', 'dipinjam')
            ->count();

        if ($jumlahPinjamanAktif >= 2) {
            return redirect()->route('units.index')->with('error', 'Anda sudah mencapai batas maksimal 2 unit peminjaman.');
        }

        // --- Proses Peminjaman ---

        // 1. Buat data peminjaman
        Peminjaman::create([
            'user_id' => $user->id,
            'unit_id' => $unit->id,
            'tanggal_pinjam' => Carbon::now(),
            'tanggal_kembali' => Carbon::now()->addDays(5), // Poin 11 (Maks 5 hari)
            'status' => 'dipinjam',
        ]);

        // 2. Update status unit menjadi 'dipinjam'
        $unit->status = 'dipinjam';
        $unit->save();

        return redirect()->route('units.index')->with('success', 'Unit berhasil dipinjam!');
    }

    /**
     * Menampilkan riwayat peminjaman milik user (Poin 14)
     */
    public function myPeminjaman()
    {
        $userId = Auth::id();
        $peminjamans = Peminjaman::with('unit') // Load relasi unit
            ->where('user_id', $userId)
            ->orderBy('tanggal_pinjam', 'desc')
            ->paginate(10);

        return view('peminjaman.saya', compact('peminjamans'));
    }
}
