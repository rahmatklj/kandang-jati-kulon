@extends('layouts.admin')

@section('title', 'Kelola Aparatur & Struktur Organisasi')

@section('content')
<!-- Sub-Navigation Tabs Profil -->
<div class="flex flex-wrap items-center gap-2 mb-6 bg-slate-100 p-1.5 rounded-2xl w-fit border border-slate-200/80">
    <a href="{{ route('dashboard.settings.visi-misi') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ request()->routeIs('dashboard.settings.visi-misi') ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/60' }}">
        <span>Visi & Misi</span>
    </a>
    <a href="{{ route('dashboard.settings.aparatur') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ request()->routeIs('dashboard.settings.aparatur') ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/60' }}">
        <span>Struktur Organisasi</span>
    </a>
    <a href="{{ route('dashboard.settings.sejarah') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ request()->routeIs('dashboard.settings.sejarah') ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/60' }}">
        <span>Sejarah Kelurahan</span>
    </a>
    <a href="{{ route('dashboard.demographics.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ request()->routeIs('dashboard.demographics.*') ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/60' }}">
        <span>Demografi & Statistik</span>
    </a>
</div>

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Kelola Aparatur & Struktur Organisasi</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola data pejabat, foto pas foto aparatur, NIP, serta diagram bagan struktur organisasi kelurahan.</p>
    </div>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-xl shadow-xs text-sm font-medium flex items-center gap-2">
    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
    <span>{{ session('success') }}</span>
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden p-6 md:p-8">
    <form action="{{ route('dashboard.settings.update') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateAparaturForm(this)" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- SECTION 1: ATASAN DIRECT / CAMAT -->
        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200/90 space-y-4">
            <div class="flex items-center gap-2 border-b border-slate-200 pb-3">
                <span class="w-3 h-3 rounded-full bg-indigo-600"></span>
                <h3 class="text-base font-extrabold text-slate-900 uppercase tracking-wide">1. Atasan Direct / Camat (Kepala Kecamatan / Pembina)</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Foto Atasan / Camat (1:1 Pas Foto HD)</label>
                    <div class="mb-3">
                        @php
                            $atasanVal = $settings['foto_atasan'] ?? '';
                            $atasanSrc = $atasanVal ? (\Illuminate\Support\Str::startsWith($atasanVal, ['http://', 'https://']) ? $atasanVal : Storage::url($atasanVal)) : 'https://ui-avatars.com/api/?name=Camat+Kraksaan&background=4338ca&color=fff&size=200';
                        @endphp
                        <img id="previewFotoAtasan" src="{{ $atasanSrc }}"
                             alt="Foto Atasan / Camat" class="w-32 h-32 object-cover rounded-2xl border-2 border-slate-300 shadow-sm mx-auto md:mx-0">
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2">
                            <input type="file" name="foto_atasan" id="inputFotoAtasan" data-ratio="1:1" data-preview="#previewFotoAtasan" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-100 file:text-indigo-800 hover:file:bg-indigo-200 transition cursor-pointer">
                            <button type="button" onclick="if(document.getElementById('inputFotoAtasan').files.length){ window.CropHelper.open(document.getElementById('inputFotoAtasan')); } else { alert('Pilih berkas foto terlebih dahulu!'); }" class="px-3 py-1.5 bg-white hover:bg-indigo-50 text-slate-700 hover:text-indigo-700 rounded-xl border border-slate-300 text-xs font-bold transition shrink-0 shadow-2xs">
                                Potong (HD)
                            </button>
                            @if(!empty($settings['foto_atasan']))
                            <button type="submit" form="delete-foto-atasan" onclick="return confirm('Apakah Anda yakin ingin menghapus foto Atasan / Camat?')" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 hover:text-rose-700 rounded-xl border border-rose-200 text-xs font-bold transition shrink-0 shadow-2xs flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Hapus
                            </button>
                            @endif
                        </div>
                        <input type="url" name="foto_atasan_url" value="{{ \Illuminate\Support\Str::startsWith($atasanVal, ['http://', 'https://']) ? $atasanVal : '' }}" onchange="validateImageUrlInput(this)" onblur="validateImageUrlInput(this)" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-300 font-mono" placeholder="Atau paste URL Foto Atasan / Camat">
                    </div>
                </div>

                <div class="md:col-span-2 space-y-3.5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Lengkap & Gelar Atasan Direct / Camat</label>
                        <input type="text" name="nama_atasan" value="{{ $settings['nama_atasan'] ?? '' }}"
                               placeholder="Contoh: Drs. H. Sucipto, M.Si"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm font-bold text-slate-800">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">NIP Atasan Direct / Camat</label>
                        <input type="text" name="nip_atasan" value="{{ $settings['nip_atasan'] ?? '' }}"
                               placeholder="Contoh: 19720315 199403 1 005"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Jabatan Resmi Atasan Direct / Camat</label>
                        <input type="text" name="jabatan_atasan" value="{{ $settings['jabatan_atasan'] ?? '' }}"
                               placeholder="Contoh: Camat Kraksaan / Pembina Utama Muda (IV/c)"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm font-semibold">
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: KEPALA KELURAHAN (LURAH) -->
        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200/90 space-y-4">
            <div class="flex items-center gap-2 border-b border-slate-200 pb-3">
                <span class="w-3 h-3 rounded-full bg-slate-900"></span>
                <h3 class="text-base font-extrabold text-slate-900 uppercase tracking-wide">2. Kepala Kelurahan (Lurah)</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Foto Lurah (1:1 Pas Foto HD)</label>
                    <div class="mb-3">
                        @php
                            $lurahVal = $settings['foto_lurah'] ?? $settings['kadin_photo'] ?? '';
                            $lurahSrc = $lurahVal ? (\Illuminate\Support\Str::startsWith($lurahVal, ['http://', 'https://']) ? $lurahVal : Storage::url($lurahVal)) : 'https://ui-avatars.com/api/?name=Ahmad+Syarif&background=0f172a&color=fff&size=200';
                        @endphp
                        <img id="previewFotoLurah" src="{{ $lurahSrc }}"
                             alt="Foto Lurah" class="w-32 h-32 object-cover rounded-2xl border-2 border-slate-300 shadow-sm mx-auto md:mx-0">
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2">
                            <input type="file" name="foto_lurah" id="inputFotoLurah" data-ratio="1:1" data-preview="#previewFotoLurah" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-100 file:text-emerald-800 hover:file:bg-emerald-200 transition cursor-pointer">
                            <button type="button" onclick="if(document.getElementById('inputFotoLurah').files.length){ window.CropHelper.open(document.getElementById('inputFotoLurah')); } else { alert('Pilih berkas foto terlebih dahulu!'); }" class="px-3 py-1.5 bg-white hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 rounded-xl border border-slate-300 text-xs font-bold transition shrink-0 shadow-2xs">
                                Potong (HD)
                            </button>
                            @if(!empty($settings['foto_lurah']) || !empty($settings['kadin_photo']))
                            <button type="submit" form="delete-foto-lurah" onclick="return confirm('Apakah Anda yakin ingin menghapus foto Lurah?')" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 hover:text-rose-700 rounded-xl border border-rose-200 text-xs font-bold transition shrink-0 shadow-2xs flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Hapus
                            </button>
                            @endif
                        </div>
                        <input type="url" name="foto_lurah_url" value="{{ \Illuminate\Support\Str::startsWith($lurahVal, ['http://', 'https://']) ? $lurahVal : '' }}" onchange="validateImageUrlInput(this)" onblur="validateImageUrlInput(this)" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-300 font-mono" placeholder="Atau paste URL Foto Lurah">
                    </div>
                </div>

                <div class="md:col-span-2 space-y-3.5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Lengkap & Gelar</label>
                        <input type="text" name="nama_lurah" value="{{ $settings['nama_lurah'] ?? 'H. Ahmad Syarif, S.STP, M.Si' }}"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-sm font-bold text-slate-800">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">NIP Kepala Kelurahan</label>
                        <input type="text" name="nip_lurah" value="{{ $settings['nip_lurah'] ?? '19780512 200212 1 003' }}"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-sm font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Jabatan Resmi</label>
                        <input type="text" name="jabatan_lurah" value="{{ $settings['jabatan_lurah'] ?? 'Lurah Kandang Jati Kulon' }}"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-sm font-semibold">
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 3: SEKRETARIS KELURAHAN & KEPALA SEKSI (KASI) -->
        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200/90 space-y-6">
            <div class="flex items-center gap-2 border-b border-slate-200 pb-3">
                <span class="w-3 h-3 rounded-full bg-blue-600"></span>
                <h3 class="text-base font-extrabold text-slate-900 uppercase tracking-wide">3. Sekretariat & Kepala Seksi (Kasi)</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Sekretaris Kelurahan -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 space-y-3">
                    <h4 class="font-bold text-sm text-slate-800 border-b pb-2 flex items-center justify-between">
                        <span>Sekretaris Kelurahan</span>
                        <span class="text-[10px] text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full font-extrabold">Sekretariat</span>
                    </h4>
                    <div class="flex items-center gap-4">
                        @php
                            $sekVal = $settings['foto_sekretaris'] ?? '';
                            $sekSrc = $sekVal ? (\Illuminate\Support\Str::startsWith($sekVal, ['http://', 'https://']) ? $sekVal : Storage::url($sekVal)) : 'https://ui-avatars.com/api/?name=Budi+Santoso&background=64748b&color=fff&size=150';
                        @endphp
                        <img id="previewFotoSekretaris" src="{{ $sekSrc }}" class="w-20 h-20 object-cover rounded-xl border border-slate-200 shrink-0">
                        <div class="w-full space-y-2">
                            <div class="flex items-center gap-2">
                                <input type="file" name="foto_sekretaris" id="inputFotoSekretaris" data-ratio="1:1" data-preview="#previewFotoSekretaris" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-blue-50 file:text-blue-700">
                                <button type="button" onclick="if(document.getElementById('inputFotoSekretaris').files.length){ window.CropHelper.open(document.getElementById('inputFotoSekretaris')); } else { alert('Pilih berkas foto terlebih dahulu!'); }" class="px-2 py-1 bg-white hover:bg-blue-50 text-slate-700 hover:text-blue-700 rounded-lg border border-slate-300 text-[11px] font-bold transition shrink-0 shadow-2xs">
                                    Potong
                                </button>
                                @if(!empty($settings['foto_sekretaris']))
                                <button type="submit" form="delete-foto-sekretaris" onclick="return confirm('Apakah Anda yakin ingin menghapus foto Sekretaris?')" class="px-2 py-1 bg-rose-50 hover:bg-rose-100 text-rose-600 hover:text-rose-700 rounded-lg border border-rose-200 text-[11px] font-bold transition shrink-0 shadow-2xs flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                                @endif
                            </div>
                            <input type="url" name="foto_sekretaris_url" value="{{ \Illuminate\Support\Str::startsWith($sekVal, ['http://', 'https://']) ? $sekVal : '' }}" onchange="validateImageUrlInput(this)" onblur="validateImageUrlInput(this)" class="w-full px-2.5 py-1 text-xs rounded-lg border border-slate-300 font-mono" placeholder="atau paste URL foto">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_sekretaris" value="{{ $settings['nama_sekretaris'] ?? 'Budi Santoso, S.Sos' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Jabatan & Pangkat <span class="text-rose-500">*</span></label>
                            <input type="text" name="jabatan_sekretaris" value="{{ $settings['jabatan_sekretaris'] ?? 'Sekretaris Kelurahan Kandang Jati Kulon' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-semibold">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Atasan Langsung / Dibawah Siapa</label>
                            <input type="text" name="atasan_sekretaris" list="atasan_list" value="{{ $settings['atasan_sekretaris'] ?? '' }}" placeholder="Ketik atasan (mis: Lurah Kandang Jati Kulon)..." class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-semibold bg-white text-slate-800">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">NIP / NIK (Opsional)</label>
                        <input type="text" name="nip_sekretaris" value="{{ $settings['nip_sekretaris'] ?? '19820315 200604 1 008' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-mono">
                    </div>
                </div>

                <!-- Kasi Pemerintahan -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 space-y-3">
                    <h4 class="font-bold text-sm text-slate-800 border-b pb-2 flex items-center justify-between">
                        <span>Kasi Pemerintahan</span>
                        <span class="text-[10px] text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full font-extrabold">Seksi 1</span>
                    </h4>
                    <div class="flex items-center gap-4">
                        @php
                            $pemVal = $settings['foto_kasi_pemerintahan'] ?? '';
                            $pemSrc = $pemVal ? (\Illuminate\Support\Str::startsWith($pemVal, ['http://', 'https://']) ? $pemVal : Storage::url($pemVal)) : 'https://ui-avatars.com/api/?name=Hendra+Setiawan&background=64748b&color=fff&size=150';
                        @endphp
                        <img id="previewFotoKasiPem" src="{{ $pemSrc }}" class="w-20 h-20 object-cover rounded-xl border border-slate-200 shrink-0">
                        <div class="w-full space-y-2">
                            <div class="flex items-center gap-2">
                                <input type="file" name="foto_kasi_pemerintahan" id="inputFotoKasiPem" data-ratio="1:1" data-preview="#previewFotoKasiPem" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-amber-50 file:text-amber-800">
                                <button type="button" onclick="if(document.getElementById('inputFotoKasiPem').files.length){ window.CropHelper.open(document.getElementById('inputFotoKasiPem')); } else { alert('Pilih berkas foto terlebih dahulu!'); }" class="px-2 py-1 bg-white hover:bg-amber-50 text-slate-700 hover:text-amber-700 rounded-lg border border-slate-300 text-[11px] font-bold transition shrink-0 shadow-2xs">
                                    Potong
                                </button>
                                @if(!empty($settings['foto_kasi_pemerintahan']))
                                <button type="submit" form="delete-foto-kasi-pem" onclick="return confirm('Apakah Anda yakin ingin menghapus foto Kasi Pemerintahan?')" class="px-2 py-1 bg-rose-50 hover:bg-rose-100 text-rose-600 hover:text-rose-700 rounded-lg border border-rose-200 text-[11px] font-bold transition shrink-0 shadow-2xs flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                                @endif
                            </div>
                            <input type="url" name="foto_kasi_pemerintahan_url" value="{{ \Illuminate\Support\Str::startsWith($pemVal, ['http://', 'https://']) ? $pemVal : '' }}" onchange="validateImageUrlInput(this)" onblur="validateImageUrlInput(this)" class="w-full px-2.5 py-1 text-xs rounded-lg border border-slate-300 font-mono" placeholder="atau paste URL foto">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_kasi_pemerintahan" value="{{ $settings['nama_kasi_pemerintahan'] ?? 'Hendra Setiawan, S.AP' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Jabatan & Pangkat <span class="text-rose-500">*</span></label>
                            <input type="text" name="jabatan_kasi_pemerintahan" value="{{ $settings['jabatan_kasi_pemerintahan'] ?? 'Kasi Pemerintahan' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-semibold">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Atasan Langsung / Dibawah Siapa</label>
                            <input type="text" name="atasan_kasi_pemerintahan" list="atasan_list" value="{{ $settings['atasan_kasi_pemerintahan'] ?? '' }}" placeholder="Ketik atasan (mis: Sekretaris Kelurahan)..." class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-semibold bg-white text-slate-800">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">NIP / NIK (Opsional)</label>
                        <input type="text" name="nip_kasi_pemerintahan" value="{{ $settings['nip_kasi_pemerintahan'] ?? '19850620 200902 1 004' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-mono">
                    </div>
                </div>

                <!-- Kasi Trantib -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 space-y-3">
                    <h4 class="font-bold text-sm text-slate-800 border-b pb-2 flex items-center justify-between">
                        <span>Kasi Trantib (Ketentraman & Ketertiban)</span>
                        <span class="text-[10px] text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full font-extrabold">Seksi 2</span>
                    </h4>
                    <div class="flex items-center gap-4">
                        @php
                            $trantibVal = $settings['foto_kasi_trantib'] ?? '';
                            $trantibSrc = $trantibVal ? (\Illuminate\Support\Str::startsWith($trantibVal, ['http://', 'https://']) ? $trantibVal : Storage::url($trantibVal)) : 'https://ui-avatars.com/api/?name=M+Rizky+Pratama&background=64748b&color=fff&size=150';
                        @endphp
                        <img id="previewFotoKasiTrantib" src="{{ $trantibSrc }}" class="w-20 h-20 object-cover rounded-xl border border-slate-200 shrink-0">
                        <div class="w-full space-y-2">
                            <div class="flex items-center gap-2">
                                <input type="file" name="foto_kasi_trantib" id="inputFotoKasiTrantib" data-ratio="1:1" data-preview="#previewFotoKasiTrantib" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-emerald-50 file:text-emerald-800">
                                <button type="button" onclick="if(document.getElementById('inputFotoKasiTrantib').files.length){ window.CropHelper.open(document.getElementById('inputFotoKasiTrantib')); } else { alert('Pilih berkas foto terlebih dahulu!'); }" class="px-2 py-1 bg-white hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 rounded-lg border border-slate-300 text-[11px] font-bold transition shrink-0 shadow-2xs">
                                    Potong
                                </button>
                                @if(!empty($settings['foto_kasi_trantib']))
                                <button type="submit" form="delete-foto-kasi-trantib" onclick="return confirm('Apakah Anda yakin ingin menghapus foto Kasi Trantib?')" class="px-2 py-1 bg-rose-50 hover:bg-rose-100 text-rose-600 hover:text-rose-700 rounded-lg border border-rose-200 text-[11px] font-bold transition shrink-0 shadow-2xs flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                                @endif
                            </div>
                            <input type="url" name="foto_kasi_trantib_url" value="{{ \Illuminate\Support\Str::startsWith($trantibVal, ['http://', 'https://']) ? $trantibVal : '' }}" onchange="validateImageUrlInput(this)" onblur="validateImageUrlInput(this)" class="w-full px-2.5 py-1 text-xs rounded-lg border border-slate-300 font-mono" placeholder="atau paste URL foto">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_kasi_trantib" value="{{ $settings['nama_kasi_trantib'] ?? 'M. Rizky Pratama, S.IP' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Jabatan & Pangkat <span class="text-rose-500">*</span></label>
                            <input type="text" name="jabatan_kasi_trantib" value="{{ $settings['jabatan_kasi_trantib'] ?? 'Kasi Trantib (Ketentraman & Ketertiban)' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-semibold">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Atasan Langsung / Dibawah Siapa</label>
                            <input type="text" name="atasan_kasi_trantib" list="atasan_list" value="{{ $settings['atasan_kasi_trantib'] ?? '' }}" placeholder="Ketik atasan (mis: Sekretaris Kelurahan)..." class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-semibold bg-white text-slate-800">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">NIP / NIK (Opsional)</label>
                        <input type="text" name="nip_kasi_trantib" value="{{ $settings['nip_kasi_trantib'] ?? '19880110 201101 1 002' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-mono">
                    </div>
                </div>

                <!-- Kasi Pembangunan & Kesra -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 space-y-3">
                    <h4 class="font-bold text-sm text-slate-800 border-b pb-2 flex items-center justify-between">
                        <span>Kasi Pembangunan & Kesra</span>
                        <span class="text-[10px] text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full font-extrabold">Seksi 3</span>
                    </h4>
                    <div class="flex items-center gap-4">
                        @php
                            $kesraVal = $settings['foto_kasi_kesra'] ?? '';
                            $kesraSrc = $kesraVal ? (\Illuminate\Support\Str::startsWith($kesraVal, ['http://', 'https://']) ? $kesraVal : Storage::url($kesraVal)) : 'https://ui-avatars.com/api/?name=Nurul+Hidayah&background=64748b&color=fff&size=150';
                        @endphp
                        <img id="previewFotoKasiKesra" src="{{ $kesraSrc }}" class="w-20 h-20 object-cover rounded-xl border border-slate-200 shrink-0">
                        <div class="w-full space-y-2">
                            <div class="flex items-center gap-2">
                                <input type="file" name="foto_kasi_kesra" id="inputFotoKasiKesra" data-ratio="1:1" data-preview="#previewFotoKasiKesra" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-purple-50 file:text-purple-800">
                                <button type="button" onclick="if(document.getElementById('inputFotoKasiKesra').files.length){ window.CropHelper.open(document.getElementById('inputFotoKasiKesra')); } else { alert('Pilih berkas foto terlebih dahulu!'); }" class="px-2 py-1 bg-white hover:bg-purple-50 text-slate-700 hover:text-purple-700 rounded-lg border border-slate-300 text-[11px] font-bold transition shrink-0 shadow-2xs">
                                    Potong
                                </button>
                                @if(!empty($settings['foto_kasi_kesra']))
                                <button type="submit" form="delete-foto-kasi-kesra" onclick="return confirm('Apakah Anda yakin ingin menghapus foto Kasi Pembangunan & Kesra?')" class="px-2 py-1 bg-rose-50 hover:bg-rose-100 text-rose-600 hover:text-rose-700 rounded-lg border border-rose-200 text-[11px] font-bold transition shrink-0 shadow-2xs flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                                @endif
                            </div>
                            <input type="url" name="foto_kasi_kesra_url" value="{{ \Illuminate\Support\Str::startsWith($kesraVal, ['http://', 'https://']) ? $kesraVal : '' }}" onchange="validateImageUrlInput(this)" onblur="validateImageUrlInput(this)" class="w-full px-2.5 py-1 text-xs rounded-lg border border-slate-300 font-mono" placeholder="atau paste URL foto">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_kasi_kesra" value="{{ $settings['nama_kasi_kesra'] ?? 'Nurul Hidayah, SE., MM' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Jabatan & Pangkat <span class="text-rose-500">*</span></label>
                            <input type="text" name="jabatan_kasi_kesra" value="{{ $settings['jabatan_kasi_kesra'] ?? 'Kasi Pembangunan & Kesra' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-semibold">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Atasan Langsung / Dibawah Siapa</label>
                            <input type="text" name="atasan_kasi_kesra" list="atasan_list" value="{{ $settings['atasan_kasi_kesra'] ?? '' }}" placeholder="Ketik atasan (mis: Sekretaris Kelurahan)..." class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-semibold bg-white text-slate-800">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">NIP / NIK (Opsional)</label>
                        <input type="text" name="nip_kasi_kesra" value="{{ $settings['nip_kasi_kesra'] ?? '19870904 201001 2 005' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-mono">
                    </div>
                </div>

            </div>
        </div>

        <!-- SECTION 4: STAF & ANGGOTA APARATUR TAMBAHAN -->
        @php
            $additionalAparatur = !empty($settings['additional_aparatur']) ? json_decode($settings['additional_aparatur'], true) : [];
            if (!is_array($additionalAparatur)) {
                $additionalAparatur = [];
            }
        @endphp
        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200/90 space-y-4" x-data="{ members: {{ json_encode($additionalAparatur) }} }">
            <input type="hidden" name="additional_aparatur_submitted" value="1">
            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-emerald-600"></span>
                    <h3 class="text-base font-extrabold text-slate-900 uppercase tracking-wide">4. Staf & Anggota Aparatur Kelurahan (Tambahan)</h3>
                </div>
                <button type="button" @click="members.push({ name: '', jabatan: '', nip: '', atasan: '', photo: '', photo_url: '', photo_old: '' })" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-2xs cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    + Tambah Anggota / Staf Baru
                </button>
            </div>

            <!-- Datalist Autocomplete Pilihan Atasan Langsung -->
            <datalist id="atasan_list">
                <option value="Lurah Kandang Jati Kulon"></option>
                <option value="Sekretaris Kelurahan"></option>
                <option value="Kasi Pemerintahan"></option>
                <option value="Kasi Trantib (Ketentraman & Ketertiban)"></option>
                <option value="Kasi Pembangunan & Kesra"></option>
                <option value="Atasan Direct / Camat"></option>
            </datalist>

            <template x-if="members.length === 0">
                <div class="p-6 text-center text-xs text-slate-400 bg-white rounded-xl border border-slate-200/80">
                    Belum ada anggota / staf tambahan. Klik tombol <span class="font-bold text-emerald-600">+ Tambah Anggota / Staf Baru</span> untuk menambahkan staf keanggotaan baru.
                </div>
            </template>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <template x-for="(member, index) in members" :key="index">
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 space-y-3 relative group">
                        <div class="flex items-center justify-between border-b pb-2">
                            <span class="text-xs font-bold text-slate-700 uppercase" x-text="'Staf / Anggota #' + (index + 1)"></span>
                            <button type="button" @click="members.splice(index, 1)" class="text-rose-500 hover:text-rose-700 text-xs font-bold flex items-center gap-1 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Hapus Staf
                            </button>
                        </div>
                        <input type="hidden" :name="'additional_aparatur[' + index + '][photo_old]'" x-model="member.photo">

                        <div class="flex items-center gap-3">
                            <img :src="member.photo_url || (member.photo && typeof member.photo === 'string' ? (member.photo.startsWith('http') ? member.photo : '/storage/' + member.photo) : ('https://ui-avatars.com/api/?name=' + encodeURIComponent(member.name || 'Staf Kelurahan') + '&background=64748b&color=fff&size=150'))" class="w-16 h-16 object-cover rounded-xl border border-slate-200 shrink-0">
                            <div class="w-full space-y-1.5">
                                <input type="file" :name="'additional_aparatur_photo_file_' + index" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-emerald-50 file:text-emerald-800">
                                <input type="url" :name="'additional_aparatur[' + index + '][photo_url]'" x-model="member.photo_url" class="w-full px-2.5 py-1 text-xs rounded-lg border border-slate-300 font-mono" placeholder="atau paste URL foto">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                            <input type="text" :name="'additional_aparatur[' + index + '][name]'" x-model="member.name" placeholder="Contoh: Rahmat Maulana, S.Kom" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Jabatan & Pangkat</label>
                                <input type="text" :name="'additional_aparatur[' + index + '][jabatan]'" x-model="member.jabatan" placeholder="Contoh: Pengelola IT" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-semibold">
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Atasan Langsung / Dibawah Siapa</label>
                                <input type="text" :name="'additional_aparatur[' + index + '][atasan]'" x-model="member.atasan" list="atasan_list" placeholder="Ketik atau pilih atasan..." class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-semibold bg-white text-slate-800">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">NIP / NIK (Opsional)</label>
                            <input type="text" :name="'additional_aparatur[' + index + '][nip]'" x-model="member.nip" placeholder="Contoh: 19950812 202001 1 001" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-mono">
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- SECTION 5: GAMBAR BAGAN STRUKTUR ORGANISASI UTUH (OPSIONAL) -->
        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200/90 space-y-4">
            <div class="flex items-center gap-2 border-b border-slate-200 pb-3">
                <span class="w-3 h-3 rounded-full bg-teal-600"></span>
                <h3 class="text-base font-extrabold text-slate-900 uppercase tracking-wide">5. Berkas Gambar Diagram Bagan Organisasi Utuh (Opsional)</h3>
            </div>

            <div class="space-y-4">
                @php
                    $baganVal = $settings['gambar_bagan_struktur'] ?? '';
                    $baganSrc = $baganVal ? (\Illuminate\Support\Str::startsWith($baganVal, ['http://', 'https://']) ? $baganVal : Storage::url($baganVal)) : '';
                @endphp
                @if($baganSrc)
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Bagan Saat Ini:</label>
                    <img id="previewBaganStruktur" src="{{ $baganSrc }}" class="max-h-64 rounded-xl border border-slate-300 shadow-sm mx-auto object-contain bg-white p-2">
                </div>
                @endif

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Unggah Gambar Diagram Bagan Organisasi Baru (PNG/JPG)</label>
                    <div class="flex items-center gap-3">
                        <input type="file" name="gambar_bagan_struktur" id="inputBaganStruktur" data-ratio="16:9" data-preview="#previewBaganStruktur" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-teal-50 file:text-teal-800">
                        <button type="button" onclick="if(document.getElementById('inputBaganStruktur').files.length){ window.CropHelper.open(document.getElementById('inputBaganStruktur')); } else { alert('Pilih berkas diagram bagan terlebih dahulu!'); }" class="px-3.5 py-2 bg-white hover:bg-teal-50 text-slate-700 hover:text-teal-800 rounded-xl border border-slate-300 text-xs font-bold transition shrink-0 shadow-2xs">
                            Potong (HD)
                        </button>
                        @if(!empty($settings['gambar_bagan_struktur']))
                        <button type="submit" form="delete-gambar-bagan" onclick="return confirm('Apakah Anda yakin ingin menghapus gambar Diagram Bagan Organisasi?')" class="px-3.5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 hover:text-rose-700 rounded-xl border border-rose-200 text-xs font-bold transition shrink-0 shadow-2xs flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Hapus Bagan
                        </button>
                        @endif
                    </div>
                    <input type="url" name="gambar_bagan_struktur_url" value="{{ \Illuminate\Support\Str::startsWith($baganVal, ['http://', 'https://']) ? $baganVal : '' }}" onchange="validateImageUrlInput(this)" onblur="validateImageUrlInput(this)" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 font-mono mt-2" placeholder="Atau paste URL Berkas Gambar Bagan">
                </div>
            </div>
        </div>

        <!-- SECTION 6: NARASI KETERANGAN STRUKTUR -->
        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200/90 space-y-4">
            <div class="flex items-center gap-2 border-b border-slate-200 pb-3">
                <span class="w-3 h-3 rounded-full bg-slate-600"></span>
                <h3 class="text-base font-extrabold text-slate-900 uppercase tracking-wide">6. Narasi & Keterangan Tambahan</h3>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Penjelasan Tugas Pokok & Keterangan Struktur</label>
                <textarea name="struktur_organisasi" id="struktur_organisasi" rows="10"
                          class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-sm leading-relaxed"
                          placeholder="Penjelasan rincian tugas Sekretaris Kelurahan, Kasi Pemerintahan, Kasi Trantib, Kasi Kesra, dsb...">{{ $settings['struktur_organisasi'] ?? '' }}</textarea>
            </div>
        </div>

        <div class="pt-4 flex items-center justify-between gap-4">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs uppercase tracking-wider py-3.5 px-8 rounded-xl shadow-md transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Simpan Seluruh Aparatur & Struktur
            </button>
        </div>
    </form>
</div>

<!-- Forms Hidden untuk Hapus Foto Setting Aparatur -->
@if(!empty($settings['foto_atasan']))
<form id="delete-foto-atasan" action="{{ route('dashboard.settings.destroy-key', 'foto_atasan') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endif

@if(!empty($settings['foto_lurah']) || !empty($settings['kadin_photo']))
<form id="delete-foto-lurah" action="{{ route('dashboard.settings.destroy-key', 'foto_lurah') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endif

@if(!empty($settings['foto_sekretaris']))
<form id="delete-foto-sekretaris" action="{{ route('dashboard.settings.destroy-key', 'foto_sekretaris') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endif

@if(!empty($settings['foto_kasi_pemerintahan']))
<form id="delete-foto-kasi-pem" action="{{ route('dashboard.settings.destroy-key', 'foto_kasi_pemerintahan') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endif

@if(!empty($settings['foto_kasi_trantib']))
<form id="delete-foto-kasi-trantib" action="{{ route('dashboard.settings.destroy-key', 'foto_kasi_trantib') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endif

@if(!empty($settings['foto_kasi_kesra']))
<form id="delete-foto-kasi-kesra" action="{{ route('dashboard.settings.destroy-key', 'foto_kasi_kesra') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endif

@if(!empty($settings['gambar_bagan_struktur']))
<form id="delete-gambar-bagan" action="{{ route('dashboard.settings.destroy-key', 'gambar_bagan_struktur') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endif

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="no-referrer"></script>
<script>
    window.validateImageUrlInput = function(input) {
        const val = input.value ? input.value.trim() : '';
        if (!val) return true;

        const isImageUrl = /^https?:\/\/.+/i.test(val) || /^data:image\/.+/i.test(val);
        if (!isImageUrl) {
            input.value = '';
            input.dispatchEvent(new Event('input'));
            alert('🚫 AKSES DITOLAK!\n\nTautan URL foto \'' + val + '\' tidak valid.\n\nHarap gunakan tautan URL gambar yang diawali dengan http:// atau https://');
            return false;
        }
        return true;
    };

    window.validateAparaturForm = function(form) {
        const fileInputs = form.querySelectorAll('input[type="file"][accept*="image"]');
        for (let input of fileInputs) {
            if (input.files && input.files.length > 0) {
                if (!validateImageUpload(input)) {
                    return false;
                }
            }
        }

        const urlInputs = [
            'foto_atasan_url',
            'foto_lurah_url',
            'foto_sekretaris_url',
            'foto_kasi_pemerintahan_url',
            'foto_kasi_trantib_url',
            'foto_kasi_kesra_url',
            'gambar_bagan_struktur_url'
        ];

        for (let name of urlInputs) {
            const input = form.querySelector(`input[name="${name}"]`);
            if (input && input.value.trim() !== '') {
                if (!validateImageUrlInput(input)) {
                    return false;
                }
            }
        }

        return true;
    };

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: '#struktur_organisasi',
                height: 450,
                menubar: true,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor removeformat | link image media table | preview fullscreen code',
                content_style: 'body { font-family: Inter, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.6; color: #334155; } ol { list-style-type: decimal; padding-left: 1.5rem; } ul { list-style-type: disc; padding-left: 1.5rem; } li { margin-bottom: 0.375rem; }',
                branding: false,
                promotion: false,
                setup: function (editor) {
                    editor.on('change keyup blur', function () {
                        editor.save();
                    });
                }
            });
        }
    });
</script>
@endpush
