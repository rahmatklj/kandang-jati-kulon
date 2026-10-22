@extends('layouts.admin')

@section('title', 'Kelola Menu Navigasi (Navbar)')

@push('styles')
<style>
.tox-tinymce-aux {
    z-index: 99999 !important;
}
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Alert Notifications -->
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl shadow-xs flex items-center justify-between" role="alert">
        <div class="flex items-center gap-2.5">
            <div class="w-7 h-7 rounded-lg bg-emerald-500/15 flex items-center justify-center text-emerald-600 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <span class="font-semibold text-sm">{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 font-bold p-1 cursor-pointer">&times;</button>
    </div>
    @endif

    @if(isset($errors) && $errors->any())
    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl shadow-xs" role="alert">
        <div class="font-bold text-sm mb-1 flex items-center gap-2">
            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>Perhatian Validation Error:</span>
        </div>
        <ul class="list-disc list-inside text-xs space-y-0.5 ml-6">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Panduan Ringkas Operator Kelurahan -->
    <div class="bg-gradient-to-r from-emerald-500/10 via-teal-500/5 to-slate-50 border border-emerald-500/20 rounded-2xl p-4 sm:p-5 shadow-2xs flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-start gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-xs font-bold text-lg">
                💡
            </div>
            <div class="space-y-1">
                <h3 class="font-extrabold text-slate-800 text-sm sm:text-base">
                    Panduan Pengelolaan Navigasi Website
                </h3>
                <p class="text-xs text-slate-600 leading-relaxed max-w-3xl">
                    Halaman ini digunakan oleh operator untuk mengatur susunan menu pada baris navigasi atas website publik kelurahan. 
                    Anda dapat mengubah nama, mengatur urutan tampilan, menambah sub-menu, atau mengelola isi konten halaman.
                </p>
            </div>
        </div>
        <div class="flex flex-wrap md:flex-nowrap items-center gap-2 shrink-0 self-stretch md:self-auto text-xs">
            <div class="bg-white/90 border border-slate-200/80 px-3 py-1.5 rounded-xl font-medium text-slate-700 flex items-center gap-1.5 shadow-2xs">
                <span class="w-2 h-2 rounded-full bg-slate-700"></span>
                <span><strong>Menu Utama</strong> = Baris Atas</span>
            </div>
            <div class="bg-white/90 border border-slate-200/80 px-3 py-1.5 rounded-xl font-medium text-slate-700 flex items-center gap-1.5 shadow-2xs">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span><strong>Sub-Menu</strong> = Dropdown</span>
            </div>
        </div>
    </div>

    <!-- Executive Summary Stats Grid -->
    @php
        $totalParent = $menus->count();
        $totalChildren = $menus->sum(fn($m) => $m->children->count());
        $totalActive = $menus->where('is_active', true)->count() + $menus->sum(fn($m) => $m->children->where('is_active', true)->count());
        $totalMenus = $totalParent + $totalChildren;
    @endphp
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-2xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Menu</p>
                <p class="text-xl font-extrabold text-slate-800">{{ $totalMenus }} <span class="text-xs font-semibold text-slate-500">Item</span></p>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-2xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Menu Utama</p>
                <p class="text-xl font-extrabold text-slate-800">{{ $totalParent }} <span class="text-xs font-semibold text-slate-500">Navbar</span></p>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-2xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Sub-Menu</p>
                <p class="text-xl font-extrabold text-slate-800">{{ $totalChildren }} <span class="text-xs font-semibold text-slate-500">Dropdown</span></p>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-2xs flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status Aktif</p>
                <p class="text-xl font-extrabold text-emerald-600">{{ $totalActive }} <span class="text-xs font-normal text-slate-400">/ {{ $totalMenus }} Item</span></p>
            </div>
        </div>
    </div>

    <!-- Tree View Card Container -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <!-- Card Bar Header -->
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/70 flex items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                </div>
                <div>
                    <h2 class="font-extrabold text-slate-800 text-sm">Struktur Menu Navigasi Website</h2>
                    <p class="text-xs text-slate-400 font-medium">Urutan tampilan disusun berdasarkan nomor urut <code>#</code></p>
                </div>
            </div>
        </div>

        <!-- Hierarchical Tree List -->
        <div class="p-4 sm:p-6 space-y-4">
            @php
                $getFeatureLink = function($item) {
                    $title = strtolower(trim($item->title));
                    $url = strtolower(trim($item->url));

                    if (str_contains($url, 'visi-misi') || str_contains($title, 'visi')) {
                        return route('dashboard.settings.visi-misi');
                    }
                    if (str_contains($url, 'sejarah') || str_contains($title, 'sejarah')) {
                        return route('dashboard.settings.sejarah');
                    }
                    if (str_contains($url, 'struktur') || str_contains($title, 'struktur') || str_contains($title, 'aparatur')) {
                        return route('dashboard.settings.aparatur');
                    }
                    if (str_contains($url, 'demografi') || str_contains($url, 'statistik') || str_contains($title, 'demografi') || str_contains($title, 'statistik')) {
                        return route('dashboard.demographics.index');
                    }
                    if (str_contains($url, 'berita') || str_contains($title, 'berita') || str_contains($title, 'artikel')) {
                        return route('dashboard.posts.index');
                    }
                    if (str_contains($url, 'video') || str_contains($title, 'video')) {
                        return route('dashboard.videos.index');
                    }
                    if (str_contains($url, 'galeri') || str_contains($title, 'galeri') || str_contains($title, 'foto')) {
                        return route('dashboard.galleries.index');
                    }
                    if (str_contains($url, 'agenda') || str_contains($title, 'agenda')) {
                        return route('dashboard.agendas.index');
                    }
                    if (str_contains($url, 'lembaga') || str_contains($title, 'lembaga')) {
                        return route('dashboard.lembagas.index');
                    }
                    if (str_contains($url, 'apbd') || str_contains($url, 'transparansi') || str_contains($title, 'apbd') || str_contains($title, 'anggaran')) {
                        return route('dashboard.apbd.index');
                    }
                    if (str_contains($url, 'survei') || str_contains($title, 'survei') || str_contains($title, 'skm')) {
                        return route('dashboard.survei.index');
                    }
                    if (str_contains($url, 'layanan') || str_contains($title, 'layanan') || str_contains($title, 'sop')) {
                        return route('dashboard.services.index');
                    }
                    if (str_contains($url, 'dokumen') || str_contains($title, 'dokumen') || str_contains($title, 'pdf')) {
                        return route('dashboard.documents.index');
                    }
                    if (str_contains($url, 'pengumuman') || str_contains($title, 'pengumuman')) {
                        return route('dashboard.announcements.index');
                    }
                    if (str_contains($url, 'lapor') || str_contains($title, 'lapor')) {
                        return route('dashboard.integrations.lapor');
                    }
                    if (str_contains($url, 'hallo') || str_contains($url, 'wa.me') || str_contains($title, 'hallo')) {
                        return route('dashboard.integrations.hallo-sae');
                    }
                    if (str_contains($url, 'hubungi') || str_contains($url, 'kontak') || str_contains($title, 'hubungi') || str_contains($title, 'kontak')) {
                        return route('dashboard.integrations.contact-maps');
                    }
                    if (str_contains($url, 'profil') || str_contains($title, 'profil')) {
                        return route('dashboard.settings.index');
                    }

                    return null;
                };
            @endphp

            @forelse($menus as $menu)
                @php
                    $titleLower = strtolower(trim($menu->title));
                    $isHome = in_array($titleLower, ['home', 'beranda']) || $menu->url === '/';
                    $isProfil = in_array($titleLower, ['profil', 'profil kelurahan']);
                    $isLayanan = in_array($titleLower, ['layanan', 'layanan publik']);
                    $isDokumen = in_array($titleLower, ['dokumen', 'dokumen publik']);
                    $canAddSubmenu = !$isHome;
                    $hasChildren = $menu->children->count() > 0 || $isLayanan || $isDokumen;
                @endphp
                <div class="rounded-2xl border border-slate-200/90 overflow-hidden bg-white shadow-2xs hover:shadow-xs transition-all duration-200">
                    <!-- Main Parent Header Bar -->
                    <div class="p-4 sm:p-4.5 flex flex-col md:flex-row md:items-center justify-between gap-3.5 bg-slate-50/60 border-b border-slate-100">
                        <!-- Left Info -->
                        <div class="flex items-start sm:items-center gap-3">
                            <span class="px-2.5 py-1 rounded-xl bg-slate-800 text-white font-extrabold text-xs shrink-0 shadow-2xs">
                                #{{ $menu->order }}
                            </span>

                            <div class="space-y-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="font-extrabold text-slate-800 text-base flex items-center gap-2">
                                        <span>{{ $menu->title }}</span>
                                        @if($menu->image)
                                            <img src="{{ asset('storage/' . $menu->image) }}" class="w-7 h-7 object-cover rounded-lg border border-slate-200 shrink-0" title="Foto Halaman" alt="Banner">
                                        @endif
                                    </h3>

                                    @if($isLayanan)
                                        <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-[11px] font-bold flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            Dropdown ({{ $services->count() + $menu->children->count() }} Sub-Menu SOP)
                                        </span>
                                    @elseif($isDokumen)
                                        <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-[11px] font-bold flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            Dropdown ({{ $docCategories->count() + $menu->children->count() }} Sub-Menu Dokumen)
                                        </span>
                                    @elseif($menu->children->count() > 0)
                                        <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-[11px] font-bold flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            Dropdown ({{ $menu->children->count() }} Sub-Menu)
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 bg-slate-100 text-slate-600 border border-slate-200/80 rounded-full text-[11px] font-medium">
                                            Menu Utama
                                        </span>
                                    @endif

                                    @if($menu->target === '_blank')
                                        <span class="px-2 py-0.5 bg-blue-50 text-blue-700 border border-blue-200 rounded-full text-[10px] font-bold flex items-center gap-1" title="Menu ini membuka halaman pada tab baru">
                                            <span>Buka Tab Baru ↗</span>
                                        </span>
                                    @endif
                                </div>

                                <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500">
                                    <span class="text-slate-400">Path Tautan:</span>
                                    <code class="px-2 py-0.5 bg-slate-100 rounded-lg text-slate-700 font-mono font-medium text-[11px]">{{ $menu->url }}</code>
                                </div>
                            </div>
                        </div>

                        <!-- Right Actions -->
                        <div class="flex items-center gap-2 shrink-0 self-end md:self-auto pt-2 md:pt-0 border-t md:border-t-0 border-slate-200/60 w-full md:w-auto justify-end">
                            @php
                                $titleLower = strtolower(trim($menu->title));
                                $isHome = in_array($titleLower, ['home', 'beranda']) || $menu->url === '/';
                                $defaultParentTitles = ['home', 'beranda', 'profil', 'profil kelurahan', 'layanan', 'layanan publik', 'dokumen', 'dokumen publik', 'informasi', 'hubungi'];
                                $isDefaultParent = in_array($titleLower, $defaultParentTitles) || $menu->url === '/';
                                $isNoEditParent = $isDefaultParent;
                            @endphp

                            <!-- Toggle Active Button -->
                            <form action="{{ route('dashboard.navigation.toggle', $menu->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer shadow-2xs {{ $menu->is_active ? 'bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200/80' : 'bg-slate-100 hover:bg-slate-200 text-slate-600 border border-slate-200' }}"
                                        title="Klik untuk mengubah status aktif menu">
                                    <span class="w-2 h-2 rounded-full {{ $menu->is_active ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
                                    <span>{{ $menu->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                </button>
                            </form>

                            @if($canAddSubmenu)
                                <!-- Add Sub-Menu Button -->
                                @if($isLayanan)
                                    <button type="button" 
                                            onclick="openCreateServiceModal()"
                                            class="px-3 py-1.5 bg-[#008c5f] hover:bg-[#00734e] text-white rounded-xl text-xs font-bold transition flex items-center gap-1 cursor-pointer shadow-2xs"
                                            title="Tambah Dokumen SOP / Layanan Baru">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        <span>+ Tambah Sub-Menu</span>
                                    </button>
                                @elseif($isDokumen)
                                    <button type="button" 
                                            onclick="openCreateDocumentModal()"
                                            class="px-3 py-1.5 bg-[#008c5f] hover:bg-[#00734e] text-white rounded-xl text-xs font-bold transition flex items-center gap-1 cursor-pointer shadow-2xs"
                                            title="Unggah Dokumen PDF Publik Baru">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        <span>+ Tambah Sub-Menu</span>
                                    </button>
                                @else
                                    <button type="button" 
                                            onclick="openAddSubMenuModal({{ $menu->id }}, '{{ addslashes($menu->title) }}')"
                                            class="px-3 py-1.5 bg-[#008c5f] hover:bg-[#00734e] text-white rounded-xl text-xs font-bold transition flex items-center gap-1 cursor-pointer shadow-2xs"
                                            title="Tambah Sub-Menu baru di bawah menu ini">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        <span>+ Tambah Sub-Menu</span>
                                    </button>
                                @endif
                            @endif

                            @if(!$isNoEditParent)
                                <!-- Edit Menu Button -->
                                <button type="button" 
                                        onclick="openEditNavigationModal({{ $menu->id }}, '{{ addslashes($menu->title) }}', '{{ addslashes($menu->url) }}', {{ $menu->parent_id ?? 'null' }}, {{ $menu->order }}, '{{ $menu->target }}', {{ $menu->is_active ? 1 : 0 }}, {{ $menu->show_on_homepage ? 1 : 0 }}, '{{ addslashes($menu->description ?? '') }}', '{{ addslashes($menu->content ?? '') }}', '{{ addslashes($menu->image ?? '') }}')"
                                        class="px-2.5 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-xl text-xs font-bold transition flex items-center gap-1 cursor-pointer border border-blue-200/80 shadow-2xs" 
                                        title="Edit Pengaturan Menu Utama">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    <span>Edit Menu</span>
                                </button>
                            @endif

                            @if(!$isDefaultParent && $menu->children->count() === 0)
                                <form action="{{ route('dashboard.navigation.destroy', $menu->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu &quot;{{ addslashes($menu->title) }}&quot;?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-xl text-xs font-bold transition flex items-center gap-1 cursor-pointer border border-rose-200/80 shadow-2xs" 
                                            title="Hapus Menu Utama">
                                        <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <!-- Sub-Menu Children Tree Section -->
                    @if($hasChildren)
                        <div class="p-4 sm:p-5 bg-slate-50/40">
                            <div class="space-y-2 border-l-2 border-emerald-400/50 pl-3 sm:pl-5 ml-2 sm:ml-4">
                                
                                {{-- Render Dynamic Layanan SOP Items --}}
                                @if($isLayanan && isset($services) && $services->count() > 0)
                                    @foreach($services as $srvIdx => $srv)
                                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 p-3 bg-white rounded-xl border border-slate-200/80 shadow-2xs hover:border-emerald-300 transition">
                                            <!-- Left Info -->
                                            <div class="flex items-center gap-2.5 min-w-0">
                                                <div class="text-emerald-500 font-mono font-bold text-xs shrink-0 flex items-center">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                                </div>

                                                <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-600 font-bold text-[11px] flex items-center justify-center shrink-0 border border-slate-200/80">
                                                    #{{ $srvIdx + 1 }}
                                                </span>

                                                <div class="min-w-0">
                                                    <div class="font-bold text-slate-800 text-sm flex items-center gap-2 flex-wrap">
                                                        <span class="truncate">{{ $srv->title }}</span>
                                                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-md text-[10px] font-bold shrink-0">Sub-Menu SOP</span>
                                                    </div>
                                                    <div class="text-xs text-slate-500 mt-0.5 flex items-center gap-2 flex-wrap">
                                                        <span>Path: <code class="text-slate-700 bg-slate-100 px-1.5 py-0.5 rounded text-[11px] font-mono">/layanan/{{ $srv->slug }}</code></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Right Actions -->
                                            <div class="flex items-center gap-2 shrink-0 self-end md:self-auto">
                                                <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold flex items-center gap-1 bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    <span>Aktif</span>
                                                </span>

                                                <a href="{{ route('dashboard.services.edit', $srv->id) }}" 
                                                   class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition cursor-pointer border border-slate-200/80 flex items-center gap-1.5 text-[11px] font-bold shadow-2xs" 
                                                   title="Kelola & Isi Data SOP {{ $srv->title }}">
                                                    <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                                                    <span>Kelola Isi Halaman</span>
                                                </a>

                                                <form action="{{ route('dashboard.services.destroy', $srv->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus SOP &quot;{{ addslashes($srv->title) }}&quot;?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="px-2.5 py-1 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg transition border border-rose-200/80 text-[11px] font-bold flex items-center gap-1 shadow-2xs cursor-pointer" 
                                                            title="Hapus SOP Layanan">
                                                        <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        <span>Hapus</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                {{-- Render Dynamic Dokumen Categories --}}
                                @if($isDokumen && isset($docCategories) && $docCategories->count() > 0)
                                    @foreach($docCategories as $catIdx => $catItem)
                                        @php
                                            $cSlug = \Illuminate\Support\Str::slug($catItem->slug ?: $catItem->name);
                                            if (in_array($cSlug, ['musrenbang', 'dokumen-musrenbang'])) {
                                                $docUrl = '/dokumen/musrenbang';
                                            } elseif (in_array($cSlug, ['renstra-renja', 'renstra_renja', 'dokumen-renstra-renja'])) {
                                                $docUrl = '/dokumen/renstra-renja';
                                            } elseif (in_array($cSlug, ['sk-kelembagaan', 'sk_kelembagaan', 'dokumen-sk-kelembagaan'])) {
                                                $docUrl = '/dokumen/sk-kelembagaan';
                                            } else {
                                                $docUrl = '/dokumen?kategori=' . ($catItem->slug ?: $catItem->name);
                                            }
                                        @endphp
                                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 p-3 bg-white rounded-xl border border-slate-200/80 shadow-2xs hover:border-emerald-300 transition">
                                            <!-- Left Info -->
                                            <div class="flex items-center gap-2.5 min-w-0">
                                                <div class="text-blue-500 font-mono font-bold text-xs shrink-0 flex items-center">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                                </div>

                                                <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-600 font-bold text-[11px] flex items-center justify-center shrink-0 border border-slate-200/80">
                                                    #{{ $catIdx + 1 }}
                                                </span>

                                                <div class="min-w-0">
                                                    <div class="font-bold text-slate-800 text-sm flex items-center gap-2 flex-wrap">
                                                        <span class="truncate">{{ $catItem->name }}</span>
                                                        <span class="px-2 py-0.5 bg-blue-50 text-blue-700 border border-blue-200 rounded-md text-[10px] font-bold shrink-0">Sub-Menu Dokumen</span>
                                                    </div>
                                                    <div class="text-xs text-slate-500 mt-0.5 flex items-center gap-2 flex-wrap">
                                                        <span>Path: <code class="text-slate-700 bg-slate-100 px-1.5 py-0.5 rounded text-[11px] font-mono">{{ $docUrl }}</code></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Right Actions -->
                                            <div class="flex items-center gap-2 shrink-0 self-end md:self-auto">
                                                <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold flex items-center gap-1 bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    <span>Aktif</span>
                                                </span>

                                                <a href="{{ route('dashboard.documents.index', ['category' => $catItem->slug ?: $catItem->name]) }}" 
                                                   class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition cursor-pointer border border-slate-200/80 flex items-center gap-1.5 text-[11px] font-bold shadow-2xs" 
                                                   title="Kelola & Unggah Berkas Dokumen {{ $catItem->name }}">
                                                    <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                                                    <span>Kelola Isi Halaman</span>
                                                </a>

                                                <form action="{{ route('dashboard.categories.destroy', $catItem->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori dokumen &quot;{{ addslashes($catItem->name) }}&quot;?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="px-2.5 py-1 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg transition border border-rose-200/80 text-[11px] font-bold flex items-center gap-1 shadow-2xs cursor-pointer" 
                                                            title="Hapus Kategori Dokumen">
                                                        <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        <span>Hapus</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                {{-- Render Database Custom Sub-Menus --}}
                                @foreach($menu->children as $child)
                                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 p-3 bg-white rounded-xl border border-slate-200/80 shadow-2xs hover:border-emerald-300 transition">
                                        <!-- Left Child Info -->
                                        <div class="flex items-center gap-2.5 min-w-0">
                                            <div class="text-emerald-500 font-mono font-bold text-xs shrink-0 flex items-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </div>

                                            <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-600 font-bold text-[11px] flex items-center justify-center shrink-0 border border-slate-200/80">
                                                #{{ $child->order }}
                                            </span>

                                            <div class="min-w-0">
                                                <div class="font-bold text-slate-800 text-sm flex items-center gap-2 flex-wrap">
                                                    <span class="truncate">{{ $child->title }}</span>
                                                    @if($child->image)
                                                        <img src="{{ asset('storage/' . $child->image) }}" class="w-6 h-6 object-cover rounded-md border border-slate-200 shrink-0" title="Foto Sub-Menu" alt="Thumbnail">
                                                    @endif
                                                    <span class="px-2 py-0.5 bg-purple-50 text-purple-700 border border-purple-200 rounded-md text-[10px] font-bold shrink-0">Sub-Menu</span>
                                                    @if($child->show_on_homepage)
                                                        <span class="px-2 py-0.5 bg-amber-50 text-amber-700 border border-amber-300/80 rounded-md text-[10px] font-bold flex items-center gap-1 shrink-0" title="Tampil di Card Sekilas Profil Beranda">
                                                            <svg class="w-3 h-3 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                            <span>Tampil di Beranda</span>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="text-xs text-slate-500 mt-0.5 flex items-center gap-2 flex-wrap">
                                                    <span>Path: <code class="text-slate-700 bg-slate-100 px-1.5 py-0.5 rounded text-[11px] font-mono">{{ $child->url }}</code></span>
                                                    @if($child->target === '_blank')
                                                        <span class="text-blue-600 font-semibold text-[11px]">Buka Tab Baru ↗</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right Child Actions -->
                                        <div class="flex items-center gap-2 shrink-0 self-end md:self-auto">
                                            <!-- Toggle Active -->
                                            <form action="{{ route('dashboard.navigation.toggle', $child->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="px-2.5 py-1 rounded-lg text-[11px] font-bold transition flex items-center gap-1 cursor-pointer {{ $child->is_active ? 'bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-slate-100 hover:bg-slate-200 text-slate-600 border border-slate-200' }}">
                                                    <span class="w-1.5 h-1.5 rounded-full {{ $child->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                                    <span>{{ $child->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                                </button>
                                            </form>

                                            <!-- Edit Button for Modal Form -->
                                            <button type="button" 
                                                    onclick="openEditNavigationModal({{ $child->id }}, '{{ addslashes($child->title) }}', '{{ addslashes($child->url) }}', {{ $child->parent_id }}, {{ $child->order }}, '{{ $child->target }}', {{ $child->is_active ? 1 : 0 }}, {{ $child->show_on_homepage ? 1 : 0 }}, '{{ addslashes($child->description ?? '') }}', '{{ addslashes($child->content ?? '') }}', '{{ addslashes($child->image ?? '') }}')"
                                                    class="px-2.5 py-1 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg transition cursor-pointer border border-blue-200/80 flex items-center gap-1 text-[11px] font-bold shadow-2xs" 
                                                    title="Edit Setting & Nama Sub-Menu">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                <span>Edit</span>
                                            </button>

                                            @php $childFeatureUrl = $getFeatureLink($child); @endphp
                                            @if($childFeatureUrl)
                                                <!-- Link to specialized setting page -->
                                                <a href="{{ $childFeatureUrl }}" 
                                                   class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition border border-slate-200/80 text-[11px] font-bold flex items-center gap-1.5 shadow-2xs" 
                                                   title="Buka Halaman Pengisian Konten {{ $child->title }}">
                                                    <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                                                    <span>Kelola Isi Halaman</span>
                                                </a>
                                            @endif

                                            <!-- Delete Sub-Menu Button -->
                                            <form action="{{ route('dashboard.navigation.destroy', $child->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sub-menu &quot;{{ addslashes($child->title) }}&quot;?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="px-2.5 py-1 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg transition border border-rose-200/80 text-[11px] font-bold flex items-center gap-1 shadow-2xs cursor-pointer" 
                                                        title="Hapus Sub-Menu">
                                                    <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    <span>Hapus</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="py-12 px-4 text-center">
                    <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-700">Belum Ada Menu Navigasi</h3>
                    <p class="text-slate-500 text-xs mt-1 max-w-sm mx-auto">Silakan tambahkan menu navigasi pertama Anda untuk menampilkan baris navigasi website.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Modal Form Tambah Menu Navigasi / Sub-Menu Baru -->
<div id="createNavigationModal" class="fixed inset-0 z-50 overflow-y-auto hidden opacity-0 transition-opacity duration-300">
    <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity"></div>
    <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
        <div class="relative w-full max-w-xl transform scale-95 overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 my-auto">
            <!-- Modal Dark Emerald Header -->
            <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <div>
                        <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">
                            KELOLA NAVIGASI
                        </span>
                        <h3 class="text-base font-black text-white mt-0.5">Tambah Menu Navigasi / Sub-Menu</h3>
                    </div>
                </div>
                <button type="button" onclick="closeModal('createNavigationModal')" class="text-slate-400 hover:text-white p-1.5 rounded-xl hover:bg-white/10 transition cursor-pointer" title="Tutup Modal">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form id="createNavigationForm" action="{{ route('dashboard.navigation.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 max-h-[85vh] overflow-y-auto custom-scrollbar">
                @csrf
                <input type="hidden" name="_form_type" value="create">

                <!-- Nama Menu & Slug -->
                <div>
                    <label for="create_title" class="block text-xs font-bold text-slate-700 mb-1.5">Nama Menu / Judul Halaman <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" id="create_title" value="{{ old('_form_type') === 'create' ? old('title') : '' }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs text-xs font-medium" placeholder="Contoh: Prestasi & Penghargaan">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="create_url" class="block text-xs font-bold text-slate-700">Tautan URL / Alamat Halaman <span class="text-rose-500">*</span></label>
                        <button type="button" onclick="forceAutoSlug('create')" class="text-emerald-600 hover:underline font-bold text-[11px] flex items-center gap-1 cursor-pointer" title="Generate otomatis dari Nama Menu">
                            ⚡ Buat URL Otomatis
                        </button>
                    </div>
                    <input type="text" name="url" id="create_url" value="{{ old('_form_type') === 'create' ? old('url') : '' }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs text-xs font-mono text-emerald-700 bg-slate-50/50" placeholder="/profil/prestasi">
                </div>

                <!-- Parent & Order Selection -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-1">
                    <div class="sm:col-span-2">
                        <label for="create_parent_id" class="block text-xs font-bold text-slate-700 mb-1.5">Posisi Menu (Menu Induk / Parent)</label>
                        <select name="parent_id" id="create_parent_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-bold bg-white">
                            <option value="">-- Menu Utama (Baris Atas Navigasi) --</option>
                            @foreach($allParentMenus as $parentOpt)
                                <option value="{{ $parentOpt->id }}" data-url="{{ $parentOpt->url }}" data-title="{{ $parentOpt->title }}" {{ (old('_form_type') === 'create' && old('parent_id') == $parentOpt->id) ? 'selected' : '' }}>
                                    Sub-Menu di bawah "{{ $parentOpt->title }}"
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="create_order" class="block text-xs font-bold text-slate-700 mb-1.5">Nomor Urut (#):</label>
                        <input type="number" name="order" id="create_order" value="1" min="1" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500 text-center bg-white">
                    </div>
                </div>

                <!-- Excerpt / Description -->
                <div>
                    <label for="create_description" class="block text-xs font-bold text-slate-700 mb-1.5">Ringkasan Singkat Halaman (Opsional):</label>
                    <textarea name="description" id="create_description" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-medium text-slate-800 placeholder-slate-400" placeholder="Ringkasan singkat mengenai informasi halaman ini..."></textarea>
                </div>

                <!-- Foto / Gambar Halaman -->
                <div>
                    <label for="create_image" class="block text-xs font-bold text-slate-700 mb-1.5">Foto / Banner Halaman (Opsional):</label>
                    <input type="file" name="image" id="create_image" accept="image/jpeg,image/png,image/webp,image/gif,image/svg+xml" onchange="validateImageUpload(this, 'create_image_label', 'Pilih Berkas Foto', 5)" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 transition cursor-pointer">
                    <span id="create_image_label" class="text-[10px] text-slate-400 mt-1 block">Format: JPG, PNG, WEBP, GIF (Maks. 5MB).</span>
                </div>

                <!-- Page Content / Detail Teks -->
                <div>
                    <label for="create_content" class="block text-xs font-bold text-slate-700 mb-1.5">Isi Konten Halaman Lengkap:</label>
                    <textarea name="content" id="create_content" rows="6" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-medium text-slate-800 placeholder-slate-400" placeholder="Tuliskan isi konten lengkap untuk halaman ini..."></textarea>
                </div>

                <!-- Checkboxes -->
                <div class="flex flex-wrap items-center gap-5 pt-3 border-t border-slate-100">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="create_is_active" value="1" {{ (old('_form_type') === 'create' ? old('is_active', true) : true) ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 bg-slate-100 border-slate-300 rounded focus:ring-emerald-500 focus:ring-2 cursor-pointer">
                        <label for="create_is_active" class="ml-2 text-xs font-bold text-slate-700 cursor-pointer">Tampilkan & Publikasikan Menu Ini</label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="show_on_homepage" id="create_show_on_homepage" value="1" {{ (old('_form_type') === 'create' && old('show_on_homepage')) ? 'checked' : '' }} class="w-4 h-4 text-amber-500 bg-slate-100 border-slate-300 rounded focus:ring-amber-500 focus:ring-2 cursor-pointer">
                        <label for="create_show_on_homepage" class="ml-2 text-xs font-bold text-slate-700 cursor-pointer flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            Tampilkan di Halaman Beranda
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="hidden" name="target" value="_self">
                        <input type="checkbox" name="target" id="create_target" value="_blank" {{ (old('_form_type') === 'create' && old('target') === '_blank') ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 bg-slate-100 border-slate-300 rounded focus:ring-emerald-500 focus:ring-2 cursor-pointer">
                        <label for="create_target" class="ml-2 text-xs font-bold text-slate-700 cursor-pointer">Buka di Tab Baru ↗</label>
                    </div>
                </div>

                <!-- Modal Footer Actions -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeModal('createNavigationModal')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span>Simpan Menu</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Form Edit Menu Navigasi -->
<div id="editNavigationModal" class="fixed inset-0 z-50 overflow-y-auto hidden opacity-0 transition-opacity duration-300">
    <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity"></div>
    <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
        <div class="relative w-full max-w-xl transform scale-95 overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 my-auto">
            <!-- Modal Dark Emerald Header -->
            <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">
                            KELOLA NAVIGASI
                        </span>
                        <h3 class="text-base font-black text-white mt-0.5">Edit Pengaturan Menu Navigasi</h3>
                    </div>
                </div>
                <button type="button" onclick="closeModal('editNavigationModal')" class="text-slate-400 hover:text-white p-1.5 rounded-xl hover:bg-white/10 transition cursor-pointer" title="Tutup Modal">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Form -->
            <form id="editNavigationForm" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 max-h-[85vh] overflow-y-auto custom-scrollbar">
                @csrf
                @method('PUT')
                <input type="hidden" name="_form_type" value="edit">

                <!-- Nama Menu & Slug -->
                <div>
                    <label for="edit_title" class="block text-xs font-bold text-slate-700 mb-1.5">Nama Menu / Judul Halaman <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" id="edit_title" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs text-xs font-medium" placeholder="Contoh: Visi & Misi">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="edit_url" class="block text-xs font-bold text-slate-700">Tautan URL / Alamat Halaman <span class="text-rose-500">*</span></label>
                        <button type="button" onclick="forceAutoSlug('edit')" class="text-emerald-600 hover:underline font-bold text-[11px] flex items-center gap-1 cursor-pointer" title="Generate otomatis dari Nama Menu">
                            ⚡ Buat URL Otomatis
                        </button>
                    </div>
                    <input type="text" name="url" id="edit_url" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs text-xs font-mono text-emerald-700 bg-slate-50/50" placeholder="/profil/visi-misi">
                </div>

                <!-- Parent & Order Selection -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-1">
                    <div class="sm:col-span-2">
                        <label for="edit_parent_id" class="block text-xs font-bold text-slate-700 mb-1.5">Posisi Menu (Menu Induk / Parent)</label>
                        <select name="parent_id" id="edit_parent_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-bold bg-white">
                            <option value="">-- Menu Utama (Baris Atas Navigasi) --</option>
                            @foreach($allParentMenus as $parentOpt)
                                <option value="{{ $parentOpt->id }}" id="edit_parent_option_{{ $parentOpt->id }}" data-url="{{ $parentOpt->url }}" data-title="{{ $parentOpt->title }}">
                                    Sub-Menu di bawah "{{ $parentOpt->title }}"
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="edit_order" class="block text-xs font-bold text-slate-700 mb-1.5">Nomor Urut (#):</label>
                        <input type="number" name="order" id="edit_order" min="1" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500 text-center bg-white">
                    </div>
                </div>

                <!-- Excerpt / Description -->
                <div>
                    <label for="edit_description" class="block text-xs font-bold text-slate-700 mb-1.5">Ringkasan Singkat Halaman (Opsional):</label>
                    <textarea name="description" id="edit_description" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-medium text-slate-800 placeholder-slate-400" placeholder="Ringkasan singkat mengenai informasi halaman ini..."></textarea>
                </div>

                <!-- Foto / Gambar Halaman -->
                <div>
                    <label for="edit_image" class="block text-xs font-bold text-slate-700 mb-1.5">Foto / Banner Halaman (Opsional):</label>
                    <div id="edit_image_preview_container" class="mb-2 hidden">
                        <div class="relative inline-flex items-center gap-3 border border-slate-200 rounded-xl p-2 bg-slate-50">
                            <img id="edit_image_preview" src="" alt="Preview" class="h-16 w-24 object-cover rounded-lg border border-slate-200">
                            <label class="flex items-center gap-1.5 text-xs text-rose-600 font-semibold cursor-pointer">
                                <input type="checkbox" name="remove_image" id="edit_remove_image" value="1" class="rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                                Hapus Foto Ini
                            </label>
                        </div>
                    </div>
                    <input type="file" name="image" id="edit_image" accept="image/jpeg,image/png,image/webp,image/gif,image/svg+xml" onchange="validateImageUpload(this, 'edit_image_label', 'Pilih Berkas Foto', 5)" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 transition cursor-pointer">
                    <span id="edit_image_label" class="text-[10px] text-slate-400 mt-1 block">Format: JPG, PNG, WEBP, GIF (Maks. 5MB).</span>
                </div>

                <!-- Page Content / Detail Teks -->
                <div>
                    <label for="edit_content" class="block text-xs font-bold text-slate-700 mb-1.5">Isi Konten Halaman Lengkap:</label>
                    <textarea name="content" id="edit_content" rows="6" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-medium text-slate-800 placeholder-slate-400" placeholder="Tuliskan isi konten lengkap untuk halaman ini..."></textarea>
                </div>

                <!-- Checkboxes -->
                <div class="flex flex-wrap items-center gap-5 pt-3 border-t border-slate-100">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="edit_is_active" value="1" class="w-4 h-4 text-emerald-600 bg-slate-100 border-slate-300 rounded focus:ring-emerald-500 focus:ring-2 cursor-pointer">
                        <label for="edit_is_active" class="ml-2 text-xs font-bold text-slate-700 cursor-pointer">Tampilkan & Publikasikan Menu Ini</label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="show_on_homepage" id="edit_show_on_homepage" value="1" class="w-4 h-4 text-amber-500 bg-slate-100 border-slate-300 rounded focus:ring-amber-500 focus:ring-2 cursor-pointer">
                        <label for="edit_show_on_homepage" class="ml-2 text-xs font-bold text-slate-700 cursor-pointer flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            Tampilkan di Halaman Beranda
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="hidden" name="target" value="_self">
                        <input type="checkbox" name="target" id="edit_target" value="_blank" class="w-4 h-4 text-emerald-600 bg-slate-100 border-slate-300 rounded focus:ring-emerald-500 focus:ring-2 cursor-pointer">
                        <label for="edit_target" class="ml-2 text-xs font-bold text-slate-700 cursor-pointer">Buka di Tab Baru ↗</label>
                    </div>
                </div>

                <!-- Modal Footer Actions -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeModal('editNavigationModal')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Form Tambah SOP / Standar Pelayanan Baru (Grup Layanan) -->
<div id="createServiceModal" class="fixed inset-0 z-50 overflow-y-auto hidden opacity-0 transition-opacity duration-300">
    <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity"></div>
    <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
        <div class="relative w-full max-w-2xl transform scale-95 overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 my-auto">
            <!-- Modal Dark Emerald Header -->
            <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">
                            STANDAR PELAYANAN SOP
                        </span>
                        <h3 class="text-base font-black text-white mt-0.5">Tambah Dokumen SOP / Layanan Baru</h3>
                    </div>
                </div>
                <button type="button" onclick="closeModal('createServiceModal')" class="text-slate-400 hover:text-white p-1.5 rounded-xl hover:bg-white/10 transition cursor-pointer" title="Tutup Modal">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Form -->
            <form action="{{ route('dashboard.services.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 max-h-[85vh] overflow-y-auto custom-scrollbar">
                @csrf

                <div>
                    <label for="srv_title" class="block text-xs font-bold text-slate-700 mb-1.5">Judul Dokumen / Layanan <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" id="srv_title" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs text-xs font-medium" placeholder="Contoh: SOP Pelayanan Surat Keterangan Usaha (SKU)">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="srv_kategori_layanan_id" class="block text-xs font-bold text-slate-700">Kategori Layanan <span class="text-rose-500">*</span></label>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="openQuickAddCategoryModal('layanan', 'srv_kategori_layanan_id', 'kategori_layanan_id')" class="text-[11px] font-bold text-emerald-600 hover:underline flex items-center gap-1 cursor-pointer">
                                <span>+ Tambah</span>
                            </button>
                            <span class="text-slate-300">|</span>
                            <button type="button" onclick="quickDeleteSelectedCategory('layanan', 'srv_kategori_layanan_id', 'kategori_layanan_id')" class="text-[11px] font-bold text-rose-600 hover:underline flex items-center gap-1 cursor-pointer">
                                <span>🗑️ Hapus</span>
                            </button>
                        </div>
                    </div>
                    <select name="kategori_layanan_id" id="srv_kategori_layanan_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-bold bg-white">
                        <option value="">-- Pilih Kategori Layanan --</option>
                        @if(isset($kategoriLayanan))
                            @foreach($kategoriLayanan as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div>
                    <label for="srv_description" class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi / Ringkasan Layanan</label>
                    <textarea name="description" id="srv_description" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-medium text-slate-800 placeholder-slate-400" placeholder="Tuliskan ringkasan prosedur atau petunjuk singkat..."></textarea>
                </div>

                <div>
                    <label for="srv_requirements" class="block text-xs font-bold text-slate-700 mb-1.5">Persyaratan Dokumen</label>
                    <textarea name="requirements" id="srv_requirements" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-medium text-slate-800 placeholder-slate-400" placeholder="Contoh: Foto KTP Warga, Kartu Keluarga (KK), Surat Pengantar RT/RW (pisahkan dengan baris baru atau koma)"></textarea>
                </div>

                <div class="border-t border-slate-100 pt-3 space-y-3">
                    <label class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-500">Ketentuan Pelayanan</label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label for="srv_operating_days" class="block text-[11px] font-bold text-slate-700 mb-1">Hari Operasional</label>
                            <select name="operating_days" id="srv_operating_days" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white font-medium">
                                <option value="Senin - Jumat" selected>Senin - Jumat</option>
                                <option value="Senin - Sabtu">Senin - Sabtu</option>
                                <option value="Setiap Hari (Senin - Minggu)">Setiap Hari (Senin - Minggu)</option>
                            </select>
                        </div>
                        <div>
                            <label for="srv_operating_hours" class="block text-[11px] font-bold text-slate-700 mb-1">Jam Operasional</label>
                            <input type="text" name="operating_hours" id="srv_operating_hours" value="07.30 - 15.30 WIB" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-medium">
                        </div>
                        <div>
                            <label for="srv_processing_time" class="block text-[11px] font-bold text-slate-700 mb-1">Estimasi Waktu</label>
                            <input type="text" name="processing_time" id="srv_processing_time" value="1 Hari Kerja (1x24 Jam)" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-medium">
                        </div>
                    </div>

                    <div>
                        <label for="srv_cost" class="block text-[11px] font-bold text-slate-700 mb-1">Biaya Pelayanan</label>
                        <input type="text" name="cost" id="srv_cost" value="GRATIS" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold text-emerald-700" placeholder="GRATIS">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Berkas Dokumen PDF (Maks. 10MB)</label>
                    <input type="file" name="pdf_file" id="srv_pdf_file" accept="application/pdf" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 transition cursor-pointer">
                </div>

                <div class="flex items-center pt-2 border-t border-slate-100">
                    <input type="checkbox" name="is_active" id="srv_is_active" value="1" checked class="w-4 h-4 text-emerald-600 bg-slate-100 border-slate-300 rounded focus:ring-emerald-500 focus:ring-2 cursor-pointer">
                    <label for="srv_is_active" class="ml-2 text-xs font-bold text-slate-700 cursor-pointer">Tampilkan dokumen ini di menu & halaman publik (Aktif)</label>
                </div>

                <!-- Modal Footer Actions -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeModal('createServiceModal')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span>Simpan Dokumen SOP</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Form Unggah Dokumen PDF Baru (Grup Dokumen) -->
<div id="createDocumentModal" class="fixed inset-0 z-50 overflow-y-auto hidden opacity-0 transition-opacity duration-300">
    <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity"></div>
    <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
        <div class="relative w-full max-w-lg transform scale-95 overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 my-auto">
            <!-- Modal Dark Emerald Header -->
            <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    </div>
                    <div>
                        <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">
                            DOKUMEN PUBLIK
                        </span>
                        <h3 class="text-base font-black text-white mt-0.5">Unggah Berkas Dokumen PDF Baru</h3>
                    </div>
                </div>
                <button type="button" onclick="closeModal('createDocumentModal')" class="text-slate-400 hover:text-white p-1.5 rounded-xl hover:bg-white/10 transition cursor-pointer" title="Tutup Modal">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Form -->
            <form action="{{ route('dashboard.documents.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 max-h-[85vh] overflow-y-auto custom-scrollbar">
                @csrf

                <div>
                    <label for="doc_title" class="block text-xs font-bold text-slate-700 mb-1.5">Judul Dokumen <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" id="doc_title" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs text-xs font-medium" placeholder="Contoh: Berita Acara Musrenbang 2026">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="doc_category" class="block text-xs font-bold text-slate-700">Kategori Dokumen <span class="text-rose-500">*</span></label>
                            <div class="flex items-center gap-2">
                                <button type="button" onclick="openQuickAddCategoryModal('dokumen', 'doc_category', 'slug')" class="text-[11px] font-bold text-emerald-600 hover:underline flex items-center gap-1 cursor-pointer">
                                    <span>+ Tambah</span>
                                </button>
                                <span class="text-slate-300">|</span>
                                <button type="button" onclick="quickDeleteSelectedCategory('dokumen', 'doc_category', 'slug')" class="text-[11px] font-bold text-rose-600 hover:underline flex items-center gap-1 cursor-pointer">
                                    <span>🗑️ Hapus</span>
                                </button>
                            </div>
                        </div>
                        <select name="category" id="doc_category" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-bold bg-white">
                            @if(isset($docCategories) && $docCategories->count() > 0)
                                @foreach($docCategories as $cat)
                                    <option value="{{ $cat->slug ?: $cat->name }}">{{ $cat->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div>
                        <label for="doc_published_date" class="block text-xs font-bold text-slate-700 mb-1.5">Tanggal Dokumen</label>
                        <input type="date" name="published_date" id="doc_published_date" value="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 font-medium">
                    </div>
                </div>

                <div>
                    <label for="doc_organization" class="block text-xs font-bold text-slate-700 mb-1.5">Organisasi / Lembaga (Opsional)</label>
                    <input type="text" name="organization" id="doc_organization" value="Pemerintah Kelurahan Kandang Jati Kulon" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-medium text-slate-800 placeholder-slate-400" placeholder="Contoh: RT / RW, TP-PKK, LPMK">
                </div>

                <div>
                    <label for="doc_description" class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Singkat</label>
                    <textarea name="description" id="doc_description" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-medium text-slate-800 placeholder-slate-400" placeholder="Ringkasan isi dokumen..."></textarea>
                </div>

                <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 bg-slate-50 space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Opsi A: Upload Berkas PDF (Maks. 10 MB)</label>
                        <input type="file" name="document_file" id="doc_file" accept=".pdf,application/pdf" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 transition cursor-pointer">
                    </div>

                    <div class="text-[10px] text-slate-400 text-center font-bold uppercase">atau link tautan online pdf</div>

                    <div>
                        <input type="url" name="file_url" id="doc_file_url" placeholder="https://example.com/dokumen.pdf" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-mono">
                    </div>
                </div>

                <!-- Modal Footer Actions -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeModal('createDocumentModal')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span>Unggah Berkas PDF</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let autoSlugState = {
    create: true,
    edit: false
};

let slugTimers = {
    create: null,
    edit: null
};

function slugify(text) {
    if (!text) return '';
    return text.toString()
        .toLowerCase()
        .trim()
        .replace(/&/g, 'dan')
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/[\s_]+/g, '-')
        .replace(/-+/g, '-')
        .replace(/^-+|-+$/g, '');
}

function updateAutoUrl(type) {
    if (!autoSlugState[type]) return;

    const titleEl = document.getElementById(type + '_title');
    const parentEl = document.getElementById(type + '_parent_id');
    const urlEl = document.getElementById(type + '_url');

    if (!titleEl || !urlEl) return;

    const titleVal = titleEl.value;
    if (!titleVal.trim()) {
        urlEl.value = '';
        return;
    }

    const titleSlug = slugify(titleVal);
    let prefix = '';

    if (parentEl && parentEl.value) {
        const selectedOpt = parentEl.options[parentEl.selectedIndex];
        if (selectedOpt) {
            const parentUrl = selectedOpt.getAttribute('data-url') || '';
            const parentTitle = selectedOpt.getAttribute('data-title') || '';

            if (parentUrl && parentUrl !== '#' && parentUrl.startsWith('/')) {
                prefix = parentUrl.replace(/\/+$/, '');
            } else if (parentTitle) {
                prefix = '/' + slugify(parentTitle);
            }
        }
    }

    urlEl.value = prefix ? (prefix + '/' + titleSlug) : ('/' + titleSlug);
}

function debouncedUpdateAutoUrl(type) {
    if (slugTimers[type]) clearTimeout(slugTimers[type]);
    slugTimers[type] = setTimeout(() => updateAutoUrl(type), 120);
}

function forceAutoSlug(type) {
    autoSlugState[type] = true;
    updateAutoUrl(type);
}

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.remove('hidden');
    requestAnimationFrame(() => {
        modal.classList.remove('opacity-0');
        const card = modal.querySelector('.transform') || modal.firstElementChild;
        if (card) {
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }
    });
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.add('opacity-0');
    const card = modal.querySelector('.transform') || modal.firstElementChild;
    if (card) {
        card.classList.remove('scale-100');
        card.classList.add('scale-95');
    }
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 250);
}

let tinyMCELoaded = false;
let tinyMCELoading = false;

function loadTinyMCEScript(callback) {
    if (typeof tinymce !== 'undefined') {
        tinyMCELoaded = true;
        if (callback) callback();
        return;
    }
    if (tinyMCELoading) {
        let checkInt = setInterval(() => {
            if (typeof tinymce !== 'undefined') {
                clearInterval(checkInt);
                if (callback) callback();
            }
        }, 50);
        return;
    }
    tinyMCELoading = true;
    const script = document.createElement('script');
    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js';
    script.referrerPolicy = 'no-referrer';
    script.onload = function() {
        tinyMCELoaded = true;
        tinyMCELoading = false;
        if (callback) callback();
    };
    script.onerror = function() {
        tinyMCELoading = false;
    };
    document.head.appendChild(script);
}

function ensureTinyMCE(id, height, isFull, initialContent) {
    const val = (typeof initialContent === 'string') ? initialContent : '';
    
    loadTinyMCEScript(function() {
        if (typeof tinymce === 'undefined') return;

        const existing = tinymce.get(id);
        if (existing) {
            existing.setContent(val);
            existing.save();
            return;
        }

        tinymce.init({
            selector: '#' + id,
            height: height || 250,
            menubar: false,
            plugins: [
                'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'searchreplace', 'visualblocks', 'code', 'table', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image table | code preview',
            content_style: 'body { font-family: Inter, Helvetica, Arial, sans-serif; font-size: 13px; line-height: 1.5; color: #334155; }',
            branding: false,
            promotion: false,
            setup: function (editor) {
                editor.on('init', function () {
                    editor.setContent(val);
                });
                editor.on('change keyup NodeChange blur', function () {
                    editor.save();
                });
            }
        });
    });
}

function openCreateNavigationModal() {
    autoSlugState.create = true;
    const titleEl = document.getElementById('create_title');
    const urlEl = document.getElementById('create_url');
    const parentEl = document.getElementById('create_parent_id');
    const targetEl = document.getElementById('create_target');
    const activeEl = document.getElementById('create_is_active');
    const homeEl = document.getElementById('create_show_on_homepage');
    const descEl = document.getElementById('create_description');
    const contentEl = document.getElementById('create_content');
    
    if (titleEl) titleEl.value = '';
    if (urlEl) urlEl.value = '';
    if (parentEl) parentEl.value = '';
    if (targetEl) targetEl.checked = false;
    if (activeEl) activeEl.checked = true;
    if (homeEl) homeEl.checked = false;
    if (descEl) descEl.value = '';
    if (contentEl) contentEl.value = '';

    openModal('createNavigationModal');
    ensureTinyMCE('create_content', 280, true, '');
}

function openAddSubMenuModal(parentId, parentTitle) {
    openCreateNavigationModal();
    const parentSelect = document.getElementById('create_parent_id');
    if (parentSelect) {
        parentSelect.value = parentId || '';
        updateAutoUrl('create');
    }
}

function openEditNavigationModal(id, title, url, parentId, order, target, isActive, showOnHomepage = 0, description = '', content = '', image = '') {
    autoSlugState.edit = false;

    const form = document.getElementById('editNavigationForm');
    if (form) form.action = "{{ url('/dashboard/navigation') }}/" + id;
    
    const titleEl = document.getElementById('edit_title');
    const urlEl = document.getElementById('edit_url');
    const orderEl = document.getElementById('edit_order');
    const targetEl = document.getElementById('edit_target');
    const activeEl = document.getElementById('edit_is_active');
    const homeEl = document.getElementById('edit_show_on_homepage');
    const descEl = document.getElementById('edit_description');
    const contentEl = document.getElementById('edit_content');
    const select = document.getElementById('edit_parent_id');
    const imgFileEl = document.getElementById('edit_image');
    const imgPrevContainer = document.getElementById('edit_image_preview_container');
    const imgPrev = document.getElementById('edit_image_preview');
    const removeImg = document.getElementById('edit_remove_image');

    if (titleEl) titleEl.value = title || '';
    if (urlEl) urlEl.value = url || '';
    if (orderEl) orderEl.value = order || 1;
    if (targetEl) targetEl.checked = (target === '_blank');
    if (activeEl) activeEl.checked = Boolean(isActive);
    if (homeEl) homeEl.checked = Boolean(showOnHomepage);
    if (descEl) descEl.value = description || '';
    if (contentEl) contentEl.value = content || '';
    if (imgFileEl) imgFileEl.value = '';
    if (removeImg) removeImg.checked = false;

    if (image) {
        if (imgPrev) imgPrev.src = image.startsWith('http') ? image : "{{ asset('storage') }}/" + image;
        if (imgPrevContainer) imgPrevContainer.classList.remove('hidden');
    } else {
        if (imgPrevContainer) imgPrevContainer.classList.add('hidden');
    }

    if (select) {
        Array.from(select.options).forEach(opt => {
            opt.disabled = (opt.value == id);
        });
        select.value = parentId || '';
    }

    openModal('editNavigationModal');
    ensureTinyMCE('edit_content', 280, true, content || '');
}

function openCreateServiceModal() {
    openModal('createServiceModal');
}

function openCreateDocumentModal() {
    openModal('createDocumentModal');
}

document.addEventListener('DOMContentLoaded', function() {
    // Create form auto-slug listeners
    const createTitle = document.getElementById('create_title');
    const createParent = document.getElementById('create_parent_id');
    const createUrl = document.getElementById('create_url');

    if (createTitle) {
        createTitle.addEventListener('input', () => debouncedUpdateAutoUrl('create'));
    }
    if (createParent) {
        createParent.addEventListener('change', () => updateAutoUrl('create'));
    }
    if (createUrl) {
        createUrl.addEventListener('input', function() {
            autoSlugState.create = false;
            if (this.value.trim() === '') {
                autoSlugState.create = true;
                updateAutoUrl('create');
            }
        });
    }

    // Edit form auto-slug listeners
    const editTitle = document.getElementById('edit_title');
    const editParent = document.getElementById('edit_parent_id');
    const editUrl = document.getElementById('edit_url');

    if (editTitle) {
        editTitle.addEventListener('input', () => debouncedUpdateAutoUrl('edit'));
    }
    if (editParent) {
        editParent.addEventListener('change', () => updateAutoUrl('edit'));
    }
    if (editUrl) {
        editUrl.addEventListener('input', function() {
            autoSlugState.edit = false;
            if (this.value.trim() === '') {
                autoSlugState.edit = true;
                updateAutoUrl('edit');
            }
        });
    }


    // Form submission spinner & double submit protection
    ['createNavigationForm', 'editNavigationForm'].forEach(formId => {
        const form = document.getElementById(formId);
        if (form) {
            form.addEventListener('submit', function() {
                if (typeof tinymce !== 'undefined') {
                    tinymce.triggerSave();
                }
                const btn = this.querySelector('button[type="submit"]');
                if (btn && !btn.disabled) {
                    setTimeout(() => {
                        btn.disabled = true;
                        btn.classList.add('opacity-75', 'cursor-not-allowed');
                        btn.innerHTML = `
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Menyimpan...</span>
                        `;
                    }, 10);
                }
            });
        }
    });

    @if(isset($errors) && $errors->any())
        @if(old('_form_type') === 'edit')
            openModal('editNavigationModal');
        @else
            openModal('createNavigationModal');
        @endif
    @endif
});
</script>
@endsection
