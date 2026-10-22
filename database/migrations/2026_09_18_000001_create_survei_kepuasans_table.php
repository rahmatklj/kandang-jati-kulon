<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('survei_kepuasans', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun')->default(2026);
            $table->string('periode')->default('Semester I - 2026');
            $table->string('title')->default('Survei Kepuasan Masyarakat (SKM) Semester I Tahun 2026');
            $table->decimal('ikm_score', 5, 2)->default(88.45); // Konversi IKM (scale 25 - 100)
            $table->string('mutu_layanan')->default('A (Sangat Baik)'); // A - Sangat Baik, B - Baik, C - Kurang Baik, D - Buruk
            $table->integer('total_responden')->default(320);
            
            // 9 Unsur SKM (PermenPAN-RB No. 14/2017) Skala 1.00 - 4.00
            $table->decimal('u1_persyaratan', 4, 2)->default(3.55); // Kesesuaian Persyaratan
            $table->decimal('u2_prosedur', 4, 2)->default(3.48);    // Kemudahan Prosedur
            $table->decimal('u3_waktu', 4, 2)->default(3.40);       // Kecepatan Waktu Pelayanan
            $table->decimal('u4_biaya', 4, 2)->default(4.00);       // Ketepatan Biaya / Gratis
            $table->decimal('u5_produk', 4, 2)->default(3.60);      // Kesesuaian Produk Layanan
            $table->decimal('u6_kompetensi', 4, 2)->default(3.52);  // Kompetensi Petugas
            $table->decimal('u7_perilaku', 4, 2)->default(3.65);    // Perilaku / Kesopanan Petugas
            $table->decimal('u8_pengaduan', 4, 2)->default(3.45);   // Penanganan Pengaduan
            $table->decimal('u9_sarpras', 4, 2)->default(3.50);     // Kualitas Sarana & Prasarana

            $table->string('pdf_file')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survei_kepuasans');
    }
};
