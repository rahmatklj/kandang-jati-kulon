<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SurveiKepuasan;

class SurveiKepuasanSeeder extends Seeder
{
    public function run(): void
    {
        if (SurveiKepuasan::count() === 0) {
            SurveiKepuasan::create([
                'tahun' => 2026,
                'periode' => 'Semester I - 2026',
                'title' => 'Survei Kepuasan Masyarakat (SKM) Semester I Tahun 2026',
                'ikm_score' => 88.45,
                'mutu_layanan' => 'A (Sangat Baik)',
                'total_responden' => 320,
                'u1_persyaratan' => 3.55,
                'u2_prosedur' => 3.48,
                'u3_waktu' => 3.40,
                'u4_biaya' => 4.00,
                'u5_produk' => 3.60,
                'u6_kompetensi' => 3.52,
                'u7_perilaku' => 3.65,
                'u8_pengaduan' => 3.45,
                'u9_sarpras' => 3.50,
                'pdf_file' => null,
                'is_active' => true,
            ]);
        }
    }
}
