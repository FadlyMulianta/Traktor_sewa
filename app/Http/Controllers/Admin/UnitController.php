<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    // MENAMPILKAN SEMUA DATA (READ)
    public function index()
    {
        $units = Unit::with('categories')->latest()->paginate(10);
        return view('admin.units.index', compact('units'));
    }

    // MENAMPILKAN FORM TAMBAH (CREATE - Poin 9.g)
    public function create()
    {
        $categories = Category::all(); // Ambil semua kategori untuk checklist
        return view('admin.units.create', compact('categories'));
    }

    // MENYIMPAN DATA BARU (CREATE - Poin 9.g)
    public function store(Request $request)
    {
        // Validasi (Poin 16)
        $validator = Validator::make($request->all(), [
            'nama_unit' => 'required|string|max:255',
            'kode_unit' => 'required|string|max:50|unique:units,kode_unit', // Poin 7.f
            'categories' => 'required|array|min:1', // Poin 6
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.units.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Buat Unit
        $unit = Unit::create([
            'nama_unit' => $request->nama_unit,
            'kode_unit' => $request->kode_unit,
            'status' => 'tersedia', // Default saat dibuat
        ]);

        // Lampirkan kategori (relasi many-to-many)
        $unit->categories()->attach($request->categories);

        return redirect()->route('admin.units.index')->with('success', 'Unit berhasil ditambahkan.');
    }

    // MENAMPILKAN FORM EDIT (UPDATE - Poin 9.h)
    public function edit(Unit $unit)
    {
        $categories = Category::all();
        // Ambil ID kategori yang sudah dimiliki unit ini
        $unitCategoryIds = $unit->categories->pluck('id')->toArray();
        return view('admin.units.edit', compact('unit', 'categories', 'unitCategoryIds'));
    }

    // MENYIMPAN PERUBAHAN DATA (UPDATE - Poin 9.h)
    public function update(Request $request, Unit $unit)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_unit' => 'required|string|max:255',
            // Pastikan kode unit unik, KECUALI untuk unit ini sendiri
            'kode_unit' => 'required|string|max:50|unique:units,kode_unit,' . $unit->id,
            'status' => 'required|in:tersedia,dipinjam',
            'categories' => 'required|array|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.units.edit', $unit->id)
                ->withErrors($validator)
                ->withInput();
        }

        // Update Unit
        $unit->update([
            'nama_unit' => $request->nama_unit,
            'kode_unit' => $request->kode_unit,
            'status' => $request->status,
        ]);

        // 'sync' akan meng-update relasi: hapus yg lama, tambah yg baru
        $unit->categories()->sync($request->categories);

        return redirect()->route('admin.units.index')->with('success', 'Unit berhasil diperbarui.');
    }

    // MENGHAPUS DATA (DELETE - Poin 9.i)
    public function destroy(Unit $unit)
    {
        // Hapus relasi di pivot tabel
        $unit->categories()->detach();
        // Hapus unit
        $unit->delete();

        return redirect()->route('admin.units.index')->with('success', 'Unit berhasil dihapus.');
    }
}
