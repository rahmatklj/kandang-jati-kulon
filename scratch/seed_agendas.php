<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Agenda;

// Clean out expired first
Agenda::purgeExpired();

if (Agenda::count() === 0) {
    Agenda::create([
        'title' => 'Musyawarah Perencanaan Pembangunan Kelurahan (Musrenbangkel) 2026/2027',
        'description' => 'Musyawarah tahunan penyusunan prioritas pembangunan fisik, sarana prasarana, serta pemberdayaan masyarakat tingkat kelurahan.',
        'date' => '2026-10-05',
        'end_date' => '2026-10-05',
        'time' => '09:00 WIB',
        'end_time' => '12:00 WIB',
        'location' => 'Aula Utama Kelurahan Kandang Jati Kulon',
        'organizer' => 'Seksi Pembangunan Kelurahan & BKM',
        'image' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=800&auto=format&fit=crop',
        'is_active' => true,
    ]);

    Agenda::create([
        'title' => 'Pelatihan Kewirausahaan & Manajemen Keuangan UMKM',
        'description' => 'Pelatihan praktis pengelolaan usaha kecil, pencatatan keuangan digital, dan pemasaran produk lokal warga kelurahan.',
        'date' => '2026-10-12',
        'end_date' => '2026-10-12',
        'time' => '08:30 WIB',
        'end_time' => '15:00 WIB',
        'location' => 'Pendopo Serbaguna RW 02 Kandang Jati Kulon',
        'organizer' => 'Seksi Pemberdayaan Masyarakat & TP PKK',
        'image' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80&w=800&auto=format&fit=crop',
        'is_active' => true,
    ]);

    Agenda::create([
        'title' => 'Pemeriksaan Kesehatan Gratis & Posyandu Lansia Terintegrasi',
        'description' => 'Layanan pemeriksaan gula darah, tekanan darah, penimbangan lansia & balita, serta konseling gizi masyarakat.',
        'date' => '2026-10-20',
        'end_date' => '2026-10-20',
        'time' => '08:00 WIB',
        'end_time' => '11:30 WIB',
        'location' => 'Posyandu Melati RW 03 Kandang Jati Kulon',
        'organizer' => 'Puskesmas & Kader Kesehatan Kelurahan',
        'image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=800&auto=format&fit=crop',
        'is_active' => true,
    ]);

    echo "Successfully seeded " . Agenda::count() . " active agendas!\n";
} else {
    echo "Agendas already exist in DB (" . Agenda::count() . ").\n";
}
