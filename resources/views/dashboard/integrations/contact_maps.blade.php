@extends('layouts.admin')

@section('title', 'Kelola Informasi Kontak & Google Maps')

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

<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Kelola Informasi Kontak & Google Maps</h2>
        <p class="text-slate-500 text-sm">Kelola informasi alamat fisik kantor kelurahan, telepon resmi, email, serta sematan peta navigasi lokasi Google Maps.</p>
    </div>
    <div>
        <a href="{{ route('contact') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs rounded-xl shadow-sm transition">
            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            Lihat Halaman Kontak Publik
        </a>
    </div>
</div>

@if(session('success'))
<div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-xl mb-6 shadow-sm flex items-center justify-between" role="alert">
    <div class="flex items-center gap-3">
        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="font-medium text-sm">{{ session('success') }}</span>
    </div>
    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold">&times;</button>
</div>
@endif

<form action="{{ route('dashboard.settings.update') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateContactMapsForm(this)" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left Column: Form Input Kontak -->
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base">Informasi Kontak & Jam Operasional</h3>
                            <p class="text-slate-500 text-xs">Telepon kantor, WhatsApp hotline, email resmi, alamat, dan jam pelayanan publik.</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 md:p-8 space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Telepon Kantor Resmi</label>
                            <input type="text" name="telepon" value="{{ $settings['telepon'] ?? '(0335) 123456' }}" required class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 transition font-medium text-slate-800" placeholder="Contoh: (0335) 123456">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nomor WhatsApp Hotline</label>
                            <input type="text" name="whatsapp" value="{{ $settings['whatsapp'] ?? '0812 3456 7890' }}" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 transition font-medium text-slate-800" placeholder="Contoh: 0812 3456 7890">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Email Resmi Kelurahan</label>
                            <input type="email" name="email" value="{{ $settings['email'] ?? 'info@Kandang Jati Kulon.desa.id' }}" required class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 transition font-medium text-slate-800" placeholder="Contoh: info@Kandang Jati Kulon.desa.id">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Alamat Lengkap Fisik Kantor</label>
                        <textarea name="alamat" rows="2" required class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 transition font-medium text-slate-800">{{ $settings['alamat'] ?? 'Jl. Raya Kandang Jati Kulon No. 10, Kelurahan Kandang Jati Kulon, Kecamatan Kraksaan, Kabupaten Probolinggo, Jawa Timur 67282' }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5" x-data="{ 
                        jamSeninKamisMode: '{{ in_array($settings['jam_layanan_senin_kamis'] ?? '07.30 - 15.00 WIB', ['07.30 - 15.00 WIB', '07.30 - 15.30 WIB', '08.00 - 14.00 WIB', '08.00 - 15.00 WIB', '08.00 - 16.00 WIB', '24 Jam (Layanan Online Mandiri)']) ? ($settings['jam_layanan_senin_kamis'] ?? '07.30 - 15.00 WIB') : 'custom' }}',
                        valSeninKamis: '{{ addslashes($settings['jam_layanan_senin_kamis'] ?? '07.30 - 15.00 WIB') }}',
                        jamJumatMode: '{{ in_array($settings['jam_layanan_jumat'] ?? '07.30 - 11.30 WIB', ['07.30 - 11.30 WIB', '07.30 - 11.00 WIB', '08.00 - 11.30 WIB', '07.30 - 14.30 WIB', '08.00 - 15.00 WIB', '24 Jam (Layanan Online Mandiri)']) ? ($settings['jam_layanan_jumat'] ?? '07.30 - 11.30 WIB') : 'custom' }}',
                        valJumat: '{{ addslashes($settings['jam_layanan_jumat'] ?? '07.30 - 11.30 WIB') }}'
                    }">
                        <!-- Jam Kerja Senin - Kamis -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Jam Kerja Pelayanan (Senin - Kamis)</label>
                            <select x-model="jamSeninKamisMode" @change="if(jamSeninKamisMode !== 'custom') valSeninKamis = jamSeninKamisMode" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 transition font-medium text-slate-800 bg-white shadow-xs">
                                <option value="07.30 - 15.00 WIB">07.30 - 15.00 WIB (Standar Pemkab)</option>
                                <option value="07.30 - 15.30 WIB">07.30 - 15.30 WIB</option>
                                <option value="08.00 - 14.00 WIB">08.00 - 14.00 WIB</option>
                                <option value="08.00 - 15.00 WIB">08.00 - 15.00 WIB</option>
                                <option value="08.00 - 16.00 WIB">08.00 - 16.00 WIB</option>
                                <option value="24 Jam (Layanan Online Mandiri)">24 Jam (Layanan Online Mandiri)</option>
                                <option value="custom">-- Ketik Jam Kustom --</option>
                            </select>
                            <input type="hidden" name="jam_layanan_senin_kamis" :value="jamSeninKamisMode === 'custom' ? valSeninKamis : jamSeninKamisMode">
                            <div x-show="jamSeninKamisMode === 'custom'" x-collapse class="mt-2">
                                <input type="text" x-model="valSeninKamis" class="w-full px-4 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-medium text-slate-800" placeholder="Ketik format jam khusus...">
                            </div>
                        </div>

                        <!-- Jam Kerja Jumat -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Jam Kerja Pelayanan (Jumat)</label>
                            <select x-model="jamJumatMode" @change="if(jamJumatMode !== 'custom') valJumat = jamJumatMode" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 transition font-medium text-slate-800 bg-white shadow-xs">
                                <option value="07.30 - 11.30 WIB">07.30 - 11.30 WIB (Standar Pemkab)</option>
                                <option value="07.30 - 11.00 WIB">07.30 - 11.00 WIB</option>
                                <option value="08.00 - 11.30 WIB">08.00 - 11.30 WIB</option>
                                <option value="07.30 - 14.30 WIB">07.30 - 14.30 WIB</option>
                                <option value="08.00 - 15.00 WIB">08.00 - 15.00 WIB</option>
                                <option value="24 Jam (Layanan Online Mandiri)">24 Jam (Layanan Online Mandiri)</option>
                                <option value="custom">-- Ketik Jam Kustom --</option>
                            </select>
                            <input type="hidden" name="jam_layanan_jumat" :value="jamJumatMode === 'custom' ? valJumat : jamJumatMode">
                            <div x-show="jamJumatMode === 'custom'" x-collapse class="mt-2">
                                <input type="text" x-model="valJumat" class="w-full px-4 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-medium text-slate-800" placeholder="Ketik format jam khusus...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- QR Code Settings Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base">Pengaturan Kode QR Dinamis Footer</h3>
                            <p class="text-slate-500 text-xs">Kelola gambar Kode QR custom, URL tujuan scan, serta teks label keterangan di footer website.</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 md:p-8 space-y-5">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Unggah File Gambar Kode QR Custom (Opsional)</label>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 bg-slate-50 rounded-xl border border-slate-200">
                            @if(!empty($settings['qr_code_image']))
                                <div class="relative group shrink-0">
                                    <img src="{{ \Illuminate\Support\Str::startsWith($settings['qr_code_image'], 'http') ? $settings['qr_code_image'] : asset('storage/' . $settings['qr_code_image']) }}" alt="QR Code Custom" class="w-20 h-20 object-contain p-1 border border-slate-300 rounded-xl bg-white shadow-xs">
                                </div>
                            @endif
                            <div class="flex-grow w-full">
                                <input type="file" name="qr_code_image" accept="image/*" onchange="validateImageUpload(this)" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-purple-100 file:text-purple-700 hover:file:bg-purple-200 transition cursor-pointer">
                                <p class="text-[11px] text-slate-400 mt-1">Unggah file PNG/JPG/WEBP Kode QR khusus. Jika tidak diunggah, sistem otomatis me-render Kode QR generator dari URL tujuan di bawah.</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">URL Tujuan Scan Kode QR</label>
                        <input type="url" name="qr_code_destination_url" value="{{ $settings['qr_code_destination_url'] ?? url('/') }}" required class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-purple-500 transition font-mono text-slate-800" placeholder="{{ url('/') }}">
                        <p class="text-[11px] text-slate-400 mt-1">Warga yang melakukan scan akan diarahkan ke URL ini (misal: Halaman Beranda, WhatsApp Hotline, atau Form Pengaduan).</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Judul Label QR Code</label>
                            <input type="text" name="qr_code_title" value="{{ $settings['qr_code_title'] ?? 'Scan QR Portal Pelayanan' }}" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-purple-500 transition font-medium text-slate-800" placeholder="Scan QR Portal Pelayanan">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Subjudul / Keterangan QR</label>
                            <input type="text" name="qr_code_subtitle" value="{{ $settings['qr_code_subtitle'] ?? 'Kelurahan Kandang Jati Kulon' }}" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-purple-500 transition font-medium text-slate-800" placeholder="Kelurahan Kandang Jati Kulon">
                        </div>
                    </div>
                </div>
            </div>

            @php
                $existingSocial = [];
                if (!empty($settings['social_media'])) {
                    $decoded = is_string($settings['social_media']) ? json_decode($settings['social_media'], true) : $settings['social_media'];
                    if (is_array($decoded) && count($decoded) > 0) {
                        $existingSocial = $decoded;
                    }
                }

                if (empty($existingSocial)) {
                    if (!empty($settings['instagram'])) {
                        $existingSocial[] = ['platform' => 'instagram', 'name' => 'Instagram', 'url' => $settings['instagram']];
                    }
                    if (!empty($settings['youtube'])) {
                        $existingSocial[] = ['platform' => 'youtube', 'name' => 'YouTube', 'url' => $settings['youtube']];
                    }
                    if (!empty($settings['tiktok'])) {
                        $existingSocial[] = ['platform' => 'tiktok', 'name' => 'TikTok', 'url' => $settings['tiktok']];
                    }
                    if (!empty($settings['whatsapp'])) {
                        $existingSocial[] = ['platform' => 'whatsapp', 'name' => 'WhatsApp', 'url' => 'https://wa.me/' . preg_replace('/[^0-9]/', '', $settings['whatsapp'])];
                    }
                }

                if (empty($existingSocial)) {
                    $existingSocial = [
                        ['platform' => 'instagram', 'name' => 'Instagram', 'url' => 'https://www.instagram.com/'],
                        ['platform' => 'youtube', 'name' => 'YouTube', 'url' => 'https://www.youtube.com/'],
                        ['platform' => 'tiktok', 'name' => 'TikTok', 'url' => 'https://www.tiktok.com/'],
                    ];
                }
            @endphp

            <!-- Media Sosial Footer Section (Dinamis: Tambah & Hapus) -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden" 
                 x-data="{
                     socials: {{ json_encode($existingSocial) }},
                     addSocial() {
                         this.socials.push({
                             platform: 'instagram',
                             name: 'Instagram',
                             url: 'https://'
                         });
                     },
                     removeSocial(index) {
                         this.socials.splice(index, 1);
                     },
                     updateName(index) {
                         const p = this.socials[index].platform;
                         const names = {
                             'instagram': 'Instagram',
                             'youtube': 'YouTube',
                             'tiktok': 'TikTok',
                             'facebook': 'Facebook',
                             'twitter': 'Twitter / X',
                             'whatsapp': 'WhatsApp Hotline',
                             'telegram': 'Telegram',
                             'linkedin': 'LinkedIn',
                             'website': 'Website Resmi',
                             'custom': 'Media Sosial'
                         };
                         if (names[p]) {
                             this.socials[index].name = names[p];
                         }
                     }
                 }">
                <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-200 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base">Kelola Tautan Media Sosial Footer</h3>
                            <p class="text-slate-500 text-xs">Tambah atau hapus link akun media sosial resmi kelurahan yang muncul pada footer website.</p>
                        </div>
                    </div>

                    <button type="button" @click="addSocial()" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-2xs transition cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <span>+ Tambah Media Sosial</span>
                    </button>
                </div>

                <div class="p-6 md:p-8 space-y-4">
                    <input type="hidden" name="social_media" :value="JSON.stringify(socials)">

                    <template x-if="socials.length === 0">
                        <div class="text-center py-6 bg-slate-50 rounded-xl border border-dashed border-slate-200 text-slate-400 text-xs">
                            Belum ada media sosial yang ditambahkan. Klik tombol <strong>+ Tambah Media Sosial</strong> di atas untuk menambahkan link akun.
                        </div>
                    </template>

                    <template x-for="(item, index) in socials" :key="index">
                        <div class="flex flex-col md:flex-row items-stretch md:items-center gap-3 p-4 bg-slate-50/80 rounded-xl border border-slate-200/90 hover:border-indigo-200 transition">
                            
                            <!-- Platform Dropdown -->
                            <div class="w-full md:w-1/4">
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Platform / Medsos</label>
                                <select x-model="item.platform" @change="updateName(index)" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 font-medium text-slate-800 bg-white">
                                    <option value="instagram">Instagram</option>
                                    <option value="youtube">YouTube</option>
                                    <option value="tiktok">TikTok</option>
                                    <option value="facebook">Facebook</option>
                                    <option value="twitter">Twitter / X</option>
                                    <option value="whatsapp">WhatsApp</option>
                                    <option value="telegram">Telegram</option>
                                    <option value="linkedin">LinkedIn</option>
                                    <option value="website">Website Lain</option>
                                    <option value="custom">Kustom / Lainnya</option>
                                </select>
                            </div>

                            <!-- Label / Nama Account -->
                            <div class="w-full md:w-1/4">
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Label / Nama Akun</label>
                                <input type="text" x-model="item.name" placeholder="Misal: Instagram" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 font-medium text-slate-800 bg-white">
                            </div>

                            <!-- URL Link Input -->
                            <div class="w-full md:flex-1">
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">URL / Link Tautan</label>
                                <input type="url" x-model="item.url" placeholder="https://..." class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 font-medium text-slate-800 bg-white">
                            </div>

                            <!-- Delete Button -->
                            <div class="flex items-end shrink-0 pt-2 md:pt-4">
                                <button type="button" @click="removeSocial(index)" title="Hapus Media Sosial Ini" class="w-9 h-9 rounded-xl bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200 hover:border-rose-600 flex items-center justify-center transition cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>

                        </div>
                    </template>
                </div>
            </div>

            <!-- Google Maps Embed Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base">Pengaturan Sematan Peta Google Maps</h3>
                            <p class="text-slate-500 text-xs">Kode sematan iFrame atau link tautan Peta Google Maps Kantor Kelurahan.</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 md:p-8 space-y-5">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Tautan Navigasi Langsung Google Maps</label>
                        <input type="url" name="gmaps_link" value="{{ $settings['gmaps_link'] ?? 'https://maps.google.com/?q=Kelurahan+Kandang Jati Kulon+Kraksaan' }}" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 transition font-mono" placeholder="https://maps.google.com/?q=...">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Kode Sematan iFrame Google Maps (SRC Embed URL)</label>
                        <textarea name="gmaps_iframe" rows="3" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 transition font-mono">{{ $settings['gmaps_iframe'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15814.159392817812!2d113.407!3d-7.755!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd701a5d24d2ab7%3A0x7d0186c478a87ab5!2sKandang Jati Kulon%2C%20Kraksaan%2C%20Probolinggo%20Regency%2C%20East%20Java!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid' }}</textarea>
                        <p class="text-[11px] text-slate-400 mt-1">Tempelkan URL dari atribut `src="..."` kode embed Google Maps.</p>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow transition">Simpan Informasi Kontak & Maps</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Interactive Map & Contact Card Preview -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 space-y-4">
                <h4 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                    Pratinjau Peta Google Maps Kantor
                </h4>

                <div class="w-full h-64 rounded-xl overflow-hidden border border-slate-200 shadow-xs bg-slate-100">
                    <iframe src="{{ $settings['gmaps_iframe'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15814.159392817812!2d113.407!3d-7.755!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd701a5d24d2ab7%3A0x7d0186c478a87ab5!2sKandang Jati Kulon%2C%20Kraksaan%2C%20Probolinggo%20Regency%2C%20East%20Java!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid' }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>

                <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 text-xs space-y-2 text-slate-700">
                    <div class="font-bold text-slate-900 border-b border-slate-200 pb-2">Informasi Publik Halaman Kontak</div>
                    <div><strong class="text-slate-900">Alamat:</strong> {{ $settings['alamat'] ?? 'Jl. Raya Kandang Jati Kulon No. 10' }}</div>
                    <div><strong class="text-slate-900">Telepon:</strong> {{ $settings['telepon'] ?? '(0335) 123456' }}</div>
                    <div><strong class="text-slate-900">Email:</strong> {{ $settings['email'] ?? 'info@Kandang Jati Kulon.desa.id' }}</div>
                </div>
            </div>
        </div>

    </div>
</form>
@endsection

@push('scripts')
<script>
    window.validateContactMapsForm = function(form) {
        const fileInput = form.querySelector('input[name="qr_code_image"]');
        if (fileInput && fileInput.files && fileInput.files.length > 0) {
            if (!validateImageUpload(fileInput)) {
                return false;
            }
        }
        return true;
    };
</script>
@endpush
