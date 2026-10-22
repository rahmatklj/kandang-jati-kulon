<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Announcement;
use App\Models\Post;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Maklumat;
use App\Models\Video;
use App\Models\Partnership;
use App\Models\SurveiKepuasan;
use App\Models\NavigationMenu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $settingsRaw = Setting::all();
        $settings = $settingsRaw->pluck('value', 'key')->toArray();

        $posts = Post::whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->take(2)
            ->get();

        $services = Service::with('kategoriLayanan')->where('is_active', true)->orderBy('order', 'asc')->orderBy('id', 'asc')->get();

        // Ambil pengumuman (running text) yang aktif
        $announcements = Announcement::where('is_active', true)->latest()->get();

        // Ambil 2 album foto dari dashboard admin
        $galleries = Album::withCount('photos')->latest()->take(2)->get();

        // Ambil 2 video dokumentasi dari dashboard admin
        $videos = Video::latest()->take(2)->get();

        // Ambil maklumat pelayanan yang aktif (terbaru)
        $maklumat = Maklumat::where('is_active', true)->latest()->first() ?? Maklumat::latest()->first();

        // Ambil data kemitraan aktif
        $partnerships = Partnership::where('is_active', true)->orderBy('sort_order', 'asc')->get();

        // Ambil data survei kepuasan masyarakat (SKM) aktif
        $surveiKepuasan = SurveiKepuasan::where('is_active', true)->latest()->first() ?? SurveiKepuasan::first();

        // Ambil sub-menu Profil yang ditandai 'Tampilkan di Halaman Beranda'
        $profilParent = NavigationMenu::where(function($q) {
            $q->whereRaw('LOWER(title) LIKE ?', ['%profil%']);
        })->whereNull('parent_id')->first();

        $featuredProfileMenus = NavigationMenu::where('is_active', true)
            ->where('show_on_homepage', true)
            ->when($profilParent, function($q) use ($profilParent) {
                $q->where('parent_id', $profilParent->id);
            })
            ->orderBy('order', 'asc')
            ->get();

        return view('home', compact('services', 'posts', 'announcements', 'galleries', 'videos', 'settings', 'maklumat', 'partnerships', 'surveiKepuasan', 'featuredProfileMenus'));
    }
}
