@extends('layouts.admin')

@section('title', 'Kelola APBD & Transparansi Anggaran')

@section('content')
<!-- Sub-Navigation Tabs Dokumen -->
<div class="flex flex-wrap items-center gap-2 mb-6 bg-slate-100 p-1.5 rounded-2xl w-fit border border-slate-200/80">
    <a href="{{ route('dashboard.documents.index', ['category' => 'sk-kelembagaan']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ (request()->routeIs('dashboard.documents.*') && request('category') === 'sk-kelembagaan') ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/60' }}">
        <span>SK Kelembagaan</span>
    </a>
    <a href="{{ route('dashboard.documents.index', ['category' => 'laporan-keuangan']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ (request()->routeIs('dashboard.documents.*') && request('category') === 'laporan-keuangan') ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/60' }}">
        <span>Laporan Keuangan</span>
    </a>
    <a href="{{ route('dashboard.documents.index', ['category' => 'regulasi-kebijakan']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ (request()->routeIs('dashboard.documents.*') && request('category') === 'regulasi-kebijakan') ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/60' }}">
        <span>Regulasi & Kebijakan</span>
    </a>
    <a href="{{ route('dashboard.apbd.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ request()->routeIs('dashboard.apbd.*') ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/60' }}">
        <span>Transparansi APBD</span>
    </a>
    <a href="{{ route('dashboard.documents.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ (request()->routeIs('dashboard.documents.*') && (!request('category') || request('category') === 'all')) ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/60' }}">
        <span>Semua Dokumen PDF</span>
    </a>
</div>

<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-black text-slate-800 tracking-tight">Kelola APBD & Transparansi Anggaran</h2>
        <p class="text-slate-500 text-sm">Kelola rincian anggaran pendapatan, belanja, pembiayaan, dan realisasi APBD Kelurahan Kandang Jati Kulon.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('apbd.index', ['tahun' => $selectedYear]) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs rounded-xl shadow-sm transition">
            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            Lihat Tampilan Publik
        </a>
    </div>
</div>

@if(session('success'))
<div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-xl mb-6 shadow-sm flex items-center justify-between" role="alert">
    <div class="flex items-center gap-3">
        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="font-semibold text-sm">{{ session('success') }}</span>
    </div>
    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold">&times;</button>
</div>
@endif

@if(session('error'))
<div class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 p-4 rounded-xl mb-6 shadow-sm flex items-center justify-between" role="alert">
    <div class="flex items-center gap-3">
        <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="font-semibold text-sm">{{ session('error') }}</span>
    </div>
    <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 font-bold">&times;</button>
</div>
@endif

<!-- Top Summary Metric Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
    <!-- Card 1: Total Pendapatan -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden flex flex-col justify-between">
        <div class="absolute top-0 left-0 w-1.5 h-full bg-emerald-500"></div>
        <div class="flex items-center justify-between mb-3 pl-2">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Pendapatan ({{ $selectedYear }})</span>
            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-emerald-50 text-emerald-700 border border-emerald-200">
                {{ $persenPendapatan }}% Realisasi
            </span>
        </div>
        <div class="pl-2">
            <div class="text-2xl font-black text-slate-800">
                Rp {{ number_format($totalPendapatanRealisasi, 0, ',', '.') }}
            </div>
            <div class="text-xs text-slate-500 font-medium mt-1">
                Target Pagu: <span class="font-bold text-slate-700">Rp {{ number_format($totalPendapatanAnggaran, 0, ',', '.') }}</span>
            </div>
        </div>
        <!-- Progress mini bar -->
        <div class="w-full bg-slate-100 rounded-full h-2 mt-4 overflow-hidden pl-2">
            <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ min(100, $persenPendapatan) }}%"></div>
        </div>
    </div>

    <!-- Card 2: Total Belanja -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden flex flex-col justify-between">
        <div class="absolute top-0 left-0 w-1.5 h-full bg-indigo-500"></div>
        <div class="flex items-center justify-between mb-3 pl-2">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Belanja ({{ $selectedYear }})</span>
            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-indigo-50 text-indigo-700 border border-indigo-200">
                {{ $persenBelanja }}% Realisasi
            </span>
        </div>
        <div class="pl-2">
            <div class="text-2xl font-black text-slate-800">
                Rp {{ number_format($totalBelanjaRealisasi, 0, ',', '.') }}
            </div>
            <div class="text-xs text-slate-500 font-medium mt-1">
                Target Pagu: <span class="font-bold text-slate-700">Rp {{ number_format($totalBelanjaAnggaran, 0, ',', '.') }}</span>
            </div>
        </div>
        <!-- Progress mini bar -->
        <div class="w-full bg-slate-100 rounded-full h-2 mt-4 overflow-hidden pl-2">
            <div class="bg-indigo-500 h-2 rounded-full" style="width: {{ min(100, $persenBelanja) }}%"></div>
        </div>
    </div>

    <!-- Card 3: SILPA / Keseimbangan -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden flex flex-col justify-between">
        <div class="absolute top-0 left-0 w-1.5 h-full bg-teal-500"></div>
        <div class="flex items-center justify-between mb-3 pl-2">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Sisa Lebih (SILPA {{ $selectedYear }})</span>
            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-teal-50 text-teal-700 border border-teal-200">
                Keseimbangan Kas
            </span>
        </div>
        <div class="pl-2">
            <div class="text-2xl font-black {{ $silpa >= 0 ? 'text-teal-600' : 'text-rose-600' }}">
                Rp {{ number_format($silpa, 0, ',', '.') }}
            </div>
            <div class="text-xs text-slate-500 font-medium mt-1">
                Net Surplus/Defisit: <span class="font-bold text-slate-700">Rp {{ number_format($surplusDefisitRealisasi, 0, ',', '.') }}</span>
            </div>
        </div>
        <div class="w-full bg-slate-100 rounded-full h-2 mt-4 overflow-hidden pl-2">
            <div class="bg-teal-500 h-2 rounded-full" style="width: 100%"></div>
        </div>
    </div>
</div>

<!-- Main Table Container with Filters & Controls -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden"
     x-data="{ 
         createModalOpen: false, 
         editModalOpen: false, 
         deleteModalOpen: false, 
         manageJenisModalOpen: false,
         manageCategoryModalOpen: false,
         deleteId: null, 
         deleteTitle: '',
         editData: {
             id: null,
             tahun_anggaran: {{ $selectedYear }},
             jenis: 'pendapatan',
             kategori: '',
             uraian: '',
             anggaran: '',
             realisasi: '',
             keterangan: '',
             is_published: true,
             pdf_url: null
         }
     }">
    
    <!-- Header & Filter Bar -->
    <div class="p-5 bg-slate-50/80 border-b border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Filter Form -->
        <form method="GET" action="{{ route('dashboard.apbd.index') }}" class="flex flex-wrap items-center gap-3">
            <!-- Year Dropdown Filter -->
            <div class="flex items-center gap-2">
                <label class="text-xs font-bold text-slate-600 uppercase tracking-wider">Tahun:</label>
                <select name="tahun" onchange="this.form.submit()" class="px-3 py-1.5 text-xs font-bold rounded-xl border border-slate-300 bg-white text-slate-800 focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    @foreach($availableYears as $y)
                        <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Jenis Filter -->
            <div class="flex items-center gap-2">
                <label class="text-xs font-bold text-slate-600 uppercase tracking-wider">Jenis:</label>
                <select name="jenis" onchange="this.form.submit()" class="px-3 py-1.5 text-xs font-bold rounded-xl border border-slate-300 bg-white text-slate-800 focus:ring-2 focus:ring-emerald-500 transition shadow-2xs">
                    <option value="all" {{ $selectedJenis == 'all' ? 'selected' : '' }}>Semua Jenis Pos</option>
                    @foreach($availableJenis as $jOpt)
                        <option value="{{ $jOpt }}" {{ $selectedJenis == $jOpt ? 'selected' : '' }}>{{ ucfirst($jOpt) }}</option>
                    @endforeach
                </select>
            </div>
        </form>

        <!-- Create Button -->
        <button @click="createModalOpen = true" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            + Tambah Pos APBD Baru
        </button>
    </div>

    <!-- Data Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-100/70 text-slate-500 uppercase text-[11px] font-extrabold tracking-wider border-b border-slate-200">
                    <th class="py-3.5 px-4 text-center w-12">#</th>
                    <th class="py-3.5 px-4">Jenis</th>
                    <th class="py-3.5 px-4">Kategori & Uraian</th>
                    <th class="py-3.5 px-4 text-right">Pagu Anggaran (Rp)</th>
                    <th class="py-3.5 px-4 text-right">Realisasi (Rp)</th>
                    <th class="py-3.5 px-4 text-center">Capaian (%)</th>
                    <th class="py-3.5 px-4 text-center">Laporan PDF</th>
                    <th class="py-3.5 px-4 text-center">Publikasi</th>
                    <th class="py-3.5 px-4 text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                @forelse($items as $index => $item)
                <tr class="hover:bg-slate-50/80 transition duration-150">
                    <td class="py-3.5 px-4 text-center font-bold text-slate-400">{{ $index + 1 }}</td>
                    <td class="py-3.5 px-4">
                        @if($item->jenis === 'pendapatan')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10.5px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200 uppercase">
                                Pendapatan
                            </span>
                        @elseif($item->jenis === 'belanja')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10.5px] font-extrabold bg-indigo-100 text-indigo-800 border border-indigo-200 uppercase">
                                Belanja
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10.5px] font-extrabold bg-teal-100 text-teal-800 border border-teal-200 uppercase">
                                Pembiayaan
                            </span>
                        @endif
                    </td>
                    <td class="py-3.5 px-4">
                        <div class="font-bold text-slate-900 text-xs">{{ $item->uraian }}</div>
                        <div class="text-[11px] text-slate-500 font-semibold">{{ $item->kategori }}</div>
                        @if($item->keterangan)
                            <div class="text-[10.5px] text-slate-400 italic mt-0.5">{{ $item->keterangan }}</div>
                        @endif
                    </td>
                    <td class="py-3.5 px-4 text-right font-bold text-slate-900">
                        Rp {{ number_format($item->anggaran, 0, ',', '.') }}
                    </td>
                    <td class="py-3.5 px-4 text-right font-bold text-slate-800">
                        Rp {{ number_format($item->realisasi, 0, ',', '.') }}
                    </td>
                    <td class="py-3.5 px-4 text-center">
                        <div class="inline-block">
                            <span class="font-extrabold text-xs {{ $item->persentase_realisasi >= 80 ? 'text-emerald-700' : ($item->persentase_realisasi >= 50 ? 'text-amber-600' : 'text-slate-600') }}">
                                {{ $item->persentase_realisasi }}%
                            </span>
                            <div class="w-16 bg-slate-200 h-1.5 rounded-full mt-1 overflow-hidden">
                                <div class="{{ $item->persentase_realisasi >= 80 ? 'bg-emerald-500' : ($item->persentase_realisasi >= 50 ? 'bg-amber-500' : 'bg-slate-400') }} h-1.5 rounded-full" style="width: {{ min(100, $item->persentase_realisasi) }}%"></div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3.5 px-4 text-center">
                        @if($item->berkas_laporan_pdf)
                            <a href="{{ $item->pdf_url }}" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg text-[11px] font-bold border border-red-200 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <span>PDF</span>
                            </a>
                        @else
                            <span class="text-slate-400 text-[11px] italic">-</span>
                        @endif
                    </td>
                    <td class="py-3.5 px-4 text-center">
                        <form action="{{ route('dashboard.apbd.toggle', $item->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="cursor-pointer focus:outline-none" title="Klik untuk menguji toggle publikasi">
                                @if($item->is_published)
                                    <span class="px-2.5 py-1 rounded-full text-[10.5px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 transition">
                                        ✓ Publik
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10.5px] font-extrabold bg-slate-100 text-slate-500 border border-slate-300 hover:bg-slate-200 transition">
                                        Draft (Sembunyi)
                                    </span>
                                @endif
                            </button>
                        </form>
                    </td>
                    <td class="py-3.5 px-4 text-center">
                        <div class="flex items-center justify-center gap-1.5">
                            <!-- Edit Button -->
                            <button type="button" 
                                    @click="
                                        editData = {
                                            id: {{ $item->id }},
                                            tahun_anggaran: {{ $item->tahun_anggaran }},
                                            jenis: '{{ $item->jenis }}',
                                            kategori: '{{ addslashes($item->kategori) }}',
                                            uraian: '{{ addslashes($item->uraian) }}',
                                            anggaran: '{{ number_format($item->anggaran, 0, ',', '.') }}',
                                            realisasi: '{{ number_format($item->realisasi, 0, ',', '.') }}',
                                            keterangan: '{{ addslashes($item->keterangan ?? '') }}',
                                            is_published: {{ $item->is_published ? 'true' : 'false' }},
                                            pdf_url: '{{ $item->pdf_url }}'
                                        };
                                        editModalOpen = true;
                                    " 
                                    class="p-1.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>

                            <!-- Delete Button -->
                            <button type="button" 
                                    @click="
                                        deleteId = {{ $item->id }};
                                        deleteTitle = '{{ addslashes($item->uraian) }}';
                                        deleteModalOpen = true;
                                    " 
                                    class="p-1.5 text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="py-12 text-center text-slate-400">
                        <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 14l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="font-bold text-slate-600 text-sm">Belum Ada Data APBD untuk Tahun {{ $selectedYear }}</p>
                        <p class="text-xs text-slate-400 mt-1">Klik tombol di atas untuk menambah pos anggaran baru.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- MODAL CREATE DATA APBD -->
    <div x-show="createModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity"></div>

        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative w-full max-w-xl my-auto transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 flex flex-col max-h-[90vh]">
                <!-- Header -->
                <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative shrink-0">
                    <div class="flex items-center gap-3.5">
                        <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">Transparansi Anggaran</span>
                            </div>
                            <h3 class="text-base font-bold text-white tracking-wide">Tambah Pos APBD Kelurahan</h3>
                        </div>
                    </div>
                    <button type="button" @click="createModalOpen = false" class="text-slate-400 hover:text-white transition p-1.5 rounded-xl hover:bg-white/10 cursor-pointer" title="Tutup">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form action="{{ route('dashboard.apbd.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
                    @csrf

                    <div class="p-6 space-y-4 overflow-y-auto flex-1">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Tahun Anggaran -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tahun Anggaran <span class="text-rose-500">*</span></label>
                                <input type="number" name="tahun_anggaran" value="{{ $selectedYear }}" required min="2000" max="2099" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500">
                            </div>

                            <!-- Jenis Pos Anggaran -->
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label class="block text-xs font-bold text-slate-700 uppercase">Jenis Pos <span class="text-rose-500">*</span></label>
                                    <button type="button" @click="manageJenisModalOpen = true" class="text-[10.5px] font-bold text-emerald-600 hover:underline flex items-center gap-1 cursor-pointer">
                                        ⚙️ Kelola / Hapus Jenis Pos
                                    </button>
                                </div>
                                <input type="text" name="jenis" list="jenis_pos_presets" required placeholder="Pilih atau ketik jenis pos baru..." class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500">
                                <datalist id="jenis_pos_presets">
                                    @foreach($availableJenis as $jName)
                                        <option value="{{ ucfirst($jName) }}"></option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>

                        <!-- Kategori / Bidang -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-xs font-bold text-slate-700 uppercase">Kategori / Kelompok Bidang <span class="text-rose-500">*</span></label>
                                <button type="button" @click="manageCategoryModalOpen = true" class="text-[10.5px] font-bold text-emerald-600 hover:underline flex items-center gap-1 cursor-pointer">
                                    ⚙️ Kelola / Hapus Master Kategori
                                </button>
                            </div>
                            <input type="text" name="kategori" list="kategori_presets" required placeholder="Pilih atau ketik kategori baru..." class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 font-semibold text-slate-800 focus:ring-2 focus:ring-emerald-500">
                            <datalist id="kategori_presets">
                                @foreach($categories as $catName)
                                    <option value="{{ $catName }}"></option>
                                @endforeach
                            </datalist>
                            <span class="text-[10.5px] text-slate-400 mt-1 block">💡 Pilih dari saran kategori yang ada di atas atau ketik nama kategori baru secara bebas.</span>
                        </div>

                        <!-- Uraian Rincian Kegiatan -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Uraian Rincian Pos / Kegiatan <span class="text-rose-500">*</span></label>
                            <input type="text" name="uraian" required placeholder="Contoh: Alokasi Dana Kelurahan (ADK) atau Pembangunan Drainase" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <!-- Anggaran & Realisasi (Auto Format Currency) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Target Pagu Anggaran (Rp) <span class="text-rose-500">*</span></label>
                                <input type="text" name="anggaran" required onkeyup="formatCurrencyInput(this)" placeholder="Contoh: 150.000.000" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 font-black text-slate-900 focus:ring-2 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Capaian Realisasi Saat Ini (Rp)</label>
                                <input type="text" name="realisasi" onkeyup="formatCurrencyInput(this)" placeholder="Contoh: 100.000.000" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 font-black text-emerald-700 focus:ring-2 focus:ring-emerald-500">
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Keterangan Catatan Tambahan</label>
                            <textarea name="keterangan" rows="2" placeholder="Catatan singkat pencairan / progres fisik..." class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-300 text-slate-800 focus:ring-2 focus:ring-emerald-500"></textarea>
                        </div>

                        <!-- Upload PDF -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Unggah Berkas Laporan PDF / Foto (Opsional)</label>
                            <input type="file" name="berkas_laporan_pdf" accept="application/pdf,image/*,.pdf" onchange="validateDocumentOrImageUpload(this, null, '', 10)" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition cursor-pointer">
                        </div>

                        <!-- Status Published -->
                        <div class="flex items-center gap-2 pt-2">
                            <input type="checkbox" name="is_published" id="is_published_create" value="1" checked class="w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500 cursor-pointer">
                            <label for="is_published_create" class="text-xs font-bold text-slate-700 cursor-pointer">Publikasikan Langsung ke Halaman Website</label>
                        </div>
                    </div>

                    <!-- Footer Buttons -->
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3 shrink-0">
                        <button type="button" @click="createModalOpen = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Simpan Pos APBD</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT DATA APBD -->
    <div x-show="editModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity"></div>

        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative w-full max-w-xl my-auto transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 flex flex-col max-h-[90vh]">
                <!-- Header -->
                <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative shrink-0">
                    <div class="flex items-center gap-3.5">
                        <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">Transparansi Anggaran</span>
                            </div>
                            <h3 class="text-base font-bold text-white tracking-wide">Edit Pos APBD Kelurahan</h3>
                        </div>
                    </div>
                    <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-white transition p-1.5 rounded-xl hover:bg-white/10 cursor-pointer" title="Tutup">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form :action="'{{ url('dashboard/apbd') }}/' + editData.id" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
                    @csrf
                    @method('PUT')

                    <div class="p-6 space-y-4 overflow-y-auto flex-1">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Tahun Anggaran -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tahun Anggaran <span class="text-rose-500">*</span></label>
                                <input type="number" name="tahun_anggaran" x-model="editData.tahun_anggaran" required min="2000" max="2099" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500">
                            </div>

                            <!-- Jenis Pos Anggaran -->
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label class="block text-xs font-bold text-slate-700 uppercase">Jenis Pos <span class="text-rose-500">*</span></label>
                                    <button type="button" @click="manageJenisModalOpen = true" class="text-[10.5px] font-bold text-emerald-600 hover:underline flex items-center gap-1 cursor-pointer">
                                        ⚙️ Kelola / Hapus Jenis Pos
                                    </button>
                                </div>
                                <input type="text" name="jenis" x-model="editData.jenis" list="jenis_pos_presets" required placeholder="Pilih atau ketik jenis pos baru..." class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500">
                            </div>
                        </div>

                        <!-- Kategori -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-xs font-bold text-slate-700 uppercase">Kategori / Kelompok Bidang <span class="text-rose-500">*</span></label>
                                <button type="button" @click="manageCategoryModalOpen = true" class="text-[10.5px] font-bold text-emerald-600 hover:underline flex items-center gap-1 cursor-pointer">
                                    ⚙️ Kelola / Hapus Master Kategori
                                </button>
                            </div>
                            <input type="text" name="kategori" x-model="editData.kategori" list="kategori_presets" required class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 font-semibold text-slate-800 focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <!-- Uraian Kegiatan -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Uraian Rincian Pos / Kegiatan <span class="text-rose-500">*</span></label>
                            <input type="text" name="uraian" x-model="editData.uraian" required class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <!-- Anggaran & Realisasi -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Target Pagu Anggaran (Rp) <span class="text-rose-500">*</span></label>
                                <input type="text" name="anggaran" x-model="editData.anggaran" required onkeyup="formatCurrencyInput(this)" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 font-black text-slate-900 focus:ring-2 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Capaian Realisasi Saat Ini (Rp)</label>
                                <input type="text" name="realisasi" x-model="editData.realisasi" onkeyup="formatCurrencyInput(this)" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 font-black text-emerald-700 focus:ring-2 focus:ring-emerald-500">
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Keterangan Catatan Tambahan</label>
                            <textarea name="keterangan" x-model="editData.keterangan" rows="2" class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-300 text-slate-800 focus:ring-2 focus:ring-emerald-500"></textarea>
                        </div>

                        <!-- Upload PDF (Dengan replace otomatis) -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Ganti Berkas Laporan PDF / Foto (Opsional)</label>
                            <template x-if="editData.pdf_url">
                                <div class="mb-2 text-xs text-emerald-700 font-semibold flex items-center gap-1">
                                    <span>📄 Berkas Terpasang:</span>
                                    <a :href="editData.pdf_url" target="_blank" class="underline hover:text-emerald-900 font-bold">Lihat Berkas Saat Ini</a>
                                </div>
                            </template>
                            <input type="file" name="berkas_laporan_pdf" accept="application/pdf,image/*,.pdf" onchange="validateDocumentOrImageUpload(this, null, '', 10)" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition cursor-pointer">
                        </div>

                        <!-- Status Published -->
                        <div class="flex items-center gap-2 pt-2">
                            <input type="checkbox" name="is_published" id="is_published_edit" value="1" x-model="editData.is_published" class="w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500 cursor-pointer">
                            <label for="is_published_edit" class="text-xs font-bold text-slate-700 cursor-pointer">Publikasikan Langsung ke Halaman Website</label>
                        </div>
                    </div>

                    <!-- Footer Buttons -->
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3 shrink-0">
                        <button type="button" @click="editModalOpen = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DELETE CONFIRMATION -->
    <div x-show="deleteModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm transition-opacity"></div>

        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full p-6 text-center space-y-4 z-10 border border-slate-100" @click.stop>
                <div class="w-14 h-14 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto shadow-sm">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </div>

                <div>
                    <h3 class="text-base font-black text-slate-800">Hapus Pos APBD Ini?</h3>
                    <p class="text-xs text-slate-500 mt-1">
                        Yakin ingin menghapus pos <span class="font-bold text-slate-800" x-text="deleteTitle"></span>? Berkas PDF pertanggungjawaban fisik juga akan dihapus dari server.
                    </p>
                </div>

                <form :action="'{{ url('dashboard/apbd') }}/' + deleteId" method="POST" class="pt-2 flex justify-center gap-3">
                    @csrf
                    @method('DELETE')
                    <button type="button" @click="deleteModalOpen = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-xs rounded-xl transition shadow-md">Hapus Permanen</button>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL KELOLA JENIS POS -->
    <div x-show="manageJenisModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity" @click="manageJenisModalOpen = false"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative w-full max-w-lg my-auto transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 flex flex-col max-h-[90vh]" @click.stop>
                <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-4 border-b border-emerald-800/50 flex items-center justify-between text-white shrink-0">
                    <h3 class="text-base font-bold text-white tracking-wide">Kelola Master Jenis Pos</h3>
                    <button type="button" @click="manageJenisModalOpen = false" class="text-slate-400 hover:text-white transition p-1.5 rounded-xl hover:bg-white/10 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="p-6 space-y-6 overflow-y-auto flex-1">
                    <!-- Form Tambah Jenis Pos -->
                    <form action="{{ route('dashboard.apbd.jenis-pos.store') }}" method="POST" class="space-y-3 bg-slate-50 p-4 rounded-2xl border border-slate-200">
                        @csrf
                        <label class="block text-xs font-bold text-slate-700 uppercase">Tambah Jenis Pos Baru (Manual)</label>
                        <div class="flex gap-2">
                            <input type="text" name="name" required placeholder="Contoh: Penerimaan Khusus / Hibah" class="flex-1 px-3.5 py-2 text-xs rounded-xl border border-slate-300 font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500">
                            <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-xs transition shrink-0 cursor-pointer">
                                + Tambah
                            </button>
                        </div>
                    </form>

                    <!-- Daftar Jenis Pos Saat Ini -->
                    <div>
                        <h4 class="text-xs font-bold text-slate-700 uppercase mb-3">Daftar Jenis Pos (Bawaan & Custom)</h4>
                        <div class="space-y-2 max-h-60 overflow-y-auto pr-1">
                            @foreach($availableJenis as $jItem)
                                @php
                                    $isDefault = in_array(strtolower($jItem), ['pendapatan', 'belanja', 'pembiayaan']);
                                    $customCatObj = $customJenisList->firstWhere('name', $jItem);
                                @endphp
                                <div class="flex items-center justify-between p-3 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 transition">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full {{ $isDefault ? 'bg-emerald-500' : 'bg-indigo-500' }}"></span>
                                        <span class="font-bold text-xs text-slate-800">{{ ucfirst($jItem) }}</span>
                                        @if($isDefault)
                                            <span class="text-[9.5px] bg-slate-100 text-slate-500 font-bold px-2 py-0.5 rounded-full">Bawaan Sistem</span>
                                        @else
                                            <span class="text-[9.5px] bg-emerald-50 text-emerald-700 font-bold px-2 py-0.5 rounded-full">Custom</span>
                                        @endif
                                    </div>
                                    @if(!$isDefault && $customCatObj)
                                        <form action="{{ route('dashboard.apbd.jenis-pos.destroy', $customCatObj->id) }}" method="POST" onsubmit="return confirm('Hapus Jenis Pos {{ addslashes($jItem) }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus Jenis Pos">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL KELOLA MASTER KATEGORI APBD -->
    <div x-show="manageCategoryModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity" @click="manageCategoryModalOpen = false"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative w-full max-w-lg my-auto transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 flex flex-col max-h-[90vh]" @click.stop>
                <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-4 border-b border-emerald-800/50 flex items-center justify-between text-white shrink-0">
                    <h3 class="text-base font-bold text-white tracking-wide">Kelola Master Kategori / Kelompok Bidang</h3>
                    <button type="button" @click="manageCategoryModalOpen = false" class="text-slate-400 hover:text-white transition p-1.5 rounded-xl hover:bg-white/10 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="p-6 space-y-6 overflow-y-auto flex-1">
                    <!-- Form Tambah Master Kategori APBD -->
                    <form action="{{ route('dashboard.apbd.categories.store') }}" method="POST" class="space-y-3 bg-slate-50 p-4 rounded-2xl border border-slate-200">
                        @csrf
                        <label class="block text-xs font-bold text-slate-700 uppercase">Tambah Master Kategori APBD Baru (Manual)</label>
                        <div class="flex gap-2">
                            <input type="text" name="name" required placeholder="Contoh: Bidang Infrastruktur & Pembangunan" class="flex-1 px-3.5 py-2 text-xs rounded-xl border border-slate-300 font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500">
                            <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-xs transition shrink-0 cursor-pointer">
                                + Tambah
                            </button>
                        </div>
                    </form>

                    <!-- Daftar Master Kategori APBD -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-xs font-bold text-slate-700 uppercase">Daftar Kategori Terdaftar</h4>
                        </div>
                        <div class="space-y-2 max-h-60 overflow-y-auto pr-1">
                            @foreach($masterCategories as $mCat)
                                <div class="flex items-center justify-between p-3 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 transition">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                                        <span class="font-bold text-xs text-slate-800">{{ $mCat->name }}</span>
                                        <span class="text-[9.5px] bg-blue-50 text-blue-700 font-bold px-2 py-0.5 rounded-full uppercase">{{ $mCat->module }}</span>
                                    </div>
                                    <form action="{{ route('dashboard.apbd.categories.destroy', $mCat->id) }}" method="POST" onsubmit="return confirm('Hapus Kategori {{ addslashes($mCat->name) }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus Kategori">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    function formatCurrencyInput(input) {
        let value = input.value.replace(/[^0-9]/g, '');
        if (value) {
            input.value = new Intl.NumberFormat('id-ID').format(value);
        } else {
            input.value = '';
        }
    }
</script>
@endpush
@endsection
