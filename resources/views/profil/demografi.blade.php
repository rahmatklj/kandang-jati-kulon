@extends('layouts.app')

@section('title', 'Statistik & Monografi Kelurahan - Kelurahan Kandang Jati Kulon')

@section('content')
<div class="bg-slate-100/70 min-h-screen">

    <!-- Page Header (Deep Dark Theme matching portal standard) -->
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
                            <span class="ml-1.5 text-slate-400">Informasi</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1.5 text-emerald-400 font-semibold">Statistik & Monografi</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-900/40 border border-emerald-500/30 rounded-full text-emerald-300 text-[11px] font-bold uppercase tracking-wider mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    Statistik & Monografi Resmi
                </div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white leading-tight mb-3">
                    Statistik & Monografi Kependudukan
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-2xl">
                    Data agregat kependudukan, sebaran jenis kelamin, mata pencaharian, bantuan sosial, serta pembagian wilayah RT/RW di Kelurahan Kandang Jati Kulon.
                </p>
            </div>
        </div>
    </div>

    @php
        $kelurahanName = $settings['nama_kelurahan'] ?? 'Kandang Jati Kulon';
    @endphp

    <!-- Main Content Area -->
    <div class="container mx-auto px-4 py-8 max-w-6xl space-y-6">

        @php
            $valTotal = (int)($settings['demografi_total'] ?? ($settings['jumlah_penduduk'] ?? 2776));
            $valKk = (int)($settings['demografi_kk'] ?? 850);
            $valLaki = (int)($settings['demografi_laki'] ?? 1402);
            $valPerempuan = (int)($settings['demografi_perempuan'] ?? 1374);
            $pctLaki = $valTotal > 0 ? round(($valLaki / $valTotal) * 100, 1) : 50.5;
            $pctPerempuan = $valTotal > 0 ? round(($valPerempuan / $valTotal) * 100, 1) : 49.5;

            $valPkh = (int)($settings['demografi_pkh'] ?? 285);
            $valBpnt = (int)($settings['demografi_bpnt'] ?? 335);
            $valKis = (int)($settings['demografi_kis'] ?? 1420);

            $valPetani = (int)($settings['demografi_pekerjaan_petani'] ?? 1240);
            $valPedagang = (int)($settings['demografi_pekerjaan_pedagang'] ?? 850);
            $valSwasta = (int)($settings['demografi_pekerjaan_swasta'] ?? 1420);
            $valPns = (int)($settings['demografi_pekerjaan_pns'] ?? 310);

            $pctPetani = $valTotal > 0 ? round(($valPetani / $valTotal) * 100, 1) : 44.7;
            $pctPedagang = $valTotal > 0 ? round(($valPedagang / $valTotal) * 100, 1) : 30.6;
            $pctSwasta = $valTotal > 0 ? round(($valSwasta / $valTotal) * 100, 1) : 51.2;
            $pctPns = $valTotal > 0 ? round(($valPns / $valTotal) * 100, 1) : 11.2;
        @endphp

        <!-- 1. Top Summary Cards (4 Cards) -->
        <div class="grid grid-cols-3 lg:grid-cols-4 gap-1.5 sm:gap-4">
            
            <!-- Card 1: Total Jiwa Penduduk -->
            <div class="bg-white rounded-xl sm:rounded-2xl p-2 sm:p-5 shadow-sm border border-slate-200/90 flex flex-col items-center text-center justify-between">
                <div class="w-6 h-6 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-1.5 sm:mb-3 border border-emerald-100">
                    <svg class="w-3.5 h-3.5 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div class="text-xs sm:text-3xl font-extrabold text-slate-900 mb-0.5 sm:mb-1">
                    {{ number_format($valTotal, 0, ',', '.') }}
                </div>
                <div class="text-[6.5px] sm:text-[10.5px] font-bold text-slate-500 uppercase tracking-wider">
                    Total Penduduk
                </div>
            </div>

            <!-- Card 2: Jumlah Kepala Keluarga -->
            <div class="bg-white rounded-xl sm:rounded-2xl p-2 sm:p-5 shadow-sm border border-slate-200/90 flex flex-col items-center text-center justify-between">
                <div class="w-6 h-6 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-1.5 sm:mb-3 border border-blue-100">
                    <svg class="w-3.5 h-3.5 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
                </div>
                <div class="text-xs sm:text-3xl font-extrabold text-slate-900 mb-0.5 sm:mb-1">
                    {{ number_format($valKk, 0, ',', '.') }}
                </div>
                <div class="text-[6.5px] sm:text-[10.5px] font-bold text-slate-500 uppercase tracking-wider">
                    Kepala Keluarga
                </div>
            </div>

            <!-- Card 3: Laki-Laki -->
            <div class="bg-white rounded-xl sm:rounded-2xl p-2 sm:p-5 shadow-sm border border-slate-200/90 flex flex-col items-center text-center justify-between">
                <div class="w-6 h-6 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-1.5 sm:mb-3 border border-purple-100">
                    <svg class="w-3.5 h-3.5 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm9 7h-6v13h-2v-6h-2v6H9V9H3V7h18v2z"/></svg>
                </div>
                <div class="text-xs sm:text-3xl font-extrabold text-slate-900 mb-0.5 sm:mb-1">
                    {{ number_format($valLaki, 0, ',', '.') }}
                </div>
                <div class="text-[6.5px] sm:text-[10.5px] font-bold text-slate-500 uppercase tracking-wider">
                    Laki-Laki ({{ $pctLaki }}%)
                </div>
            </div>

            <!-- Card 4: Perempuan -->
            <div class="bg-white rounded-xl sm:rounded-2xl p-2 sm:p-5 shadow-sm border border-slate-200/90 flex flex-col items-center text-center justify-between">
                <div class="w-6 h-6 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center mb-1.5 sm:mb-3 border border-rose-100">
                    <svg class="w-3.5 h-3.5 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm2.5 7h-1v4h2l-2.5 9h-2l-2.5-9h2V9h-1c-1.1 0-2 .9-2 2v7h2v4h4v-4h2v-7c0-1.1-.9-2-2-2z"/></svg>
                </div>
                <div class="text-xs sm:text-3xl font-extrabold text-slate-900 mb-0.5 sm:mb-1">
                    {{ number_format($valPerempuan, 0, ',', '.') }}
                </div>
                <div class="text-[6.5px] sm:text-[10.5px] font-bold text-slate-500 uppercase tracking-wider">
                    Perempuan ({{ $pctPerempuan }}%)
                </div>
            </div>

        </div>

        <!-- 2. Data Penerima Bantuan Sosial -->
        <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-200/90">
            <div class="flex items-center gap-2 text-slate-900 font-bold text-xs sm:text-base mb-3 sm:mb-5">
                <div class="p-1 sm:p-1.5 bg-emerald-50 text-emerald-600 rounded-lg">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <span>Data Penerima Bantuan Sosial</span>
            </div>

            <div class="grid grid-cols-3 gap-1.5 sm:gap-4">
                
                <!-- Penerima PKH -->
                <div class="bg-slate-50/70 rounded-lg sm:rounded-xl p-2 sm:p-4 border border-slate-100">
                    <div class="text-[7.5px] sm:text-xs font-semibold text-slate-600 mb-1 truncate">Penerima PKH</div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-xs sm:text-2xl font-black text-slate-900">{{ number_format($valPkh, 0, ',', '.') }}</span>
                        <span class="text-[6.5px] sm:text-xs text-slate-400 font-medium">Jiwa</span>
                    </div>
                </div>

                <!-- Penerima BPNT / Sembako -->
                <div class="bg-slate-50/70 rounded-lg sm:rounded-xl p-2 sm:p-4 border border-slate-100">
                    <div class="text-[7.5px] sm:text-xs font-semibold text-slate-600 mb-1 truncate">Penerima BPNT</div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-xs sm:text-2xl font-black text-slate-900">{{ number_format($valBpnt, 0, ',', '.') }}</span>
                        <span class="text-[6.5px] sm:text-xs text-slate-400 font-medium">Jiwa</span>
                    </div>
                </div>

                <!-- Penerima KIS / PBI BPJS -->
                <div class="bg-slate-50/70 rounded-lg sm:rounded-xl p-2 sm:p-4 border border-slate-100">
                    <div class="text-[7.5px] sm:text-xs font-semibold text-slate-600 mb-1 truncate">Penerima KIS/BPJS</div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-xs sm:text-2xl font-black text-slate-900">{{ number_format($valKis, 0, ',', '.') }}</span>
                        <span class="text-[6.5px] sm:text-xs text-slate-400 font-medium">Jiwa</span>
                    </div>
                </div>

            </div>
        </div>

        <!-- 3. Data Pekerjaan -->
        <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-200/90">
            <div class="flex items-center gap-2 text-slate-900 font-bold text-xs sm:text-base mb-3 sm:mb-5">
                <div class="p-1 sm:p-1.5 bg-blue-50 text-blue-600 rounded-lg">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <span>Distribusi Mata Pencaharian Penduduk</span>
            </div>

            <div class="grid grid-cols-3 lg:grid-cols-4 gap-1.5 sm:gap-4">
                
                <div class="bg-slate-50/70 rounded-lg sm:rounded-xl p-2 sm:p-4 border border-slate-100">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-[7.5px] sm:text-xs font-semibold text-slate-700 truncate">Petani</span>
                        <span class="bg-emerald-50 text-emerald-700 border border-emerald-200/60 text-[6.5px] sm:text-[10px] font-bold px-1 sm:px-2 py-0.5 rounded-full">{{ $pctPetani }}%</span>
                    </div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-xs sm:text-2xl font-black text-slate-900">{{ number_format($valPetani, 0, ',', '.') }}</span>
                        <span class="text-[6.5px] sm:text-xs text-slate-400 font-medium">Jiwa</span>
                    </div>
                </div>

                <div class="bg-slate-50/70 rounded-lg sm:rounded-xl p-2 sm:p-4 border border-slate-100">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-[7.5px] sm:text-xs font-semibold text-slate-700 truncate">Pedagang</span>
                        <span class="bg-emerald-50 text-emerald-700 border border-emerald-200/60 text-[6.5px] sm:text-[10px] font-bold px-1 sm:px-2 py-0.5 rounded-full">{{ $pctPedagang }}%</span>
                    </div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-xs sm:text-2xl font-black text-slate-900">{{ number_format($valPedagang, 0, ',', '.') }}</span>
                        <span class="text-[6.5px] sm:text-xs text-slate-400 font-medium">Jiwa</span>
                    </div>
                </div>

                <div class="bg-slate-50/70 rounded-lg sm:rounded-xl p-2 sm:p-4 border border-slate-100">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-[7.5px] sm:text-xs font-semibold text-slate-700 truncate">Swasta</span>
                        <span class="bg-emerald-50 text-emerald-700 border border-emerald-200/60 text-[6.5px] sm:text-[10px] font-bold px-1 sm:px-2 py-0.5 rounded-full">{{ $pctSwasta }}%</span>
                    </div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-xs sm:text-2xl font-black text-slate-900">{{ number_format($valSwasta, 0, ',', '.') }}</span>
                        <span class="text-[6.5px] sm:text-xs text-slate-400 font-medium">Jiwa</span>
                    </div>
                <div class="bg-slate-50/70 rounded-lg sm:rounded-xl p-2 sm:p-4 border border-slate-100">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-[7.5px] sm:text-xs font-semibold text-slate-700 truncate">PNS / TNI</span>
                        <span class="bg-emerald-50 text-emerald-700 border border-emerald-200/60 text-[6.5px] sm:text-[10px] font-bold px-1 sm:px-2 py-0.5 rounded-full">{{ $pctPns }}%</span>
                    </div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-xs sm:text-2xl font-black text-slate-900">{{ number_format($valPns, 0, ',', '.') }}</span>
                        <span class="text-[6.5px] sm:text-xs text-slate-400 font-medium">Jiwa</span>
                    </div>
                </div>

            </div>
        </div>

        <!-- 4. Wilayah Administrasi RW & RT -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/90">
            <div class="flex items-center gap-2.5 text-slate-900 font-bold text-sm sm:text-base mb-5">
                <div class="p-1.5 bg-emerald-50 text-emerald-600 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <span>Wilayah Administrasi Rukun Warga (RW) & Rukun Tetangga (RT)</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                
                @if(isset($rukunWargas) && $rukunWargas->count() > 0)
                    @foreach($rukunWargas as $rw)
                    <div class="bg-emerald-50/50 border border-emerald-100 rounded-xl p-4 flex flex-col justify-between hover:shadow-sm transition">
                        <div>
                            <h4 class="font-bold text-slate-900 text-xs sm:text-sm mb-2">{{ $rw->nama_rw }}</h4>
                            <p class="text-xs text-slate-600 mb-1">
                                Jumlah RT: <span class="font-bold text-slate-800">{{ $rw->jumlah_rt }} RT</span>
                            </p>
                            <p class="text-xs text-slate-600">
                                Estimasi: <span class="font-bold text-slate-800">~{{ number_format($rw->estimasi_penduduk, 0, ',', '.') }} Jiwa</span>
                            </p>
                        </div>
                    </div>
                    @endforeach
                @else
                    @for($i = 1; $i <= 4; $i++)
                    <div class="bg-emerald-50/50 border border-emerald-100 rounded-xl p-4 flex flex-col justify-between hover:shadow-sm transition">
                        <div>
                            <h4 class="font-bold text-slate-900 text-xs sm:text-sm mb-2">RW 0{{ $i }} {{ $kelurahanName }}</h4>
                            <p class="text-xs text-slate-600 mb-1">
                                Jumlah RT: <span class="font-bold text-slate-800">{{ $i % 2 == 0 ? '4' : '5' }} RT</span>
                            </p>
                            <p class="text-xs text-slate-600">
                                Estimasi: <span class="font-bold text-slate-800">~1.200 Jiwa</span>
                            </p>
                        </div>
                    </div>
                    @endfor
                @endif

            </div>
        </div>

    </div>
</div>
@endsection
