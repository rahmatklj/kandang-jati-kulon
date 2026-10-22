<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Maklumat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ActivityLogger;

class MaklumatController extends Controller
{
    public function index()
    {
        // Ensure at least one default record exists if database is empty
        $defaultMaklumat = Maklumat::first();
        if (!$defaultMaklumat) {
            $defaultMaklumat = Maklumat::create([
                'title' => 'Maklumat Pelayanan Kelurahan Sidomukti',
                'subtitle' => 'Komitmen Pelayanan Publik Prima dan Transparan',
                'content' => "Dengan ini, kami menyatakan sanggup menyelenggarakan pelayanan sesuai dengan standar pelayanan yang telah ditetapkan dan apabila tidak menepati janji ini, kami siap menerima sanksi sesuai peraturan perundang-undangan yang berlaku.",
                'signer_name' => 'Lurah Sidomukti',
                'signer_title' => 'Kelurahan Sidomukti',
                'is_active' => true,
            ]);
        }

        $maklumats = Maklumat::orderBy('created_at', 'desc')->get();
        return view('dashboard.maklumats.index', compact('maklumats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'signer_name' => 'nullable|string|max:255',
            'signer_title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'is_active' => 'nullable|boolean',
        ]);

        if (empty($validated['content'])) {
            $validated['content'] = 'Dengan ini kami menyatakan sanggup menyelenggarakan pelayanan publik sesuai standar pelayanan yang telah ditetapkan.';
        }

        if (empty($validated['signer_name'])) {
            $validated['signer_name'] = 'Lurah Kandang Jati Kulon';
        }

        if (empty($validated['signer_title'])) {
            $validated['signer_title'] = 'Kelurahan Kandang Jati Kulon';
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('maklumats', 'public');
        }

        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;

        if ($validated['is_active']) {
            Maklumat::query()->update(['is_active' => false]);
        }

        $maklumat = Maklumat::create($validated);

        ActivityLogger::log('CREATE', 'Maklumat', "Menambahkan data Maklumat Pelayanan: {$maklumat->title}", [
            'maklumat_id' => $maklumat->id
        ]);

        return redirect()->back()->with('success', 'Maklumat Pelayanan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $maklumat = Maklumat::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'signer_name' => 'nullable|string|max:255',
            'signer_title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'is_active' => 'nullable|boolean',
        ]);

        if (empty($validated['content'])) {
            $validated['content'] = 'Dengan ini kami menyatakan sanggup menyelenggarakan pelayanan publik sesuai standar pelayanan yang telah ditetapkan.';
        }

        if (empty($validated['signer_name'])) {
            $validated['signer_name'] = 'Lurah Kandang Jati Kulon';
        }

        if (empty($validated['signer_title'])) {
            $validated['signer_title'] = 'Kelurahan Kandang Jati Kulon';
        }

        if ($request->hasFile('image')) {
            if ($maklumat->image && Storage::disk('public')->exists($maklumat->image)) {
                Storage::disk('public')->delete($maklumat->image);
            }
            $validated['image'] = $request->file('image')->store('maklumats', 'public');
        }

        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : false;

        if ($validated['is_active']) {
            Maklumat::where('id', '!=', $id)->update(['is_active' => false]);
        }

        $maklumat->update($validated);

        ActivityLogger::log('UPDATE', 'Maklumat', "Mengubah data Maklumat Pelayanan: {$maklumat->title}", [
            'maklumat_id' => $maklumat->id
        ]);

        return redirect()->back()->with('success', 'Maklumat Pelayanan berhasil diperbarui!');
    }

    public function toggleActive($id)
    {
        $maklumat = Maklumat::findOrFail($id);
        $newStatus = !$maklumat->is_active;

        if ($newStatus) {
            Maklumat::query()->update(['is_active' => false]);
        }
        $maklumat->update(['is_active' => $newStatus]);

        ActivityLogger::log('UPDATE', 'Maklumat', "Mengubah status aktif Maklumat Pelayanan ID {$id} menjadi " . ($newStatus ? 'Aktif' : 'Non-aktif'));

        return redirect()->back()->with('success', 'Status Maklumat Pelayanan berhasil diubah!');
    }

    public function destroy($id)
    {
        $maklumat = Maklumat::findOrFail($id);
        
        if ($maklumat->image && Storage::disk('public')->exists($maklumat->image)) {
            Storage::disk('public')->delete($maklumat->image);
        }

        $title = $maklumat->title;
        $maklumat->delete();

        ActivityLogger::log('DELETE', 'Maklumat', "Menghapus Maklumat Pelayanan: {$title}");

        return redirect()->back()->with('success', 'Maklumat Pelayanan berhasil dihapus!');
    }
}
