<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Lembaga;

$initialLembagas = [
    [
        'name' => 'Lembaga Pemberdayaan Masyarakat (LPMK)',
        'abbreviation' => 'LPMK',
        'description' => 'Wadah partisipasi warga dalam menyusun rencana pembangunan, menampung aspirasi masyarakat, serta membantu Pemerintah Kelurahan Kandang Jati Kulon dalam pemberdayaan ekonomi dan infrastruktur swadaya.',
        'leader_title' => 'Ketua LPMK',
        'leader_name' => 'H. Moh. Ridwan, M.Pd',
        'members_count' => 25,
        'icon' => 'building',
        'color_theme' => 'emerald',
        'sort_order' => 1,
        'is_active' => true,
    ],
    [
        'name' => 'Tim Penggerak PKK Kelurahan',
        'abbreviation' => 'PKK',
        'description' => 'Gerakan pemberdayaan keluarga yang aktif mengelola 10 program pokok PKK, posyandu balita & lansia, ketahanan pangan keluarga, serta pelatihan UMKM kerajinan & boga ibu-ibu kelurahan.',
        'leader_title' => 'Ketua TP-PKK',
        'leader_name' => 'Ibu Hj. Siti Nuraisyah',
        'members_count' => 35,
        'icon' => 'user-female',
        'color_theme' => 'rose',
        'sort_order' => 2,
        'is_active' => true,
    ],
    [
        'name' => 'Karang Taruna Kandang Jati Mandiri',
        'abbreviation' => 'KARTAR',
        'description' => 'Wadah kepemudaan warga Kelurahan Kandang Jati Kulon dalam bidang olahraga, bakti sosial, pelestarian seni budaya, pelatihan kewirausahaan digital pemuda, dan pemuda tanggap bencana.',
        'leader_title' => 'Ketua Karang Taruna',
        'leader_name' => 'Mas Rizky Kurniawan, S.Pd',
        'members_count' => 40,
        'icon' => 'user-male',
        'color_theme' => 'blue',
        'sort_order' => 3,
        'is_active' => true,
    ],
    [
        'name' => 'Satlinmas & Tiga Pilar Kelurahan',
        'abbreviation' => 'LINMAS',
        'description' => 'Sinergi Kepala Kelurahan Kandang Jati Kulon, Babinsa TNI, Bhabinkamtibmas Polri, serta Anggota Satlinmas dalam mengawal keamanan poskamling, penanggulangan ketertiban umum, dan tanggap darurat bencana.',
        'leader_title' => 'Kasatgas Linmas',
        'leader_name' => 'Bapak Sertu Herman & Aiptu Didik',
        'members_count' => 18,
        'icon' => 'shield',
        'color_theme' => 'amber',
        'sort_order' => 4,
        'is_active' => true,
    ],
    [
        'name' => 'Posyandu Balita & Lansia Flamboyan',
        'abbreviation' => 'POSYANDU',
        'description' => 'Pusat pelayanan kesehatan masyarakat terpadu tingkat RW/RT di Kelurahan Kandang Jati Kulon yang menyelenggarakan pemantauan tumbuh kembang balita, imunisasi rutin, dan cek kesehatan lansia.',
        'leader_title' => 'Koordinator Posyandu',
        'leader_name' => 'Ibu Rahmawati, A.Md.Keb',
        'members_count' => 20,
        'icon' => 'building',
        'color_theme' => 'emerald',
        'sort_order' => 5,
        'is_active' => true,
    ],
];

foreach ($initialLembagas as $data) {
    Lembaga::updateOrCreate(
        ['name' => $data['name']],
        $data
    );
}

echo "Lembaga sample data seeded: " . Lembaga::count() . " items.\n";
