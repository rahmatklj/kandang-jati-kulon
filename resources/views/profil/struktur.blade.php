@extends('layouts.app')

@section('title', 'Struktur Organisasi - Kelurahan Kandang Jati Kulon')

@section('content')
<div class="bg-slate-100/70 min-h-screen pb-16" x-data="{ activeTupoksi: null }">

    <!-- Page Header (Deep Dark Theme) -->
    <div class="bg-[#0b1329] text-white border-b border-slate-800 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute left-1/4 -bottom-10 w-80 h-80 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="container mx-auto px-4 py-8 md:py-10 relative z-10">
            <!-- Breadcrumbs -->
            <nav class="flex text-xs text-slate-400 mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1.5 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center hover:text-emerald-400 transition font-medium">
                            <svg class="w-3.5 h-3.5 mr-1 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1.5 text-slate-400">Profil</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1.5 text-emerald-400 font-semibold">Struktur Organisasi</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-900/40 border border-emerald-500/30 rounded-full text-emerald-300 text-[11px] font-bold uppercase tracking-wider mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    Bagan Organisasi Kelurahan
                </div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white leading-tight mb-3">
                    Struktur Organisasi Kelurahan Kandang Jati Kulon
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-2xl">
                    Hierarki kepemimpinan, sekretariat, kepala seksi, serta staf aparatur Pemerintah Kelurahan Kandang Jati Kulon.
                </p>
            </div>
        </div>
    </div>

    <!-- Data Extract PHP Block -->
    @php
        $atasanVal = $settings['foto_atasan'] ?? '';
        $atasanSrc = $atasanVal ? (\Illuminate\Support\Str::startsWith($atasanVal, ['http://', 'https://']) ? $atasanVal : Storage::url($atasanVal)) : 'https://ui-avatars.com/api/?name=' . urlencode($settings['nama_atasan'] ?? 'Camat') . '&background=4338ca&color=fff&size=200';
        $atasanNama = $settings['nama_atasan'] ?? '';
        $atasanNip = $settings['nip_atasan'] ?? '';
        $atasanJabatan = $settings['jabatan_atasan'] ?? 'Camat Kraksaan';
        $atasanTupoksi = $settings['tupoksi_atasan'] ?? 'Pembinaan teknis kewilayahan, supervisi ketaatan hukum, pengawasan tata kelola pemerintahan kelurahan, dan perumusan kebijakan operasional tingkat kecamatan.';

        $lurahVal = $settings['foto_lurah'] ?? $settings['kadin_photo'] ?? '';
        $lurahSrc = $lurahVal ? (\Illuminate\Support\Str::startsWith($lurahVal, ['http://', 'https://']) ? $lurahVal : Storage::url($lurahVal)) : 'https://ui-avatars.com/api/?name=' . urlencode($settings['nama_lurah'] ?? 'Ahmad Syarif') . '&background=0f172a&color=fff&size=200';
        $lurahNama = $settings['nama_lurah'] ?? 'H. Ahmad Syarif, S.STP, M.Si';
        $lurahNip = $settings['nip_lurah'] ?? '';
        $lurahJabatan = $settings['jabatan_lurah'] ?? 'Lurah Kandang Jati Kulon';
        $lurahTupoksi = $settings['tupoksi_lurah'] ?? 'Memimpin, merencanakan, mengoordinasikan, dan mengendalikan penyelenggaraan pemerintahan kelurahan, pembangunan, pembinaan ketenteraman dan ketertiban umum, serta pelayanan publik dan pemberdayaan masyarakat.';

        $sekVal = $settings['foto_sekretaris'] ?? '';
        $sekSrc = $sekVal ? (\Illuminate\Support\Str::startsWith($sekVal, ['http://', 'https://']) ? $sekVal : Storage::url($sekVal)) : 'https://ui-avatars.com/api/?name=' . urlencode($settings['nama_sekretaris'] ?? 'Budi Santoso') . '&background=64748b&color=fff&size=200';
        $sekNama = $settings['nama_sekretaris'] ?? 'Budi Santoso, S.Sos';
        $sekNip = $settings['nip_sekretaris'] ?? '';
        $sekJabatan = $settings['jabatan_sekretaris'] ?? 'Sekretaris Kelurahan';
        $sekTupoksi = $settings['tupoksi_sekretaris'] ?? 'Melaksanakan pengelolaan administrasi umum, penyusunan program, keuangan, kepegawaian, perlengkapan, urusan dalam, serta pelayanan administratif untuk mendukung pelaksanaan tugas seluruh seksi di Kelurahan.';

        $pemVal = $settings['foto_kasi_pemerintahan'] ?? '';
        $pemSrc = $pemVal ? (\Illuminate\Support\Str::startsWith($pemVal, ['http://', 'https://']) ? $pemVal : Storage::url($pemVal)) : 'https://ui-avatars.com/api/?name=' . urlencode($settings['nama_kasi_pemerintahan'] ?? 'Hendra Setiawan') . '&background=64748b&color=fff&size=200';
        $pemNama = $settings['nama_kasi_pemerintahan'] ?? 'Hendra Setiawan, S.AP';
        $pemNip = $settings['nip_kasi_pemerintahan'] ?? '';
        $pemJabatan = $settings['jabatan_kasi_pemerintahan'] ?? 'Kasi Pemerintahan & Kesra';
        $pemTupoksi = $settings['tupoksi_kasi_pemerintahan'] ?? 'Mengelola dan menyelenggarakan administrasi pemerintahan umum, kependudukan, pencatatan sipil, pertanahan, ketentraman wilayah, pembinaan rukun tetangga/rukun warga, serta layanan keagrariaan.';

        $trantibVal = $settings['foto_kasi_trantib'] ?? '';
        $trantibSrc = $trantibVal ? (\Illuminate\Support\Str::startsWith($trantibVal, ['http://', 'https://']) ? $trantibVal : Storage::url($trantibVal)) : 'https://ui-avatars.com/api/?name=' . urlencode($settings['nama_kasi_trantib'] ?? 'M Rizky Pratama') . '&background=64748b&color=fff&size=200';
        $trantibNama = $settings['nama_kasi_trantib'] ?? 'M. Rizky Pratama, S.IP';
        $trantibNip = $settings['nip_kasi_trantib'] ?? '';
        $trantibJabatan = $settings['jabatan_kasi_trantib'] ?? 'Kasi Trantib';
        $trantibTupoksi = $settings['tupoksi_kasi_trantib'] ?? 'Melaksanakan pembinaan ketenteraman dan ketertiban umum, penegakan peraturan daerah, perlindungan masyarakat (Linmas), penanggulangan bencana, serta koordinasi kebersihan lingkungan.';

        $kesraVal = $settings['foto_kasi_kesra'] ?? '';
        $kesraSrc = $kesraVal ? (\Illuminate\Support\Str::startsWith($kesraVal, ['http://', 'https://']) ? $kesraVal : Storage::url($kesraVal)) : 'https://ui-avatars.com/api/?name=' . urlencode($settings['nama_kasi_kesra'] ?? 'Nurul Hidayah') . '&background=64748b&color=fff&size=200';
        $kesraNama = $settings['nama_kasi_kesra'] ?? 'Nurul Hidayah, SE., MM';
        $kesraNip = $settings['nip_kasi_kesra'] ?? '';
        $kesraJabatan = $settings['jabatan_kasi_kesra'] ?? 'Kasi Ekonomi & Pembangunan';
        $kesraTupoksi = $settings['tupoksi_kasi_kesra'] ?? 'Penyusunan bahan perumusan kebijakan teknis dan pelaksanaan kegiatan pembangunan infrastruktur pemukiman, pemberdayaan ekonomi masyarakat, keagamaan, pendidikan, dan kesehatan sosial.';

        $additionalAparatur = !empty($settings['additional_aparatur']) ? json_decode($settings['additional_aparatur'], true) : [];
        if (!is_array($additionalAparatur)) {
            $additionalAparatur = [];
        }

        $baganVal = $settings['gambar_bagan_struktur'] ?? '';
        $baganSrc = $baganVal ? (\Illuminate\Support\Str::startsWith($baganVal, ['http://', 'https://']) ? $baganVal : Storage::url($baganVal)) : '';
    @endphp

    <!-- Chart Container Wrapper -->
    <div class="container mx-auto px-4 pt-10 pb-8 max-w-7xl">

        <!-- Outer Box Canvas for Structure Tree -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 p-4 sm:p-8 md:p-12 space-y-12 overflow-x-auto">

            <!-- Optional Top Atasan / Camat Node if available -->
            @if($atasanNama)
            <div class="flex flex-col items-center">
                <div class="w-72 sm:w-80 bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm flex flex-col items-center text-center hover:border-blue-400 hover:shadow-md transition-all duration-200">
                    <div class="w-20 h-20 sm:w-22 sm:h-22 rounded-full border-4 border-indigo-600 overflow-hidden bg-slate-100 mb-3 shadow-xs shrink-0 flex items-center justify-center">
                        <img src="{{ $atasanSrc }}" alt="{{ $atasanNama }}" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-sm sm:text-base font-extrabold text-slate-900 tracking-tight leading-snug mb-1">{{ $atasanNama }}</h3>
                    <p class="text-[11px] font-mono text-slate-400 mb-2.5 min-h-[1rem]">@if($atasanNip) NIP. {{ $atasanNip }} @else &nbsp; @endif</p>
                    <span class="bg-indigo-900 text-white text-[10px] sm:text-[11px] font-black px-3.5 py-1 rounded-full uppercase tracking-wider mb-1 inline-block shadow-2xs">CAMAT / PEMBINA</span>
                    <p class="text-[11px] font-semibold text-slate-500 mb-4 tracking-wide">{{ $atasanJabatan }}</p>

                    <button @click="activeTupoksi = {
                        nama: '{{ addslashes($atasanNama) }}',
                        nip: '{{ addslashes($atasanNip) }}',
                        jabatan: '{{ addslashes($atasanJabatan) }}',
                        pill: 'CAMAT / PEMBINA',
                        subtitle: 'Pembina Wilayah Kecamatan',
                        photo: '{{ $atasanSrc }}',
                        tupoksi: '{{ addslashes($atasanTupoksi) }}'
                    }" class="px-3.5 py-1.5 text-[11px] font-bold text-blue-600 bg-white border border-blue-300 hover:border-blue-600 hover:bg-blue-50 rounded-xl transition duration-200 flex items-center justify-center gap-1.5 shadow-2xs w-full sm:w-auto">
                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Lihat TUPOKSI
                    </button>
                </div>
                <div class="w-0.5 h-8 bg-slate-300"></div>
            </div>
            @endif

            <!-- LEVEL 1: LURAH / KEPALA KELURAHAN (TOP CENTER) -->
            <div class="flex flex-col items-center">
                <!-- Lurah Card -->
                <div class="w-72 sm:w-84 bg-white rounded-2xl p-6 border border-slate-200/90 shadow-sm flex flex-col items-center text-center hover:border-blue-500 hover:shadow-md transition-all duration-200 relative group">
                    <!-- Circular Avatar -->
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full border-4 border-blue-600 overflow-hidden bg-slate-100 mb-3.5 shadow-xs shrink-0 flex items-center justify-center">
                        <img src="{{ $lurahSrc }}" alt="{{ $lurahNama }}" class="w-full h-full object-cover">
                    </div>
                    
                    <!-- Name -->
                    <h2 class="text-sm sm:text-base font-extrabold text-slate-900 tracking-tight leading-snug mb-1">{{ $lurahNama }}</h2>
                    
                    <!-- NIP -->
                    <p class="text-[11px] font-mono text-slate-400 mb-2.5 min-h-[1rem]">@if($lurahNip) NIP. {{ $lurahNip }} @else &nbsp; @endif</p>
                    
                    <!-- Pill Badge -->
                    <span class="bg-[#0f172a] text-white text-[10px] sm:text-[11px] font-black px-4 py-1.5 rounded-full uppercase tracking-wider mb-1.5 inline-block shadow-2xs">
                        {{ strtoupper($lurahJabatan) }}
                    </span>
                    
                    <!-- Subtitle -->
                    <p class="text-[11px] font-semibold text-slate-500 mb-4 tracking-wide">Kepala Pemerintahan Kelurahan</p>
                    
                    <!-- Button Tupoksi -->
                    <button @click="activeTupoksi = {
                        nama: '{{ addslashes($lurahNama) }}',
                        nip: '{{ addslashes($lurahNip) }}',
                        jabatan: '{{ addslashes($lurahJabatan) }}',
                        pill: '{{ addslashes(strtoupper($lurahJabatan)) }}',
                        subtitle: 'Kepala Pemerintahan Kelurahan',
                        photo: '{{ $lurahSrc }}',
                        tupoksi: '{{ addslashes($lurahTupoksi) }}'
                    }" class="px-4 py-1.5 text-[11px] font-bold text-blue-600 bg-white border border-blue-300 hover:border-blue-600 hover:bg-blue-50 rounded-xl transition duration-200 flex items-center justify-center gap-1.5 shadow-2xs w-full sm:w-auto">
                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Lihat TUPOKSI
                    </button>
                </div>

                <!-- Connector Line Down from Lurah -->
                <div class="w-0.5 h-8 bg-slate-300"></div>
            </div>

            <!-- LEVEL 2: SEKRETARIS & KASI (ROW OF 4 NODES WITH TREE CONNECTORS) -->
            <div class="relative w-full max-w-6xl mx-auto">
                <!-- Horizontal Connecting Line (Desktop) -->
                <div class="hidden lg:block absolute top-0 left-[12.5%] right-[12.5%] h-0.5 bg-slate-300"></div>

                <!-- Level 2 Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 relative">

                    <!-- Node 1: Sekretaris Lurah -->
                    <div class="flex flex-col items-center">
                        <div class="hidden lg:block w-0.5 h-6 bg-slate-300 -mt-6"></div>
                        <div class="w-full bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm flex flex-col items-center text-center hover:border-blue-500 hover:shadow-md transition-all duration-200 h-full justify-between">
                            <div class="flex flex-col items-center w-full">
                                <div class="w-20 h-20 rounded-full border-4 border-slate-200 overflow-hidden bg-slate-100 mb-3 shadow-xs shrink-0 flex items-center justify-center">
                                    <img src="{{ $sekSrc }}" alt="{{ $sekNama }}" class="w-full h-full object-cover">
                                </div>
                                <h3 class="text-sm font-extrabold text-slate-900 tracking-tight leading-snug mb-1">{{ $sekNama }}</h3>
                                <p class="text-[11px] font-mono text-slate-400 mb-2.5 min-h-[1rem]">@if($sekNip) NIP. {{ $sekNip }} @else &nbsp; @endif</p>
                                <span class="bg-[#0f172a] text-white text-[10px] font-black px-3.5 py-1 rounded-full uppercase tracking-wider mb-1 inline-block shadow-2xs">SEKRETARIS LURAH</span>
                                <p class="text-[11px] font-semibold text-slate-500 mb-4 tracking-wide">Sekretariat Kelurahan</p>
                            </div>
                            <button @click="activeTupoksi = {
                                nama: '{{ addslashes($sekNama) }}',
                                nip: '{{ addslashes($sekNip) }}',
                                jabatan: '{{ addslashes($sekJabatan) }}',
                                pill: 'SEKRETARIS LURAH',
                                subtitle: 'Sekretariat Kelurahan',
                                photo: '{{ $sekSrc }}',
                                tupoksi: '{{ addslashes($sekTupoksi) }}'
                            }" class="px-3.5 py-1.5 text-[11px] font-bold text-blue-600 bg-white border border-blue-300 hover:border-blue-600 hover:bg-blue-50 rounded-xl transition duration-200 flex items-center justify-center gap-1.5 shadow-2xs w-full">
                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Lihat TUPOKSI
                            </button>
                        </div>
                    </div>

                    <!-- Node 2: Kasi Pemerintahan -->
                    <div class="flex flex-col items-center">
                        <div class="hidden lg:block w-0.5 h-6 bg-slate-300 -mt-6"></div>
                        <div class="w-full bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm flex flex-col items-center text-center hover:border-blue-500 hover:shadow-md transition-all duration-200 h-full justify-between">
                            <div class="flex flex-col items-center w-full">
                                <div class="w-20 h-20 rounded-full border-4 border-slate-200 overflow-hidden bg-slate-100 mb-3 shadow-xs shrink-0 flex items-center justify-center">
                                    <img src="{{ $pemSrc }}" alt="{{ $pemNama }}" class="w-full h-full object-cover">
                                </div>
                                <h3 class="text-sm font-extrabold text-slate-900 tracking-tight leading-snug mb-1">{{ $pemNama }}</h3>
                                <p class="text-[11px] font-mono text-slate-400 mb-2.5 min-h-[1rem]">@if($pemNip) NIP. {{ $pemNip }} @else &nbsp; @endif</p>
                                <span class="bg-[#0f172a] text-white text-[10px] font-black px-3.5 py-1 rounded-full uppercase tracking-wider mb-1 inline-block shadow-2xs">KASI PEMERINTAHAN</span>
                                <p class="text-[11px] font-semibold text-slate-500 mb-4 tracking-wide">Seksi Pemerintahan</p>
                            </div>
                            <button @click="activeTupoksi = {
                                nama: '{{ addslashes($pemNama) }}',
                                nip: '{{ addslashes($pemNip) }}',
                                jabatan: '{{ addslashes($pemJabatan) }}',
                                pill: 'KASI PEMERINTAHAN',
                                subtitle: 'Seksi Pemerintahan',
                                photo: '{{ $pemSrc }}',
                                tupoksi: '{{ addslashes($pemTupoksi) }}'
                            }" class="px-3.5 py-1.5 text-[11px] font-bold text-blue-600 bg-white border border-blue-300 hover:border-blue-600 hover:bg-blue-50 rounded-xl transition duration-200 flex items-center justify-center gap-1.5 shadow-2xs w-full">
                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Lihat TUPOKSI
                            </button>
                        </div>
                    </div>

                    <!-- Node 3: Kasi Trantib -->
                    <div class="flex flex-col items-center">
                        <div class="hidden lg:block w-0.5 h-6 bg-slate-300 -mt-6"></div>
                        <div class="w-full bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm flex flex-col items-center text-center hover:border-blue-500 hover:shadow-md transition-all duration-200 h-full justify-between">
                            <div class="flex flex-col items-center w-full">
                                <div class="w-20 h-20 rounded-full border-4 border-slate-200 overflow-hidden bg-slate-100 mb-3 shadow-xs shrink-0 flex items-center justify-center">
                                    <img src="{{ $trantibSrc }}" alt="{{ $trantibNama }}" class="w-full h-full object-cover">
                                </div>
                                <h3 class="text-sm font-extrabold text-slate-900 tracking-tight leading-snug mb-1">{{ $trantibNama }}</h3>
                                <p class="text-[11px] font-mono text-slate-400 mb-2.5 min-h-[1rem]">@if($trantibNip) NIP. {{ $trantibNip }} @else &nbsp; @endif</p>
                                <span class="bg-[#0f172a] text-white text-[10px] font-black px-3.5 py-1 rounded-full uppercase tracking-wider mb-1 inline-block shadow-2xs">KASI TRANTIB</span>
                                <p class="text-[11px] font-semibold text-slate-500 mb-4 tracking-wide">Seksi Sosial & Trantib</p>
                            </div>
                            <button @click="activeTupoksi = {
                                nama: '{{ addslashes($trantibNama) }}',
                                nip: '{{ addslashes($trantibNip) }}',
                                jabatan: '{{ addslashes($trantibJabatan) }}',
                                pill: 'KASI TRANTIB',
                                subtitle: 'Seksi Sosial & Trantib',
                                photo: '{{ $trantibSrc }}',
                                tupoksi: '{{ addslashes($trantibTupoksi) }}'
                            }" class="px-3.5 py-1.5 text-[11px] font-bold text-blue-600 bg-white border border-blue-300 hover:border-blue-600 hover:bg-blue-50 rounded-xl transition duration-200 flex items-center justify-center gap-1.5 shadow-2xs w-full">
                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Lihat TUPOKSI
                            </button>
                        </div>
                    </div>

                    <!-- Node 4: Kasi Ekonomi & Pembangunan (Kesra) -->
                    <div class="flex flex-col items-center">
                        <div class="hidden lg:block w-0.5 h-6 bg-slate-300 -mt-6"></div>
                        <div class="w-full bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm flex flex-col items-center text-center hover:border-blue-500 hover:shadow-md transition-all duration-200 h-full justify-between">
                            <div class="flex flex-col items-center w-full">
                                <div class="w-20 h-20 rounded-full border-4 border-slate-200 overflow-hidden bg-slate-100 mb-3 shadow-xs shrink-0 flex items-center justify-center">
                                    <img src="{{ $kesraSrc }}" alt="{{ $kesraNama }}" class="w-full h-full object-cover">
                                </div>
                                <h3 class="text-sm font-extrabold text-slate-900 tracking-tight leading-snug mb-1">{{ $kesraNama }}</h3>
                                <p class="text-[11px] font-mono text-slate-400 mb-2.5 min-h-[1rem]">@if($kesraNip) NIP. {{ $kesraNip }} @else &nbsp; @endif</p>
                                <span class="bg-[#0f172a] text-white text-[10px] font-black px-3.5 py-1 rounded-full uppercase tracking-wider mb-1 inline-block shadow-2xs">KASI EKONOMI & PEMBANGUNAN</span>
                                <p class="text-[11px] font-semibold text-slate-500 mb-4 tracking-wide">Seksi Perekonomian</p>
                            </div>
                            <button @click="activeTupoksi = {
                                nama: '{{ addslashes($kesraNama) }}',
                                nip: '{{ addslashes($kesraNip) }}',
                                jabatan: '{{ addslashes($kesraJabatan) }}',
                                pill: 'KASI EKONOMI & PEMBANGUNAN',
                                subtitle: 'Seksi Perekonomian',
                                photo: '{{ $kesraSrc }}',
                                tupoksi: '{{ addslashes($kesraTupoksi) }}'
                            }" class="px-3.5 py-1.5 text-[11px] font-bold text-blue-600 bg-white border border-blue-300 hover:border-blue-600 hover:bg-blue-50 rounded-xl transition duration-200 flex items-center justify-center gap-1.5 shadow-2xs w-full">
                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Lihat TUPOKSI
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- LEVEL 3: DYNAMIC STAF & ANGGOTA TAMBAHAN (CONNECTED TREE LAYOUT) -->
            @if(!empty($additionalAparatur))
            <div class="flex flex-col items-center pt-2">
                <!-- Vertical Line Down to Level 3 -->
                <div class="w-0.5 h-8 bg-slate-300"></div>

                <div class="relative w-full max-w-6xl mx-auto">
                    <!-- Horizontal Line connecting staff nodes on desktop -->
                    @if(count($additionalAparatur) > 1)
                    <div class="hidden lg:block absolute top-0 left-[8%] right-[8%] h-0.5 bg-slate-300"></div>
                    @endif

                    <!-- Staff Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 relative">
                        @foreach($additionalAparatur as $index => $staf)
                        @php
                            $stafName = $staf['name'] ?? 'Staf Kelurahan';
                            $stafNip = $staf['nip'] ?? '';
                            $stafJabatan = $staf['jabatan'] ?? 'Staf Pelaksana';
                            $stafAtasan = $staf['atasan'] ?? 'Staf Pendukung';
                            $stafPhoto = !empty($staf['photo']) ? (\Illuminate\Support\Str::startsWith($staf['photo'], ['http://', 'https://']) ? $staf['photo'] : Storage::url($staf['photo'])) : 'https://ui-avatars.com/api/?name=' . urlencode($stafName) . '&background=64748b&color=fff&size=200';
                            $stafTupoksi = !empty($staf['tupoksi']) ? $staf['tupoksi'] : 'Pelaksanaan tugas teknis operasional, administrasi pendukung, dan pelayanan masyarakat sesuai arahan pimpinan/atasan seksi.';
                        @endphp

                        <div class="flex flex-col items-center">
                            <div class="hidden lg:block w-0.5 h-6 bg-slate-300 -mt-6"></div>
                            <div class="w-full bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm flex flex-col items-center text-center hover:border-blue-500 hover:shadow-md transition-all duration-200 h-full justify-between">
                                <div class="flex flex-col items-center w-full">
                                    <div class="w-20 h-20 rounded-full border-4 border-slate-200 overflow-hidden bg-slate-100 mb-3 shadow-xs shrink-0 flex items-center justify-center">
                                        <img src="{{ $stafPhoto }}" alt="{{ $stafName }}" class="w-full h-full object-cover">
                                    </div>
                                    <h3 class="text-sm font-extrabold text-slate-900 tracking-tight leading-snug mb-1">{{ $stafName }}</h3>
                                    <p class="text-[11px] font-mono text-slate-400 mb-2.5 min-h-[1rem]">@if($stafNip) NIP/NIK. {{ $stafNip }} @else &nbsp; @endif</p>
                                    <span class="bg-[#0f172a] text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider mb-1 inline-block shadow-2xs truncate max-w-full">
                                        {{ strtoupper($stafJabatan) }}
                                    </span>
                                    <p class="text-[11px] font-semibold text-slate-500 mb-4 tracking-wide truncate max-w-full">{{ $stafAtasan }}</p>
                                </div>
                                <button @click="activeTupoksi = {
                                    nama: '{{ addslashes($stafName) }}',
                                    nip: '{{ addslashes($stafNip) }}',
                                    jabatan: '{{ addslashes($stafJabatan) }}',
                                    pill: '{{ addslashes(strtoupper($stafJabatan)) }}',
                                    subtitle: '{{ addslashes($stafAtasan) }}',
                                    photo: '{{ $stafPhoto }}',
                                    tupoksi: '{{ addslashes($stafTupoksi) }}'
                                }" class="px-3.5 py-1.5 text-[11px] font-bold text-blue-600 bg-white border border-blue-300 hover:border-blue-600 hover:bg-blue-50 rounded-xl transition duration-200 flex items-center justify-center gap-1.5 shadow-2xs w-full">
                                    <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Lihat TUPOKSI
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

        </div>

        <!-- SECTION: BERKAS GAMBAR DIAGRAM BAGAN ORGANISASI UTUH (OPSIONAL) -->
        @if($baganSrc)
        <div class="mt-8 bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm space-y-4">
            <div class="flex items-center gap-2 border-b border-slate-200 pb-3">
                <span class="w-3 h-3 rounded-full bg-blue-600"></span>
                <h3 class="text-base font-extrabold text-slate-900 uppercase tracking-wide">Bagan Diagram Struktur Organisasi</h3>
            </div>
            <div class="rounded-xl overflow-hidden bg-slate-50 p-3 flex justify-center">
                <img src="{{ $baganSrc }}" alt="Bagan Struktur Organisasi Kandang Jati Kulon" class="w-full max-w-4xl h-auto object-contain rounded-lg">
            </div>
        </div>
        @endif

        <!-- SECTION: TUGAS POKOK & PENJELASAN STRUKTUR ORGANISASI -->
        @if(!empty($settings['struktur_organisasi']))
        <div class="mt-8 bg-white p-6 rounded-2xl border border-slate-200/90 shadow-sm space-y-3">
            <div class="flex items-center gap-2 border-b border-slate-200 pb-3">
                <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="text-base font-extrabold text-slate-900 uppercase tracking-wide">Penjelasan Tugas Pokok & Fungsi</h3>
            </div>
            <div class="text-xs sm:text-sm text-slate-600 leading-relaxed space-y-2 prose max-w-none pt-1">
                {!! $settings['struktur_organisasi'] !!}
            </div>
        </div>
        @endif

    </div>

    <!-- INTERACTIVE ALPHINEJS MODAL FOR "Lihat TUPOKSI" -->
    <div x-cloak x-show="activeTupoksi !== null" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div x-show="activeTupoksi !== null" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="activeTupoksi = null"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div x-show="activeTupoksi !== null" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200">
                
                <!-- Modal Header -->
                <div class="bg-[#0f172a] text-white p-5 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white shrink-0 shadow-xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-white" x-text="activeTupoksi?.nama || 'Detail TUPOKSI'"></h3>
                            <p class="text-xs text-slate-300" x-text="activeTupoksi?.subtitle || activeTupoksi?.jabatan || ''"></p>
                        </div>
                    </div>
                    <button @click="activeTupoksi = null" class="text-slate-400 hover:text-white p-1 rounded-lg transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 space-y-4">
                    <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <img :src="activeTupoksi?.photo" :alt="activeTupoksi?.nama" class="w-16 h-16 rounded-full object-cover border-2 border-blue-600 shrink-0">
                        <div>
                            <span class="inline-block px-3 py-0.5 bg-[#0f172a] text-white text-[10px] font-black rounded-full uppercase tracking-wider mb-1" x-text="activeTupoksi?.pill"></span>
                            <h4 class="text-sm font-extrabold text-slate-900" x-text="activeTupoksi?.nama"></h4>
                            <p class="text-xs text-slate-500 font-mono" x-show="activeTupoksi?.nip" x-text="'NIP. ' + activeTupoksi?.nip"></p>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <h4 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                            Tugas Pokok & Fungsi (TUPOKSI)
                        </h4>
                        <div class="text-xs text-slate-700 leading-relaxed bg-blue-50/50 p-4 rounded-xl border border-blue-100 space-y-2" x-html="activeTupoksi?.tupoksi"></div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-slate-50 px-6 py-4 flex justify-end border-t border-slate-200">
                    <button @click="activeTupoksi = null" class="px-5 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl transition shadow-xs">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection

