<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Traits\HasFileCleanup;

class SurveiKepuasan extends Model
{
    use HasFactory, HasFileCleanup;

    protected $table = 'survei_kepuasans';

    protected $fillable = [
        'tahun',
        'periode',
        'title',
        'ikm_score',
        'mutu_layanan',
        'total_responden',
        'u1_persyaratan',
        'u2_prosedur',
        'u3_waktu',
        'u4_biaya',
        'u5_produk',
        'u6_kompetensi',
        'u7_perilaku',
        'u8_pengaduan',
        'u9_sarpras',
        'pdf_file',
        'is_active',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'total_responden' => 'integer',
        'ikm_score' => 'float',
        'u1_persyaratan' => 'float',
        'u2_prosedur' => 'float',
        'u3_waktu' => 'float',
        'u4_biaya' => 'float',
        'u5_produk' => 'float',
        'u6_kompetensi' => 'float',
        'u7_perilaku' => 'float',
        'u8_pengaduan' => 'float',
        'u9_sarpras' => 'float',
        'is_active' => 'boolean',
    ];

    /**
     * Hitung nilai konversi IKM (scale 25 - 100) dari 9 unsur
     */
    public function getCalculatedIkmAttribute(): float
    {
        $sum = $this->u1_persyaratan +
               $this->u2_prosedur +
               $this->u3_waktu +
               $this->u4_biaya +
               $this->u5_produk +
               $this->u6_kompetensi +
               $this->u7_perilaku +
               $this->u8_pengaduan +
               $this->u9_sarpras;

        $nrr = $sum / 9.0;
        return round($nrr * 25.0, 2);
    }

    /**
     * Tentukan Mutu Layanan berdasarkan nilai IKM Konversi (PermenPAN-RB No. 14/2017)
     */
    public static function determineMutuLayanan(float $ikmScore): string
    {
        if ($ikmScore >= 88.31) {
            return 'A (Sangat Baik)';
        } elseif ($ikmScore >= 76.61) {
            return 'B (Baik)';
        } elseif ($ikmScore >= 65.00) {
            return 'C (Kurang Baik)';
        } else {
            return 'D (Buruk)';
        }
    }

    /**
     * Get URL Berkas PDF Report
     */
    public function getPdfUrlAttribute(): ?string
    {
        if (!$this->pdf_file) {
            return null;
        }

        if (Str::startsWith($this->pdf_file, ['http://', 'https://'])) {
            return $this->pdf_file;
        }

        return Storage::url($this->pdf_file);
    }

    /**
     * Array label 9 Unsur Pelayanan
     */
    public static function getUnsurLabels(): array
    {
        return [
            'u1_persyaratan' => [
                'code' => 'U1',
                'title' => 'Kesesuaian Persyaratan',
                'desc' => 'Kesesuaian berkas dan dokumen persyaratan pelayanan dengan standar yang ditetapkan.'
            ],
            'u2_prosedur' => [
                'code' => 'U2',
                'title' => 'Kemudahan Prosedur',
                'desc' => 'Kemudahan alur dan tahapan tata cara pelayanan bagi masyarakat.'
            ],
            'u3_waktu' => [
                'code' => 'U3',
                'title' => 'Kecepatan Waktu Pelayanan',
                'desc' => 'Kecepatan waktu penyelesaian pengurusan dokumen dan surat keterangan.'
            ],
            'u4_biaya' => [
                'code' => 'U4',
                'title' => 'Ketepatan Tarif / Biaya (Gratis)',
                'desc' => 'Kesesuaian biaya pelayanan (seluruh pelayanan administrasi kelurahan Rp 0,- / Gratis).'
            ],
            'u5_produk' => [
                'code' => 'U5',
                'title' => 'Kesesuaian Produk Layanan',
                'desc' => 'Kesesuaian hasil/keluaran dokumen yang diterima dengan ketentuan yang dijanjikan.'
            ],
            'u6_kompetensi' => [
                'code' => 'U6',
                'title' => 'Kompetensi Petugas',
                'desc' => 'Kemampuan, keahlian, dan penguasaan materi pelayanan oleh petugas kelurahan.'
            ],
            'u7_perilaku' => [
                'code' => 'U7',
                'title' => 'Perilaku & Kesopanan Petugas',
                'desc' => 'Sikap ramah, sopan, komunikatif, dan responsif dalam memberikan pelayanan.'
            ],
            'u8_pengaduan' => [
                'code' => 'U8',
                'title' => 'Penanganan Pengaduan',
                'desc' => 'Kecepatan dan tindak lanjut penanganan keluhan/saran masyarakat.'
            ],
            'u9_sarpras' => [
                'code' => 'U9',
                'title' => 'Kualitas Sarana & Prasarana',
                'desc' => 'Kenyamanan ruang tunggu, kebersihan kantor, serta fasilitas penunjang pelayanan.'
            ],
        ];
    }
}
