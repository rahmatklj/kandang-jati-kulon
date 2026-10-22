@extends('layouts.app')

@section('title', 'Laporan Hasil Survei Kepuasan Masyarakat (SKM) - Kelurahan Kandang Jati Kulon')

@section('content')

<!-- Banner Header Halaman -->
<section class="relative bg-gradient-to-br from-slate-950 via-slate-900 to-emerald-950 text-white py-14 overflow-hidden border-b border-emerald-900/40">
    <!-- Subtle Ambient Glow -->
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl">
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-4 font-medium">
                <a href="{{ route('home') }}" class="hover:text-emerald-400 transition">Beranda</a>
                <span>&rsaquo;</span>
                <span class="text-slate-300">Informasi</span>
                <span>&rsaquo;</span>
                <span class="text-emerald-400 font-bold">Survei Kepuasan Masyarakat (SKM)</span>
            </nav>

            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-emerald-500/20 text-emerald-300 text-[11px] font-extrabold uppercase tracking-widest rounded-full mb-4 border border-emerald-500/30">
                <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                Transparansi Mutu Pelayanan Publik
            </div>

            <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight mb-4">
                Laporan Hasil Survei Kepuasan Masyarakat (SKM / IKM)
            </h1>

            <p class="text-sm md:text-base text-slate-300 font-normal leading-relaxed max-w-3xl">
                Pengukuran tingkat kepuasan warga terhadap kualitas pelayanan publik di {{ $settings['agency_name'] ?? 'Kelurahan Kandang Jati Kulon' }} sesuai standar pedoman PermenPAN-RB Nomor 14 Tahun 2017.
            </p>
        </div>
    </div>
</section>

<!-- Filter & Main Content Section -->
<section class="py-12 bg-slate-50 min-h-screen">
    <div class="container mx-auto px-4">

        <!-- Toolbar Filter & Pemilih Periode -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0 border border-emerald-100 font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Periode Survei Aktif</span>
                    <h3 class="text-base font-extrabold text-slate-800">
                        {{ $selectedSurvei ? $selectedSurvei->title : 'Belum Ada Data Survei' }}
                    </h3>
                </div>
            </div>

            <form method="GET" action="{{ route('survei.index') }}" class="flex flex-wrap items-center gap-3">
                @if(isset($tahunList) && count($tahunList) > 0)
                <div class="flex items-center gap-2">
                    <label for="filterTahun" class="text-xs font-bold text-slate-600 uppercase shrink-0">Tahun:</label>
                    <select id="filterTahun" name="tahun" onchange="this.form.submit()" class="px-3.5 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800 bg-white">
                        <option value="">Semua Tahun</option>
                        @foreach($tahunList as $t)
                            <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>Tahun {{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                @if(isset($surveis) && count($surveis) > 1)
                <div class="flex items-center gap-2">
                    <label for="filterSurvei" class="text-xs font-bold text-slate-600 uppercase shrink-0">Pilih Periode:</label>
                    <select id="filterSurvei" name="survei_id" onchange="this.form.submit()" class="px-3.5 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800 bg-white">
                        @foreach($surveis as $s)
                            <option value="{{ $s->id }}" {{ ($selectedSurvei && $selectedSurvei->id == $s->id) ? 'selected' : '' }}>
                                {{ $s->periode }} (IKM: {{ number_format($s->ikm_score, 2) }})
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
            </form>
        </div>

        @if($selectedSurvei)
        <!-- Grid Ringkasan Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <!-- 1. Skor Nilai Konversi IKM -->
            <div class="bg-gradient-to-br from-emerald-600 to-emerald-800 rounded-2xl p-6 text-white shadow-xl shadow-emerald-900/20 relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition duration-500">
                    <svg class="w-32 h-32 fill-current" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                </div>
                <span class="text-emerald-200 text-xs font-bold uppercase tracking-wider block mb-1">Nilai Konversi IKM</span>
                <div class="text-4xl md:text-5xl font-black text-white tracking-tight mb-2">
                    {{ number_format($selectedSurvei->ikm_score, 2) }}
                    <span class="text-sm font-semibold text-emerald-200">/ 100</span>
                </div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/20 backdrop-blur-md rounded-lg text-xs font-extrabold uppercase tracking-wider text-white border border-white/30">
                    Mutu: {{ $selectedSurvei->mutu_layanan }}
                </div>
            </div>

            <!-- 2. Nilai Rata-Rata Terimbang (NRR) -->
            @php
                $nrrRaw = round(($selectedSurvei->ikm_score / 25.0), 2);
            @endphp
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-slate-500 text-xs font-bold uppercase tracking-wider block">Nilai Kinerja (NRR)</span>
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">Skala 4</div>
                </div>
                <div class="text-3xl md:text-4xl font-extrabold text-slate-800 mb-2">
                    {{ number_format($nrrRaw, 2) }}
                    <span class="text-xs font-semibold text-slate-400">/ 4.00</span>
                </div>
                <p class="text-xs text-slate-500 font-medium">Nilai rata-rata dari 9 unsur pelayanan publik.</p>
            </div>

            <!-- 3. Total Responden Warga -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-slate-500 text-xs font-bold uppercase tracking-wider block">Partisipasi Responden</span>
                    <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                </div>
                <div class="text-3xl md:text-4xl font-extrabold text-slate-800 mb-2">
                    {{ number_format($selectedSurvei->total_responden) }}
                    <span class="text-xs font-semibold text-slate-400">Orang</span>
                </div>
                <p class="text-xs text-slate-500 font-medium">Masyarakat pengguna layanan kelurahan.</p>
            </div>

            <!-- 4. Berkas Laporan PDF -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                <div>
                    <span class="text-slate-500 text-xs font-bold uppercase tracking-wider block mb-1">Dokumen Laporan SKM</span>
                    <div class="text-sm font-bold text-slate-800 mb-2 line-clamp-1">{{ $selectedSurvei->periode }}</div>
                </div>
                @if($selectedSurvei->pdf_file)
                <a href="{{ route('survei.download', $selectedSurvei->id) }}" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Unduh Berkas Laporan PDF
                </a>
                @else
                <button disabled class="w-full py-2.5 bg-slate-100 text-slate-400 font-bold text-xs rounded-xl cursor-not-allowed">
                    PDF Belum Diunggah
                </button>
                @endif
            </div>
        </div>

        <!-- Section Breakdown 9 Unsur Pelayanan -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-12">
            <div class="bg-slate-900 text-white px-6 py-5 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h3 class="text-lg font-black tracking-tight text-white">Capaian 9 Unsur Standar Pelayanan Publik</h3>
                    <p class="text-slate-400 text-xs mt-0.5">Rincian nilai persepsi masyarakat pada tiap elemen pelayanan kelurahan (Skala 1 - 4 & Konversi 25 - 100).</p>
                </div>
                <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-xs font-extrabold uppercase rounded-full border border-emerald-500/30 shrink-0">
                    PermenPAN-RB No. 14/2017
                </span>
            </div>

            <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($unsurLabels as $field => $info)
                    @php
                        $valRaw = floatval($selectedSurvei->$field ?? 3.50);
                        $valConverted = round($valRaw * 25.0, 2);
                        $mutuUnsur = \App\Models\SurveiKepuasan::determineMutuLayanan($valConverted);
                    @endphp
                    <div class="p-5 bg-slate-50 rounded-2xl border border-slate-200/80 space-y-3 hover:border-emerald-400 hover:shadow-md transition">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 font-black text-xs rounded-lg uppercase tracking-wider">
                                {{ $info['code'] }}
                            </span>
                            <span class="text-xs font-bold text-slate-600 bg-white px-2 py-0.5 rounded border border-slate-200">
                                {{ $mutuUnsur }}
                            </span>
                        </div>

                        <div>
                            <h4 class="font-extrabold text-sm text-slate-800 leading-snug">{{ $info['title'] }}</h4>
                            <p class="text-[11.5px] text-slate-500 leading-relaxed mt-1 line-clamp-2">{{ $info['desc'] }}</p>
                        </div>

                        <!-- Progress Bar Visual -->
                        <div class="space-y-1.5 pt-1">
                            <div class="flex items-center justify-between text-xs font-extrabold">
                                <span class="text-slate-700">Skor: {{ number_format($valRaw, 2) }} / 4.00</span>
                                <span class="text-emerald-700">{{ number_format($valConverted, 2) }}</span>
                            </div>
                            <div class="w-full h-3 bg-slate-200 rounded-full overflow-hidden shadow-inner">
                                <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full transition-all duration-700"
                                     style="width: {{ min(100, max(0, $valConverted)) }}%;"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tabel Referensi Mutu Layanan SKM PermenPAN-RB -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8">
            <h3 class="text-base font-extrabold text-slate-800 mb-1">Pedoman Skala Penilaian & Mutu Pelayanan (PermenPAN-RB No. 14/2017)</h3>
            <p class="text-xs text-slate-500 mb-6">Tabel acuan penetapan mutu kinerja pelayanan publik berdasarkan rentang nilai konversi IKM.</p>

            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left text-slate-700 border border-slate-200 rounded-xl overflow-hidden">
                    <thead class="bg-slate-900 text-white uppercase tracking-wider font-bold">
                        <tr>
                            <th class="px-4 py-3 text-center border-r border-slate-800">Nilai Persepsi (1 - 4)</th>
                            <th class="px-4 py-3 text-center border-r border-slate-800">Nilai Konversi IKM (25 - 100)</th>
                            <th class="px-4 py-3 text-center border-r border-slate-800">Mutu Pelayanan</th>
                            <th class="px-4 py-3 text-center">Kinerja Unit Pelayanan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <tr class="bg-emerald-50/70 font-semibold">
                            <td class="px-4 py-3 text-center border-r border-slate-200 font-bold text-emerald-800">3,53 - 4,00</td>
                            <td class="px-4 py-3 text-center border-r border-slate-200 font-black text-emerald-700">88,31 - 100,00</td>
                            <td class="px-4 py-3 text-center border-r border-slate-200 font-bold text-emerald-800">A</td>
                            <td class="px-4 py-3 text-center font-extrabold text-emerald-700">Sangat Baik</td>
                        </tr>
                        <tr class="bg-white">
                            <td class="px-4 py-3 text-center border-r border-slate-200 font-bold">3,07 - 3,52</td>
                            <td class="px-4 py-3 text-center border-r border-slate-200 font-bold text-blue-700">76,61 - 88,30</td>
                            <td class="px-4 py-3 text-center border-r border-slate-200 font-bold text-blue-800">B</td>
                            <td class="px-4 py-3 text-center font-bold text-blue-700">Baik</td>
                        </tr>
                        <tr class="bg-slate-50">
                            <td class="px-4 py-3 text-center border-r border-slate-200 font-bold">2,60 - 3,06</td>
                            <td class="px-4 py-3 text-center border-r border-slate-200 font-bold text-amber-700">65,00 - 76,60</td>
                            <td class="px-4 py-3 text-center border-r border-slate-200 font-bold text-amber-800">C</td>
                            <td class="px-4 py-3 text-center font-bold text-amber-700">Kurang Baik</td>
                        </tr>
                        <tr class="bg-white">
                            <td class="px-4 py-3 text-center border-r border-slate-200 font-bold text-rose-700">1,00 - 2,59</td>
                            <td class="px-4 py-3 text-center border-r border-slate-200 font-bold text-rose-700">25,00 - 64,99</td>
                            <td class="px-4 py-3 text-center border-r border-slate-200 font-bold text-rose-800">D</td>
                            <td class="px-4 py-3 text-center font-bold text-rose-700">Buruk</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="bg-white rounded-3xl p-12 text-center border-2 border-dashed border-slate-200 text-slate-400">
            <svg class="w-16 h-16 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            <h3 class="text-base font-bold text-slate-700">Belum Ada Data Hasil Survei SKM</h3>
            <p class="text-xs text-slate-400 mt-1">Silakan kelola data survei melalui Panel Admin Dashboard.</p>
        </div>
        @endif

    </div>
</section>

@endsection
