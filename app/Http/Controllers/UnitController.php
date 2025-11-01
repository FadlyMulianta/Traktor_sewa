<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $query = Unit::with('categories');

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_unit', 'like', '%' . $request->search . '%');
        }
        $units = $query->paginate(10);
        return view('units.index', compact('units'));
    }
}
