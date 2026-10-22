<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Str;

function getOrCreateCategory($name, $module = 'berita', $order = 1) {
    $slug = Str::slug($name);
    $existing = Category::where('slug', $slug)->first();
    if ($existing) {
        return $existing;
    }
    return Category::create([
        'name' => $name,
        'slug' => $slug,
        'module' => $module,
        'status' => 'aktif',
        'order' => $order
    ]);
}

$cat1 = getOrCreateCategory('Informasi Publik', 'berita', 1);
$cat2 = getOrCreateCategory('Kegiatan Kelurahan', 'berita', 2);
$cat3 = getOrCreateCategory('Pemberdayaan Masyarakat', 'berita', 3);
$cat4 = getOrCreateCategory('Pembangunan & Sarpras', 'berita', 4);

if (Post::count() === 0) {
    $post1 = Post::create([
        'title' => 'Rapat Koordinasi Kelurahan Terkait Pelayanan Administrasi Warga 2026',
        'slug' => 'rapat-koordinasi-kelurahan-terkait-pelayanan-administrasi-warga-2026',
        'category_id' => $cat1->id,
        'category' => $cat1->name,
        'author' => 'Rahmat Maulana (Admin)',
        'excerpt' => 'Kelurahan Kandang Jati Kulon mengadakan rapat koordinasi bersama tokoh masyarakat dan RT/RW untuk optimalisasi layanan publik.',
        'thumbnail' => 'https://images.unsplash.com/photo-1577962917302-cd874c4e31d2?q=80&w=800&auto=format&fit=crop',
        'content' => '<p>Kelurahan Kandang Jati Kulon mengadakan rapat koordinasi bersama pengurus RT/RW, tokoh masyarakat, dan perangkat kelurahan guna meningkatkan efektivitas serta kualitas pelayanan administrasi kependudukan bagi seluruh warga.</p><p>Lurah Kandang Jati Kulon menyampaikan komitmen bahwa seluruh bentuk pengurusan dokumen seperti pengantar KTP, Kartu Keluarga, dan Surat Keterangan Administrasi Pelayanan akan dilayani secara cepat, transparan, dan akuntabel.</p><p>Melalui sistem informasi digital kelurahan ini, diharapkan sinergi antara pemerintah kelurahan dan masyarakat dapat terus terjalin secara harmonis demi mewujudkan Kandang Jati Kulon yang lebih maju, rapi, dan sejahtera.</p>',
        'published_at' => now()->subDays(2),
    ]);
    $post1->created_at = now()->subDays(2);
    $post1->save();

    $post2 = Post::create([
        'title' => 'Kegiatan Kerja Bakti & Penguatan Sanitasi Lingkungan RT 02 / RW 01',
        'slug' => 'kegiatan-kerja-bakti-penguatan-sanitasi-lingkungan-rt-02-rw-01',
        'category_id' => $cat2->id,
        'category' => $cat2->name,
        'author' => 'Rahmat Maulana (Admin)',
        'excerpt' => 'Aksi gotong royong dan pembersihan selokan lingkungan oleh warga Kandang Jati Kulon guna mengantisipasi genangan air.',
        'thumbnail' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop',
        'content' => '<p>Masyarakat Kelurahan Kandang Jati Kulon bersama aparatur kelurahan dan pemuda setempat melaksanakan kegiatan kerja bakti gotong royong di lingkungan RT 02 / RW 01.</p><p>Fokus kegiatan melingkupi pembersihan saluran air (drainase), perapihan fasilitas umum, serta pemilahan sampah organik dan anorganik untuk menjaga kebersihan dan kesehatan lingkungan pemukiman.</p><p>Lurah menyampaikan apresiasi yang tinggi atas semangat kebersamaan dan kekompakan warga dalam menjaga ketertiban serta keindahan lingkungan tempat tinggal.</p>',
        'published_at' => now()->subDays(5),
    ]);
    $post2->created_at = now()->subDays(5);
    $post2->save();

    $post3 = Post::create([
        'title' => 'Sosialisasi Program Pemberdayaan Ekonomi Kreatif UMKM Kelurahan',
        'slug' => 'sosialisasi-program-pemberdayaan-ekonomi-kreatif-umkm-kelurahan',
        'category_id' => $cat3->id,
        'category' => $cat3->name,
        'author' => 'Rahmat Maulana (Admin)',
        'excerpt' => 'Pelatihan pemasaran digital dan pendataan izin usaha gratis bagi para pelaku UMKM lokal Kandang Jati Kulon.',
        'thumbnail' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80&w=800&auto=format&fit=crop',
        'content' => '<p>Dalam rangka mendorong kemandirian ekonomi masyarakat, Kelurahan Kandang Jati Kulon menyelenggarakan Sosialisasi & Pendampingan Pemasaran Digital bagi para pelaku Usaha Mikro, Kecil, dan Menengah (UMKM).</p><p>Acara ini menghadirkan narasumber pendamping UMKM Kabupaten Probolinggo untuk memberikan materi seputar pendaftaran NIB (Nomor Induk Berusaha), kemasan produk higienis, serta optimalisasi media sosial untuk penjualan online.</p><p>Diharapkan melalui kegiatan ini, produk unggulan warga Kandang Jati Kulon mampu bersaing di pasar yang lebih luas dan meningkatkan kesejahteraan ekonomi keluarga.</p>',
        'published_at' => now()->subDays(10),
    ]);
    $post3->created_at = now()->subDays(10);
    $post3->save();

    echo "Successfully seeded " . Post::count() . " initial posts!\n";
} else {
    echo "Posts already exist in DB (" . Post::count() . ").\n";
}
