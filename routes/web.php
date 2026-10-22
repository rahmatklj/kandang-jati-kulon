<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\PublicServiceController;
use App\Http\Controllers\Dashboard\DemographicController;
use App\Http\Controllers\Dashboard\RtRwController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\AgendaController as DashboardAgendaController;
use App\Http\Controllers\Dashboard\DocumentController as DashboardDocumentController;
use App\Http\Controllers\Dashboard\LembagaController as DashboardLembagaController;
use App\Http\Controllers\Dashboard\MaklumatController as DashboardMaklumatController;
use App\Http\Controllers\Dashboard\PartnershipController as DashboardPartnershipController;
use App\Http\Controllers\Dashboard\ActivityLogController;
use App\Http\Controllers\KategoriLayananController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil/visi-misi', [ProfileController::class, 'visiMisi'])->name('profil.visi-misi');
Route::get('/profil/struktur-organisasi', [ProfileController::class, 'struktur'])->name('profil.struktur');
Route::get('/profil/sejarah', [ProfileController::class, 'sejarah'])->name('profil.sejarah');
Route::get('/profil/demografi', [ProfileController::class, 'demografi'])->name('profil.demografi');
Route::get('/profil/{slug}', [ProfileController::class, 'showDynamicPage'])->name('profil.dynamic');
Route::get('/halaman/{slug}', [ProfileController::class, 'showDynamicPage'])->name('halaman.dynamic');
Route::get('/statistik-penduduk', [ProfileController::class, 'demografi'])->name('statistik.index');
Route::get('/hubungi', function () {
    $settingsRaw = \App\Models\Setting::all();
    $settings = $settingsRaw->pluck('value', 'key')->toArray();
    return view('contact', compact('settings'));
})->name('contact');

Route::get('/kontak', fn() => redirect()->route('contact'));
Route::get('/kontak-kelurahan', fn() => redirect()->route('contact'));
Route::get('/informasi/kontak', fn() => redirect()->route('contact'));

Route::get('/berita', [App\Http\Controllers\PublicPostController::class, 'index'])->name('posts.index');
Route::get('/berita/{slug}', [App\Http\Controllers\PublicPostController::class, 'show'])->name('posts.show');

Route::get('/galeri', [App\Http\Controllers\PublicGalleryController::class, 'index'])->name('galleries.index');
Route::get('/galeri/{slug}', [App\Http\Controllers\PublicGalleryController::class, 'show'])->name('galleries.show');
Route::get('/video', [App\Http\Controllers\PublicVideoController::class, 'index'])->name('videos.index');
Route::get('/agenda', [App\Http\Controllers\AgendaController::class, 'index'])->name('agendas.index');
Route::get('/lembaga', [App\Http\Controllers\LembagaController::class, 'index'])->name('lembaga.index');
Route::get('/lembaga-kemasyarakatan', [App\Http\Controllers\LembagaController::class, 'index']);

// Transparansi Anggaran (APBD Kelurahan) Routes (Public)
Route::get('/informasi/apbd', [App\Http\Controllers\ApbdPublicController::class, 'index'])->name('apbd.index');
Route::get('/transparansi-anggaran', [App\Http\Controllers\ApbdPublicController::class, 'index']);
Route::get('/informasi/apbd/download/{id}', [App\Http\Controllers\ApbdPublicController::class, 'downloadPdf'])->name('apbd.download');

// Survei Kepuasan Masyarakat (SKM / IKM) Routes (Public)
Route::get('/informasi/survei-kepuasan', [App\Http\Controllers\SurveiPublicController::class, 'index'])->name('survei.index');
Route::get('/survei-kepuasan', [App\Http\Controllers\SurveiPublicController::class, 'index']);
Route::get('/informasi/survei-kepuasan/download/{id}', [App\Http\Controllers\SurveiPublicController::class, 'downloadPdf'])->name('survei.download');

Route::get('/dokumen/musrenbang/{tahun?}', [App\Http\Controllers\DocumentController::class, 'musrenbang'])->name('documents.musrenbang');
Route::get('/dokumen/renstra-renja/{tahun?}', [App\Http\Controllers\DocumentController::class, 'renstraRenja'])->name('documents.renstra_renja');
Route::get('/dokumen/sk-kelembagaan/{tahun?}', [App\Http\Controllers\DocumentController::class, 'skKelembagaan'])->name('documents.sk_kelembagaan');
Route::get('/dokumen/download/{document}', [App\Http\Controllers\DocumentController::class, 'download'])->name('documents.download');
Route::get('/dokumen/view/{document}', [App\Http\Controllers\DocumentController::class, 'view'])->name('documents.view');
Route::get('/dokumen/{tahun?}', [App\Http\Controllers\DocumentController::class, 'index'])->name('documents.index');

// ----------------------------------------------------------------
// LAYANAN & SOP ROUTES (PUBLIC)
// ----------------------------------------------------------------
Route::get('/layanan', [PublicServiceController::class, 'index'])->name('services.index');
Route::get('/layanan/{slug}', [PublicServiceController::class, 'show'])->name('services.show');
Route::get('/layanan/{slug}/download', [PublicServiceController::class, 'download'])->name('services.download');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forceLogin'])->name('password.force');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard Overview Route (All Auth Users)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Profile Management (All Auth Users)
    Route::get('/dashboard/settings/profile', [SettingController::class, 'profile'])->name('dashboard.settings.profile');
    Route::put('/dashboard/settings/profile', [SettingController::class, 'updateProfile'])->name('dashboard.settings.profile.update');

    // ----------------------------------------------------------------
    // PROFIL KELURAHAN ROUTES (Staff & Admin)
    // ----------------------------------------------------------------
    Route::get('/dashboard/settings/visi-misi', [SettingController::class, 'visiMisi'])->name('dashboard.settings.visi-misi');
    Route::get('/dashboard/settings/sejarah', [SettingController::class, 'sejarah'])->name('dashboard.settings.sejarah');
    Route::get('/dashboard/settings/aparatur', [SettingController::class, 'aparatur'])->name('dashboard.settings.aparatur');
    Route::get('/dashboard/demographics', [DemographicController::class, 'index'])->name('dashboard.demographics.index');
    Route::put('/dashboard/settings', [SettingController::class, 'update'])->name('dashboard.settings.update');

    // ----------------------------------------------------------------
    // INFORMASI KELURAHAN ROUTES (Staff & Admin)
    // ----------------------------------------------------------------
    // Warta & Berita
    Route::patch('/dashboard/posts/{post}/date', [PostController::class, 'updateDate'])->name('dashboard.posts.update-date');
    Route::resource('/dashboard/posts', PostController::class, ['as' => 'dashboard'])->except(['show']);

    // Galeri Foto & Dokumentasi Video
    Route::resource('/dashboard/galleries', GalleryController::class, ['as' => 'dashboard'])->except(['show']);
    Route::delete('/dashboard/galleries/photos/{photo}', [GalleryController::class, 'destroyPhoto'])->name('dashboard.galleries.photos.destroy');
    Route::resource('/dashboard/videos', App\Http\Controllers\Dashboard\VideoController::class, ['as' => 'dashboard'])->except(['show']);

    // Pengumuman Running Text
    Route::resource('/dashboard/announcements', AnnouncementController::class, ['as' => 'dashboard'])->except(['show']);

    // Agenda Kegiatan
    Route::get('/dashboard/agendas', [DashboardAgendaController::class, 'index'])->name('dashboard.agendas.index');
    Route::post('/dashboard/agendas', [DashboardAgendaController::class, 'store'])->name('dashboard.agendas.store');
    Route::put('/dashboard/agendas/{id}', [DashboardAgendaController::class, 'update'])->name('dashboard.agendas.update');
    Route::delete('/dashboard/agendas/{id}', [DashboardAgendaController::class, 'destroy'])->name('dashboard.agendas.destroy');

    // Lembaga Kemasyarakatan
    Route::get('/dashboard/lembagas', [DashboardLembagaController::class, 'index'])->name('dashboard.lembagas.index');
    Route::post('/dashboard/lembagas', [DashboardLembagaController::class, 'store'])->name('dashboard.lembagas.store');
    Route::put('/dashboard/lembagas/{id}', [DashboardLembagaController::class, 'update'])->name('dashboard.lembagas.update');
    Route::delete('/dashboard/lembagas/{id}', [DashboardLembagaController::class, 'destroy'])->name('dashboard.lembagas.destroy');

    // Data RT & RW
    Route::get('/dashboard/rt-rw', function() {
        return redirect()->route('dashboard.demographics.index');
    })->name('dashboard.rt-rw.index');
    Route::post('/dashboard/rt-rw', [RtRwController::class, 'store'])->name('dashboard.rt-rw.store');
    Route::put('/dashboard/rt-rw/{id}', [RtRwController::class, 'update'])->name('dashboard.rt-rw.update');
    Route::delete('/dashboard/rt-rw/{id}', [RtRwController::class, 'destroy'])->name('dashboard.rt-rw.destroy');

    // Informasi Kontak & Maps
    Route::get('/dashboard/integrations/contact-maps', [SettingController::class, 'contactMaps'])->name('dashboard.integrations.contact-maps');


    // ----------------------------------------------------------------
    // SUPER ADMIN ONLY ROUTES (Restricted for Staff)
    // ----------------------------------------------------------------
    Route::middleware('role:admin')->group(function () {
        // Pelayanan Publik (Standar Pelayanan, SOP, Maklumat, LAPOR, Hallo SAE)
        Route::resource('/dashboard/services', ServiceController::class, ['as' => 'dashboard'])->except(['show']);
        Route::post('/admin/master-kategori/quick-store', [KategoriLayananController::class, 'quickStore'])->name('admin.master-kategori.quick-store');
        Route::post('/dashboard/master-kategori/quick-store', [KategoriLayananController::class, 'quickStore'])->name('dashboard.master-kategori.quick-store');
        Route::delete('/admin/master-kategori/{id}', [KategoriLayananController::class, 'destroy'])->name('admin.master-kategori.destroy');
        Route::delete('/dashboard/master-kategori/{id}', [KategoriLayananController::class, 'destroy'])->name('dashboard.master-kategori.destroy');

        Route::get('/dashboard/maklumats', [DashboardMaklumatController::class, 'index'])->name('dashboard.maklumats.index');
        Route::post('/dashboard/maklumats', [DashboardMaklumatController::class, 'store'])->name('dashboard.maklumats.store');
        Route::put('/dashboard/maklumats/{id}', [DashboardMaklumatController::class, 'update'])->name('dashboard.maklumats.update');
        Route::patch('/dashboard/maklumats/{id}/toggle', [DashboardMaklumatController::class, 'toggleActive'])->name('dashboard.maklumats.toggle');
        Route::delete('/dashboard/maklumats/{id}', [DashboardMaklumatController::class, 'destroy'])->name('dashboard.maklumats.destroy');

        Route::get('/dashboard/integrations/lapor', [SettingController::class, 'lapor'])->name('dashboard.integrations.lapor');
        Route::get('/dashboard/integrations/hallo-sae', [SettingController::class, 'halloSae'])->name('dashboard.integrations.hallo-sae');
        Route::put('/dashboard/complaints/{id}/status', [SettingController::class, 'updateComplaintStatus'])->name('dashboard.complaints.update-status');
        Route::delete('/dashboard/complaints/{id}', [SettingController::class, 'destroyComplaint'])->name('dashboard.complaints.destroy');

        Route::get('/dashboard/survei', [App\Http\Controllers\Dashboard\SurveiAdminController::class, 'index'])->name('dashboard.survei.index');
        Route::post('/dashboard/survei', [App\Http\Controllers\Dashboard\SurveiAdminController::class, 'store'])->name('dashboard.survei.store');
        Route::put('/dashboard/survei/{id}', [App\Http\Controllers\Dashboard\SurveiAdminController::class, 'update'])->name('dashboard.survei.update');
        Route::patch('/dashboard/survei/{id}/toggle', [App\Http\Controllers\Dashboard\SurveiAdminController::class, 'toggleActive'])->name('dashboard.survei.toggle');
        Route::delete('/dashboard/survei/{id}', [App\Http\Controllers\Dashboard\SurveiAdminController::class, 'destroy'])->name('dashboard.survei.destroy');

        // Dokumen Publik (PDF & Transparansi APBD)
        Route::get('/dashboard/documents', [DashboardDocumentController::class, 'index'])->name('dashboard.documents.index');
        Route::post('/dashboard/documents', [DashboardDocumentController::class, 'store'])->name('dashboard.documents.store');
        Route::put('/dashboard/documents/{document}', [DashboardDocumentController::class, 'update'])->name('dashboard.documents.update');
        Route::delete('/dashboard/documents/{document}', [DashboardDocumentController::class, 'destroy'])->name('dashboard.documents.destroy');
        Route::get('/dashboard/documents/{document}/download', [DashboardDocumentController::class, 'download'])->name('dashboard.documents.download');

        Route::get('/dashboard/apbd', [App\Http\Controllers\Dashboard\ApbdAdminController::class, 'index'])->name('dashboard.apbd.index');
        Route::post('/dashboard/apbd', [App\Http\Controllers\Dashboard\ApbdAdminController::class, 'store'])->name('dashboard.apbd.store');
        Route::put('/dashboard/apbd/{id}', [App\Http\Controllers\Dashboard\ApbdAdminController::class, 'update'])->name('dashboard.apbd.update');
        Route::patch('/dashboard/apbd/{id}/toggle', [App\Http\Controllers\Dashboard\ApbdAdminController::class, 'toggleActive'])->name('dashboard.apbd.toggle');
        Route::delete('/dashboard/apbd/{id}', [App\Http\Controllers\Dashboard\ApbdAdminController::class, 'destroy'])->name('dashboard.apbd.destroy');
        Route::post('/dashboard/apbd/jenis-pos', [App\Http\Controllers\Dashboard\ApbdAdminController::class, 'storeJenisPos'])->name('dashboard.apbd.jenis-pos.store');
        Route::delete('/dashboard/apbd/jenis-pos/{id}', [App\Http\Controllers\Dashboard\ApbdAdminController::class, 'destroyJenisPos'])->name('dashboard.apbd.jenis-pos.destroy');
        Route::post('/dashboard/apbd/categories/quick', [App\Http\Controllers\Dashboard\ApbdAdminController::class, 'storeCategoryQuick'])->name('dashboard.apbd.categories.store');
        Route::delete('/dashboard/apbd/categories/quick/{id}', [App\Http\Controllers\Dashboard\ApbdAdminController::class, 'destroyCategoryQuick'])->name('dashboard.apbd.categories.destroy');

        // Link Terkait & Kerjasama (Partnerships)
        Route::get('/dashboard/partnerships', [DashboardPartnershipController::class, 'index'])->name('dashboard.partnerships.index');
        Route::post('/dashboard/partnerships', [DashboardPartnershipController::class, 'store'])->name('dashboard.partnerships.store');
        Route::post('/dashboard/partnerships/categories', [DashboardPartnershipController::class, 'storeCategory'])->name('dashboard.partnerships.categories.store');
        Route::delete('/dashboard/partnerships/categories/{id}', [DashboardPartnershipController::class, 'destroyCategory'])->name('dashboard.partnerships.categories.destroy');
        Route::put('/dashboard/partnerships/{id}', [DashboardPartnershipController::class, 'update'])->name('dashboard.partnerships.update');
        Route::delete('/dashboard/partnerships/{id}', [DashboardPartnershipController::class, 'destroy'])->name('dashboard.partnerships.destroy');

        // Navigation Menu Management
        Route::get('/dashboard/navigation', [App\Http\Controllers\Dashboard\NavigationMenuController::class, 'index'])->name('dashboard.navigation.index');
        Route::post('/dashboard/navigation', [App\Http\Controllers\Dashboard\NavigationMenuController::class, 'store'])->name('dashboard.navigation.store');
        Route::put('/dashboard/navigation/{id}', [App\Http\Controllers\Dashboard\NavigationMenuController::class, 'update'])->name('dashboard.navigation.update');
        Route::patch('/dashboard/navigation/{id}/toggle', [App\Http\Controllers\Dashboard\NavigationMenuController::class, 'toggleActive'])->name('dashboard.navigation.toggle');
        Route::delete('/dashboard/navigation/{id}', [App\Http\Controllers\Dashboard\NavigationMenuController::class, 'destroy'])->name('dashboard.navigation.destroy');

        // Master Categories
        Route::resource('/dashboard/categories', CategoryController::class, ['as' => 'dashboard'])->except(['show', 'create', 'edit']);
        Route::post('/dashboard/categories/quick-destroy', [CategoryController::class, 'destroyQuick'])->name('dashboard.categories.quick-destroy');

        // Hero Banner Settings
        Route::get('/dashboard/settings', [SettingController::class, 'index'])->name('dashboard.settings.index');
        Route::delete('/dashboard/settings/key/{key}', [SettingController::class, 'destroyKey'])->name('dashboard.settings.destroy-key');
        Route::delete('/dashboard/settings/{key}', [SettingController::class, 'destroyKey'])->name('dashboard.settings.destroy');

        // User Management (CRUD Pengguna & Hak Akses)
        Route::resource('/dashboard/users', UserController::class, ['as' => 'dashboard'])->except(['show']);

        // Log Aktivitas Sistem
        Route::get('/dashboard/activity-logs', [ActivityLogController::class, 'index'])->name('dashboard.activity-logs.index');
        Route::post('/dashboard/activity-logs/clear', [ActivityLogController::class, 'clear'])->name('dashboard.activity-logs.clear');
    });
});
