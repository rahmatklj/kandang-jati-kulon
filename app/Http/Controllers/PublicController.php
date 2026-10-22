<?php

namespace App\Http\Controllers;

use App\Models\Setting;      // ← PERBAIKAN: dulunya SiteSetting (tabel site_settings yang tidak ada)
use App\Models\Post;
use App\Models\Service;
use App\Models\Announcement;
use App\Models\Album;
use App\Models\Video;
use App\Models\Maklumat;
use App\Models\Partnership;
use App\Models\SurveiKepuasan;
use App\Models\NavigationMenu;
use Illuminate\Http\Request;

/**
 * PublicController
 *
 * Controller ini menggantikan versi lama yang menggunakan model SiteSetting
 * (tabel site_settings). Versi baru menggunakan model Setting (tabel settings)
 * yang sudah ada di database.
 *
 * PERUBAHAN UTAMA:
 *   - SiteSetting::pluck(...) → Setting::pluck(...)
 *   - Model-model yang tidak ada (NewsItem, SidebarWidget, dll) dihapus
 */
class PublicController extends Controller
{
    /**
     * Ambil data umum (settings) yang digunakan di semua method.
     * PERBAIKAN: Menggunakan model Setting (tabel: settings)
     *            bukan SiteSetting (tabel: site_settings yang tidak ada).
     */
    private function getCommonData(): array
    {
        // SEBELUMNYA (SALAH):
        // $settingsRaw = SiteSetting::pluck('value', 'key')->toArray();
        //
        // SESUDAH (BENAR):
        $settingsRaw = Setting::pluck('value', 'key')->toArray();

        $defaults = [
            'site_title'     => 'Website Resmi Kelurahan Kandang Jati Kulon | Kecamatan Kraksaan, Kabupaten Probolinggo',
            'agency_name'    => 'Kelurahan Kandang Jati Kulon',
            'regency_name'   => 'Kecamatan Kraksaan, Kabupaten Probolinggo',
            'instagram_url'  => 'https://www.instagram.com/',
            'facebook_url'   => 'https://www.facebook.com/',
            'tiktok_url'     => 'https://www.tiktok.com/',
            'whatsapp_url'   => 'https://wa.me/6281234567890',
            'youtube_url'    => 'https://www.youtube.com/',
            'phone'          => '(0335) 841234',
            'email'          => 'kelurahan@probolinggokab.go.id',
            'address'        => 'Kelurahan Kandang Jati Kulon, Kecamatan Kraksaan, Kabupaten Probolinggo',
        ];

        return array_merge($defaults, $settingsRaw);
    }

    /**
     * Halaman utama / beranda publik.
     * Didelegasikan ke HomeController untuk konsistensi.
     */
    public function index()
    {
        $settings = $this->getCommonData();

        $posts = Post::whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();

        $services = Service::with('kategoriLayanan')
            ->where('is_active', true)
            ->orderBy('order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $announcements = Announcement::where('is_active', true)->latest()->get();

        $galleries = Album::withCount('photos')->latest()->take(6)->get();

        $videos = Video::latest()->take(4)->get();

        $maklumat = Maklumat::where('is_active', true)->latest()->first()
            ?? Maklumat::latest()->first();

        $partnerships = Partnership::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        $surveiKepuasan = SurveiKepuasan::where('is_active', true)->latest()->first()
            ?? SurveiKepuasan::first();

        $profilParent = NavigationMenu::whereRaw('LOWER(title) LIKE ?', ['%profil%'])
            ->whereNull('parent_id')
            ->first();

        $featuredProfileMenus = NavigationMenu::where('is_active', true)
            ->where('show_on_homepage', true)
            ->when($profilParent, function ($q) use ($profilParent) {
                $q->where('parent_id', $profilParent->id);
            })
            ->orderBy('order', 'asc')
            ->get();

        return view('home', compact(
            'settings',
            'posts',
            'services',
            'announcements',
            'galleries',
            'videos',
            'maklumat',
            'partnerships',
            'surveiKepuasan',
            'featuredProfileMenus'
        ));
    }
}
