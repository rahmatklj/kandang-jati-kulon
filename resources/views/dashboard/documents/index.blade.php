@extends('layouts.admin')

@section('title', 'Kelola Dokumen PDF Publik')

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

<div x-data="{ uploadModal: false, editModal: false, editDoc: { id: '', title: '', category: '', published_date: '', organization: '', description: '', file_url: '' } }">
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Kelola Dokumen PDF Publik</h1>
            <p class="text-sm text-slate-500 mt-1">Manajemen arsip dokumen resmi kelurahan berformat PDF.</p>
        </div>

        <button @click="uploadModal = true" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase px-4 py-2.5 rounded-xl shadow-sm transition-all duration-200 flex items-center gap-2 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
            + Unggah Dokumen PDF
        </button>
    </div>

    <!-- Modal Form Unggah Dokumen PDF -->
    <div x-show="uploadModal" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;"
         x-cloak>
        
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity"></div>

        <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
            <div class="relative w-full max-w-lg transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 my-auto">
                <!-- Modal Dark Emerald Header -->
                <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        </div>
                        <div>
                            <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">
                                DOKUMEN PDF PUBLIK
                            </span>
                            <h3 class="text-base font-black text-white mt-0.5">Unggah Berkas PDF Baru</h3>
                        </div>
                    </div>
                    <button type="button" @click="uploadModal = false" class="text-slate-400 hover:text-white p-1.5 rounded-xl hover:bg-white/10 transition cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form action="{{ route('dashboard.documents.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateDocumentForm(this)" class="p-6 space-y-4 max-h-[85vh] overflow-y-auto custom-scrollbar">
                    @csrf

                    <div>
                        <label for="title" class="block text-xs font-bold text-slate-700 mb-1.5">Judul Dokumen <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" id="title" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs text-xs font-medium" placeholder="Contoh: Laporan Kinerja Kelurahan 2026">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="category" class="block text-xs font-bold text-slate-700">Kategori Dokumen <span class="text-rose-500">*</span></label>
                                <div class="flex items-center gap-2">
                                    <button type="button" onclick="openQuickAddCategoryModal('dokumen', 'category', 'slug')" class="text-[11px] font-bold text-emerald-600 hover:underline flex items-center gap-1 cursor-pointer">
                                        <span>+ Tambah</span>
                                    </button>
                                    <span class="text-slate-300">|</span>
                                    <button type="button" onclick="quickDeleteSelectedCategory('dokumen', 'category', 'slug')" class="text-[11px] font-bold text-rose-600 hover:underline flex items-center gap-1 cursor-pointer">
                                        <span>🗑️ Hapus</span>
                                    </button>
                                </div>
                            </div>
                            <select name="category" id="category" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-bold bg-white">
                                <option value="">-- Pilih Kategori --</option>
                                @if(isset($categories) && $categories->count() > 0)
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->slug ?: $cat->name }}">{{ $cat->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div>
                            <label for="published_date" class="block text-xs font-bold text-slate-700 mb-1.5">Tanggal Dokumen</label>
                            <input type="date" name="published_date" id="published_date" value="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 font-medium">
                        </div>
                    </div>

                    <div>
                        <label for="organization" class="block text-xs font-bold text-slate-700 mb-1.5">Organisasi / Lembaga (Opsional)</label>
                        <input type="text" name="organization" id="organization" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-medium text-slate-800 placeholder-slate-400" placeholder="Contoh: RT / RW, TP-PKK, LPMK">
                    </div>

                    <div>
                        <label for="description" class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Singkat</label>
                        <textarea name="description" id="description" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-medium text-slate-800 placeholder-slate-400" placeholder="Ringkasan isi dokumen..."></textarea>
                    </div>

                    <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 bg-slate-50 space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Opsi A: Upload Berkas PDF (Maks. 10 MB)</label>
                            <input type="file" name="document_file" id="document_file" accept=".pdf,application/pdf" onchange="validatePdfUpload(this, null, '', 10)" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 transition cursor-pointer">
                        </div>

                        <div class="text-[10px] text-slate-400 text-center font-bold uppercase">atau link tautan online pdf</div>

                        <div>
                            <input type="url" name="file_url" id="file_url" onchange="validatePdfUrlInput(this)" onblur="validatePdfUrlInput(this)" placeholder="https://example.com/dokumen.pdf" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-mono">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="button" @click="uploadModal = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span>Unggah Berkas</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Form Edit Dokumen PDF -->
    <div x-show="editModal" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;"
         x-cloak>
        
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity"></div>

        <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
            <div class="relative w-full max-w-lg transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 my-auto">
                <!-- Modal Dark Emerald Header -->
                <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                        <div>
                            <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">
                                DOKUMEN PDF PUBLIK
                            </span>
                            <h3 class="text-base font-black text-white mt-0.5">Edit Dokumen PDF</h3>
                        </div>
                    </div>
                    <button type="button" @click="editModal = false" class="text-slate-400 hover:text-white p-1.5 rounded-xl hover:bg-white/10 transition cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form :action="'/dashboard/documents/' + editDoc.id" method="POST" enctype="multipart/form-data" onsubmit="return validateDocumentForm(this)" class="p-6 space-y-4 max-h-[85vh] overflow-y-auto custom-scrollbar">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="edit_title" class="block text-xs font-bold text-slate-700 mb-1.5">Judul Dokumen <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" id="edit_title" x-model="editDoc.title" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs text-xs font-medium">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="edit_category" class="block text-xs font-bold text-slate-700">Kategori Dokumen <span class="text-rose-500">*</span></label>
                                <div class="flex items-center gap-2">
                                    <button type="button" onclick="openQuickAddCategoryModal('dokumen', 'edit_category', 'slug')" class="text-[11px] font-bold text-emerald-600 hover:underline flex items-center gap-1 cursor-pointer">
                                        <span>+ Tambah</span>
                                    </button>
                                    <span class="text-slate-300">|</span>
                                    <button type="button" onclick="quickDeleteSelectedCategory('dokumen', 'edit_category', 'slug')" class="text-[11px] font-bold text-rose-600 hover:underline flex items-center gap-1 cursor-pointer">
                                        <span>🗑️ Hapus</span>
                                    </button>
                                </div>
                            </div>
                            <select name="category" id="edit_category" x-model="editDoc.category" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-bold bg-white">
                                <option value="">-- Pilih Kategori --</option>
                                @if(isset($categories) && $categories->count() > 0)
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->slug ?: $cat->name }}">{{ $cat->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div>
                            <label for="edit_published_date" class="block text-xs font-bold text-slate-700 mb-1.5">Tanggal Dokumen</label>
                            <input type="date" name="published_date" id="edit_published_date" x-model="editDoc.published_date" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 font-medium">
                        </div>
                    </div>

                    <div>
                        <label for="edit_organization" class="block text-xs font-bold text-slate-700 mb-1.5">Organisasi / Lembaga (Opsional)</label>
                        <input type="text" name="organization" id="edit_organization" x-model="editDoc.organization" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-medium text-slate-800 placeholder-slate-400">
                    </div>

                    <div>
                        <label for="edit_description" class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Singkat</label>
                        <textarea name="description" id="edit_description" x-model="editDoc.description" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-medium text-slate-800 placeholder-slate-400"></textarea>
                    </div>

                    <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 bg-slate-50 space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Ganti Berkas PDF (Opsional, biarkan kosong jika tidak diganti)</label>
                            <input type="file" name="document_file" id="edit_document_file" accept=".pdf,application/pdf" onchange="validatePdfUpload(this, null, '', 10)" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 transition cursor-pointer">
                        </div>

                        <div class="text-[10px] text-slate-400 text-center font-bold uppercase">atau ubah link tautan online</div>

                        <div>
                            <input type="url" name="file_url" id="edit_file_url" x-model="editDoc.file_url" onchange="validatePdfUrlInput(this)" onblur="validatePdfUrlInput(this)" placeholder="https://example.com/dokumen.pdf" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-mono">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="button" @click="editModal = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-6">
        <span class="block sm:inline font-medium text-xs">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-6">
        <span class="block sm:inline font-medium text-xs">{{ session('error') }}</span>
    </div>
    @endif

    <!-- Filter Kategori Tabs -->
    <div class="mb-6 flex flex-wrap gap-2 border-b border-slate-200 pb-3">
        <a href="{{ route('dashboard.documents.index', ['category' => 'all']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $categoryFilter === 'all' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            Semua Dokumen
        </a>
        @if(isset($categories) && $categories->count() > 0)
            @foreach($categories as $cat)
            @php $cSlug = $cat->slug ?: $cat->name; @endphp
            <a href="{{ route('dashboard.documents.index', ['category' => $cSlug]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ ($categoryFilter === $cSlug || $categoryFilter === $cat->slug || $categoryFilter === $cat->name) ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                {{ $cat->name }}
            </a>
            @endforeach
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
        @forelse($documents as $doc)
        <div class="bg-white rounded-2xl p-5 shadow-xs border border-slate-200 hover:shadow-md transition flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-[10px] font-extrabold uppercase tracking-wider">
                        {{ $doc->category_label }}
                    </span>
                    <span class="text-xs font-mono text-slate-400 font-semibold">{{ $doc->file_size }}</span>
                </div>
                <h3 class="font-bold text-slate-800 text-sm mb-1.5 leading-snug line-clamp-2">{{ $doc->title }}</h3>
                <p class="text-xs text-slate-500 line-clamp-2 mb-4 leading-relaxed">{{ $doc->description }}</p>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                <div class="text-[11px] text-slate-400 font-medium">
                    {{ $doc->published_date ? $doc->published_date->translatedFormat('d M Y') : $doc->created_at->translatedFormat('d M Y') }}
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('dashboard.documents.download', $doc->id) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 rounded-lg text-xs font-bold transition flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        PDF
                    </a>

                    <button type="button" @click="editDoc = {{ json_encode([
                        'id' => (string)$doc->id,
                        'title' => (string)$doc->title,
                        'category' => (string)$doc->category,
                        'published_date' => $doc->published_date ? $doc->published_date->format('Y-m-d') : '',
                        'organization' => (string)($doc->organization ?? ''),
                        'description' => (string)($doc->description ?? ''),
                        'file_url' => Str::startsWith($doc->file_path, ['http://', 'https://']) ? (string)$doc->file_path : '',
                    ]) }}; editModal = true;" class="p-1.5 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg transition cursor-pointer" title="Edit Dokumen">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </button>

                    <form action="{{ route('dashboard.documents.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Hapus dokumen PDF {{ addslashes($doc->title) }}?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition cursor-pointer" title="Hapus Dokumen">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 text-center text-slate-400 font-medium bg-white rounded-2xl border border-slate-200">
            Tidak ada dokumen ditemukan untuk kategori ini.
        </div>
        @endforelse
    </div>

    @if($documents->hasPages())
    <div class="mt-6">
        {{ $documents->links() }}
    </div>
    @endif
</div>

<script>
window.validatePdfUrlInput = function(input) {
    const val = input.value ? input.value.trim() : '';
    if (!val) return true;

    // Validate that input URL starts with http:// or https:// and contains/ends with .pdf
    const isPdfUrl = /^https?:\/\/.+/i.test(val) && /\.pdf($|\?|#)/i.test(val);
    if (!isPdfUrl) {
        input.value = '';
        input.dispatchEvent(new Event('input'));
        alert('🚫 AKSES DITOLAK!\n\nTautan link URL berkas \'' + val + '\' tidak diperbolehkan.\n\nHanya tautan link URL berkas PDF yang diperbolehkan (harus diawali http:// atau https:// dan berakhiran .pdf)!');
        return false;
    }
    return true;
};

window.validateDocumentForm = function(form) {
    const fileInput = form.querySelector('input[type="file"]');
    if (fileInput && fileInput.files && fileInput.files.length > 0) {
        if (!validatePdfUpload(fileInput, null, '', 10)) {
            return false;
        }
    }

    const urlInput = form.querySelector('input[name="file_url"]');
    if (urlInput && urlInput.value.trim() !== '') {
        if (!validatePdfUrlInput(urlInput)) {
            return false;
        }
    }

    const isEdit = form.getAttribute('method') && form.getAttribute('method').toUpperCase() === 'POST' && form.querySelector('input[name="_method"]');
    if (!isEdit) {
        const hasFile = fileInput && fileInput.files && fileInput.files.length > 0;
        const hasUrl = urlInput && urlInput.value.trim() !== '';
        if (!hasFile && !hasUrl) {
            alert('🚫 AKSES DITOLAK!\n\nSilakan pilih berkas PDF untuk diunggah atau masukkan link tautan online berkas PDF!');
            return false;
        }
    }

    return true;
};
</script>
@endsection
