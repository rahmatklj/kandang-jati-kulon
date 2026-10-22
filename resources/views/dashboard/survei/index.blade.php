@extends('layouts.admin')

@section('title', 'Kelola Survei Kepuasan Masyarakat (SKM)')

@section('content')
<div x-data="{ createModalOpen: false, editModalOpen: false, editData: {} }">

    <!-- Header Section -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Kelola Hasil Survei Kepuasan Masyarakat (SKM)</h2>
            <p class="text-slate-500 text-sm">Kelola laporan periodik IKM, 9 unsur standar pelayanan, dan unggah berkas PDF resmi.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('survei.index') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs rounded-xl shadow-sm transition">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                Lihat Halaman Publik
            </a>
            <button @click="createModalOpen = true" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Periode SKM
            </button>
        </div>
    </div>

    <!-- Alert Success / Error -->
    @if(session('success'))
    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-xl mb-6 shadow-sm flex items-center justify-between" role="alert">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium text-sm">{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold">&times;</button>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-xl mb-6 shadow-sm">
        <ul class="list-disc list-inside text-xs space-y-1">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Data Table Container -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 text-base">Daftar Laporan Hasil SKM / IKM</h3>
            <span class="text-xs text-slate-500 font-medium">Total {{ $surveis->total() }} Periode</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-100/80 text-slate-700 uppercase tracking-wider font-extrabold border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3.5">Tahun / Periode</th>
                        <th class="px-6 py-3.5">Judul Laporan</th>
                        <th class="px-6 py-3.5 text-center">Responden</th>
                        <th class="px-6 py-3.5 text-center">Skor IKM</th>
                        <th class="px-6 py-3.5 text-center">Mutu Layanan</th>
                        <th class="px-6 py-3.5 text-center">File PDF / Foto</th>
                        <th class="px-6 py-3.5 text-center">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-slate-700">
                    @forelse($surveis as $item)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="px-6 py-4 font-bold text-slate-800">
                            <div>{{ $item->periode }}</div>
                            <span class="text-[10px] text-slate-400 font-semibold uppercase">Tahun {{ $item->tahun }}</span>
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-800 max-w-xs">
                            {{ $item->title }}
                        </td>
                        <td class="px-6 py-4 text-center font-bold">
                            {{ number_format($item->total_responden) }} <span class="text-slate-400 font-normal">Orang</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-base font-black text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200">
                                {{ number_format($item->ikm_score, 2) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center font-bold">
                            <span class="px-2.5 py-1 rounded-full text-[10px] uppercase tracking-wider bg-slate-100 text-slate-800 border border-slate-200">
                                {{ $item->mutu_layanan }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($item->pdf_file)
                                <a href="{{ asset('storage/' . $item->pdf_file) }}" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 bg-blue-50 text-blue-700 font-bold rounded-lg hover:bg-blue-100 border border-blue-200 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    PDF / Foto
                                </a>
                            @else
                                <span class="text-slate-400 italic text-[11px]">Belum Ada File</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('dashboard.survei.toggle', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider transition cursor-pointer {{ $item->is_active ? 'bg-emerald-100 text-emerald-800 border border-emerald-300 hover:bg-emerald-200' : 'bg-slate-100 text-slate-500 border border-slate-300 hover:bg-slate-200' }}">
                                    {{ $item->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button @click="editData = {{ json_encode($item) }}; editModalOpen = true;" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold rounded-lg border border-amber-200 transition cursor-pointer">
                                Edit
                            </button>
                            <form action="{{ route('dashboard.survei.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data survei ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-700 font-bold rounded-lg border border-red-200 transition cursor-pointer">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-slate-400">
                            Belum ada data survei SKM yang ditambahkan. Klik tombol "Tambah Periode SKM" di atas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($surveis->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $surveis->links() }}
        </div>
        @endif
    </div>

    <!-- Modal Tambah Data Survei -->
    <div x-show="createModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative w-full max-w-3xl my-auto transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 flex flex-col max-h-[90vh]">
                <!-- Header -->
                <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative shrink-0">
                    <div class="flex items-center gap-3.5">
                        <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">Survei Kepuasan</span>
                            </div>
                            <h3 class="text-base font-bold text-white tracking-wide">Tambah Periode Survei SKM Baru</h3>
                        </div>
                    </div>
                    <button type="button" @click="createModalOpen = false" class="text-slate-400 hover:text-white transition p-1.5 rounded-xl hover:bg-white/10 cursor-pointer" title="Tutup">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form action="{{ route('dashboard.survei.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
                    @csrf
                    
                    <div class="p-6 space-y-6 overflow-y-auto flex-1">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Tahun Survei</label>
                                <input type="number" name="tahun" value="{{ date('Y') }}" class="w-full px-4 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Nama Periode</label>
                                <input type="text" name="periode" placeholder="Contoh: Semester I - 2026" class="w-full px-4 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Total Responden</label>
                                <input type="number" name="total_responden" value="320" class="w-full px-4 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Judul Resmi Laporan</label>
                            <input type="text" name="title" value="Survei Kepuasan Masyarakat (SKM) Semester I Tahun {{ date('Y') }}" class="w-full px-4 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800" required>
                        </div>

                        <!-- Mode Simpel: Skor Akhir IKM -->
                        <div class="p-4 bg-emerald-50/70 rounded-2xl border border-emerald-200/80 space-y-2">
                            <label class="block text-xs font-extrabold uppercase tracking-wider text-emerald-900">
                                Nilai / Skor Akhir IKM (Skala 25.00 - 100.00) <span class="text-rose-500">*</span>
                            </label>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                                <input type="number" step="0.01" min="25" max="100" name="ikm_score" value="88.50" required class="w-full sm:w-48 px-4 py-2.5 text-sm rounded-xl border border-emerald-300 focus:ring-2 focus:ring-emerald-500 font-black text-emerald-900 bg-white shadow-2xs" placeholder="Contoh: 88.50">
                                <span class="px-3 py-1.5 bg-emerald-600 text-white font-extrabold text-xs rounded-xl shadow-xs inline-flex items-center gap-1.5 shrink-0">
                                    <span>⭐ Mutu Layanan: A (SANGAT BAIK)</span>
                                </span>
                            </div>
                            <p class="text-[11px] text-emerald-700 font-medium">💡 <strong>Mode Ringkas:</strong> Admin cukup memasukkan nilai akhir IKM. Nilai 9 unsur pelayanan akan dihitung otomatis oleh sistem.</p>
                        </div>

                        <!-- Collapsible Detail 9 Unsur (Opsional) -->
                        <details class="group bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden">
                            <summary class="px-4 py-3 font-bold text-xs text-slate-700 cursor-pointer flex items-center justify-between hover:bg-slate-100 transition select-none">
                                <span class="flex items-center gap-2">
                                    <span>⚙️ Detail 9 Unsur Pelayanan</span>
                                    <span class="text-[10px] text-slate-400 font-normal">(Opsional - hanya jika ingin isi manual U1–U9)</span>
                                </span>
                                <svg class="w-4 h-4 text-slate-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </summary>
                            <div class="p-4 border-t border-slate-200 grid grid-cols-1 sm:grid-cols-3 gap-3 bg-white">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">U1: Persyaratan</label>
                                    <input type="number" step="0.01" min="1" max="4" name="u1_persyaratan" value="3.55" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">U2: Prosedur</label>
                                    <input type="number" step="0.01" min="1" max="4" name="u2_prosedur" value="3.48" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">U3: Kecepatan Waktu</label>
                                    <input type="number" step="0.01" min="1" max="4" name="u3_waktu" value="3.40" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">U4: Tarif / Biaya (Gratis)</label>
                                    <input type="number" step="0.01" min="1" max="4" name="u4_biaya" value="4.00" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">U5: Produk Layanan</label>
                                    <input type="number" step="0.01" min="1" max="4" name="u5_produk" value="3.60" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">U6: Kompetensi Petugas</label>
                                    <input type="number" step="0.01" min="1" max="4" name="u6_kompetensi" value="3.52" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">U7: Perilaku / Sopan Santun</label>
                                    <input type="number" step="0.01" min="1" max="4" name="u7_perilaku" value="3.65" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">U8: Penanganan Pengaduan</label>
                                    <input type="number" step="0.01" min="1" max="4" name="u8_pengaduan" value="3.45" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">U9: Sarana & Prasarana</label>
                                    <input type="number" step="0.01" min="1" max="4" name="u9_sarpras" value="3.50" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800">
                                </div>
                            </div>
                        </details>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Unggah Berkas Laporan / Foto (PDF / Gambar, Max 10MB)</label>
                                <input type="file" name="pdf_file" accept=".pdf,application/pdf,image/*" onchange="validateDocumentOrImageUpload(this, null, '', 10)" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition cursor-pointer">
                            </div>
                            <div class="flex items-center pt-5">
                                <label class="inline-flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                                    <span class="text-xs font-bold text-slate-800">Publikasikan & Tampilkan di Beranda</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3 shrink-0">
                        <button type="button" @click="createModalOpen = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Simpan Data SKM</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Data Survei -->
    <div x-show="editModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative w-full max-w-3xl my-auto transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 flex flex-col max-h-[90vh]">
                <!-- Header -->
                <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative shrink-0">
                    <div class="flex items-center gap-3.5">
                        <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">Survei Kepuasan</span>
                            </div>
                            <h3 class="text-base font-bold text-white tracking-wide">Edit Periode Survei SKM</h3>
                        </div>
                    </div>
                    <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-white transition p-1.5 rounded-xl hover:bg-white/10 cursor-pointer" title="Tutup">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form :action="'/dashboard/survei/' + editData.id" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
                    @csrf
                    @method('PUT')
                    
                    <div class="p-6 space-y-6 overflow-y-auto flex-1">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Tahun Survei</label>
                                <input type="number" name="tahun" x-model="editData.tahun" class="w-full px-4 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Nama Periode</label>
                                <input type="text" name="periode" x-model="editData.periode" class="w-full px-4 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Total Responden</label>
                                <input type="number" name="total_responden" x-model="editData.total_responden" class="w-full px-4 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Judul Resmi Laporan</label>
                            <input type="text" name="title" x-model="editData.title" class="w-full px-4 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800" required>
                        </div>

                        <!-- Mode Simpel: Skor Akhir IKM -->
                        <div class="p-4 bg-emerald-50/70 rounded-2xl border border-emerald-200/80 space-y-2">
                            <label class="block text-xs font-extrabold uppercase tracking-wider text-emerald-900">
                                Nilai / Skor Akhir IKM (Skala 25.00 - 100.00) <span class="text-rose-500">*</span>
                            </label>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                                <input type="number" step="0.01" min="25" max="100" name="ikm_score" x-model="editData.ikm_score" required class="w-full sm:w-48 px-4 py-2.5 text-sm rounded-xl border border-emerald-300 focus:ring-2 focus:ring-emerald-500 font-black text-emerald-900 bg-white shadow-2xs" placeholder="Contoh: 88.50">
                                <span class="px-3 py-1.5 bg-emerald-600 text-white font-extrabold text-xs rounded-xl shadow-xs inline-flex items-center gap-1.5 shrink-0" x-text="'⭐ Mutu Layanan: ' + (editData.mutu_layanan || 'A (SANGAT BAIK)')">
                                </span>
                            </div>
                            <p class="text-[11px] text-emerald-700 font-medium">💡 <strong>Mode Ringkas:</strong> Admin cukup memasukkan nilai akhir IKM. Nilai 9 unsur pelayanan akan dihitung otomatis oleh sistem.</p>
                        </div>

                        <!-- Collapsible Detail 9 Unsur (Opsional) -->
                        <details class="group bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden">
                            <summary class="px-4 py-3 font-bold text-xs text-slate-700 cursor-pointer flex items-center justify-between hover:bg-slate-100 transition select-none">
                                <span class="flex items-center gap-2">
                                    <span>⚙️ Detail 9 Unsur Pelayanan</span>
                                    <span class="text-[10px] text-slate-400 font-normal">(Opsional - hanya jika ingin kustom nilai U1–U9)</span>
                                </span>
                                <svg class="w-4 h-4 text-slate-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </summary>
                            <div class="p-4 border-t border-slate-200 grid grid-cols-1 sm:grid-cols-3 gap-3 bg-white">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">U1: Persyaratan</label>
                                    <input type="number" step="0.01" min="1" max="4" name="u1_persyaratan" x-model="editData.u1_persyaratan" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">U2: Prosedur</label>
                                    <input type="number" step="0.01" min="1" max="4" name="u2_prosedur" x-model="editData.u2_prosedur" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">U3: Kecepatan Waktu</label>
                                    <input type="number" step="0.01" min="1" max="4" name="u3_waktu" x-model="editData.u3_waktu" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">U4: Tarif / Biaya (Gratis)</label>
                                    <input type="number" step="0.01" min="1" max="4" name="u4_biaya" x-model="editData.u4_biaya" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">U5: Produk Layanan</label>
                                    <input type="number" step="0.01" min="1" max="4" name="u5_produk" x-model="editData.u5_produk" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">U6: Kompetensi Petugas</label>
                                    <input type="number" step="0.01" min="1" max="4" name="u6_kompetensi" x-model="editData.u6_kompetensi" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">U7: Perilaku / Sopan Santun</label>
                                    <input type="number" step="0.01" min="1" max="4" name="u7_perilaku" x-model="editData.u7_perilaku" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">U8: Penanganan Pengaduan</label>
                                    <input type="number" step="0.01" min="1" max="4" name="u8_pengaduan" x-model="editData.u8_pengaduan" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">U9: Sarana & Prasarana</label>
                                    <input type="number" step="0.01" min="1" max="4" name="u9_sarpras" x-model="editData.u9_sarpras" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800">
                                </div>
                            </div>
                        </details>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Ganti Berkas Laporan / Foto (PDF / Gambar, Max 10MB)</label>
                                <input type="file" name="pdf_file" accept=".pdf,application/pdf,image/*" onchange="validateDocumentOrImageUpload(this, null, '', 10)" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition cursor-pointer">
                                <span class="text-[10px] text-slate-400 mt-1 block">Biarkan kosong jika tidak ingin mengganti berkas yang ada.</span>
                            </div>
                            <div class="flex items-center pt-5">
                                <label class="inline-flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" :checked="editData.is_active" class="w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                                    <span class="text-xs font-bold text-slate-800">Publikasikan & Tampilkan di Beranda</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3 shrink-0">
                        <button type="button" @click="editModalOpen = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Perbarui Data SKM</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
