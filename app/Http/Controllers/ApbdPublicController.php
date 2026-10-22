<?php

namespace App\Http\Controllers;

use App\Models\AnggaranKelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApbdPublicController extends Controller
{
    /**
     * Halaman Utama Publik Transparansi Anggaran (APBD / APB-Kel Sidomukti)
     */
    public function index(Request $request)
    {
        // Daftar tahun anggaran publik yang tersedia
        $availableYears = AnggaranKelurahan::where('is_published', true)
            ->select('tahun_anggaran')
            ->distinct()
            ->orderBy('tahun_anggaran', 'desc')
            ->pluck('tahun_anggaran')
            ->toArray();

        if (empty($availableYears)) {
            $availableYears = [(int) date('Y')];
        }

        $selectedYear = (int) $request->get('tahun', $availableYears[0]);

        // Ambil semua data publik untuk tahun terpilih
        $items = AnggaranKelurahan::where('tahun_anggaran', $selectedYear)
            ->where('is_published', true)
            ->orderBy('jenis', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        // Pisahkan per jenis
        $pendapatanItems = $items->where('jenis', 'pendapatan');
        $belanjaItems = $items->where('jenis', 'belanja');
        $pembiayaanItems = $items->where('jenis', 'pembiayaan');

        // Kelompokkan per kategori untuk tampilan tabel rincian
        $pendapatanGrouped = $pendapatanItems->groupBy('kategori');
        $belanjaGrouped = $belanjaItems->groupBy('kategori');
        $pembiayaanGrouped = $pembiayaanItems->groupBy('kategori');

        // Hitung Total Metrik
        $totalPendapatanAnggaran = $pendapatanItems->sum('anggaran');
        $totalPendapatanRealisasi = $pendapatanItems->sum('realisasi');
        $persenPendapatan = $totalPendapatanAnggaran > 0 ? round(($totalPendapatanRealisasi / $totalPendapatanAnggaran) * 100, 1) : 0;

        $totalBelanjaAnggaran = $belanjaItems->sum('anggaran');
        $totalBelanjaRealisasi = $belanjaItems->sum('realisasi');
        $persenBelanja = $totalBelanjaAnggaran > 0 ? round(($totalBelanjaRealisasi / $totalBelanjaAnggaran) * 100, 1) : 0;

        $totalPembiayaanAnggaran = $pembiayaanItems->sum('anggaran');
        $totalPembiayaanRealisasi = $pembiayaanItems->sum('realisasi');

        // Surplus / Defisit Anggaran & Realisasi
        $surplusDefisitAnggaran = $totalPendapatanAnggaran - $totalBelanjaAnggaran;
        $surplusDefisitRealisasi = $totalPendapatanRealisasi - $totalBelanjaRealisasi;

        // SILPA Realisasi
        $silpaRealisasi = $surplusDefisitRealisasi + $totalPembiayaanRealisasi;

        return view('public.apbd.index', compact(
            'availableYears',
            'selectedYear',
            'pendapatanItems',
            'belanjaItems',
            'pembiayaanItems',
            'pendapatanGrouped',
            'belanjaGrouped',
            'pembiayaanGrouped',
            'totalPendapatanAnggaran',
            'totalPendapatanRealisasi',
            'persenPendapatan',
            'totalBelanjaAnggaran',
            'totalBelanjaRealisasi',
            'persenBelanja',
            'totalPembiayaanAnggaran',
            'totalPembiayaanRealisasi',
            'surplusDefisitAnggaran',
            'surplusDefisitRealisasi',
            'silpaRealisasi'
        ));
    }

    /**
     * Unduh Berkas PDF Laporan Pertanggungjawaban
     */
    public function downloadPdf($id)
    {
        $item = AnggaranKelurahan::where('is_published', true)->findOrFail($id);

        if (!$item->berkas_laporan_pdf) {
            return redirect()->back()->with('error', 'Berkas PDF laporan pertanggungjawaban belum diunggah.');
        }

        if (\Illuminate\Support\Str::startsWith($item->berkas_laporan_pdf, ['http://', 'https://'])) {
            return redirect()->away($item->berkas_laporan_pdf);
        }

        if (Storage::disk('public')->exists($item->berkas_laporan_pdf)) {
            $filename = 'Laporan-APBD-' . \Illuminate\Support\Str::slug($item->uraian) . '-' . $item->tahun_anggaran . '.pdf';
            return Storage::disk('public')->download($item->berkas_laporan_pdf, $filename);
        }

        return redirect()->back()->with('error', 'Berkas PDF laporan tidak ditemukan di server.');
    }
}
