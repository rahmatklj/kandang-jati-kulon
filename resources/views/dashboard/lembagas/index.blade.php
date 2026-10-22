@extends('layouts.admin')

@section('title', 'Kelola Lembaga Kemasyarakatan')

@section('content')
<!-- Navigasi Cepat Kelola Informasi -->
<div class="mb-6 flex flex-wrap gap-2 border-b border-slate-200 pb-3">
    <a href="{{ route('dashboard.posts.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-150 flex items-center gap-2 {{ request()->routeIs('dashboard.posts.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
        Warta & Berita
    </a>
    <a href="{{ route('dashboard.agendas.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-150 flex items-center gap-2 {{ request()->routeIs('dashboard.agendas.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        Agenda Kegiatan
    </a>
    <a href="{{ route('dashboard.galleries.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-150 flex items-center gap-2 {{ request()->routeIs('dashboard.galleries.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        Galeri Foto
    </a>
    <a href="{{ route('dashboard.videos.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-150 flex items-center gap-2 {{ request()->routeIs('dashboard.videos.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
        Dokumentasi Video
    </a>
    <a href="{{ route('dashboard.lembagas.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-150 flex items-center gap-2 {{ request()->routeIs('dashboard.lembagas.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h6m-6 0V11m0 0H9m3 0h3"></path></svg>
        Profil Lembaga Kelurahan
    </a>
    <a href="{{ route('dashboard.demographics.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-150 flex items-center gap-2 {{ request()->routeIs(['dashboard.demographics.*', 'dashboard.rt-rw.*']) ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        Data RT & RW
    </a>
    <a href="{{ route('dashboard.integrations.contact-maps') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-150 flex items-center gap-2 {{ request()->routeIs('dashboard.integrations.contact-maps') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        Informasi Kontak & Maps
    </a>
</div>

<div x-data="{ showCreateModal: false, showEditModal: false, editItem: { id: '', name: '', abbreviation: '', description: '', leader_title: '', leader_name: '', members_count: 0, is_active: 1 } }">
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Kelola Lembaga Kemasyarakatan</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola profil dan struktur Lembaga Kemasyarakatan Kelurahan (LPMK, PKK, Karang Taruna, Posyandu).</p>
        </div>

        <button @click="showCreateModal = true" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase px-4 py-2.5 rounded-xl shadow-sm transition-all duration-200 flex items-center gap-2 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            + Tambah Lembaga Baru
        </button>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-xl shadow-xs text-sm font-medium flex items-center justify-between">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- Grid Kartu Lembaga -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        @forelse($lembagas as $item)
        <div class="bg-white rounded-2xl p-5 shadow-xs border border-slate-200 flex flex-col justify-between hover:shadow-md transition group">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-extrabold text-xs uppercase">
                        {{ $item->abbreviation ?? substr($item->name, 0, 3) }}
                    </span>
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $item->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                            {{ $item->is_active ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                        
                        <!-- Action buttons (Edit & Delete) -->
                        <button type="button" @click="editItem = {{ json_encode([
                            'id' => (string)$item->id,
                            'name' => (string)$item->name,
                            'abbreviation' => (string)($item->abbreviation ?? ''),
                            'description' => (string)$item->description,
                            'leader_title' => (string)($item->leader_title ?? ''),
                            'leader_name' => (string)($item->leader_name ?? ''),
                            'members_count' => (int)($item->members_count ?? 0),
                            'is_active' => (bool)$item->is_active,
                        ]) }}; showEditModal = true;" class="p-1 text-slate-400 hover:text-amber-600 transition cursor-pointer" title="Edit Lembaga">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>

                        <form action="{{ route('dashboard.lembagas.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus lembaga {{ addslashes($item->name) }}?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1 text-slate-400 hover:text-rose-600 transition cursor-pointer" title="Hapus Lembaga">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
                <h3 class="font-bold text-slate-800 text-base mb-1 leading-snug">{{ $item->name }}</h3>
                <p class="text-xs text-slate-500 line-clamp-3 mb-4 leading-relaxed">{{ $item->description }}</p>
            </div>

            <div class="pt-4 border-t border-slate-100 text-xs space-y-1.5 text-slate-600">
                <div class="flex justify-between">
                    <span class="text-slate-400">Ketua / Pimpinan:</span>
                    <span class="font-bold text-slate-700 text-right truncate max-w-[140px]" title="{{ $item->leader_name }}">{{ $item->leader_name ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">Jumlah Anggota:</span>
                    <span class="font-bold text-slate-700">{{ $item->members_count ?? '0' }} Orang</span>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 text-center text-slate-400 font-medium bg-white rounded-2xl border border-slate-200">
            Belum ada data lembaga kemasyarakatan.
        </div>
        @endforelse
    </div>

    <!-- Modal Form Tambah Lembaga -->
    <div x-show="showCreateModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative w-full max-w-lg my-auto transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 flex flex-col max-h-[90vh]">
                <!-- Header -->
                <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative shrink-0">
                    <div class="flex items-center gap-3.5">
                        <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-1-4h.01M9 16h.01M9 12h.01M9 8h.01M15 16h.01M15 12h.01M15 8h.01"></path></svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">Kelembagaan</span>
                            </div>
                            <h3 class="text-base font-bold text-white tracking-wide">Tambah Lembaga Kemasyarakatan</h3>
                        </div>
                    </div>
                    <button type="button" @click="showCreateModal = false" class="text-slate-400 hover:text-white transition p-1.5 rounded-xl hover:bg-white/10 cursor-pointer" title="Tutup">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form action="{{ route('dashboard.lembagas.store') }}" method="POST" class="flex flex-col flex-1 overflow-hidden">
                    @csrf
                    <div class="p-6 space-y-4 overflow-y-auto flex-1">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Nama Lengkap Lembaga <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required placeholder="Contoh: Posyandu Balita & Lansia Flamboyan" class="w-full text-sm border border-slate-200 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Singkatan / Inisial</label>
                                <input type="text" name="abbreviation" placeholder="Contoh: POS" class="w-full text-sm border border-slate-200 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Jumlah Anggota</label>
                                <input type="number" name="members_count" value="0" min="0" class="w-full text-sm border border-slate-200 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Jabatan Pimpinan</label>
                                <input type="text" name="leader_title" placeholder="Contoh: Ketua Posyandu" class="w-full text-sm border border-slate-200 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Nama Ketua / Pimpinan</label>
                                <input type="text" name="leader_name" placeholder="Contoh: Ibu Rahmawati" class="w-full text-sm border border-slate-200 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Deskripsi / Peran Lembaga <span class="text-red-500">*</span></label>
                            <textarea name="description" rows="3" required placeholder="Jelaskan secara singkat tugas dan fungsi lembaga..." class="w-full text-sm border border-slate-200 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none"></textarea>
                        </div>
                        <div class="flex items-center gap-2 pt-1">
                            <input type="checkbox" name="is_active" id="create_is_active" value="1" checked class="w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                            <label for="create_is_active" class="text-xs font-bold text-slate-700">Status Aktif</label>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3 shrink-0">
                        <button type="button" @click="showCreateModal = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Simpan Lembaga</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Form Edit Lembaga -->
    <div x-show="showEditModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative w-full max-w-lg my-auto transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 flex flex-col max-h-[90vh]">
                <!-- Header -->
                <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative shrink-0">
                    <div class="flex items-center gap-3.5">
                        <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">Kelembagaan</span>
                            </div>
                            <h3 class="text-base font-bold text-white tracking-wide">Edit Lembaga Kemasyarakatan</h3>
                        </div>
                    </div>
                    <button type="button" @click="showEditModal = false" class="text-slate-400 hover:text-white transition p-1.5 rounded-xl hover:bg-white/10 cursor-pointer" title="Tutup">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form :action="'/dashboard/lembagas/' + editItem.id" method="POST" class="flex flex-col flex-1 overflow-hidden">
                    @csrf
                    @method('PUT')
                    <div class="p-6 space-y-4 overflow-y-auto flex-1">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Nama Lengkap Lembaga <span class="text-red-500">*</span></label>
                            <input type="text" name="name" x-model="editItem.name" required class="w-full text-sm border border-slate-200 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Singkatan / Inisial</label>
                                <input type="text" name="abbreviation" x-model="editItem.abbreviation" class="w-full text-sm border border-slate-200 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Jumlah Anggota</label>
                                <input type="number" name="members_count" x-model="editItem.members_count" min="0" class="w-full text-sm border border-slate-200 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Jabatan Pimpinan</label>
                                <input type="text" name="leader_title" x-model="editItem.leader_title" class="w-full text-sm border border-slate-200 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Nama Ketua / Pimpinan</label>
                                <input type="text" name="leader_name" x-model="editItem.leader_name" class="w-full text-sm border border-slate-200 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Deskripsi / Peran Lembaga <span class="text-red-500">*</span></label>
                            <textarea name="description" x-model="editItem.description" rows="3" required class="w-full text-sm border border-slate-200 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none"></textarea>
                        </div>
                        <div class="flex items-center gap-2 pt-1">
                            <input type="checkbox" name="is_active" id="edit_is_active" value="1" x-model="editItem.is_active" class="w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                            <label for="edit_is_active" class="text-xs font-bold text-slate-700">Status Aktif</label>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3 shrink-0">
                        <button type="button" @click="showEditModal = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
