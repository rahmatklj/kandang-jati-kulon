<?php
use App\Models\NavigationMenu;
use Illuminate\Support\Facades\DB;

// Clear existing menus
DB::table('navigation_menus')->truncate();

// 1. HOME
NavigationMenu::create([
    'title' => 'HOME',
    'url' => '/',
    'parent_id' => null,
    'sort_order' => 1,
    'is_active' => true,
]);

// 2. PROFIL
$profil = NavigationMenu::create([
    'title' => 'PROFIL',
    'url' => '#',
    'parent_id' => null,
    'sort_order' => 2,
    'is_active' => true,
]);
NavigationMenu::create([
    'title' => 'Visi & Misi',
    'url' => '/profil/visi-misi',
    'parent_id' => $profil->id,
    'sort_order' => 1,
    'is_active' => true,
    'show_on_homepage' => true,
    'description' => 'Arah kebijakan strategis, komitmen pelayanan, dan sasaran prioritas pembangunan Kelurahan Kandang Jati Kulon.',
]);
NavigationMenu::create([
    'title' => 'Struktur Organisasi',
    'url' => '/profil/struktur-organisasi',
    'parent_id' => $profil->id,
    'sort_order' => 2,
    'is_active' => true,
    'show_on_homepage' => true,
    'description' => 'Bagan susunan organisasi, susunan aparatur pemerintahan, dan tata kerja Kelurahan Kandang Jati Kulon.',
]);
NavigationMenu::create([
    'title' => 'Sejarah Kelurahan',
    'url' => '/profil/sejarah',
    'parent_id' => $profil->id,
    'sort_order' => 3,
    'is_active' => true,
    'show_on_homepage' => true,
    'description' => 'Histori singkat kepemimpinan, asal usul wilayah, dan rekam jejak pembangunan Kelurahan Kandang Jati Kulon.',
]);
NavigationMenu::create([
    'title' => 'Demografi & Statistik',
    'url' => '/profil/demografi',
    'parent_id' => $profil->id,
    'sort_order' => 4,
    'is_active' => true,
]);

// 3. LAYANAN
$layanan = NavigationMenu::create([
    'title' => 'LAYANAN',
    'url' => '#',
    'parent_id' => null,
    'sort_order' => 3,
    'is_active' => true,
]);
NavigationMenu::create([
    'title' => 'Standar Pelayanan & SOP',
    'url' => '/layanan',
    'parent_id' => $layanan->id,
    'sort_order' => 1,
    'is_active' => true,
]);
NavigationMenu::create([
    'title' => 'Layanan Surat Keterangan',
    'url' => '/layanan',
    'parent_id' => $layanan->id,
    'sort_order' => 2,
    'is_active' => true,
]);

// 4. DOKUMEN
$dokumen = NavigationMenu::create([
    'title' => 'DOKUMEN',
    'url' => '#',
    'parent_id' => null,
    'sort_order' => 4,
    'is_active' => true,
]);
NavigationMenu::create([
    'title' => 'Transparansi APBD',
    'url' => '/informasi/apbd',
    'parent_id' => $dokumen->id,
    'sort_order' => 1,
    'is_active' => true,
]);
NavigationMenu::create([
    'title' => 'Dokumen Musrenbang',
    'url' => '/dokumen/musrenbang',
    'parent_id' => $dokumen->id,
    'sort_order' => 2,
    'is_active' => true,
]);
NavigationMenu::create([
    'title' => 'Renstra & Renja',
    'url' => '/dokumen/renstra-renja',
    'parent_id' => $dokumen->id,
    'sort_order' => 3,
    'is_active' => true,
]);
NavigationMenu::create([
    'title' => 'SK Kelembagaan',
    'url' => '/dokumen/sk-kelembagaan',
    'parent_id' => $dokumen->id,
    'sort_order' => 4,
    'is_active' => true,
]);

// 5. INFORMASI
$informasi = NavigationMenu::create([
    'title' => 'INFORMASI',
    'url' => '#',
    'parent_id' => null,
    'sort_order' => 5,
    'is_active' => true,
]);
NavigationMenu::create([
    'title' => 'Warta & Berita',
    'url' => '/berita',
    'parent_id' => $informasi->id,
    'sort_order' => 1,
    'is_active' => true,
]);
NavigationMenu::create([
    'title' => 'Agenda Kegiatan',
    'url' => '/agenda',
    'parent_id' => $informasi->id,
    'sort_order' => 2,
    'is_active' => true,
]);
NavigationMenu::create([
    'title' => 'Galeri Foto',
    'url' => '/galeri',
    'parent_id' => $informasi->id,
    'sort_order' => 3,
    'is_active' => true,
]);
NavigationMenu::create([
    'title' => 'Dokumentasi Video',
    'url' => '/video',
    'parent_id' => $informasi->id,
    'sort_order' => 4,
    'is_active' => true,
]);

// 6. KELEMBAGAAN
$lembaga = NavigationMenu::create([
    'title' => 'KELEMBAGAAN',
    'url' => '#',
    'parent_id' => null,
    'sort_order' => 6,
    'is_active' => true,
]);
NavigationMenu::create([
    'title' => 'Profil Lembaga Kelurahan',
    'url' => '/lembaga',
    'parent_id' => $lembaga->id,
    'sort_order' => 1,
    'is_active' => true,
]);
NavigationMenu::create([
    'title' => 'Data RT & RW',
    'url' => '/profil/demografi',
    'parent_id' => $lembaga->id,
    'sort_order' => 2,
    'is_active' => true,
]);

echo "Navigation Menu successfully seeded!\n";
