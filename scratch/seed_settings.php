<?php
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

$defaults = [
    'site_title' => 'Website Resmi Kelurahan Kandang Jati Kulon | Kecamatan Kraksaan Kabupaten Probolinggo',
    'site_description' => 'Website Resmi Kelurahan Kandang Jati Kulon, Kecamatan Kraksaan, Kabupaten Probolinggo - Portal Informasi Publik dan Pelayanan Digital.',
    'agency_name' => 'Kelurahan Kandang Jati Kulon',
    'regency_name' => 'Kecamatan Kraksaan, Kabupaten Probolinggo',
    'logo_frontend' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e0/Lambang_Kabupaten_Probolinggo.jpg/440px-Lambang_Kabupaten_Probolinggo.jpg',
    'foto_lurah' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=600&auto=format&fit=crop',
    'kadin_photo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=600&auto=format&fit=crop',
    'nama_lurah' => 'Lurah Kandang Jati Kulon Kraksaan',
    'kadin_name' => 'Lurah Kandang Jati Kulon Kraksaan',
    'jabatan_lurah' => 'LURAH KANDANG JATI KULON',
    'kadin_title' => 'LURAH KANDANG JATI KULON',
    'sambutan_subtitle' => 'Sambutan Lurah Kandang Jati Kulon Kraksaan',
    'sambutan_title' => 'Melayani Warga Sepenuh Hati Menuju KELURAHAN KANDANG JATI KULON yang Maju, Sejahtera & Mandiri',
    'sambutan_isi' => 'Selamat Datang di Website Resmi Kelurahan Kandang Jati Kulon, Kecamatan Kraksaan, Kabupaten Probolinggo. Kami berkomitmen memberikan pelayanan publik terbaik, cepat, transparan, serta mengedepankan efisiensi administrasi kependudukan dan pemberdayaan ekonomi masyarakat.',
    'appd_title' => 'Portal APPD (Aplikasi Pelayanan Kelurahan Digital)',
    'appd_desc' => 'Sistem informasi pelayanan kemasyarakatan digital, terintegrasi data RT/RW, dan kemudahan pengajuan surat keterangan warga KELURAHAN KANDANG JATI KULON KRAKSAAN.',
    'appd_url' => '/layanan',
    'stat_apbd' => '1.250.000.000,-',
    'stat_penduduk' => '5.000',
    'stat_kk' => '1.420',
    'stat_rtrw' => '18 RT / 4 RW',
    'stat_luas' => '2,45 km²',
    'phone' => '(0335) 841234',
    'email' => 'kelurahankandangjatikulon@probolinggokab.go.id',
    'address' => 'Jl. Rayung Pelita No. 01, Kelurahan Kandang Jati Kulon, Kecamatan Kraksaan, Kabupaten Probolinggo',
    'hero_title_1' => 'Selamat Datang di Website Resmi',
    'hero_title_2' => 'Kelurahan Kandang Jati Kulon',
    'hero_subtitle' => 'Kelurahan Kandang Jati Kulon, Kecamatan Kraksaan, Kabupaten Probolinggo - Melayani Warga Sepenuh Hati, Cepat, Transparan, dan Bebas Pungli',
    'hero_tag' => 'INFORMASI RESMI KELURAHAN KANDANG JATI KULON',
    'hero_background' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=1920&auto=format&fit=crop',
];

foreach ($defaults as $key => $val) {
    DB::table('settings')->updateOrInsert(
        ['key' => $key],
        ['value' => $val, 'created_at' => now(), 'updated_at' => now()]
    );
}

echo "Settings successfully updated!\n";
