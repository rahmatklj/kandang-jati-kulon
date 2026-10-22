<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AnggaranKelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\ActivityLogger;

class ApbdAdminController extends Controller
{
    /**
     * Tampilkan halaman kelola APBD Kelurahan di Dashboard Admin.
     */
    public function index(Request $request)
    {
        // Ambil daftar tahun anggaran yang tersedia di DB
        $availableYears = AnggaranKelurahan::select('tahun_anggaran')
            ->distinct()
            ->orderBy('tahun_anggaran', 'desc')
            ->pluck('tahun_anggaran')
            ->toArray();

        if (empty($availableYears)) {
            $availableYears = [(int) date('Y')];
        }

        $selectedYear = (int) $request->get('tahun', $availableYears[0]);
        $selectedJenis = $request->get('jenis', 'all');

        // Main Query
        $query = AnggaranKelurahan::where('tahun_anggaran', $selectedYear);

        if ($selectedJenis !== 'all') {
            $query->where('jenis', $selectedJenis);
        }

        $items = $query->orderBy('jenis', 'asc')->orderBy('id', 'asc')->get();

        // Hitung Ringkasan Metrik Keuangan untuk Tahun Terpilih
        $allYearItems = AnggaranKelurahan::where('tahun_anggaran', $selectedYear)->get();

        $totalPendapatanAnggaran = $allYearItems->where('jenis', 'pendapatan')->sum('anggaran');
        $totalPendapatanRealisasi = $allYearItems->where('jenis', 'pendapatan')->sum('realisasi');
        $persenPendapatan = $totalPendapatanAnggaran > 0 ? round(($totalPendapatanRealisasi / $totalPendapatanAnggaran) * 100, 1) : 0;

        $totalBelanjaAnggaran = $allYearItems->where('jenis', 'belanja')->sum('anggaran');
        $totalBelanjaRealisasi = $allYearItems->where('jenis', 'belanja')->sum('realisasi');
        $persenBelanja = $totalBelanjaAnggaran > 0 ? round(($totalBelanjaRealisasi / $totalBelanjaAnggaran) * 100, 1) : 0;

        $totalPembiayaanRealisasi = $allYearItems->where('jenis', 'pembiayaan')->sum('realisasi');

        // Surplus / Defisit Realisasi
        $surplusDefisitRealisasi = $totalPendapatanRealisasi - $totalBelanjaRealisasi;

        // SILPA (Sisa Lebih Pembiayaan Anggaran)
        $silpa = $surplusDefisitRealisasi + $totalPembiayaanRealisasi;

        // Ambil Jenis Pos Dinamis
        $customJenisList = \App\Models\Category::where('module', 'jenis_pos')->orderBy('name', 'asc')->get();
        $dbJenis = AnggaranKelurahan::select('jenis')->distinct()->pluck('jenis')->toArray();
        $defaultJenis = ['pendapatan', 'belanja', 'pembiayaan'];
        $availableJenis = array_values(array_unique(array_filter(array_merge($defaultJenis, $customJenisList->pluck('name')->toArray(), $dbJenis))));

        // Ambil Master Kategori untuk APBD Dinamis
        $masterCategories = \App\Models\Category::whereIn('module', ['apbd', 'dokumen'])->orderBy('name', 'asc')->get();
        $categoriesFromDb = AnggaranKelurahan::select('kategori')->distinct()->pluck('kategori')->toArray();
        $categories = array_values(array_unique(array_filter(array_merge($masterCategories->pluck('name')->toArray(), $categoriesFromDb))));

        return view('dashboard.apbd.index', compact(
            'items',
            'availableYears',
            'selectedYear',
            'selectedJenis',
            'availableJenis',
            'customJenisList',
            'categories',
            'masterCategories',
            'totalPendapatanAnggaran',
            'totalPendapatanRealisasi',
            'persenPendapatan',
            'totalBelanjaAnggaran',
            'totalBelanjaRealisasi',
            'persenBelanja',
            'surplusDefisitRealisasi',
            'silpa'
        ));
    }

    /**
     * Simpan data pos anggaran baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun_anggaran' => 'required|integer|min:2000|max:2099',
            'jenis' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'uraian' => 'required|string|max:255',
            'anggaran' => 'required',
            'realisasi' => 'nullable',
            'keterangan' => 'nullable|string',
            'berkas_laporan_pdf' => 'nullable|file|mimes:pdf,jpeg,png,jpg,webp,gif,svg|max:10240',
        ], [
            'tahun_anggaran.required' => 'Tahun Anggaran wajib dipilih.',
            'jenis.required' => 'Jenis Pos Anggaran wajib diisi.',
            'kategori.required' => 'Kategori / Bidang Anggaran wajib diisi.',
            'uraian.required' => 'Uraian rincian kegiatan wajib diisi.',
            'anggaran.required' => 'Nominal Anggaran (Rp) wajib diisi.',
            'berkas_laporan_pdf.mimes' => 'Berkas laporan harus berformat PDF atau Foto/Gambar.',
            'berkas_laporan_pdf.max' => 'Ukuran berkas maksimal 10MB.',
        ]);

        $anggaranNominal = $this->parseCurrency($request->anggaran);
        $realisasiNominal = $this->parseCurrency($request->realisasi ?? 0);

        $pdfPath = null;
        if ($request->hasFile('berkas_laporan_pdf')) {
            $pdfPath = $request->file('berkas_laporan_pdf')->store('apbd_reports', 'public');
        }

        $jenisVal = trim($request->jenis);
        $kategoriVal = trim($request->kategori);

        // Jika Jenis Pos baru belum ada di master category, simpan otomatis
        if (!in_array(strtolower($jenisVal), ['pendapatan', 'belanja', 'pembiayaan'])) {
            $slugJenis = Str::slug('jenis-pos-' . $jenisVal);
            \App\Models\Category::firstOrCreate(
                ['slug' => $slugJenis],
                [
                    'name' => $jenisVal,
                    'module' => 'jenis_pos',
                    'status' => 'aktif',
                    'color' => 'emerald',
                    'order' => 1,
                ]
            );
        }

        // Jika Kategori baru belum ada di master category, simpan otomatis
        $slugCat = Str::slug('apbd-' . $kategoriVal);
        \App\Models\Category::firstOrCreate(
            ['slug' => $slugCat],
            [
                'name' => $kategoriVal,
                'module' => 'apbd',
                'status' => 'aktif',
                'color' => 'blue',
                'order' => 1,
            ]
        );

        $item = AnggaranKelurahan::create([
            'tahun_anggaran' => $request->tahun_anggaran,
            'jenis' => $jenisVal,
            'kategori' => $kategoriVal,
            'uraian' => trim($request->uraian),
            'anggaran' => $anggaranNominal,
            'realisasi' => $realisasiNominal,
            'keterangan' => $request->keterangan,
            'berkas_laporan_pdf' => $pdfPath,
            'is_published' => $request->has('is_published') ? true : false,
        ]);

        ActivityLogger::log('CREATE', 'APBD Kelurahan', "Menambahkan pos APBD ({$item->jenis}): {$item->uraian} (Rp " . number_format($item->anggaran, 0, ',', '.') . ")", [
            'item_id' => $item->id,
            'tahun' => $item->tahun_anggaran,
        ]);

        return redirect()->back()->with('success', 'Pos APBD Kelurahan berhasil ditambahkan.');
    }

    /**
     * Perbarui data pos anggaran.
     */
    public function update(Request $request, $id)
    {
        $item = AnggaranKelurahan::findOrFail($id);

        $request->validate([
            'tahun_anggaran' => 'required|integer|min:2000|max:2099',
            'jenis' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'uraian' => 'required|string|max:255',
            'anggaran' => 'required',
            'realisasi' => 'nullable',
            'keterangan' => 'nullable|string',
            'berkas_laporan_pdf' => 'nullable|file|mimes:pdf,jpeg,png,jpg,webp,gif,svg|max:10240',
        ]);

        $anggaranNominal = $this->parseCurrency($request->anggaran);
        $realisasiNominal = $this->parseCurrency($request->realisasi ?? 0);

        $pdfPath = $item->berkas_laporan_pdf;
        if ($request->hasFile('berkas_laporan_pdf')) {
            $pdfPath = $request->file('berkas_laporan_pdf')->store('apbd_reports', 'public');
        }

        $jenisVal = trim($request->jenis);
        $kategoriVal = trim($request->kategori);

        if (!in_array(strtolower($jenisVal), ['pendapatan', 'belanja', 'pembiayaan'])) {
            $slugJenis = Str::slug('jenis-pos-' . $jenisVal);
            \App\Models\Category::firstOrCreate(
                ['slug' => $slugJenis],
                [
                    'name' => $jenisVal,
                    'module' => 'jenis_pos',
                    'status' => 'aktif',
                    'color' => 'emerald',
                    'order' => 1,
                ]
            );
        }

        $slugCat = Str::slug('apbd-' . $kategoriVal);
        \App\Models\Category::firstOrCreate(
            ['slug' => $slugCat],
            [
                'name' => $kategoriVal,
                'module' => 'apbd',
                'status' => 'aktif',
                'color' => 'blue',
                'order' => 1,
            ]
        );

        $item->update([
            'tahun_anggaran' => $request->tahun_anggaran,
            'jenis' => $jenisVal,
            'kategori' => $kategoriVal,
            'uraian' => trim($request->uraian),
            'anggaran' => $anggaranNominal,
            'realisasi' => $realisasiNominal,
            'keterangan' => $request->keterangan,
            'berkas_laporan_pdf' => $pdfPath,
            'is_published' => $request->has('is_published') ? true : false,
        ]);

        ActivityLogger::log('UPDATE', 'APBD Kelurahan', "Mengubah pos APBD: {$item->uraian}", [
            'item_id' => $item->id,
            'tahun' => $item->tahun_anggaran,
        ]);

        return redirect()->back()->with('success', 'Pos APBD Kelurahan berhasil diperbarui.');
    }

    /**
     * Tambah Jenis Pos baru secara manual ke Master.
     */
    public function storeJenisPos(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama Jenis Pos wajib diisi.',
        ]);

        $name = trim($request->name);
        $slug = Str::slug('jenis-pos-' . $name);

        \App\Models\Category::updateOrCreate(
            ['slug' => $slug],
            [
                'name' => $name,
                'module' => 'jenis_pos',
                'status' => 'aktif',
                'color' => 'emerald',
                'order' => 1,
            ]
        );

        ActivityLogger::log('CREATE', 'Jenis Pos', "Menambahkan jenis pos baru: {$name}");

        return redirect()->back()->with('success', "Jenis Pos \"{$name}\" berhasil ditambahkan.");
    }

    /**
     * Hapus Jenis Pos dari Master.
     */
    public function destroyJenisPos($id)
    {
        $cat = \App\Models\Category::where('id', $id)->first();
        if ($cat) {
            $name = $cat->name;
            $cat->delete();
            ActivityLogger::log('DELETE', 'Jenis Pos', "Menghapus jenis pos: {$name}");
            return redirect()->back()->with('success', "Jenis Pos \"{$name}\" berhasil dihapus.");
        }
        return redirect()->back()->with('error', 'Jenis Pos tidak ditemukan.');
    }

    /**
     * Tambah Master Kategori APBD secara manual.
     */
    public function storeCategoryQuick(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama Master Kategori wajib diisi.',
        ]);

        $name = trim($request->name);
        $slug = Str::slug('apbd-' . $name);

        \App\Models\Category::updateOrCreate(
            ['slug' => $slug],
            [
                'name' => $name,
                'module' => 'apbd',
                'status' => 'aktif',
                'color' => 'blue',
                'order' => 1,
            ]
        );

        ActivityLogger::log('CREATE', 'Master Kategori', "Menambahkan master kategori APBD baru: {$name}");

        return redirect()->back()->with('success', "Master Kategori \"{$name}\" berhasil ditambahkan.");
    }

    /**
     * Hapus Master Kategori APBD.
     */
    public function destroyCategoryQuick($id)
    {
        $cat = \App\Models\Category::where('id', $id)->first();
        if ($cat) {
            $name = $cat->name;
            $cat->delete();
            ActivityLogger::log('DELETE', 'Master Kategori', "Menghapus master kategori APBD: {$name}");
            return redirect()->back()->with('success', "Master Kategori \"{$name}\" berhasil dihapus.");
        }
        return redirect()->back()->with('error', 'Master Kategori tidak ditemukan.');
    }

    /**
     * Toggle status publikasi data APBD.
     */
    public function toggleActive($id)
    {
        $item = AnggaranKelurahan::findOrFail($id);
        $item->is_published = !$item->is_published;
        $item->save();

        $statusLabel = $item->is_published ? 'dipublikasikan' : 'disembunyikan';
        ActivityLogger::log('UPDATE', 'APBD Kelurahan', "Mengubah status publikasi pos APBD #{$item->id} menjadi {$statusLabel}");

        return redirect()->back()->with('success', "Status publikasi pos anggaran berhasil {$statusLabel}.");
    }

    /**
     * Hapus pos data APBD.
     */
    public function destroy($id)
    {
        $item = AnggaranKelurahan::findOrFail($id);
        $uraian = $item->uraian;

        // Model delete memicu HasFileCleanup trait untuk otomatis menghapus PDF dari storage
        $item->delete();

        ActivityLogger::log('DELETE', 'APBD Kelurahan', "Menghapus pos APBD: {$uraian}");

        return redirect()->back()->with('success', 'Pos APBD Kelurahan berhasil dihapus.');
    }

    /**
     * Helper untuk konversi input ribuan string (1.500.000 / Rp 1.500.000) ke float/decimal
     */
    private function parseCurrency($value): float
    {
        if (is_numeric($value)) {
            return (float) $value;
        }

        $clean = preg_replace('/[^0-9]/', '', (string) $value);
        return (float) ($clean ?: 0);
    }
}
