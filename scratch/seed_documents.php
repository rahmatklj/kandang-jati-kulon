<?php
chdir(__DIR__ . '/..');
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Category;
use App\Models\Document;

// =============================================
// 1. BUAT KATEGORI DOKUMEN
// =============================================
$categories = [
    ['name' => 'SK Kelembagaan',     'slug' => 'sk-kelembagaan',     'module' => 'dokumen', 'status' => 'aktif', 'order' => 1],
    ['name' => 'Laporan Keuangan',   'slug' => 'laporan-keuangan',   'module' => 'dokumen', 'status' => 'aktif', 'order' => 2],
    ['name' => 'Regulasi & Kebijakan','slug' => 'regulasi-kebijakan','module' => 'dokumen', 'status' => 'aktif', 'order' => 3],
    ['name' => 'Musrenbang',         'slug' => 'musrenbang',         'module' => 'dokumen', 'status' => 'aktif', 'order' => 4],
    ['name' => 'Renstra & Renja',    'slug' => 'renstra-renja',      'module' => 'dokumen', 'status' => 'aktif', 'order' => 5],
];

echo "=== MEMBUAT KATEGORI DOKUMEN ===\n";
foreach ($categories as $cat) {
    $existing = Category::where('slug', $cat['slug'])->where('module', 'dokumen')->first();
    if (!$existing) {
        Category::create($cat);
        echo "  ✅ Kategori dibuat: {$cat['name']}\n";
    } else {
        echo "  ⏭️  Sudah ada: {$cat['name']}\n";
    }
}

// =============================================
// 2. BUAT DOKUMEN CONTOH
// =============================================
$documents = [
    [
        'title'          => 'SK Pengurus LPMK Kandang Jati Kulon Tahun 2024',
        'category'       => 'sk-kelembagaan',
        'description'    => 'Surat Keputusan Lurah tentang Pengurus Lembaga Pemberdayaan Masyarakat Kelurahan (LPMK) periode 2024-2026.',
        'file_path'      => 'https://www.w3.org/WAI/UR/wai-reports/REC-html401-19991224.pdf',
        'file_name'      => 'SK-LPMK-2024.pdf',
        'file_size'      => 'PDF Link',
        'organization'   => 'Kelurahan Kandang Jati Kulon',
        'status'         => 'Disahkan',
        'published_date' => '2024-01-15',
    ],
    [
        'title'          => 'SK Pengurus RT/RW Kelurahan Kandang Jati Kulon 2024',
        'category'       => 'sk-kelembagaan',
        'description'    => 'Surat Keputusan resmi tentang susunan pengurus RT dan RW di seluruh wilayah Kelurahan Kandang Jati Kulon.',
        'file_path'      => 'https://www.w3.org/WAI/UR/wai-reports/REC-html401-19991224.pdf',
        'file_name'      => 'SK-RT-RW-2024.pdf',
        'file_size'      => 'PDF Link',
        'organization'   => 'Kelurahan Kandang Jati Kulon',
        'status'         => 'Disahkan',
        'published_date' => '2024-02-01',
    ],
    [
        'title'          => 'Laporan Keuangan Kelurahan Triwulan I Tahun 2025',
        'category'       => 'laporan-keuangan',
        'description'    => 'Laporan realisasi anggaran dan keuangan kelurahan periode Januari - Maret 2025.',
        'file_path'      => 'https://www.w3.org/WAI/UR/wai-reports/REC-html401-19991224.pdf',
        'file_name'      => 'LapKeu-TW1-2025.pdf',
        'file_size'      => 'PDF Link',
        'organization'   => 'Kelurahan Kandang Jati Kulon',
        'status'         => 'Disahkan',
        'published_date' => '2025-04-10',
    ],
    [
        'title'          => 'Laporan Keuangan Kelurahan Triwulan II Tahun 2025',
        'category'       => 'laporan-keuangan',
        'description'    => 'Laporan realisasi anggaran dan keuangan kelurahan periode April - Juni 2025.',
        'file_path'      => 'https://www.w3.org/WAI/UR/wai-reports/REC-html401-19991224.pdf',
        'file_name'      => 'LapKeu-TW2-2025.pdf',
        'file_size'      => 'PDF Link',
        'organization'   => 'Kelurahan Kandang Jati Kulon',
        'status'         => 'Disahkan',
        'published_date' => '2025-07-10',
    ],
    [
        'title'          => 'Peraturan Lurah No. 1 Tahun 2025 tentang Tata Tertib Warga',
        'category'       => 'regulasi-kebijakan',
        'description'    => 'Peraturan lurah yang mengatur tata tertib kehidupan bermasyarakat di wilayah Kelurahan Kandang Jati Kulon.',
        'file_path'      => 'https://www.w3.org/WAI/UR/wai-reports/REC-html401-19991224.pdf',
        'file_name'      => 'Perlur-No1-2025.pdf',
        'file_size'      => 'PDF Link',
        'organization'   => 'Kelurahan Kandang Jati Kulon',
        'status'         => 'Disahkan',
        'published_date' => '2025-01-20',
    ],
    [
        'title'          => 'Hasil Musrenbang Kelurahan Kandang Jati Kulon 2025',
        'category'       => 'musrenbang',
        'description'    => 'Dokumen hasil Musyawarah Rencana Pembangunan (Musrenbang) tingkat kelurahan tahun 2025 untuk perencanaan tahun 2026.',
        'file_path'      => 'https://www.w3.org/WAI/UR/wai-reports/REC-html401-19991224.pdf',
        'file_name'      => 'Musrenbang-2025.pdf',
        'file_size'      => 'PDF Link',
        'organization'   => 'Kelurahan Kandang Jati Kulon',
        'status'         => 'Disahkan',
        'published_date' => '2025-02-15',
    ],
    [
        'title'          => 'Rencana Strategis (Renstra) Kelurahan 2024-2026',
        'category'       => 'renstra-renja',
        'description'    => 'Dokumen Rencana Strategis Kelurahan Kandang Jati Kulon periode 2024-2026 sebagai pedoman pembangunan kelurahan.',
        'file_path'      => 'https://www.w3.org/WAI/UR/wai-reports/REC-html401-19991224.pdf',
        'file_name'      => 'Renstra-2024-2026.pdf',
        'file_size'      => 'PDF Link',
        'organization'   => 'Kelurahan Kandang Jati Kulon',
        'status'         => 'Disahkan',
        'published_date' => '2024-03-01',
    ],
    [
        'title'          => 'Rencana Kerja (Renja) Kelurahan Tahun 2025',
        'category'       => 'renstra-renja',
        'description'    => 'Dokumen Rencana Kerja tahunan Kelurahan Kandang Jati Kulon untuk tahun anggaran 2025.',
        'file_path'      => 'https://www.w3.org/WAI/UR/wai-reports/REC-html401-19991224.pdf',
        'file_name'      => 'Renja-2025.pdf',
        'file_size'      => 'PDF Link',
        'organization'   => 'Kelurahan Kandang Jati Kulon',
        'status'         => 'Disahkan',
        'published_date' => '2025-01-05',
    ],
];

echo "\n=== MEMBUAT DOKUMEN CONTOH ===\n";
foreach ($documents as $doc) {
    $existing = Document::where('title', $doc['title'])->first();
    if (!$existing) {
        Document::create($doc);
        echo "  ✅ Dokumen dibuat: {$doc['title']}\n";
    } else {
        echo "  ⏭️  Sudah ada: {$doc['title']}\n";
    }
}

echo "\n=== HASIL AKHIR ===\n";
echo "Total kategori dokumen : " . Category::where('module','dokumen')->count() . "\n";
echo "Total dokumen          : " . Document::count() . "\n";
echo "\n✅ Selesai! Buka halaman /dokumen di website untuk melihat hasilnya.\n";
