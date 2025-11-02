<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon; // Penting untuk denda

class PeminjamanController extends Controller
{
    /**
     * Poin 13: Menampilkan list unit yang sedang dipinjam.
     */
    public function index()
    {
        // Ambil semua peminjaman yang statusnya masih 'dipinjam'
        // 'with' untuk mengambil data relasi (user & unit) agar efisien
        $peminjamans = Peminjaman::with('user', 'unit')
            ->where('status', 'dipinjam')
            ->orderBy('tanggal_kembali', 'asc') // Urutkan berdasarkan yang paling dekat deadline
            ->get(); // Kita 'get()' semua, bukan 'paginate'

        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    /**
     * Poin 12 & 11: Memproses pengembalian unit dan menghitung denda.
     */
    public function kembalikan(Request $request, Peminjaman $peminjaman)
    {
        // Cek jika sudah dikembalikan (mencegah double-click)
        if ($peminjaman->status == 'dikembalikan') {
            return redirect()->route('admin.peminjaman.aktif')->with('error', 'Unit ini sudah dikembalikan.');
        }

        // --- Logika Denda (Poin 11) ---
        $tanggal_kembali_seharusnya = Carbon::parse($peminjaman->tanggal_kembali);
        $tanggal_kembali_sekarang = Carbon::now();
        $denda = 0;

        // Cek apakah tanggal sekarang lebih lambat dari tanggal seharusnya
        if ($tanggal_kembali_sekarang->isAfter($tanggal_kembali_seharusnya)) {
            // Hitung selisih hari keterlambatan
            $selisih_hari = $tanggal_kembali_sekarang->diffInDays($tanggal_kembali_seharusnya);

            // Ambil harga sewa per hari dari unit yang bersangkutan
            $harga_per_hari = $peminjaman->unit->harga_sewa_per_hari;

            // Hitung denda
            $denda = $selisih_hari * $harga_per_hari;
        }
        // --- Akhir Logika Denda ---


        // 1. Update data Peminjaman
        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_pengembalian_sebenarnya' => $tanggal_kembali_sekarang,
            'denda' => $denda,
        ]);

        // 2. Update status Unit (kembalikan jadi 'tersedia')
        // $peminjaman->unit()->update([
        //     'status' => 'tersedia'
        // ]);

        // $pesan_sukses = 'Unit berhasil dikembalikan.';
        // if ($denda > 0) {
        //     $pesan_sukses .= ' Denda yang dikenakan: Rp ' . number_format($denda);
        // }

        return redirect()->route('admin.peminjaman.aktif');
    }

    public function history()
    {
        // Ambil semua data peminjaman, diurutkan dari yang terbaru
        $peminjamans = Peminjaman::with('user', 'unit')
            ->orderBy('tanggal_pinjam', 'desc')
            ->paginate(20); // Kita pakai paginate di sini

        return view('admin.peminjaman.histori', compact('peminjamans'));
    }

    /**
     * Poin 15: Menyiapkan halaman untuk dicetak.
     */
    public function print()
    {
        // Ambil SEMUA data (tanpa paginate) untuk dicetak
        $peminjamans = Peminjaman::with('user', 'unit')
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        $tanggal_cetak = \Carbon\Carbon::now()->format('d M Y');

        return view('admin.peminjaman.print', compact('peminjamans', 'tanggal_cetak'));
    }
}
