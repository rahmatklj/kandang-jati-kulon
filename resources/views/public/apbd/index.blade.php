@extends('layouts.app')

@section('title', 'Transparansi Anggaran (APBD / APB-Kel) - Kelurahan Kandang Jati Kulon')

@section('content')
<div class="bg-slate-50 min-h-screen">

    <!-- Page Header Banner (Deep Dark Theme) -->
    <div class="bg-[#0b1329] text-white border-b border-slate-800 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute left-1/4 -bottom-10 w-80 h-80 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="container mx-auto px-4 py-8 md:py-12 relative z-10">
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
                            <span class="ml-1.5 text-slate-400 font-medium">Informasi</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1.5 text-emerald-400 font-bold">Transparansi Anggaran (APBD)</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-900/40 border border-emerald-500/30 rounded-full text-emerald-300 text-[11px] font-bold uppercase tracking-wider mb-3">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Akuntabilitas & Keterbukaan Informasi Publik
                    </div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white leading-tight mb-3">
                        Transparansi APBD Kelurahan Kandang Jati Kulon
                    </h1>
                    <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-2xl">
                        Rincian publikasi Anggaran Pendapatan dan Belanja Kelurahan (APB-Kel) Kandang Jati Kulon, Kecamatan Kraksaan, Kabupaten Probolinggo Tahun Anggaran {{ $selectedYear }}.
                    </p>
                </div>

                <!-- Year Selector Form -->
                <div class="bg-slate-900/90 border border-slate-800 p-4 rounded-2xl shadow-xl shrink-0">
                    <form method="GET" action="{{ route('apbd.index') }}" class="flex flex-col gap-1.5">
                        <label class="text-[11px] font-extrabold uppercase tracking-wider text-emerald-400">Pilih Tahun Anggaran:</label>
                        <select name="tahun" onchange="this.form.submit()" class="px-4 py-2.5 bg-slate-800 border border-slate-700 text-white rounded-xl text-xs font-bold focus:ring-2 focus:ring-emerald-500 focus:outline-none transition cursor-pointer">
                            @foreach($availableYears as $y)
                                <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>Tahun Anggaran {{ $y }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="container mx-auto px-4 py-8 md:py-10 max-w-7xl space-y-10">

        <!-- Executive Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Card 1: Pendapatan -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm relative overflow-hidden flex flex-col justify-between group hover:shadow-lg transition duration-300">
                <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-emerald-500 to-teal-500"></div>
                
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-black uppercase tracking-widest text-emerald-800">1. Pendapatan</span>
                        <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-50 text-emerald-700 border border-emerald-200">
                            {{ $persenPendapatan }}% Realisasi
                        </span>
                    </div>

                    <div class="space-y-1">
                        <div class="text-3xl font-black text-slate-900 tracking-tight">
                            Rp {{ number_format($totalPendapatanRealisasi, 0, ',', '.') }}
                        </div>
                        <div class="text-xs text-slate-500 font-semibold">
                            Target Pagu: <span class="font-bold text-slate-700">Rp {{ number_format($totalPendapatanAnggaran, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100">
                    <div class="flex justify-between text-[11px] font-bold text-slate-500 mb-1.5">
                        <span>Capaian Terkumpul</span>
                        <span>{{ $persenPendapatan }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-gradient-to-r from-emerald-500 to-teal-500 h-2.5 rounded-full transition-all duration-700" style="width: {{ min(100, $persenPendapatan) }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Belanja -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm relative overflow-hidden flex flex-col justify-between group hover:shadow-lg transition duration-300">
                <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-indigo-500 to-blue-500"></div>
                
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-black uppercase tracking-widest text-indigo-800">2. Belanja</span>
                        <span class="px-3 py-1 rounded-full text-xs font-black bg-indigo-50 text-indigo-700 border border-indigo-200">
                            {{ $persenBelanja }}% Terpakai
                        </span>
                    </div>

                    <div class="space-y-1">
                        <div class="text-3xl font-black text-slate-900 tracking-tight">
                            Rp {{ number_format($totalBelanjaRealisasi, 0, ',', '.') }}
                        </div>
                        <div class="text-xs text-slate-500 font-semibold">
                            Target Pagu: <span class="font-bold text-slate-700">Rp {{ number_format($totalBelanjaAnggaran, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100">
                    <div class="flex justify-between text-[11px] font-bold text-slate-500 mb-1.5">
                        <span>Serapan Anggaran</span>
                        <span>{{ $persenBelanja }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-500 to-blue-500 h-2.5 rounded-full transition-all duration-700" style="width: {{ min(100, $persenBelanja) }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Card 3: SILPA / Keseimbangan -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm relative overflow-hidden flex flex-col justify-between group hover:shadow-lg transition duration-300">
                <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-teal-500 to-emerald-600"></div>
                
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-black uppercase tracking-widest text-teal-800">3. Pembiayaan & SILPA</span>
                        <span class="px-3 py-1 rounded-full text-xs font-black bg-teal-50 text-teal-700 border border-teal-200">
                            Kas Kelurahan
                        </span>
                    </div>

                    <div class="space-y-1">
                        <div class="text-3xl font-black {{ $silpaRealisasi >= 0 ? 'text-teal-700' : 'text-rose-600' }} tracking-tight">
                            Rp {{ number_format($silpaRealisasi, 0, ',', '.') }}
                        </div>
                        <div class="text-xs text-slate-500 font-semibold">
                            Net Surplus / Defisit: <span class="font-bold text-slate-700">Rp {{ number_format($surplusDefisitRealisasi, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-slate-600">
                    <span>Status Kas Keuangan:</span>
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-extrabold">Seimbang & Akuntabel</span>
                </div>
            </div>

        </div>

        <!-- Section 1: RINCIAN PENDAPATAN -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-900 to-slate-900 px-6 py-4 text-white flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-black">
                        1
                    </div>
                    <div>
                        <h2 class="font-black text-base md:text-lg tracking-tight">Pendapatan Kelurahan Kandang Jati Kulon</h2>
                        <p class="text-slate-300 text-xs">Pagu dan realisasi sumber pendapatan daerah / alokasi dana kelurahan TA {{ $selectedYear }}.</p>
                    </div>
                </div>
                <div class="text-right hidden sm:block">
                    <div class="text-xs text-slate-300">Total Realisasi Pendapatan:</div>
                    <div class="text-base font-black text-emerald-300">Rp {{ number_format($totalPendapatanRealisasi, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="p-6">
                @forelse($pendapatanGrouped as $kategori => $groupItems)
                <div class="mb-6 last:mb-0">
                    <div class="flex items-center justify-between bg-slate-100/80 px-4 py-2.5 rounded-xl mb-3 border border-slate-200/80">
                        <span class="font-black text-xs uppercase tracking-wider text-slate-700">{{ $kategori }}</span>
                        <span class="text-xs font-extrabold text-slate-800">
                            Subtotal Realisasi: Rp {{ number_format($groupItems->sum('realisasi'), 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-slate-500 uppercase text-[10.5px] font-extrabold tracking-wider border-b border-slate-200">
                                    <th class="py-2.5 px-3">Uraian Rincian Sumber Pendapatan</th>
                                    <th class="py-2.5 px-3 text-right">Target Pagu (Rp)</th>
                                    <th class="py-2.5 px-3 text-right">Realisasi (Rp)</th>
                                    <th class="py-2.5 px-3 text-center">Capaian (%)</th>
                                    <th class="py-2.5 px-3 text-center">Laporan PDF</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                                @foreach($groupItems as $item)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-3 px-3">
                                        <div class="font-bold text-slate-800 text-xs">{{ $item->uraian }}</div>
                                        @if($item->keterangan)
                                            <div class="text-[11px] text-slate-500 italic mt-0.5">{{ $item->keterangan }}</div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3 text-right font-bold text-slate-800">
                                        Rp {{ number_format($item->anggaran, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-3 text-right font-black text-emerald-700">
                                        Rp {{ number_format($item->realisasi, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-3 text-center font-extrabold">
                                        <span class="px-2.5 py-1 rounded-full text-[11px] bg-emerald-50 text-emerald-800 border border-emerald-200">
                                            {{ $item->persentase_realisasi }}%
                                        </span>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        @if($item->berkas_laporan_pdf)
                                            <a href="{{ route('apbd.download', $item->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition shadow-2xs">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                Unduh PDF
                                            </a>
                                        @else
                                            <span class="text-slate-400 text-xs italic">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-slate-400">
                    <p class="text-xs font-semibold">Belum ada rincian data pendapatan untuk tahun {{ $selectedYear }}.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Section 2: RINCIAN BELANJA -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-900 to-slate-900 px-6 py-4 text-white flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-indigo-500/20 text-indigo-300 flex items-center justify-center font-black">
                        2
                    </div>
                    <div>
                        <h2 class="font-black text-base md:text-lg tracking-tight">Belanja Kelurahan Kandang Jati Kulon</h2>
                        <p class="text-slate-300 text-xs">Pagu dan serapan belanja operasional, fisik sarpras, dan pembedayaan TA {{ $selectedYear }}.</p>
                    </div>
                </div>
                <div class="text-right hidden sm:block">
                    <div class="text-xs text-slate-300">Total Realisasi Belanja:</div>
                    <div class="text-base font-black text-indigo-300">Rp {{ number_format($totalBelanjaRealisasi, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="p-6">
                @forelse($belanjaGrouped as $kategori => $groupItems)
                <div class="mb-6 last:mb-0">
                    <div class="flex items-center justify-between bg-slate-100/80 px-4 py-2.5 rounded-xl mb-3 border border-slate-200/80">
                        <span class="font-black text-xs uppercase tracking-wider text-slate-700">{{ $kategori }}</span>
                        <span class="text-xs font-extrabold text-slate-800">
                            Subtotal Serapan: Rp {{ number_format($groupItems->sum('realisasi'), 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-slate-500 uppercase text-[10.5px] font-extrabold tracking-wider border-b border-slate-200">
                                    <th class="py-2.5 px-3">Uraian Rincian Belanja & Kegiatan</th>
                                    <th class="py-2.5 px-3 text-right">Pagu Anggaran (Rp)</th>
                                    <th class="py-2.5 px-3 text-right">Realisasi (Rp)</th>
                                    <th class="py-2.5 px-3 text-center">Serapan (%)</th>
                                    <th class="py-2.5 px-3 text-center">Laporan PDF</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                                @foreach($groupItems as $item)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-3 px-3">
                                        <div class="font-bold text-slate-800 text-xs">{{ $item->uraian }}</div>
                                        @if($item->keterangan)
                                            <div class="text-[11px] text-slate-500 italic mt-0.5">{{ $item->keterangan }}</div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3 text-right font-bold text-slate-800">
                                        Rp {{ number_format($item->anggaran, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-3 text-right font-black text-indigo-700">
                                        Rp {{ number_format($item->realisasi, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-3 text-center font-extrabold">
                                        <span class="px-2.5 py-1 rounded-full text-[11px] bg-indigo-50 text-indigo-800 border border-indigo-200">
                                            {{ $item->persentase_realisasi }}%
                                        </span>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        @if($item->berkas_laporan_pdf)
                                            <a href="{{ route('apbd.download', $item->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold transition shadow-2xs">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                Unduh PDF
                                            </a>
                                        @else
                                            <span class="text-slate-400 text-xs italic">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-slate-400">
                    <p class="text-xs font-semibold">Belum ada rincian data belanja untuk tahun {{ $selectedYear }}.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Section 3: PEMBIAYAAN & SILPA -->
        @if($pembiayaanItems->count() > 0)
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-teal-900 to-slate-900 px-6 py-4 text-white flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-teal-500/20 text-teal-300 flex items-center justify-center font-black">
                        3
                    </div>
                    <div>
                        <h2 class="font-black text-base md:text-lg tracking-tight">Pembiayaan & SILPA Kas Kelurahan</h2>
                        <p class="text-slate-300 text-xs">Penerimaan pembiayaan sisa lebih perhitungan anggaran TA {{ $selectedYear }}.</p>
                    </div>
                </div>
                <div class="text-right hidden sm:block">
                    <div class="text-xs text-slate-300">Total Realisasi Pembiayaan:</div>
                    <div class="text-base font-black text-teal-300">Rp {{ number_format($totalPembiayaanRealisasi, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="p-6">
                @foreach($pembiayaanGrouped as $kategori => $groupItems)
                <div class="mb-4 last:mb-0">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-slate-500 uppercase text-[10.5px] font-extrabold tracking-wider border-b border-slate-200">
                                    <th class="py-2.5 px-3">Uraian Rincian Pembiayaan</th>
                                    <th class="py-2.5 px-3 text-right">Pagu (Rp)</th>
                                    <th class="py-2.5 px-3 text-right">Realisasi (Rp)</th>
                                    <th class="py-2.5 px-3 text-center">Laporan PDF</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                                @foreach($groupItems as $item)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-3 px-3">
                                        <div class="font-bold text-slate-800 text-xs">{{ $item->uraian }}</div>
                                        @if($item->keterangan)
                                            <div class="text-[11px] text-slate-500 italic mt-0.5">{{ $item->keterangan }}</div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3 text-right font-bold text-slate-800">
                                        Rp {{ number_format($item->anggaran, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-3 text-right font-black text-teal-700">
                                        Rp {{ number_format($item->realisasi, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        @if($item->berkas_laporan_pdf)
                                            <a href="{{ route('apbd.download', $item->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1 bg-teal-600 hover:bg-teal-700 text-white rounded-lg text-xs font-bold transition shadow-2xs">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                Unduh PDF
                                            </a>
                                        @else
                                            <span class="text-slate-400 text-xs italic">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Disclaimer Callout Box -->
        <div class="bg-gradient-to-r from-slate-900 to-emerald-950 rounded-3xl p-6 text-white border border-slate-800 shadow-xl flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-black shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h3 class="font-black text-sm md:text-base">Komitmen Keterbukaan Informasi Publik (KIP)</h3>
                    <p class="text-slate-300 text-xs mt-1 leading-relaxed">
                        Data anggaran dan realisasi APBD Kelurahan Kandang Jati Kulon dipublikasikan secara transparan berdasarkan Undang-Undang No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik.
                    </p>
                </div>
            </div>
            <a href="{{ route('contact') }}" class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-extrabold text-xs rounded-xl transition shrink-0 shadow-md">
                Hubungi Kami / Pengaduan
            </a>
        </div>

    </div>
</div>
@endsection
