<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Lembaga;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

class LembagaController extends Controller
{
    public function index()
    {
        $lembagas = Lembaga::orderBy('sort_order', 'asc')->get();
        return view('dashboard.lembagas.index', compact('lembagas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'abbreviation' => 'nullable|string|max:50',
            'description' => 'required|string',
            'leader_title' => 'nullable|string|max:255',
            'leader_name' => 'nullable|string|max:255',
            'members_count' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;
        $lembaga = Lembaga::create($validated);

        ActivityLogger::log('CREATE', 'Lembaga', "Menambahkan data lembaga kemasyarakatan: {$lembaga->name}", [
            'lembaga_id' => $lembaga->id
        ]);

        return redirect()->back()->with('success', 'Lembaga Kemasyarakatan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $lembaga = Lembaga::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'abbreviation' => 'nullable|string|max:50',
            'description' => 'required|string',
            'leader_title' => 'nullable|string|max:255',
            'leader_name' => 'nullable|string|max:255',
            'members_count' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;
        $lembaga->update($validated);

        ActivityLogger::log('UPDATE', 'Lembaga', "Mengubah data lembaga: {$lembaga->name}", [
            'lembaga_id' => $lembaga->id
        ]);

        return redirect()->back()->with('success', 'Data Lembaga berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $lembaga = Lembaga::findOrFail($id);
        $name = $lembaga->name;
        $lembaga->delete();

        ActivityLogger::log('DELETE', 'Lembaga', "Menghapus data lembaga: {$name}");

        return redirect()->back()->with('success', 'Data Lembaga berhasil dihapus!');
    }
}
