@extends('layouts.app')

@section('content')

<!-- Hero Banner -->
@php
    $heroMode = $settings['hero_banner_mode'] ?? 'slider';
    $rawSlides = isset($settings['hero_slides']) ? json_decode($settings['hero_slides'], true) : [];
    
    if (empty($rawSlides) || !is_array($rawSlides)) {
        $rawSlides = [
            [
                'tag' => $settings['hero_tag'] ?? 'Program Unggulan Kelurahan',
                'title_1' => $settings['hero_title_1'] ?? 'Pelayanan Publik',
                'title_2' => $settings['hero_title_2'] ?? 'Berbasis Digital Cepat & Transparan',
                'subtitle' => $settings['hero_subtitle'] ?? 'Kini administrasi kependudukan lebih cepat dan transparan melalui integrasi digital.',
                'background' => $settings['hero_background'] ?? '',
            ]
        ];
    }
    
    $slides = [];
    foreach ($rawSlides as $s) {
        $bgVal = $s['background'] ?? '';
        $bgSrc = !empty($bgVal)
            ? (\Illuminate\Support\Str::startsWith($bgVal, ['http://', 'https://']) ? $bgVal : Storage::url($bgVal))
            : asset('hero-bg.jpg');
            
        $slides[] = [
            'tag' => $s['tag'] ?? 'Program Unggulan Kelurahan',
            'title_1' => $s['title_1'] ?? 'Pelayanan Publik',
            'title_2' => $s['title_2'] ?? 'Berbasis Digital Cepat & Transparan',
            'subtitle' => $s['subtitle'] ?? '',
            'bg' => $bgSrc,
        ];
    }
    
    $isSlider = ($heroMode === 'slider' && count($slides) > 1);
@endphp

<!-- Hero Banner Wrapped in Container -->
<div class="container mx-auto px-4 pt-4 sm:pt-6">
    @if($isSlider)
    <!-- Hero Banner Carousel Mode (Multi Slide Auto-play) -->
    <section class="relative bg-slate-950 h-[520px] md:h-[600px] w-full rounded-2xl sm:rounded-3xl overflow-hidden shadow-xl"
             x-data="{
                 activeSlide: 0,
                 totalSlides: {{ count($slides) }},
                 timer: null,
                 init() {
                     this.startAutoPlay();
                 },
                 startAutoPlay() {
                     this.stopAutoPlay();
                     this.timer = setInterval(() => {
                         this.next();
                     }, 6000);
                 },
                 stopAutoPlay() {
                     if (this.timer) clearInterval(this.timer);
                 },
                 next() {
                     this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
                 },
                 prev() {
                     this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides;
                 },
                 goTo(index) {
                     this.activeSlide = index;
                 }
             }"
             @mouseenter="stopAutoPlay()"
             @mouseleave="startAutoPlay()">

        @foreach($slides as $index => $slide)
        <div x-show="activeSlide === {{ $index }}"
             x-transition:enter="transition ease-out duration-700"
             x-transition:enter-start="opacity-0 scale-105"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-500"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="absolute inset-0 w-full h-full"
             x-cloak>
            
            <!-- Background Image -->
            <img src="{{ $slide['bg'] }}" class="absolute inset-0 w-full h-full object-cover object-center opacity-90 transition-all duration-700" alt="{{ strip_tags($slide['title_1']) }}">

            <!-- Smooth Soft Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/85 via-slate-950/50 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-slate-950/20"></div>

            <div class="w-full h-full relative z-10 flex items-center px-6 md:px-12 lg:px-16">
                <div class="w-full md:w-2/3 lg:w-1/2 text-white">
                    @if(!empty($slide['tag']))
                    <div class="hero-animate hero-animate-delay-1 inline-flex items-center gap-2 px-5 py-2 bg-gradient-to-r from-green-600 to-[#00A859] text-white text-[11px] font-bold tracking-widest uppercase shadow-lg shadow-green-500/20 mb-6 border-l-4 border-yellow-400 rounded-r-full">
                        {{ $slide['tag'] }}
                    </div>
                    @endif

                    <h2 class="hero-animate hero-animate-delay-2 text-4xl md:text-5xl lg:text-[56px] font-extrabold leading-[1.1] mb-5 text-white tracking-tight">
                        {!! $slide['title_1'] !!}
                        @if(!empty($slide['title_2']))
                        <span class="block text-[#00A859] mt-1">{!! $slide['title_2'] !!}</span>
                        @endif
                    </h2>

                    <div class="hero-animate hero-animate-delay-3 w-20 h-1.5 bg-gradient-to-r from-yellow-400 to-yellow-500 mb-8 rounded-full shadow-[0_0_10px_rgba(250,204,21,0.4)]"></div>

                    @if(!empty($slide['subtitle']))
                    <p class="hero-animate hero-animate-delay-3 text-base md:text-lg text-slate-300 mb-8 font-normal leading-relaxed max-w-lg">
                        {{ $slide['subtitle'] }}
                    </p>
                    @endif
                </div>
            </div>
        </div>
        @endforeach


        <!-- Pagination Dots -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2 px-4 py-2 bg-slate-950/40 backdrop-blur-md rounded-full border border-white/10">
            @foreach($slides as $index => $slide)
            <button @click="goTo({{ $index }}); startAutoPlay();"
                    aria-label="Ke Slide {{ $index + 1 }}"
                    :class="activeSlide === {{ $index }} ? 'w-8 bg-emerald-500' : 'w-2.5 bg-white/50 hover:bg-white'"
                    class="h-2.5 rounded-full transition-all duration-300 cursor-pointer"></button>
            @endforeach
        </div>

    </section>
    @else
    <!-- Hero Banner Mode Statis (Single Slide) -->
    @php $staticSlide = $slides[0] ?? [
        'tag' => 'Program Unggulan Kelurahan',
        'title_1' => 'Pelayanan Publik',
        'title_2' => 'Berbasis Digital Cepat & Transparan',
        'subtitle' => 'Kini administrasi kependudukan lebih cepat dan transparan melalui integrasi digital.',
        'bg' => asset('hero-bg.jpg')
    ]; @endphp
    <section class="relative bg-slate-950 h-[520px] md:h-[600px] w-full rounded-2xl sm:rounded-3xl overflow-hidden shadow-xl">
        <!-- Background Image -->
        <img src="{{ $staticSlide['bg'] }}" class="absolute inset-0 w-full h-full object-cover object-center opacity-95 transition-opacity duration-500" alt="Pelayanan Publik Digital Kelurahan Kandang Jati Kulon">

        <!-- Smooth Soft Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/80 via-slate-950/45 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/50 via-transparent to-slate-950/20"></div>

        <div class="w-full h-full relative z-10 flex items-center px-6 md:px-12 lg:px-16">
            <div class="w-full md:w-2/3 lg:w-1/2 text-white">
                @if(!empty($staticSlide['tag']))
                <div class="hero-animate hero-animate-delay-1 inline-flex items-center gap-2 px-5 py-2 bg-gradient-to-r from-green-600 to-[#00A859] text-white text-[11px] font-bold tracking-widest uppercase shadow-lg shadow-green-500/20 mb-6 border-l-4 border-yellow-400 rounded-r-full">
                    {{ $staticSlide['tag'] }}
                </div>
                @endif

                <h2 class="hero-animate hero-animate-delay-2 text-4xl md:text-5xl lg:text-[56px] font-extrabold leading-[1.1] mb-5 text-white tracking-tight">
                    {!! $staticSlide['title_1'] !!}
                    @if(!empty($staticSlide['title_2']))
                    <span class="block text-[#00A859] mt-1">{!! $staticSlide['title_2'] !!}</span>
                    @endif
                </h2>

                <div class="hero-animate hero-animate-delay-3 w-20 h-1.5 bg-gradient-to-r from-yellow-400 to-yellow-500 mb-8 rounded-full shadow-[0_0_10px_rgba(250,204,21,0.4)]"></div>

                @if(!empty($staticSlide['subtitle']))
                <p class="hero-animate hero-animate-delay-3 text-base md:text-lg text-slate-300 mb-8 font-normal leading-relaxed max-w-lg">
                    {{ $staticSlide['subtitle'] }}
                </p>
                @endif
            </div>
        </div>
    </section>
    @endif
</div>

<!-- Sambutan Pimpinan / Lurah -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-12 items-center">
            <div class="w-full lg:w-1/3 flex justify-center reveal fade-right">
                <div class="relative w-64">
                    @php
                        $kadinVal = $settings['kadin_photo'] ?? $settings['foto_lurah'] ?? null;
                        $kadinPhoto = !empty($kadinVal)
                            ? (\Illuminate\Support\Str::startsWith($kadinVal, ['http://', 'https://']) ? $kadinVal : Storage::url($kadinVal))
                            : 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=600&auto=format&fit=crop';
                    @endphp
                    <img src="{{ $kadinPhoto }}"
                         alt="Pimpinan Kelurahan" class="w-full h-80 object-cover rounded-2xl shadow-lg border border-slate-100">
                    <div class="absolute -bottom-4 inset-x-4 bg-white border border-slate-100 py-3 px-4 rounded-xl shadow-sm text-center">
                        <h4 class="font-bold text-sm text-slate-800">{{ $settings['kadin_name'] ?? $settings['nama_lurah'] ?? 'H. Ahmad Syarif, S.STP, M.Si' }}</h4>
                        <p class="text-[10px] text-green-600 font-semibold uppercase mt-0.5">{{ $settings['kadin_title'] ?? 'LURAH Kandang Jati Kulon' }}</p>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-2/3 space-y-5 text-center lg:text-left reveal fade-left">
                <div class="inline-flex items-center gap-2 text-green-600 text-xs font-bold uppercase tracking-widest">
                    {{ $settings['sambutan_subtitle'] ?? ('Sambutan ' . ($settings['jabatan_lurah'] ?? $settings['kadin_title'] ?? 'LURAH Kandang Jati Kulon')) }}
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 leading-tight">
                    {{ $settings['sambutan_title'] ?? 'Melayani Warga Sepenuh Hati Menuju Kelurahan yang Maju, Sejahtera & Mandiri' }}
                </h2>
                <div class="text-slate-600 text-sm leading-relaxed max-w-3xl space-y-3 prose prose-slate">
                    @if(!empty($settings['sambutan_isi']))
                        {!! $settings['sambutan_isi'] !!}
                    @else
                        <p>Selamat Datang di Portal Resmi <strong>{{ $settings['agency_name'] ?? 'KELURAHAN Kandang Jati Kulon' }} {{ $settings['regency_name'] ?? 'Kecamatan Kraksaan, Kabupaten Probolinggo' }}</strong>. Kami berkomitmen menyajikan pelayanan publik prima, kemudahan administrasi kependudukan dan pengurusan surat keterangan, transparansi kinerja kelurahan, serta pemberdayaan potensi ekonomi warga lokal.</p>
                    @endif
                </div>
                <div class="pt-4 flex flex-wrap gap-4 items-center justify-center lg:justify-start">
                    <a href="{{ route('profil.visi-misi') }}" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold text-sm transition-colors flex items-center gap-2">
                        Visi & Misi Kami <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Portal APPD Banner Section -->
<section id="portal-appd" class="py-10 bg-white border-b border-slate-100 relative z-10">
    <div class="container mx-auto px-4">
        <div class="bg-slate-50/70 border border-slate-200/80 rounded-2xl p-6 sm:p-8 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 hover:border-slate-300 transition-all duration-300">
            <div class="space-y-3 max-w-3xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-slate-200 text-slate-700 text-[10px] font-extrabold tracking-widest uppercase rounded-full shadow-2xs">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    APPD KELURAHAN KANDANG JATI KULON
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    {{ $settings['appd_title'] ?? 'Portal APPD (Aplikasi Pelayanan Kelurahan Kandang Jati Kulon Digital)' }}
                </h2>
                <p class="text-slate-500 text-xs sm:text-sm font-medium leading-relaxed">
                    {{ $settings['appd_desc'] ?? 'Akses sistem informasi pelayanan kependudukan digital, integrasi data RT/RW, dan kemudahan pengurusan administrasi warga Kelurahan Kandang Jati Kulon Kraksaan.' }}
                </p>
            </div>
            <div class="shrink-0 w-full sm:w-auto">
                <a href="{{ route('services.index') }}" class="w-full sm:w-auto px-6 py-3.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs sm:text-sm rounded-xl transition duration-200 flex items-center justify-center gap-2.5 shadow-md hover:shadow-lg group">
                    <svg class="w-4 h-4 text-emerald-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    <span>Buka Portal APPD Kandang Jati Kulon</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Transparansi Data & Kinerja Kelurahan (5 Cards Statistics Layout) -->
<section id="transparansi-statistik" class="relative z-20 py-12 bg-slate-50 border-t border-b border-slate-100">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="mb-8 reveal fade-up">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-extrabold tracking-widest uppercase rounded-full mb-3 border border-emerald-200/60 shadow-2xs">
                TRANSPARANSI DATA & KINERJA KELURAHAN
            </span>
            <h2 class="text-2xl md:text-3xl font-extrabold text-[#111827] tracking-tight">Data & Statistik Pelayanan Kandang Jati Kulon</h2>
            <div class="flex items-center gap-2 mt-4 text-xs font-bold text-slate-700 uppercase tracking-wider">
                <svg class="w-4 h-4 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                <span>DATA DEMOGRAFI & WILAYAH KELURAHAN (5 ITEM UTAMA)</span>
            </div>
        </div>

        <!-- 5 Cards Grid -->
        <div class="grid grid-cols-3 lg:grid-cols-5 gap-1.5 sm:gap-4">
            
            <!-- Card 1: Dana Kelurahan -->
            <div class="bg-white rounded-xl sm:rounded-2xl border border-slate-200/80 p-2 sm:p-5 shadow-2xs hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group reveal fade-up" data-delay="0">
                <div>
                    <div class="w-6 h-6 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center mb-2 sm:mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-3.5 h-3.5 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="text-[9px] sm:text-base xl:text-lg font-extrabold text-slate-900 tracking-tight leading-tight sm:leading-snug truncate">
                        Rp {{ $settings['stat_apbd'] ?? '1.250.000.000,-' }}
                    </div>
                    <p class="text-[6.5px] sm:text-[10.5px] text-slate-500 font-extrabold uppercase tracking-wider mt-0.5 sm:mt-1">DANA KELURAHAN</p>
                </div>
                <div class="pt-1.5 mt-1.5 sm:pt-4 sm:mt-3 border-t border-slate-100">
                    <a href="{{ route('apbd.index') }}" class="inline-flex items-center gap-0.5 sm:gap-1 text-[8px] sm:text-[11.5px] font-bold text-slate-700 hover:text-emerald-700 transition group/link">
                        <span class="truncate">Transparansi</span>
                        <svg class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5 text-slate-400 group-hover/link:text-emerald-700 group-hover/link:translate-x-1 transition-all shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Card 2: Jumlah Penduduk -->
            <div class="bg-white rounded-xl sm:rounded-2xl border border-slate-200/80 p-2 sm:p-5 shadow-2xs hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group reveal fade-up" data-delay="100">
                <div>
                    <div class="w-6 h-6 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center mb-2 sm:mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-3.5 h-3.5 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div class="text-[11px] sm:text-xl xl:text-2xl font-extrabold text-slate-900 tracking-tight leading-tight sm:leading-snug">
                        {{ $settings['stat_penduduk'] ?? ($settings['demografi_total'] ?? '5000') }}
                    </div>
                    <p class="text-[6.5px] sm:text-[10.5px] text-slate-500 font-extrabold uppercase tracking-wider mt-0.5 sm:mt-1">JUMLAH PENDUDUK</p>
                </div>
                <div class="pt-1.5 mt-1.5 sm:pt-4 sm:mt-3 border-t border-slate-100">
                    <a href="{{ route('profil.demografi') }}" class="inline-flex items-center gap-0.5 sm:gap-1 text-[8px] sm:text-[11.5px] font-bold text-slate-700 hover:text-emerald-700 transition group/link">
                        <span>Terkini</span>
                        <svg class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5 text-slate-400 group-hover/link:text-emerald-700 group-hover/link:translate-x-1 transition-all shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Card 3: Jumlah KK -->
            <div class="bg-white rounded-xl sm:rounded-2xl border border-slate-200/80 p-2 sm:p-5 shadow-2xs hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group reveal fade-up" data-delay="200">
                <div>
                    <div class="w-6 h-6 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center mb-2 sm:mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-3.5 h-3.5 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </div>
                    <div class="text-[11px] sm:text-xl xl:text-2xl font-extrabold text-slate-900 tracking-tight leading-tight sm:leading-snug">
                        {{ $settings['stat_kk'] ?? ($settings['demografi_kk'] ?? '1.420') }}
                    </div>
                    <p class="text-[6.5px] sm:text-[10.5px] text-slate-500 font-extrabold uppercase tracking-wider mt-0.5 sm:mt-1">JUMLAH KK</p>
                </div>
                <div class="pt-1.5 mt-1.5 sm:pt-4 sm:mt-3 border-t border-slate-100">
                    <a href="{{ route('profil.demografi') }}" class="inline-flex items-center gap-0.5 sm:gap-1 text-[8px] sm:text-[11.5px] font-bold text-slate-700 hover:text-emerald-700 transition group/link">
                        <span>Keluarga</span>
                        <svg class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5 text-slate-400 group-hover/link:text-emerald-700 group-hover/link:translate-x-1 transition-all shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Card 4: Jumlah RT / RW -->
            <div class="bg-white rounded-xl sm:rounded-2xl border border-slate-200/80 p-2 sm:p-5 shadow-2xs hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group reveal fade-up" data-delay="300">
                <div>
                    <div class="w-6 h-6 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center mb-2 sm:mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-3.5 h-3.5 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div class="text-[9px] sm:text-base xl:text-lg font-extrabold text-slate-900 tracking-tight leading-tight sm:leading-snug truncate">
                        {{ $settings['stat_rtrw'] ?? '18 RT / 4 RW' }}
                    </div>
                    <p class="text-[6.5px] sm:text-[10.5px] text-slate-500 font-extrabold uppercase tracking-wider mt-0.5 sm:mt-1">JUMLAH RT / RW</p>
                </div>
                <div class="pt-1.5 mt-1.5 sm:pt-4 sm:mt-3 border-t border-slate-100">
                    <a href="{{ route('profil.struktur') }}" class="inline-flex items-center gap-0.5 sm:gap-1 text-[8px] sm:text-[11.5px] font-bold text-slate-700 hover:text-emerald-700 transition group/link">
                        <span>Struktur</span>
                        <svg class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5 text-slate-400 group-hover/link:text-emerald-700 group-hover/link:translate-x-1 transition-all shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Card 5: Luas Wilayah -->
            <div class="bg-white rounded-xl sm:rounded-2xl border border-slate-200/80 p-2 sm:p-5 shadow-2xs hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group reveal fade-up" data-delay="400">
                <div>
                    <div class="w-6 h-6 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center mb-2 sm:mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-3.5 h-3.5 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l5.447 2.724A1 1 0 0021 18.818V8.045a1 1 0 00-1.447-.894L15 9m0 11V9m0 0L9 7"></path></svg>
                    </div>
                    <div class="text-[11px] sm:text-xl xl:text-2xl font-extrabold text-slate-900 tracking-tight leading-tight sm:leading-snug">
                        {{ $settings['stat_luas'] ?? '2,45 km²' }}
                    </div>
                    <p class="text-[6.5px] sm:text-[10.5px] text-slate-500 font-extrabold uppercase tracking-wider mt-0.5 sm:mt-1">LUAS WILAYAH</p>
                </div>
                <div class="pt-1.5 mt-1.5 sm:pt-4 sm:mt-3 border-t border-slate-100">
                    <a href="{{ route('profil.demografi') }}" class="inline-flex items-center gap-0.5 sm:gap-1 text-[8px] sm:text-[11.5px] font-bold text-slate-700 hover:text-emerald-700 transition group/link">
                        <span>Geografis</span>
                        <svg class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5 text-slate-400 group-hover/link:text-emerald-700 group-hover/link:translate-x-1 transition-all shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Standar Pelayanan & SOP (Horizontal Scroll / Carousel Minimalis & Responsif) -->
<section id="layanan" class="py-10 bg-white relative z-10 border-b border-slate-100" 
         x-data="{ 
            isDown: false, 
            startX: 0, 
            scrollLeft: 0, 
            dragged: false,
            scrollSop(dir) { 
                if (this.$refs && this.$refs.sopCarousel) {
                    this.$refs.sopCarousel.scrollBy({ left: dir * 260, behavior: 'smooth' });
                }
            },
            onMouseDown(e) {
                this.isDown = true;
                this.dragged = false;
                if (this.$refs && this.$refs.sopCarousel) {
                    this.startX = e.pageX - this.$refs.sopCarousel.offsetLeft;
                    this.scrollLeft = this.$refs.sopCarousel.scrollLeft;
                }
            },
            onMouseLeave() {
                this.isDown = false;
            },
            onMouseUp() {
                setTimeout(() => { this.dragged = false; }, 50);
                this.isDown = false;
            },
            onMouseMove(e) {
                if (!this.isDown || !this.$refs || !this.$refs.sopCarousel) return;
                const x = e.pageX - this.$refs.sopCarousel.offsetLeft;
                const walk = (x - this.startX) * 1.5;
                if (Math.abs(walk) > 5) {
                    this.dragged = true;
                    this.$refs.sopCarousel.scrollLeft = this.scrollLeft - walk;
                }
            },
            preventClickIfDragged(e) {
                if (this.dragged) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            }
         }">
    <div class="container mx-auto px-4">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-6 reveal fade-up">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-extrabold tracking-widest uppercase rounded-full mb-2 border border-emerald-200/60 shadow-2xs">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Standar Pelayanan Publik
                </span>
                <h2 class="text-xl md:text-2xl font-extrabold text-[#111827]">Standar Operasional Prosedur (SOP)</h2>
                <p class="text-slate-500 mt-1 text-xs font-medium max-w-xl">Panduan resmi alur kepengurusan administrasi pelayanan di Kelurahan Kandang Jati Kulon.</p>
            </div>
            
            <!-- Navigation Controls -->
            <div class="flex items-center gap-1.5 mt-3 sm:mt-0 shrink-0 z-30 relative">
                <button type="button"
                        id="btn-sop-prev"
                        onclick="const el = document.getElementById('sop-carousel-container'); if(el) el.scrollBy({ left: -260, behavior: 'smooth' });"
                        @click="const el = document.getElementById('sop-carousel-container'); if(el) el.scrollBy({ left: -260, behavior: 'smooth' });" 
                        title="Geser Kiri"
                        class="w-8 h-8 rounded-lg bg-slate-50 hover:bg-emerald-600 border border-slate-200 hover:border-emerald-600 text-slate-700 hover:text-white transition-all duration-150 flex items-center justify-center shadow-2xs active:scale-95 cursor-pointer z-30 relative">
                    <svg class="w-3.5 h-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button type="button"
                        id="btn-sop-next"
                        onclick="const el = document.getElementById('sop-carousel-container'); if(el) el.scrollBy({ left: 260, behavior: 'smooth' });"
                        @click="const el = document.getElementById('sop-carousel-container'); if(el) el.scrollBy({ left: 260, behavior: 'smooth' });" 
                        title="Geser Kanan"
                        class="w-8 h-8 rounded-lg bg-emerald-600 hover:bg-emerald-700 border border-emerald-600 text-white transition-all duration-150 flex items-center justify-center shadow-xs active:scale-95 cursor-pointer z-30 relative">
                    <svg class="w-3.5 h-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                </button>
                <a href="{{ route('services.index') }}" class="ml-1.5 text-xs font-bold text-emerald-700 hover:text-emerald-800 hover:underline flex items-center gap-1 z-30 relative cursor-pointer">
                    Semua SOP →
                </a>
            </div>
        </div>

        <!-- Horizontal Scroll Carousel (Ultra Compact & Minimalist) -->
        <div class="relative group/carousel">
            <div id="sop-carousel-container"
                 x-ref="sopCarousel" 
                 @mousedown="onMouseDown($event)"
                 @mouseleave="onMouseLeave()"
                 @mouseup="onMouseUp()"
                 @mousemove="onMouseMove($event)"
                 :class="isDown ? 'cursor-grabbing select-none' : 'cursor-grab'"
                 class="flex overflow-x-auto pb-3 pt-0.5 gap-3 snap-x snap-mandatory scrollbar-thin scrollbar-thumb-emerald-200 scrollbar-track-slate-50 hover:scrollbar-thumb-emerald-400 scroll-smooth">
                @if(isset($services) && $services->count() > 0)
                    @foreach($services as $index => $service)
                    <div class="snap-start shrink-0 w-56 md:w-60 flex flex-col justify-between bg-white border border-slate-200/80 hover:border-emerald-400 rounded-xl p-3.5 shadow-2xs hover:shadow-md transition-all duration-200 group/card hover:-translate-y-0.5">
                        <div>
                            <!-- Card Header & Badge -->
                            <div class="flex items-center justify-between mb-2.5">
                                <span class="w-6 h-6 rounded-md bg-emerald-50 text-emerald-700 font-extrabold text-[11px] flex items-center justify-center border border-emerald-200/60 group-hover/card:bg-emerald-600 group-hover/card:text-white group-hover/card:border-emerald-600 transition-colors">
                                    {{ $service->order ?? $loop->iteration }}
                                </span>
                                @if($service->kategoriLayanan)
                                    <span class="inline-flex items-center gap-1 text-[9.5px] font-semibold text-emerald-700 bg-emerald-50/80 px-2 py-0.5 rounded-full border border-emerald-200/50 truncate max-w-[110px]">
                                        {{ $service->kategoriLayanan->nama_kategori }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[9.5px] font-medium text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">
                                        Dokumen SOP
                                    </span>
                                @endif
                            </div>

                            <!-- Title -->
                            <a href="{{ route('services.show', $service->slug) }}" @click="preventClickIfDragged($event)">
                                <h3 class="font-bold text-[12px] md:text-[13px] text-slate-800 leading-snug mb-1.5 group-hover/card:text-emerald-700 transition-colors line-clamp-2 min-h-[2.2rem]">
                                    {{ $service->title }}
                                </h3>
                            </a>

                            <!-- Description -->
                            <p class="text-[10.5px] text-slate-500 leading-tight line-clamp-2 mb-3">
                                {{ $service->description ?? 'Pedoman operasional standar pelayanan administrasi masyarakat kelurahan.' }}
                            </p>
                        </div>

                        <!-- Action Button -->
                        <div class="pt-2 border-t border-slate-100 flex items-center gap-1.5">
                            <a href="{{ route('services.show', $service->slug) }}" 
                               @click="preventClickIfDragged($event)"
                               class="w-full py-1.5 px-2 bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white font-bold text-[11px] rounded-lg text-center transition duration-150 flex items-center justify-center gap-1 shadow-2xs">
                                <span>Lihat Dokumen SOP</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="mt-4 text-center sm:hidden">
            <a href="{{ route('services.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-emerald-600 text-emerald-700 hover:bg-emerald-600 hover:text-white font-bold rounded-lg transition text-xs shadow-2xs">
                Lihat Semua Dokumen SOP ({{ $services->count() }})
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>
</section>

<!-- Feed Informasi Berita & Maklumat Pelayanan (Sejajar) -->
<section id="berita" class="py-16 bg-slate-50 border-b border-slate-200/80" x-data="{ showMaklumatModal: false }">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- Kolom Kiri: Berita & Informasi (lg:col-span-7) -->
            <div class="lg:col-span-7 flex flex-col justify-between h-full">
                <div>
                    <div class="flex justify-between items-end mb-6 pb-2 border-b-2 border-slate-200 reveal fade-up">
                        <div>
                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-green-50 text-green-700 text-[10px] font-bold tracking-widest uppercase rounded-full mb-2 border border-green-200/60">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                Kabar Terkini
                            </span>
                            <h2 class="text-2xl font-extrabold text-slate-800 border-b-4 border-green-600 pb-2 -mb-[10px] inline-block">Berita & Informasi</h2>
                        </div>
                        <a href="{{ route('posts.index') }}" class="hidden sm:flex text-xs font-bold text-green-700 hover:text-green-800 transition items-center gap-1 uppercase tracking-wide bg-green-50 px-3.5 py-1.5 rounded-lg hover:bg-green-100 border border-green-200">
                            Indeks Berita <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>

                    @if(isset($posts) && $posts->count() > 0)
                    <div class="grid grid-cols-3 gap-1.5 sm:gap-5">
                        @foreach($posts->take(3) as $index => $post)
                        <article class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden hover:shadow-xl transition duration-300 group flex flex-col h-full reveal fade-up" data-delay="{{ $index * 80 }}">
                            <div class="relative h-20 sm:h-40 overflow-hidden bg-slate-200 shrink-0">
                                <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <div class="absolute top-1.5 left-1.5 sm:top-3 sm:left-3 flex flex-col text-center shadow-lg rounded-md sm:rounded-lg overflow-hidden">
                                    <span class="bg-green-600 text-white font-extrabold text-[10px] sm:text-base px-1 sm:px-2.5 py-0.5">{{ \Carbon\Carbon::parse($post->published_at)->format('d') }}</span>
                                    <span class="bg-white text-slate-800 text-[6.5px] sm:text-[9px] font-bold uppercase px-1 sm:px-2 py-0.5 leading-none tracking-wider">{{ \Carbon\Carbon::parse($post->published_at)->format('M Y') }}</span>
                                </div>
                                @if($index === 0)
                                <div class="absolute top-1.5 right-1.5 sm:top-3 sm:right-3">
                                    <span class="bg-yellow-500 text-slate-900 text-[6.5px] sm:text-[9px] font-extrabold px-1 sm:px-2 py-0.5 rounded-full uppercase tracking-wider shadow">Baru</span>
                                </div>
                                @endif
                            </div>
                            <div class="p-2 sm:p-4 flex flex-col flex-grow">
                                <span class="inline-flex items-center gap-0.5 sm:gap-1 text-[7px] sm:text-[10px] font-bold text-green-600 uppercase tracking-wider mb-1">
                                    <span class="w-1 h-1 sm:w-1.5 sm:h-1.5 rounded-full bg-green-500 shrink-0"></span> {{ $post->category_name }}
                                </span>
                                <a href="{{ route('posts.show', $post->slug) }}">
                                    <h3 class="font-bold text-[9px] sm:text-sm text-slate-800 leading-tight sm:leading-snug mb-1 sm:mb-2 group-hover:text-green-700 transition line-clamp-2">{{ $post->title }}</h3>
                                </a>
                                <p class="hidden sm:block text-xs text-slate-500 line-clamp-2 mb-3 flex-grow leading-relaxed">{{ Str::limit(strip_tags($post->content), 75) }}</p>
                                <div class="mt-auto pt-1.5 sm:pt-2.5 border-t border-slate-100 flex items-center justify-between">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="inline-flex items-center gap-0.5 sm:gap-1 text-[8px] sm:text-xs font-bold text-green-600 hover:text-green-700 transition">
                                        <span class="hidden sm:inline">Baca Selengkapnya</span>
                                        <span class="sm:hidden">Baca</span>
                                        <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>
                    @else
                    <div class="grid grid-cols-3 gap-1.5 sm:gap-5">
                        @foreach([1, 2, 3] as $index => $i)
                        <article class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden hover:shadow-xl transition duration-300 group flex flex-col h-full reveal fade-up" data-delay="{{ $index * 80 }}">
                            <div class="relative h-20 sm:h-40 overflow-hidden bg-slate-200 shrink-0">
                                <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=600&auto=format&fit=crop&sig={{$i}}" alt="Berita Dummy" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <div class="absolute top-1.5 left-1.5 sm:top-3 sm:left-3 flex flex-col text-center shadow-lg rounded-md sm:rounded-lg overflow-hidden">
                                    <span class="bg-green-600 text-white font-extrabold text-[10px] sm:text-base px-1 sm:px-2.5 py-0.5">{{ 10 + $i }}</span>
                                    <span class="bg-white text-slate-800 text-[6.5px] sm:text-[9px] font-bold uppercase px-1 sm:px-2 py-0.5 leading-none tracking-wider">Sep 2026</span>
                                </div>
                            </div>
                            <div class="p-2 sm:p-4 flex flex-col flex-grow">
                                <span class="inline-flex items-center gap-0.5 sm:gap-1 text-[7px] sm:text-[10px] font-bold text-green-600 uppercase tracking-wider mb-1">
                                    <span class="w-1 h-1 sm:w-1.5 sm:h-1.5 rounded-full bg-green-500 shrink-0"></span> Informasi
                                </span>
                                <a href="#"><h3 class="font-bold text-[9px] sm:text-sm text-slate-800 leading-tight sm:leading-snug mb-1 sm:mb-2 group-hover:text-green-700 transition line-clamp-2">Rapat Koordinasi Kelurahan Terkait Pelayanan {{$i}}</h3></a>
                                <p class="hidden sm:block text-xs text-slate-500 line-clamp-2 mb-3 flex-grow leading-relaxed">Kelurahan Kandang Jati Kulon mengadakan rapat koordinasi bersama tokoh masyarakat...</p>
                                <div class="mt-auto pt-1.5 sm:pt-2.5 border-t border-slate-100">
                                    <a href="#" class="inline-flex items-center gap-0.5 sm:gap-1 text-[8px] sm:text-xs font-bold text-green-600 hover:text-green-800 transition">
                                        <span class="hidden sm:inline">Baca Selengkapnya</span>
                                        <span class="sm:hidden">Baca</span>
                                        <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>
                    @endif
                </div>

                <div class="mt-6 text-center sm:hidden">
                    <a href="{{ route('posts.index') }}" class="inline-flex text-xs font-bold text-white transition items-center gap-2 uppercase tracking-wide bg-green-600 hover:bg-green-700 px-5 py-2.5 rounded-xl shadow">Semua Berita <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></a>
                </div>
            </div>

            <!-- Kolom Kanan: Maklumat Pelayanan (lg:col-span-5) -->
            <div class="lg:col-span-5 flex flex-col gap-4 reveal fade-up" data-delay="150">
                <div class="flex justify-between items-end mb-2 pb-2 border-b-2 border-slate-200">
                    <div>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-extrabold tracking-widest uppercase rounded-full mb-1 border border-emerald-200/60 shadow-2xs">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            Komitmen Pelayanan Publik
                        </span>
                        <h2 class="text-xl font-extrabold text-slate-800 border-b-4 border-emerald-600 pb-1.5 -mb-[10px] inline-block">Maklumat Pelayanan</h2>
                    </div>
                </div>

                <!-- Maklumat Pelayanan Card (Proportional & Matching News Card Size) -->
                <article class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden hover:shadow-xl transition duration-300 group flex flex-col h-full">
                    <!-- Top Thumbnail Image (Height matches news card h-40) -->
                    <div class="relative h-40 overflow-hidden bg-slate-100 shrink-0 cursor-pointer" @click="showMaklumatModal = true">
                        @if(isset($maklumat) && $maklumat->image_url)
                            <img src="{{ $maklumat->image_url }}" 
                                 alt="{{ $maklumat->title ?? 'Maklumat Pelayanan' }}" 
                                 class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-emerald-600 to-teal-800 p-4 flex flex-col items-center justify-center text-white text-center">
                                <img src="{{ $app_logo }}" class="w-10 h-10 object-contain mb-1.5" alt="Logo Kelurahan">
                                <span class="text-xs font-extrabold uppercase tracking-wider">Maklumat Pelayanan Publik</span>
                            </div>
                        @endif
                        <div class="absolute top-3 right-3">
                            <span class="bg-emerald-600 text-white text-[9px] font-extrabold px-2.5 py-1 rounded-full uppercase tracking-wider shadow-sm">Resmi</span>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-4 flex flex-col flex-grow">
                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 uppercase tracking-wider mb-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Maklumat Pelayanan
                        </span>
                        
                        <a @click="showMaklumatModal = true" class="cursor-pointer">
                            <h3 class="font-bold text-sm text-slate-800 leading-snug mb-2 group-hover:text-emerald-700 transition line-clamp-2">
                                {{ $maklumat->title ?? 'Maklumat Pelayanan Publik' }}
                            </h3>
                        </a>

                        <p class="text-xs text-slate-500 line-clamp-2 mb-3 flex-grow leading-relaxed">
                            {{ Str::limit(strip_tags($maklumat->content ?? 'Dengan ini kami menyatakan sanggup menyelenggarakan pelayanan publik sesuai standar pelayanan yang telah ditetapkan, dan siap menerima sanksi sesuai ketentuan.'), 85) }}
                        </p>

                        <div class="mt-auto pt-2.5 border-t border-slate-100 flex items-center justify-between">
                            <button type="button" @click="showMaklumatModal = true" class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 hover:text-emerald-700 transition cursor-pointer group/btn">
                                <span>Baca Selengkapnya</span>
                                <svg class="w-3.5 h-3.5 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                    </div>
                </article>
            </div>

        </div>
    </div>

    <!-- Modal Popup Detail Maklumat Pelayanan -->
    <div x-show="showMaklumatModal" 
         x-cloak 
         @keydown.escape.window="showMaklumatModal = false"
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Backdrop -->
            <div x-show="showMaklumatModal" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 @click="showMaklumatModal = false" 
                 class="fixed inset-0 bg-slate-900/80 backdrop-blur-xs transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal Content Box -->
            <div x-show="showMaklumatModal" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-200">
                
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-emerald-600 to-teal-700 px-6 py-4 text-white flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 p-1 bg-white/10 rounded-lg flex items-center justify-center border border-white/20 shrink-0">
                            <img src="{{ $app_logo }}" class="w-full h-full object-contain" alt="Logo Kelurahan">
                        </div>
                        <div>
                            <h3 class="font-extrabold text-base leading-tight">{{ $maklumat->title ?? 'Maklumat Pelayanan Publik' }}</h3>
                            <p class="text-xs text-emerald-100 font-medium">Kelurahan Kandang Jati Kulon</p>
                        </div>
                    </div>

                    <button @click="showMaklumatModal = false" type="button" class="text-white/80 hover:text-white bg-white/10 hover:bg-white/20 p-2 rounded-full transition cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 max-h-[75vh] overflow-y-auto space-y-4">
                    @if(isset($maklumat) && $maklumat->image_url)
                        <div class="rounded-2xl overflow-hidden border border-slate-200 shadow-xs bg-slate-900 text-center relative group">
                            <img src="{{ $maklumat->image_url }}" alt="{{ $maklumat->title ?? 'Maklumat Pelayanan' }}" class="w-full h-auto max-h-[650px] object-contain mx-auto rounded-xl">
                            <div class="p-3 bg-slate-900/95 border-t border-slate-800 flex items-center justify-between text-xs text-slate-300">
                                <span>Poster Resmi Maklumat Pelayanan</span>
                                <a href="{{ $maklumat->image_url }}" target="_blank" class="text-emerald-400 hover:text-emerald-300 font-bold flex items-center gap-1">
                                    <span>Buka Ukuran Penuh (Full HD)</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            </div>
                        </div>
                    @endif

                    @if(isset($maklumat->content) && $maklumat->content)
                        <div class="bg-emerald-50/70 rounded-2xl p-5 border border-emerald-200/80 text-slate-800 text-sm leading-relaxed italic relative">
                            <span class="text-2xl text-emerald-400 font-serif leading-none absolute top-2 left-3">“</span>
                            <p class="px-4 py-0.5 relative z-10 font-medium text-slate-700">
                                {{ $maklumat->content }}
                            </p>
                            <span class="text-2xl text-emerald-400 font-serif leading-none absolute bottom-1 right-3">”</span>
                        </div>
                    @endif

                    <div class="flex items-center justify-between pt-3 border-t border-slate-200 text-xs text-slate-500">
                        <div>
                            <span>Status: </span>
                            <span class="font-bold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">Resmi & Aktif</span>
                        </div>
                        <div>
                            <span>Pengesah: </span>
                            <span class="font-bold text-slate-800">{{ $maklumat->signer_name ?? 'Lurah Kandang Jati Kulon' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-slate-50 px-6 py-3.5 border-t border-slate-200 flex justify-end">
                    <button @click="showMaklumatModal = false" type="button" class="px-5 py-2 bg-slate-700 hover:bg-slate-800 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-xs transition cursor-pointer">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Galeri & Album Kegiatan (2 Album + 2 Video) -->
<section id="galeri" class="py-16 bg-slate-50 border-b border-slate-200/80" x-data="{
    lightboxOpen: false,
    lightboxSrc: '',
    lightboxTitle: '',
    lightboxSlug: '',
    videoOpen: false,
    videoEmbedUrl: '',
    videoTitle: ''
}">
    <div class="container mx-auto px-4">
        <!-- Header Seksi Galeri & Video -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 pb-4 border-b border-slate-200/80 reveal fade-up">
            <div>
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-slate-100 text-slate-800 text-[11px] font-extrabold tracking-widest uppercase rounded-full mb-3 border border-slate-200 shadow-xs">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Dokumentasi Visual & Video
                </span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">Galeri Album & Video Kegiatan</h2>
                <p class="text-slate-500 mt-2 text-sm sm:text-base font-medium max-w-xl">Dokumentasi resmi foto program serta video kegiatan warga Kelurahan Kandang Jati Kulon.</p>
            </div>
            <div class="hidden md:flex flex-wrap items-center gap-3 mt-5 md:mt-0 shrink-0">
                <a href="{{ route('galleries.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200/80 px-4 py-2.5 rounded-xl transition-all shadow-xs hover:shadow group">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>Semua Album Foto</span>
                    <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
                <a href="{{ route('videos.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200/80 px-4 py-2.5 rounded-xl transition-all shadow-xs hover:shadow group">
                    <svg class="w-3.5 h-3.5 text-rose-600 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    <span>Semua Video Dokumentasi</span>
                    <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-3 lg:grid-cols-4 gap-1.5 sm:gap-6">
            <!-- 1. DUA ALBUM FOTO (2 Cards) -->
            @php
                $albumsList = (isset($galleries) && $galleries->count() > 0) ? $galleries->take(2) : collect([]);
            @endphp

            @if($albumsList->count() > 0)
                @foreach($albumsList as $index => $gallery)
                @php
                    $coverUrl = method_exists($gallery, 'getCoverUrlAttribute') ? $gallery->cover_url : (Str::startsWith($gallery->cover_image ?? $gallery->image_path, ['http://', 'https://']) ? ($gallery->cover_image ?? $gallery->image_path) : Storage::url($gallery->cover_image ?? $gallery->image_path));
                    $photoCount = $gallery->photos_count ?? (isset($gallery->photos) ? $gallery->photos->count() : 1);
                    $albumSlug = $gallery->slug ?? null;
                @endphp
                <div class="group bg-white rounded-xl sm:rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-emerald-500/30 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between relative reveal fade-up" data-delay="{{ $index * 80 }}">
                    <!-- Top Accent Line on Hover -->
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 to-teal-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20"></div>

                    <div>
                        <!-- Cover Image Container -->
                        <div class="relative aspect-video w-full overflow-hidden bg-slate-950">
                            <img src="{{ $coverUrl }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-95 group-hover:opacity-100">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>

                            <!-- Category Badge Top-Left -->
                            <div class="absolute top-1.5 left-1.5 sm:top-3 sm:left-3 z-10">
                                <span class="px-1.5 py-0.5 sm:px-2.5 sm:py-1 bg-slate-900/80 backdrop-blur-md text-emerald-400 text-[7px] sm:text-[10px] font-bold uppercase tracking-wider rounded-md sm:rounded-lg border border-slate-700/80 shadow-xs">
                                    {{ ucfirst($gallery->category ?? 'Pemberdayaan') }}
                                </span>
                            </div>

                            <!-- Count Badge Bottom-Right -->
                            <div class="absolute bottom-1.5 right-1.5 sm:bottom-3 sm:right-3 z-10">
                                <span class="px-1.5 py-0.5 sm:px-2.5 sm:py-1 bg-emerald-600/90 backdrop-blur-md text-white text-[7px] sm:text-[11px] font-bold rounded-md sm:rounded-lg shadow-md flex items-center gap-1 border border-white/20">
                                    <svg class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $photoCount }} Foto
                                </span>
                            </div>

                            <!-- Hover Overlay Preview Button -->
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 bg-slate-950/40 backdrop-blur-xs">
                                <button @click.prevent="lightboxSrc = '{{ addslashes($coverUrl) }}'; lightboxTitle = '{{ addslashes($gallery->title) }}'; lightboxSlug = '{{ $albumSlug }}'; lightboxOpen = true;" class="bg-white/95 hover:bg-white text-slate-900 font-bold py-1 px-2.5 sm:py-2 sm:px-4 rounded-full text-[9px] sm:text-xs shadow-xl transition transform group-hover:scale-105 flex items-center gap-1.5 cursor-pointer">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    <span class="hidden sm:inline">Perbesar Cover</span>
                                </button>
                            </div>
                        </div>

                        <!-- Content Info -->
                        <div class="p-2 sm:p-5">
                            @if($albumSlug)
                            <a href="{{ route('galleries.show', $albumSlug) }}">
                                <h3 class="font-bold text-[9px] sm:text-base text-slate-900 leading-tight sm:leading-snug group-hover:text-emerald-700 transition line-clamp-2 mb-1 sm:mb-2">
                                    {{ $gallery->title }}
                                </h3>
                            </a>
                            @else
                            <h3 class="font-bold text-[9px] sm:text-base text-slate-900 leading-tight sm:leading-snug group-hover:text-emerald-700 transition line-clamp-2 mb-1 sm:mb-2">
                                {{ $gallery->title }}
                            </h3>
                            @endif
                            <p class="text-[7px] sm:text-xs text-slate-500 font-normal flex items-center gap-0.5 sm:gap-1">
                                <svg class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $gallery->event_date ? \Carbon\Carbon::parse($gallery->event_date)->translatedFormat('d F Y') : 'Dokumentasi' }}
                            </p>
                        </div>
                    </div>

                    <div class="px-2 pb-2 pt-0 sm:px-5 sm:pb-5">
                        <div class="pt-1.5 sm:pt-3 border-t border-slate-100 flex items-center justify-between">
                            @if($albumSlug)
                            <a href="{{ route('galleries.show', $albumSlug) }}" class="inline-flex items-center gap-1 text-[8px] sm:text-xs font-bold text-emerald-600 hover:text-emerald-700 group-hover:translate-x-1 transition-all">
                                <span>Lihat Album</span>
                                <svg class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                            @else
                            <button @click.prevent="lightboxSrc = '{{ addslashes($coverUrl) }}'; lightboxTitle = '{{ addslashes($gallery->title) }}'; lightboxOpen = true;" class="inline-flex items-center gap-1 text-[8px] sm:text-xs font-bold text-emerald-600 hover:text-emerald-700 group-hover:translate-x-1 transition-all cursor-pointer">
                                <span>Perbesar</span>
                                <svg class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Fallback 2 Dummy Album Cards if DB empty -->
                @foreach([
                    ['title' => 'Pelatihan UMKM Kripik Warga Kandang Jati Kulon', 'date' => '12 Aug 2026', 'cat' => 'Pemberdayaan', 'img' => 'https://images.unsplash.com/photo-1542744100-8a38a7611dc8?q=80&w=600&auto=format&fit=crop'],
                    ['title' => 'Peresmian Drainase Lingkungan RW 03', 'date' => '28 Jul 2026', 'cat' => 'Pembangunan', 'img' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=600&auto=format&fit=crop']
                ] as $index => $dummyAlbum)
                <div class="group bg-white rounded-xl sm:rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-emerald-500/30 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between relative reveal fade-up" data-delay="{{ $index * 80 }}">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 to-teal-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20"></div>

                    <div>
                        <div class="relative aspect-video w-full overflow-hidden bg-slate-950">
                            <img src="{{ $dummyAlbum['img'] }}" alt="{{ $dummyAlbum['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-95">
                            <div class="absolute top-1.5 left-1.5 sm:top-3 sm:left-3 z-10">
                                <span class="px-1.5 py-0.5 sm:px-2.5 sm:py-1 bg-slate-900/80 backdrop-blur-md text-emerald-400 text-[7px] sm:text-[10px] font-bold uppercase tracking-wider rounded-md sm:rounded-lg border border-slate-700/80">{{ $dummyAlbum['cat'] }}</span>
                            </div>
                            <div class="absolute bottom-1.5 right-1.5 sm:bottom-3 sm:right-3 z-10">
                                <span class="px-1.5 py-0.5 sm:px-2.5 sm:py-1 bg-emerald-600/90 backdrop-blur-md text-white text-[7px] sm:text-[11px] font-bold rounded-md sm:rounded-lg shadow-md flex items-center gap-1 border border-white/20">
                                    <svg class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    4 Foto
                                </span>
                            </div>
                        </div>
                        <div class="p-2 sm:p-5">
                            <h3 class="font-bold text-[9px] sm:text-base text-slate-900 leading-tight sm:leading-snug group-hover:text-emerald-700 transition line-clamp-2 mb-1 sm:mb-2">{{ $dummyAlbum['title'] }}</h3>
                            <p class="text-[7px] sm:text-xs text-slate-500 font-normal flex items-center gap-0.5 sm:gap-1">
                                <svg class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $dummyAlbum['date'] }}
                            </p>
                        </div>
                    </div>
                    <div class="px-2 pb-2 pt-0 sm:px-5 sm:pb-5">
                        <div class="pt-1.5 sm:pt-3 border-t border-slate-100">
                            <button @click.prevent="lightboxSrc = '{{ addslashes($dummyAlbum['img']) }}'; lightboxTitle = '{{ addslashes($dummyAlbum['title']) }}'; lightboxOpen = true;" class="inline-flex items-center gap-1 text-[8px] sm:text-xs font-bold text-emerald-600 hover:text-emerald-700 group-hover:translate-x-1 transition-all cursor-pointer">
                                <span>Perbesar</span>
                                <svg class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif

            <!-- 2. DUA VIDEO DOKUMENTASI (2 Cards) -->
            @php
                $videosList = (isset($videos) && $videos->count() > 0) ? $videos->take(2) : collect([]);
            @endphp

            @if($videosList->count() > 0)
                @foreach($videosList as $index => $video)
                @php
                    $vThumb = $video->thumbnail_url;
                    $vEmbed = $video->embed_url;
                @endphp
                <div class="group bg-white rounded-xl sm:rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-rose-500/30 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between relative reveal fade-up" data-delay="{{ ($index + 2) * 80 }}">
                    <!-- Top Accent Line on Hover -->
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-rose-500 to-amber-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20"></div>

                    <div>
                        <!-- Thumbnail Container with Play Button -->
                        <div class="relative aspect-video w-full overflow-hidden bg-slate-950 cursor-pointer" @click="videoEmbedUrl = '{{ addslashes($vEmbed) }}'; videoTitle = '{{ addslashes($video->title) }}'; videoOpen = true;">
                            <img src="{{ $vThumb }}" alt="{{ $video->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-90 group-hover:opacity-100">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>

                            <!-- Category Badge Top-Left -->
                            <div class="absolute top-1.5 left-1.5 sm:top-3 sm:left-3 z-10">
                                <span class="px-1.5 py-0.5 sm:px-2.5 sm:py-1 bg-rose-600/90 backdrop-blur-md text-white text-[7px] sm:text-[10px] font-bold uppercase tracking-wider rounded-md sm:rounded-lg border border-rose-400/40 shadow-xs flex items-center gap-1">
                                    <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    {{ ucfirst($video->category ?? 'Video Kegiatan') }}
                                </span>
                            </div>

                            <!-- Duration Badge Bottom-Right -->
                            <div class="absolute bottom-1.5 right-1.5 sm:bottom-3 sm:right-3 z-10">
                                <span class="px-1.5 py-0.5 sm:px-2.5 sm:py-1 bg-slate-900/90 backdrop-blur-md text-slate-200 text-[7px] sm:text-[10px] font-bold rounded-md sm:rounded-lg border border-slate-700/80 shadow-xs">
                                    {{ $video->duration ?? 'Video Dok.' }}
                                </span>
                            </div>

                            <!-- Center Glowing Play Icon -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-7 h-7 sm:w-12 sm:h-12 rounded-full bg-rose-600 text-white shadow-lg shadow-rose-600/40 flex items-center justify-center group-hover:scale-110 group-hover:bg-rose-500 transition duration-300 border-2 border-white/90">
                                    <svg class="w-3 h-3 sm:w-5 sm:h-5 fill-current ml-0.5" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Content Info -->
                        <div class="p-2 sm:p-5">
                            <h3 @click="videoEmbedUrl = '{{ addslashes($vEmbed) }}'; videoTitle = '{{ addslashes($video->title) }}'; videoOpen = true;" class="font-bold text-[9px] sm:text-base text-slate-900 leading-tight sm:leading-snug group-hover:text-rose-600 transition line-clamp-2 mb-1 sm:mb-2 cursor-pointer">
                                {{ $video->title }}
                            </h3>
                            <p class="text-[7px] sm:text-xs text-slate-500 font-normal line-clamp-1">
                                {{ $video->description ?? 'Video Liputan Resmi' }}
                            </p>
                        </div>
                    </div>

                    <div class="px-2 pb-2 pt-0 sm:px-5 sm:pb-5">
                        <div class="pt-1.5 sm:pt-3 border-t border-slate-100 flex items-center justify-between">
                            <button type="button" @click="videoEmbedUrl = '{{ addslashes($vEmbed) }}'; videoTitle = '{{ addslashes($video->title) }}'; videoOpen = true;" class="inline-flex items-center gap-1 text-[8px] sm:text-xs font-bold text-rose-600 hover:text-rose-700 group-hover:translate-x-1 transition-all cursor-pointer">
                                <svg class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                <span>Putar Video</span>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Fallback 2 Dummy Video Cards if DB empty -->
                @foreach([
                    ['title' => 'Video Profil Kelurahan Kandang Jati Kulon', 'cat' => 'Pemerintahan', 'dur' => '05:30', 'embed' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'thumb' => 'https://images.unsplash.com/photo-1574626003295-d868953930b8?q=80&w=600&auto=format&fit=crop'],
                    ['title' => 'Dokumentasi Gotong Royong RW 03', 'cat' => 'Pembangunan', 'dur' => '04:15', 'embed' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'thumb' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?q=80&w=600&auto=format&fit=crop']
                ] as $index => $dummyVid)
                <div class="group bg-white rounded-xl sm:rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-rose-500/30 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between relative reveal fade-up" data-delay="{{ ($index + 2) * 80 }}">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-rose-500 to-amber-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20"></div>

                    <div>
                        <div class="relative aspect-video w-full overflow-hidden bg-slate-950 cursor-pointer" @click="videoEmbedUrl = '{{ addslashes($dummyVid['embed']) }}'; videoTitle = '{{ addslashes($dummyVid['title']) }}'; videoOpen = true;">
                            <img src="{{ $dummyVid['thumb'] }}" alt="{{ $dummyVid['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-90">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>

                            <div class="absolute top-1.5 left-1.5 sm:top-3 sm:left-3 z-10">
                                <span class="px-1.5 py-0.5 sm:px-2.5 sm:py-1 bg-rose-600/90 backdrop-blur-md text-white text-[7px] sm:text-[10px] font-bold uppercase tracking-wider rounded-md sm:rounded-lg border border-rose-400/40 shadow-xs flex items-center gap-1">
                                    <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    {{ $dummyVid['cat'] }}
                                </span>
                            </div>

                            <div class="absolute bottom-1.5 right-1.5 sm:bottom-3 sm:right-3 z-10">
                                <span class="px-1.5 py-0.5 sm:px-2.5 sm:py-1 bg-slate-900/90 backdrop-blur-md text-slate-200 text-[7px] sm:text-[10px] font-bold rounded-md sm:rounded-lg border border-slate-700/80 shadow-xs">
                                    {{ $dummyVid['dur'] }}
                                </span>
                            </div>

                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-7 h-7 sm:w-12 sm:h-12 rounded-full bg-rose-600 text-white shadow-lg shadow-rose-600/40 flex items-center justify-center group-hover:scale-110 group-hover:bg-rose-500 transition duration-300 border-2 border-white/90">
                                    <svg class="w-3 h-3 sm:w-5 sm:h-5 fill-current ml-0.5" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </div>
                        </div>

                        <div class="p-2 sm:p-5">
                            <h3 @click="videoEmbedUrl = '{{ addslashes($dummyVid['embed']) }}'; videoTitle = '{{ addslashes($dummyVid['title']) }}'; videoOpen = true;" class="font-bold text-[9px] sm:text-base text-slate-900 leading-tight sm:leading-snug group-hover:text-rose-600 transition line-clamp-2 mb-1 sm:mb-2 cursor-pointer">
                                {{ $dummyVid['title'] }}
                            </h3>
                            <p class="text-[7px] sm:text-xs text-slate-500 font-normal line-clamp-1">Gambaran umum pelayanan...</p>
                        </div>
                    </div>

                    <div class="px-2 pb-2 pt-0 sm:px-5 sm:pb-5">
                        <div class="pt-1.5 sm:pt-3 border-t border-slate-100 flex items-center justify-between">
                            <button type="button" @click="videoEmbedUrl = '{{ addslashes($dummyVid['embed']) }}'; videoTitle = '{{ addslashes($dummyVid['title']) }}'; videoOpen = true;" class="inline-flex items-center gap-1 text-[8px] sm:text-xs font-bold text-rose-600 hover:text-rose-700 group-hover:translate-x-1 transition-all cursor-pointer">
                                <svg class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                <span>Putar Video</span>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

        <!-- Mobile Nav Buttons -->
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3 md:hidden">
            <a href="{{ route('galleries.index') }}" class="w-full sm:w-auto inline-flex justify-center text-xs font-bold text-emerald-800 transition items-center gap-2 uppercase tracking-wide bg-emerald-50 hover:bg-emerald-100 px-5 py-3 rounded-xl border border-emerald-200/80 shadow-xs">
                <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>Semua Album Foto</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
            <a href="{{ route('videos.index') }}" class="w-full sm:w-auto inline-flex justify-center text-xs font-bold text-rose-800 transition items-center gap-2 uppercase tracking-wide bg-rose-50 hover:bg-rose-100 px-5 py-3 rounded-xl border border-rose-200/80 shadow-xs">
                <svg class="w-4 h-4 text-rose-700 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                <span>Semua Video Dokumentasi</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>

    <!-- Seksi Kemitraan Strategis & Mitra Kerja (Carousel Minimalis & Responsif) -->
    <section id="kemitraan" class="py-10 bg-slate-50/50 relative z-10 border-t border-slate-200/60"
             x-data="{ 
                isPartnerDown: false, 
                partnerStartX: 0, 
                partnerScrollLeft: 0, 
                partnerDragged: false,
                onPartnerMouseDown(e) {
                    this.isPartnerDown = true;
                    this.partnerDragged = false;
                    if (this.$refs && this.$refs.partnerCarousel) {
                        this.partnerStartX = e.pageX - this.$refs.partnerCarousel.offsetLeft;
                        this.partnerScrollLeft = this.$refs.partnerCarousel.scrollLeft;
                    }
                },
                onPartnerMouseLeave() {
                    this.isPartnerDown = false;
                },
                onPartnerMouseUp() {
                    setTimeout(() => { this.partnerDragged = false; }, 50);
                    this.isPartnerDown = false;
                },
                onPartnerMouseMove(e) {
                    if (!this.isPartnerDown || !this.$refs || !this.$refs.partnerCarousel) return;
                    const x = e.pageX - this.$refs.partnerCarousel.offsetLeft;
                    const walk = (x - this.partnerStartX) * 1.5;
                    if (Math.abs(walk) > 5) {
                        this.partnerDragged = true;
                        this.$refs.partnerCarousel.scrollLeft = this.partnerScrollLeft - walk;
                    }
                },
                preventClickIfPartnerDragged(e) {
                    if (this.partnerDragged) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                }
             }">
        <div class="container mx-auto px-4">
            <div class="text-center flex flex-col items-center justify-center mb-6 reveal fade-up">
                <div class="flex flex-col items-center text-center">
                    <span class="inline-flex items-center gap-1.5 px-3 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-extrabold tracking-widest uppercase rounded-full mb-2 border border-emerald-200/60 shadow-2xs">
                        <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Sinergi & Kolaborasi
                    </span>
                    <h2 class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight text-center">Link Terkait</h2>
                    <p class="text-slate-500 mt-1 text-xs font-medium max-w-xl text-center">
                        Tautan penting instansi pemerintah, BUMN/BUMD, pendidikan, & mitra kerja di Kelurahan Kandang Jati Kulon.
                    </p>
                </div>
                
                <!-- Navigation Controls -->
                <div class="flex items-center gap-1.5 mt-3 shrink-0 z-30 relative justify-center">
                    <button type="button"
                            id="btn-partner-prev"
                            onclick="const el = document.getElementById('partner-carousel-container'); if(el) el.scrollBy({ left: -220, behavior: 'smooth' });"
                            @click="const el = document.getElementById('partner-carousel-container'); if(el) el.scrollBy({ left: -220, behavior: 'smooth' });" 
                            title="Geser Kiri"
                            class="w-7 h-7 rounded-lg bg-white hover:bg-emerald-600 border border-slate-200 hover:border-emerald-600 text-slate-700 hover:text-white transition-all duration-150 flex items-center justify-center shadow-2xs active:scale-95 cursor-pointer z-30 relative">
                        <svg class="w-3.5 h-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button type="button"
                            id="btn-partner-next"
                            onclick="const el = document.getElementById('partner-carousel-container'); if(el) el.scrollBy({ left: 220, behavior: 'smooth' });"
                            @click="const el = document.getElementById('partner-carousel-container'); if(el) el.scrollBy({ left: 220, behavior: 'smooth' });" 
                            title="Geser Kanan"
                            class="w-7 h-7 rounded-lg bg-emerald-600 hover:bg-emerald-700 border border-emerald-600 text-white transition-all duration-150 flex items-center justify-center shadow-xs active:scale-95 cursor-pointer z-30 relative">
                        <svg class="w-3.5 h-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>

            @if(isset($partnerships) && $partnerships->count() > 0)
            <!-- Horizontal Scroll Carousel (Ultra Compact Short Cards) -->
            <div class="relative group/carousel">
                <div id="partner-carousel-container"
                     x-ref="partnerCarousel" 
                     @mousedown="onPartnerMouseDown($event)"
                     @mouseleave="onPartnerMouseLeave()"
                     @mouseup="onPartnerMouseUp()"
                     @mousemove="onPartnerMouseMove($event)"
                     :class="isPartnerDown ? 'cursor-grabbing select-none' : 'cursor-grab'"
                     class="flex overflow-x-auto justify-center pb-3 pt-0.5 gap-3 snap-x snap-mandatory scrollbar-thin scrollbar-thumb-emerald-200 scrollbar-track-slate-50 hover:scrollbar-thumb-emerald-400 scroll-smooth">
                    @foreach($partnerships as $index => $partner)
                    @php
                        $cat = strtolower($partner->category ?? '');
                        $badgeStyle = 'bg-amber-50 text-amber-700 border-amber-200/60';
                        if (str_contains($cat, 'pemerintah') || str_contains($cat, 'instansi')) {
                            $badgeStyle = 'bg-emerald-50 text-emerald-700 border-emerald-200/60';
                        } elseif (str_contains($cat, 'bumn') || str_contains($cat, 'bumd')) {
                            $badgeStyle = 'bg-sky-50 text-sky-700 border-sky-200/60';
                        } elseif (str_contains($cat, 'pendidikan') || str_contains($cat, 'sekolah') || str_contains($cat, 'kampus')) {
                            $badgeStyle = 'bg-indigo-50 text-indigo-700 border-indigo-200/60';
                        }
                    @endphp
                    <a href="{{ $partner->website ?? '#' }}" 
                       @if(!empty($partner->website)) target="_blank" rel="noopener" @endif
                       @click="preventClickIfPartnerDragged($event)"
                       class="snap-start shrink-0 w-44 sm:w-48 md:w-52 flex flex-col justify-between bg-white border border-slate-200/80 hover:border-emerald-400 rounded-2xl p-3 shadow-2xs hover:shadow-md transition-all duration-200 group/card hover:-translate-y-0.5 cursor-pointer text-left">
                        <div>
                            <!-- Header Baris Kartu: Logo (Kiri) & Category (Kanan) -->
                            <div class="flex items-center justify-between gap-2 mb-2 pb-1.5 border-b border-slate-100">
                                <!-- Logo Frame Ringkas -->
                                <div class="w-7 h-7 rounded-lg bg-slate-50 p-1 border border-slate-100 flex items-center justify-center shrink-0 group-hover/card:bg-emerald-50 group-hover/card:border-emerald-200/60 transition duration-200">
                                    <img src="{{ $partner->logo }}" alt="{{ $partner->name }}" class="max-h-full max-w-full object-contain">
                                </div>

                                <!-- Category Badge -->
                                <span class="px-2 py-0.5 text-[8.5px] font-extrabold uppercase tracking-wider rounded-full border truncate max-w-[95px] text-right {{ $badgeStyle }}">
                                    {{ $partner->category }}
                                </span>
                            </div>

                            <!-- Partner Name -->
                            <h3 class="font-bold text-[11.5px] md:text-[12px] text-slate-800 group-hover/card:text-emerald-700 transition-colors leading-snug line-clamp-2 min-h-[2.2rem]">
                                {{ $partner->name }}
                            </h3>
                        </div>

                        @if($partner->website)
                        <div class="pt-1.5 border-t border-slate-100 mt-2.5">
                            <span class="text-[10px] font-bold text-emerald-600 group-hover/card:text-emerald-700 inline-flex items-center gap-1 group-hover/card:translate-x-0.5 transition-transform duration-200">
                                <span>Kunjungi Situs Resmi</span>
                                <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </span>
                        </div>
                        @endif
                    </a>
                    @endforeach
                </div>
            </div>
            @else
            <div class="text-center py-8 bg-white rounded-xl border border-slate-100 text-slate-400 text-xs">
                Belum ada data kemitraan aktif yang ditampilkan.
            </div>
            @endif
        </div>
    </section>

    <!-- 1. Lightbox Modal Foto -->
    <div x-show="lightboxOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[100] flex items-center justify-center p-4 lightbox-overlay bg-slate-950/80 backdrop-blur-md" style="display: none;">
        <div class="relative max-w-4xl w-full max-h-[85vh] bg-white rounded-2xl overflow-hidden shadow-2xl border border-slate-200">
            <button @click="lightboxOpen = false" class="absolute top-4 right-4 z-10 w-10 h-10 bg-slate-900/80 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-red-600 transition cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <img :src="lightboxSrc" :alt="lightboxTitle" class="w-full max-h-[70vh] object-contain bg-slate-950">
            <div class="p-5 bg-white flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div>
                    <h3 class="text-slate-900 font-bold text-base md:text-lg" x-text="lightboxTitle"></h3>
                    <p class="text-slate-500 text-xs mt-0.5">Kelurahan Kandang Jati Kulon — Dokumentasi Galeri Album</p>
                </div>
                <template x-if="lightboxSlug">
                    <a :href="'/galeri/' + lightboxSlug" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold text-xs transition inline-flex items-center gap-1.5">
                        Buka Album Full
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </template>
            </div>
        </div>
    </div>

    <!-- 2. Lightbox Modal Video Embed YouTube -->
    <div x-show="videoOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md" style="display: none;" x-cloak>
        <div class="relative max-w-4xl w-full bg-slate-900 rounded-2xl overflow-hidden shadow-2xl border border-slate-800">
            <div class="flex items-center justify-between px-5 py-3 border-b border-slate-800 text-white">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-500 animate-pulse"></span>
                    <h3 class="font-bold text-sm truncate max-w-lg" x-text="videoTitle"></h3>
                </div>
                <button @click="videoOpen = false; videoEmbedUrl = ''" class="text-slate-400 hover:text-white p-1 rounded-lg hover:bg-slate-800 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="relative aspect-video w-full bg-black">
                <template x-if="videoEmbedUrl">
                    <iframe :src="videoEmbedUrl + (videoEmbedUrl.includes('?') ? '&' : '?') + 'autoplay=1'" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </template>
            </div>
        </div>
    </div>
</section>
@endsection
