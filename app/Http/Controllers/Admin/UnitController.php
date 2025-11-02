<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::with('categories')->latest()->paginate(10);
        return view('admin.units.index', compact('units'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.units.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_unit' => 'required|string|max:50|unique:units,kode_unit', // <-- TETAP ADA
            'nama_unit' => 'required|string|max:255',
            'harga_sewa_per_hari' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0', // <-- BARU
            'categories' => 'required|array|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.units.create')
                ->withErrors($validator)
                ->withInput();
        }

        $unit = Unit::create([
            'kode_unit' => $request->kode_unit, // <-- TETAP ADA
            'nama_unit' => $request->nama_unit,
            'harga_sewa_per_hari' => $request->harga_sewa_per_hari,
            'stok' => $request->stok, // <-- BARU
        ]);

        $unit->categories()->attach($request->categories);
        return redirect()->route('admin.units.index')->with('success', 'Unit berhasil ditambahkan.');
    }

    public function edit(Unit $unit)
    {
        $categories = Category::all();
        $unitCategoryIds = $unit->categories->pluck('id')->toArray();
        return view('admin.units.edit', compact('unit', 'categories', 'unitCategoryIds'));
    }

    public function update(Request $request, Unit $unit)
    {
        $validator = Validator::make($request->all(), [
            'kode_unit' => 'required|string|max:50|unique:units,kode_unit,' . $unit->id, // <-- TETAP ADA
            'nama_unit' => 'required|string|max:255',
            'harga_sewa_per_hari' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0', // <-- BARU
            'categories' => 'required|array|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.units.edit', $unit->id)
                ->withErrors($validator)
                ->withInput();
        }

        $unit->update([
            'kode_unit' => $request->kode_unit, // <-- TETAP ADA
            'nama_unit' => $request->nama_unit,
            'harga_sewa_per_hari' => $request->harga_sewa_per_hari,
            'stok' => $request->stok, // <-- BARU
        ]);

        $unit->categories()->sync($request->categories);
        return redirect()->route('admin.units.index')->with('success', 'Unit berhasil diperbarui.');
    }

    public function destroy(Unit $unit)
    {
        // Cek jika masih ada yang pinjam
        if ($unit->stok_tersedia != $unit->stok) {
            return redirect()->route('admin.units.index')->with('error', 'Unit tidak bisa dihapus karena masih ada yang dipinjam.');
        }

        $unit->categories()->detach();
        $unit->delete();
        return redirect()->route('admin.units.index')->with('success', 'Unit berhasil dihapus.');
    }
}
