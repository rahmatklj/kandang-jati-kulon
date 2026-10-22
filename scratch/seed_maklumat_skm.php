<?php
use App\Models\Maklumat;
use App\Models\SurveiKepuasan;

if (Maklumat::count() === 0) {
    Maklumat::create([
        'title' => 'Maklumat Pelayanan Publik',
        'subtitle' => 'Komitmen Standard Mutu & Kepastian Layanan',
        'content' => 'Dengan ini kami menyatakan sanggup menyelenggarakan pelayanan publik sesuai standar pelayanan yang telah ditetapkan, dan apabila tidak menepati janji, kami siap menerima sanksi sesuai dengan ketentuan peraturan perundang-undangan yang berlaku.',
        'signer_name' => 'Lurah Kandang Jati Kulon',
        'signer_title' => 'Kepala Kelurahan Kandang Jati Kulon',
        'is_active' => true,
    ]);
    echo "Maklumat created successfully.\n";
} else {
    $m = Maklumat::first();
    $m->is_active = true;
    $m->save();
    echo "Maklumat updated to active.\n";
}

if (SurveiKepuasan::count() === 0) {
    SurveiKepuasan::create([
        'tahun' => 2026,
        'periode' => 'Semester I 2026',
        'title' => 'Hasil Survei Kepuasan Masyarakat (SKM)',
        'ikm_score' => 88.50,
        'mutu_layanan' => 'A (Sangat Baik)',
        'total_responden' => 350,
        'u1_persyaratan' => 3.55,
        'u2_prosedur' => 3.50,
        'u3_waktu' => 3.48,
        'u4_biaya' => 4.00,
        'u5_produk' => 3.52,
        'u6_kompetensi' => 3.58,
        'u7_perilaku' => 3.60,
        'u8_pengaduan' => 3.50,
        'u9_sarpras' => 3.45,
        'is_active' => true,
    ]);
    echo "SurveiKepuasan created successfully.\n";
} else {
    $s = SurveiKepuasan::first();
    $s->is_active = true;
    $s->save();
    echo "SurveiKepuasan updated to active.\n";
}
