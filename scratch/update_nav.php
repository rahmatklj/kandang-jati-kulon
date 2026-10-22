<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\NavigationMenu;
use App\Models\Setting;

// Get WhatsApp number from settings
$waRaw = Setting::where('key', 'whatsapp')->value('value') 
    ?? Setting::where('key', 'wa_number')->value('value') 
    ?? '6281234567890';
$waNumOnly = preg_replace('/[^0-9]/', '', $waRaw);
if (str_starts_with($waNumOnly, '0')) {
    $waNumOnly = '62' . substr($waNumOnly, 1);
}
$halloSaeUrl = "https://wa.me/{$waNumOnly}";

// 1. Find or create INFORMASI parent
$informasi = NavigationMenu::where('title', 'INFORMASI')
    ->orWhere('title', 'Informasi')
    ->whereNull('parent_id')
    ->first();

if ($informasi) {
    // Make sure /lembaga is inside INFORMASI
    $existLembaga = NavigationMenu::where('parent_id', $informasi->id)
        ->where('url', '/lembaga')
        ->first();
    
    if (!$existLembaga) {
        $maxOrder = NavigationMenu::where('parent_id', $informasi->id)->max('order') ?? 0;
        NavigationMenu::create([
            'title' => 'Lembaga Kemasyarakatan',
            'url' => '/lembaga',
            'parent_id' => $informasi->id,
            'order' => $maxOrder + 1,
            'target' => '_self',
            'is_active' => true,
        ]);
    }
}

// 2. Find KELEMBAGAAN or HUBUNGI parent
$kelembagaan = NavigationMenu::where('title', 'KELEMBAGAAN')
    ->orWhere('title', 'Kelembagaan')
    ->whereNull('parent_id')
    ->first();

if (!$kelembagaan) {
    $kelembagaan = NavigationMenu::where('title', 'HUBUNGI')
        ->orWhere('title', 'Hubungi')
        ->whereNull('parent_id')
        ->first();
}

if (!$kelembagaan) {
    $maxOrder = NavigationMenu::whereNull('parent_id')->max('order') ?? 5;
    $kelembagaan = NavigationMenu::create([
        'title' => 'HUBUNGI',
        'url' => '#',
        'order' => $maxOrder + 1,
        'target' => '_self',
        'is_active' => true,
    ]);
} else {
    $kelembagaan->update([
        'title' => 'HUBUNGI',
        'url' => '#',
    ]);
}

// 3. Move old children of kelembagaan (if any) to INFORMASI if they are not SP4N / Hallo SAE / Kontak
$oldChildren = NavigationMenu::where('parent_id', $kelembagaan->id)->get();
foreach ($oldChildren as $c) {
    if (in_array(strtolower($c->title), ['sp4n lapor!', 'sp4n lapor', 'hallo sae', 'hallo sae (whatsapp)', 'kontak kami', 'kontak kelurahan'])) {
        $c->delete();
    } else {
        if ($informasi) {
            $maxOrder = NavigationMenu::where('parent_id', $informasi->id)->max('order') ?? 0;
            $c->update([
                'parent_id' => $informasi->id,
                'order' => $maxOrder + 1
            ]);
        }
    }
}

// 4. Create new children for HUBUNGI dropdown:
// - SP4N LAPOR!
// - Hallo SAE (Terhubung ke WA)
// - Kontak Kami
NavigationMenu::create([
    'title' => 'SP4N LAPOR!',
    'url' => 'https://www.lapor.go.id',
    'parent_id' => $kelembagaan->id,
    'order' => 1,
    'target' => '_blank',
    'is_active' => true,
    'description' => 'Layanan Pengaduan Pelayanan Publik Nasional (SP4N LAPOR!)'
]);

NavigationMenu::create([
    'title' => 'Hallo SAE',
    'url' => $halloSaeUrl,
    'parent_id' => $kelembagaan->id,
    'order' => 2,
    'target' => '_blank',
    'is_active' => true,
    'description' => 'Layanan Pengaduan & Informasi Cepat via WhatsApp Hotline Kelurahan'
]);

NavigationMenu::create([
    'title' => 'Kontak Kelurahan',
    'url' => '/contact',
    'parent_id' => $kelembagaan->id,
    'order' => 3,
    'target' => '_self',
    'is_active' => true,
    'description' => 'Informasi Alamat, Telepon, Email, dan Google Maps Kantor Kelurahan'
]);

echo "Navigation Menu updated successfully!\n";
