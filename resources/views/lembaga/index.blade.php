@extends('layouts.app')

@section('title', 'Lembaga Kemasyarakatan - Kelurahan Kandang Jati Kulon')

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
                            <span class="ml-1.5 text-emerald-400 font-semibold">Lembaga Kemasyarakatan</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-900/40 border border-emerald-500/30 rounded-full text-emerald-300 text-[11px] font-bold uppercase tracking-wider mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    Mitra Pembangunan Kelurahan
                </div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white leading-tight mb-3">
                    Lembaga Kemasyarakatan Kelurahan
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-2xl">
                    Wadah partisipasi warga dalam pembangunan, pemberdayaan ekonomi, kesehatan keluarga, ketertiban lingkungan, dan kepemudaan di Kelurahan Kandang Jati Kulon.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            @forelse($lembagas as $lembaga)
                @php
                    $theme = $lembaga->color_theme ?? 'emerald';
                    $badgeBg = 'bg-emerald-50 text-emerald-700 border-emerald-200/60';
                    $iconColor = 'bg-emerald-50 text-emerald-600 border-emerald-100';

                    if ($theme === 'rose' || str_contains(strtolower($lembaga->name), 'pkk')) {
                        $badgeBg = 'bg-rose-50 text-rose-700 border-rose-200/60';
                        $iconColor = 'bg-rose-50 text-rose-600 border-rose-100';
                    } elseif ($theme === 'blue' || str_contains(strtolower($lembaga->name), 'karang taruna')) {
                        $badgeBg = 'bg-blue-50 text-blue-700 border-blue-200/60';
                        $iconColor = 'bg-blue-50 text-blue-600 border-blue-100';
                    } elseif ($theme === 'amber' || str_contains(strtolower($lembaga->name), 'pilar') || str_contains(strtolower($lembaga->name), 'linmas')) {
                        $badgeBg = 'bg-amber-50 text-amber-800 border-amber-200/60';
                        $iconColor = 'bg-amber-50 text-amber-600 border-amber-100';
                    }
                @endphp
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/90 flex flex-col justify-between hover:shadow-md hover:border-emerald-400 transition-all duration-200 group h-full">
                    <div>
                        <!-- Icon Circle & Category -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-xl flex items-center justify-center border shadow-2xs {{ $iconColor }}">
                                    @if($lembaga->icon === 'building' || str_contains(strtolower($lembaga->name), 'lpmk'))
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 1L3 5v2h18V5L12 1zm-7 8v9h3V9H5zm5 0v9h3V9h-3zm5 0v9h3V9h-3zm5 0v9h3V9h-3zM2 20v2h20v-2H2z"/>
                                        </svg>
                                    @elseif($lembaga->icon === 'user-female' || str_contains(strtolower($lembaga->name), 'pkk'))
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2a4 4 0 100 8 4 4 0 000-8zm-5 11c-1.1 0-2 .9-2 2v4c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-4c0-1.1-.9-2-2-2H7z"/>
                                        </svg>
                                    @elseif($lembaga->icon === 'user-male' || str_contains(strtolower($lembaga->name), 'karang taruna'))
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2a4 4 0 100 8 4 4 0 000-8zm-4 10c-1.66 0-3 1.34-3 3v6h14v-6c0-1.66-1.34-3-3-3H8z"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
                                        </svg>
                                    @endif
                                </div>
                                @if(!empty($lembaga->abbreviation))
                                <span class="px-2.5 py-0.5 rounded-lg text-xs font-black uppercase tracking-wider border {{ $badgeBg }}">
                                    {{ $lembaga->abbreviation }}
                                </span>
                                @endif
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold border bg-emerald-50 text-emerald-700 border-emerald-200/60">
                                Active
                            </span>
                        </div>

                        <!-- Title -->
                        <h3 class="text-base font-bold text-slate-900 mb-2 leading-snug group-hover:text-emerald-700 transition-colors">
                            {{ $lembaga->name }}
                        </h3>

                        <!-- Description -->
                        <p class="text-xs text-slate-500 leading-relaxed mb-6">
                            {{ $lembaga->description ?? 'Lembaga kemasyarakatan yang aktif berpartisipasi dalam program kerja kelurahan.' }}
                        </p>
                    </div>

                    <!-- Footer Info -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600 font-medium">
                        <div>
                            <span class="text-slate-400 text-[11px] block uppercase font-bold">{{ $lembaga->leader_title ?? 'Ketua Lembaga' }}</span>
                            <strong class="text-slate-800 font-bold">{{ $lembaga->leader_name ?? '-' }}</strong>
                        </div>
                        @if(!empty($lembaga->members_count))
                        <div class="text-right">
                            <span class="text-slate-400 text-[11px] block uppercase font-bold">Kapasitas</span>
                            <span class="font-extrabold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100 text-[11px] inline-block mt-0.5">
                                {{ $lembaga->members_count }} Orang
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-slate-200 p-8">
                    <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h6m-6 0V11m0 0H9m3 0h3"></path></svg>
                    <h4 class="font-bold text-slate-700 text-sm mb-1">Belum Ada Data Lembaga</h4>
                    <p class="text-xs text-slate-400">Data lembaga kemasyarakatan kelurahan belum diinput oleh admin.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
