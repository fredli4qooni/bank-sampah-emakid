<?php

namespace App\Http\Controllers;

use App\Models\CalonUnit;
use Illuminate\Http\Request;

class CalonUnitController extends Controller
{
    public function index()
    {
        $calonUnits = CalonUnit::orderBy('created_at', 'desc')->paginate(15);
        return view('calon_unit.index', compact('calonUnits'));
    }

    public function updateStatus(Request $request, $id)
    {
        $calon = CalonUnit::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,dihubungi'
        ]);

        $calon->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status pendaftar berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $calon = CalonUnit::findOrFail($id);
        $calon->delete();

        return back()->with('success', 'Data pendaftar berhasil dihapus.');
    }
}
