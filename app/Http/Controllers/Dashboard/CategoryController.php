<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\KategoriLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\ActivityLogger;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index(Request $request)
    {
        $modules = Category::getModules();
        $selectedModule = $request->query('module', 'all');

        $query = Category::query();
        if ($selectedModule !== 'all' && array_key_exists($selectedModule, $modules)) {
            $query->where('module', $selectedModule);
        }

        $categories = $query->orderBy('module', 'asc')
                            ->orderBy('order', 'asc')
                            ->orderBy('name', 'asc')
                            ->get();

        // Compute usage_count for each category
        foreach ($categories as $cat) {
            $usage = 0;
            if ($cat->module === 'layanan') {
                $kl = KategoriLayanan::where('slug', $cat->slug)->first();
                if ($kl) {
                    $usage = \App\Models\Service::where('kategori_layanan_id', $kl->id)->count();
                }
            } elseif ($cat->module === 'berita') {
                $usage = \App\Models\Post::where('category_id', $cat->id)->count();
            } elseif ($cat->module === 'dokumen') {
                $usage = \App\Models\Document::where('category_id', $cat->id)->count();
            } elseif ($cat->module === 'kemitraan') {
                $usage = \App\Models\Partnership::where('category', $cat->name)->count();
            }
            $cat->usage_count = $usage;
        }

        // Module counts
        $allCount = Category::count();
        $moduleCounts = [];
        foreach ($modules as $modKey => $modName) {
            $moduleCounts[$modKey] = Category::where('module', $modKey)->count();
        }

        return view('dashboard.categories.index', compact(
            'categories',
            'modules',
            'selectedModule',
            'allCount',
            'moduleCounts'
        ));
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'module' => 'required|string|in:dokumen,berita,galeri,video,layanan,apbd,jenis_pos',
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|string|in:emerald,blue,rose,amber,purple,indigo,cyan',
            'order' => 'nullable|integer|min:1',
            'status' => 'nullable|string|in:aktif,nonaktif',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'module.required' => 'Modul kategori wajib dipilih.',
        ]);

        $color = $request->input('color', 'emerald');
        $order = $request->input('order', 1);
        $status = $request->input('status', 'aktif');

        $baseSlug = Str::slug($request->name);
        if (!in_array($request->module, ['berita', 'layanan'])) {
            $baseSlug = Str::slug($request->module . '-' . $request->name);
        }

        $slug = $baseSlug;
        $counter = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $category = Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'module' => $request->module,
            'description' => $request->description,
            'color' => $color,
            'order' => $order,
            'status' => $status,
        ]);

        $kategoriLayananId = null;
        if ($category->module === 'layanan') {
            $kl = KategoriLayanan::updateOrCreate(
                ['slug' => $category->slug],
                [
                    'nama_kategori' => $category->name,
                    'deskripsi' => $category->description,
                ]
            );
            $kategoriLayananId = $kl->id;
        }

        ActivityLogger::log('CREATE', 'Kategori', "Menambahkan kategori ({$category->module}): {$category->name}", [
            'category_id' => $category->id
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Kategori '{$category->name}' berhasil ditambahkan.",
                'category' => [
                    'id' => $category->id,
                    'kategori_layanan_id' => $kategoriLayananId ?: $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'module' => $category->module,
                ]
            ], 201);
        }

        return redirect()->route('dashboard.categories.index', ['module' => $request->module])
            ->with('success', "Kategori baru untuk modul {$category->module_label} berhasil ditambahkan.");
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'module' => 'required|string|in:dokumen,berita,galeri,video,layanan',
            'description' => 'nullable|string|max:500',
            'color' => 'required|string|in:emerald,blue,rose,amber,purple,indigo,cyan',
            'order' => 'required|integer|min:1',
            'status' => 'required|string|in:aktif,nonaktif',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'module.required' => 'Modul kategori wajib dipilih.',
            'color.required' => 'Warna penanda wajib dipilih.',
            'order.required' => 'Urutan wajib diisi.',
        ]);

        $oldSlug = $category->slug;

        $category->update([
            'name' => $request->name,
            'module' => $request->module,
            'description' => $request->description,
            'color' => $request->color,
            'order' => $request->order,
            'status' => $request->status,
        ]);

        // Sync with KategoriLayanan if module is layanan
        if ($category->module === 'layanan') {
            KategoriLayanan::updateOrCreate(
                ['slug' => $category->slug],
                [
                    'nama_kategori' => $category->name,
                    'deskripsi' => $category->description,
                ]
            );
        }

        ActivityLogger::log('UPDATE', 'Kategori', "Mengubah kategori ({$category->module}): {$category->name}", [
            'category_id' => $category->id
        ]);

        return redirect()->route('dashboard.categories.index', ['module' => $request->module])
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified category from storage with relation check validation.
     */
    public function destroy(Request $request, Category $category)
    {
        $name = $category->name;
        $mod = $category->module;
        $slug = $category->slug;

        // VALIDASI RELASI LAYANAN
        if ($mod === 'layanan') {
            $kl = KategoriLayanan::where('slug', $slug)->first();
            if ($kl) {
                $serviceCount = \App\Models\Service::where('kategori_layanan_id', $kl->id)->count();
                if ($serviceCount > 0) {
                    $errorMsg = "Kategori '{$name}' tidak dapat dihapus karena masih digunakan oleh {$serviceCount} data layanan aktif.";
                    if ($request->wantsJson() || $request->ajax()) {
                        return response()->json(['success' => false, 'message' => $errorMsg, 'usage_count' => $serviceCount], 422);
                    }
                    return redirect()->back()->with('error', $errorMsg);
                }
            }
        } elseif ($mod === 'berita') {
            $postCount = \App\Models\Post::where('category_id', $category->id)->count();
            if ($postCount > 0) {
                $errorMsg = "Kategori '{$name}' tidak dapat dihapus karena masih digunakan oleh {$postCount} berita aktif.";
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json(['success' => false, 'message' => $errorMsg], 422);
                }
                return redirect()->back()->with('error', $errorMsg);
            }
        } elseif ($mod === 'dokumen') {
            $docCount = \App\Models\Document::where('category_id', $category->id)->count();
            if ($docCount > 0) {
                $errorMsg = "Kategori '{$name}' tidak dapat dihapus karena masih digunakan oleh {$docCount} dokumen aktif.";
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json(['success' => false, 'message' => $errorMsg], 422);
                }
                return redirect()->back()->with('error', $errorMsg);
            }
        } elseif ($mod === 'kemitraan') {
            $partnerCount = \App\Models\Partnership::where('category', $category->name)->count();
            if ($partnerCount > 0) {
                $errorMsg = "Kategori '{$name}' tidak dapat dihapus karena masih digunakan oleh {$partnerCount} data mitra aktif.";
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json(['success' => false, 'message' => $errorMsg], 422);
                }
                return redirect()->back()->with('error', $errorMsg);
            }
        }

        $category->delete();

        if ($mod === 'layanan') {
            KategoriLayanan::where('slug', $slug)->delete();
        }

        ActivityLogger::log('DELETE', 'Kategori', "Menghapus kategori: {$name}");

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Kategori '{$name}' berhasil dihapus."
            ]);
        }

        return redirect()->route('dashboard.categories.index', ['module' => $mod])
            ->with('success', "Kategori '{$name}' berhasil dihapus.");
    }

    /**
     * Remove category via quick AJAX method with relation check validation.
     */
    public function destroyQuick(Request $request)
    {
        $request->validate([
            'module' => 'required|string',
            'value' => 'required',
        ]);

        $module = $request->module;
        $val = $request->value;

        if ($module === 'layanan') {
            $kl = is_numeric($val) 
                ? KategoriLayanan::find($val) 
                : KategoriLayanan::where('slug', $val)->orWhere('nama_kategori', $val)->first();

            if ($kl) {
                $serviceCount = \App\Models\Service::where('kategori_layanan_id', $kl->id)->count();
                if ($serviceCount > 0) {
                    return response()->json([
                        'success' => false,
                        'message' => "Kategori '{$kl->nama_kategori}' tidak dapat dihapus karena masih digunakan oleh {$serviceCount} data layanan aktif.",
                        'usage_count' => $serviceCount,
                    ], 422);
                }

                $deletedName = $kl->nama_kategori;
                Category::where('module', 'layanan')->where('slug', $kl->slug)->delete();
                $kl->delete();

                ActivityLogger::log('DELETE', 'Kategori', "Menghapus kategori (quick): {$deletedName}");

                return response()->json([
                    'success' => true,
                    'message' => "Kategori '{$deletedName}' berhasil dihapus."
                ]);
            }
        }

        // Generic fallback for categories
        $cat = is_numeric($val) 
            ? Category::where('id', $val)->first() 
            : Category::where('module', $module)->where(function($q) use ($val) {
                $q->where('slug', $val)->orWhere('name', $val);
            })->first();

        if (!$cat) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan atau sudah dihapus.'
            ], 404);
        }

        // Validate module relation
        if ($cat->module === 'layanan') {
            $kl = KategoriLayanan::where('slug', $cat->slug)->first();
            if ($kl) {
                $serviceCount = \App\Models\Service::where('kategori_layanan_id', $kl->id)->count();
                if ($serviceCount > 0) {
                    return response()->json([
                        'success' => false,
                        'message' => "Kategori '{$cat->name}' tidak dapat dihapus karena masih digunakan oleh {$serviceCount} data layanan aktif.",
                        'usage_count' => $serviceCount,
                    ], 422);
                }
                $kl->delete();
            }
        } elseif ($cat->module === 'kemitraan') {
            $partnerCount = \App\Models\Partnership::where('category', $cat->name)->count();
            if ($partnerCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => "Kategori '{$cat->name}' tidak dapat dihapus karena masih digunakan oleh {$partnerCount} data mitra aktif.",
                    'usage_count' => $partnerCount,
                ], 422);
            }
        }

        $deletedName = $cat->name;
        $cat->delete();

        ActivityLogger::log('DELETE', 'Kategori', "Menghapus kategori (quick): {$deletedName}");

        return response()->json([
            'success' => true,
            'message' => "Kategori '{$deletedName}' berhasil dihapus."
        ]);
    }
}
