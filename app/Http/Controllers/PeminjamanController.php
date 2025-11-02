<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Unit;
use App\Models\Peminjaman;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['unit_id' => 'required|exists:units,id']);

        $user = Auth::user();
        $unit = Unit::findOrFail($request->unit_id);

        // VALIDASI BARU: Cek stok menggunakan accessor
        if ($unit->stok_tersedia <= 0) {
            return redirect()->route('units.index')->with('error', 'Stok unit ini sudah habis.');
        }

        // Validasi Poin 10 (Maks 2 unit per user) - INI TETAP SAMA
        $jumlahPinjamanAktif = Peminjaman::where('user_id', $user->id)
            ->where('status', 'dipinjam')
            ->count();

        if ($jumlahPinjamanAktif >= 2) {
            return redirect()->route('units.index')->with('error', 'Anda sudah mencapai batas maksimal 2 unit peminjaman.');
        }

        // Proses Peminjaman (Tidak berubah)
        Peminjaman::create([
            'user_id' => $user->id,
            'unit_id' => $unit->id,
            'tanggal_pinjam' => Carbon::now(),
            'tanggal_kembali' => Carbon::now()->addDays(5),
            'status' => 'dipinjam',
        ]);

        return redirect()->route('units.index')->with('success', 'Unit berhasil dipinjam!');
    }

    public function myPeminjaman()
    {
        $userId = Auth::id();
        $peminjamans = Peminjaman::with('unit')
            ->where('user_id', $userId)
            ->orderBy('tanggal_pinjam', 'desc')
            ->paginate(10);

        return view('peminjaman.saya', compact('peminjamans'));
    }
}
