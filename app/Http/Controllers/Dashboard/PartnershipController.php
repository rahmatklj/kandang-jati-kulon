<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Partnership;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\ActivityLogger;

class PartnershipController extends Controller
{
    private function getCategories()
    {
        $categories = Category::where('module', 'kemitraan')->orderBy('order', 'asc')->orderBy('name', 'asc')->get();

        if ($categories->isEmpty()) {
            $defaults = [
                'Instansi Pemerintah',
                'BUMN / BUMD',
                'Pendidikan',
                'Sektor Swasta / UMKM',
                'Organisasi Masyarakat',
            ];
            foreach ($defaults as $index => $name) {
                Category::create([
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'module' => 'kemitraan',
                    'order' => $index + 1,
                    'status' => 'active',
                ]);
            }
            $categories = Category::where('module', 'kemitraan')->orderBy('order', 'asc')->orderBy('name', 'asc')->get();
        }

        return $categories;
    }

    public function index(Request $request)
    {
        $categoryFilter = $request->get('category', 'all');
        $search = $request->get('search');

        $query = Partnership::orderBy('sort_order', 'asc')->latest();

        if ($categoryFilter !== 'all') {
            $query->where('category', $categoryFilter);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%");
            });
        }

        $partnerships = $query->paginate(12);
        $categories = $this->getCategories();

        $stats = [
            'total' => Partnership::count(),
            'active' => Partnership::where('is_active', true)->count(),
            'categories_count' => $categories->count(),
            'gov_bumn' => Partnership::whereIn('category', ['Instansi Pemerintah', 'BUMN / BUMD'])->count(),
            'private_edu' => Partnership::whereIn('category', ['Pendidikan', 'Sektor Swasta / UMKM', 'Organisasi Masyarakat'])->count(),
        ];

        return view('dashboard.partnerships.index', compact('partnerships', 'categoryFilter', 'search', 'stats', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'logo_file' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp,gif|max:5048',
            'logo_url' => 'nullable|string|max:2000',
            'description' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
        ], [
            'logo_file.image' => '🚫 AKSES DITOLAK! Berkas logo yang diunggah harus berupa FOTO / GAMBAR.',
            'logo_file.mimes' => '🚫 AKSES DITOLAK! Format berkas logo tidak diperbolehkan. Hanya Foto/Gambar (JPG, PNG, JPEG, WEBP, GIF, SVG) yang diperbolehkan.',
            'logo_file.max' => '🚫 AKSES DITOLAK! Ukuran berkas gambar maksimal adalah 5 MB.',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo_file')) {
            $logoPath = '/storage/' . $request->file('logo_file')->store('partnerships', 'public');
        } elseif ($request->filled('logo_url')) {
            $logoPath = trim($request->logo_url);
        } else {
            $logoPath = 'https://images.unsplash.com/photo-1560179707-f14e90ef3623?auto=format&fit=crop&w=300&q=80';
        }

        $partnership = Partnership::create([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'logo' => $logoPath,
            'description' => $validated['description'] ?? null,
            'website' => $validated['website'] ?? null,
            'contact_person' => $validated['contact_person'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : true,
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        ActivityLogger::log('CREATE', 'Kemitraan', "Menambahkan mitra kerja baru: {$partnership->name}", [
            'partnership_id' => $partnership->id
        ]);

        return redirect()->route('dashboard.partnerships.index')->with('success', 'Data kemitraan baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $partnership = Partnership::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'logo_file' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp,gif|max:5048',
            'logo_url' => 'nullable|string|max:2000',
            'description' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
        ], [
            'logo_file.image' => '🚫 AKSES DITOLAK! Berkas logo yang diunggah harus berupa FOTO / GAMBAR.',
            'logo_file.mimes' => '🚫 AKSES DITOLAK! Format berkas logo tidak diperbolehkan. Hanya Foto/Gambar (JPG, PNG, JPEG, WEBP, GIF, SVG) yang diperbolehkan.',
            'logo_file.max' => '🚫 AKSES DITOLAK! Ukuran berkas gambar maksimal adalah 5 MB.',
        ]);

        if ($request->hasFile('logo_file')) {
            // Delete old file if stored locally
            if ($partnership->logo && str_contains($partnership->logo, '/storage/partnerships/')) {
                $storagePath = str_replace('/storage/', '', $partnership->logo);
                Storage::disk('public')->delete($storagePath);
            }
            $partnership->logo = '/storage/' . $request->file('logo_file')->store('partnerships', 'public');
        } elseif ($request->filled('logo_url')) {
            $partnership->logo = trim($request->logo_url);
        }

        $partnership->update([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'logo' => $partnership->logo,
            'description' => $validated['description'] ?? null,
            'website' => $validated['website'] ?? null,
            'contact_person' => $validated['contact_person'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : false,
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        ActivityLogger::log('UPDATE', 'Kemitraan', "Memperbarui data kemitraan: {$partnership->name}", [
            'partnership_id' => $partnership->id
        ]);

        return redirect()->route('dashboard.partnerships.index')->with('success', 'Data kemitraan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $partnership = Partnership::findOrFail($id);
        $name = $partnership->name;

        if ($partnership->logo && str_contains($partnership->logo, '/storage/partnerships/')) {
            $storagePath = str_replace('/storage/', '', $partnership->logo);
            Storage::disk('public')->delete($storagePath);
        }

        $partnership->delete();

        ActivityLogger::log('DELETE', 'Kemitraan', "Menghapus data kemitraan: {$name}");

        return redirect()->route('dashboard.partnerships.index')->with('success', 'Data kemitraan berhasil dihapus!');
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:100',
            'category_description' => 'nullable|string|max:255',
        ], [
            'category_name.required' => 'Nama kategori baru wajib diisi.',
            'category_name.max' => 'Nama kategori maksimal 100 karakter.',
        ]);

        $name = trim($validated['category_name']);
        $slug = Str::slug($name);

        $exists = Category::where('module', 'kemitraan')
            ->where(function($q) use ($name, $slug) {
                $q->where('name', $name)->orWhere('slug', $slug);
            })->exists();

        if ($exists) {
            return back()->withErrors(['category_name' => "Kategori '{$name}' sudah ada."]);
        }

        $maxOrder = Category::where('module', 'kemitraan')->max('order') ?? 0;

        Category::create([
            'name' => $name,
            'slug' => $slug,
            'description' => $validated['category_description'] ?? null,
            'module' => 'kemitraan',
            'order' => $maxOrder + 1,
            'status' => 'active',
        ]);

        ActivityLogger::log('CREATE', 'Kategori Kemitraan', "Menambahkan kategori kemitraan baru: {$name}");

        return back()->with('success', "Kategori '{$name}' berhasil ditambahkan!");
    }

    public function destroyCategory($id)
    {
        $category = Category::where('module', 'kemitraan')->findOrFail($id);
        $name = $category->name;

        $category->delete();

        ActivityLogger::log('DELETE', 'Kategori Kemitraan', "Menghapus kategori kemitraan: {$name}");

        return back()->with('success', "Kategori '{$name}' berhasil dihapus!");
    }
}
