<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ActivityLogger;

class SettingController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        $recentActivities = \App\Models\ActivityLog::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.settings.profile', compact('user', 'recentActivities'));
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'current_password' => 'nullable|required_with:new_password|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email ini telah digunakan oleh akun lain.',
            'new_password.min' => 'Kata sandi baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            'current_password.required_with' => 'Kata sandi saat ini wajib diisi jika ingin mengubah kata sandi.',
        ]);

        if ($request->filled('new_password')) {
            if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak cocok.'])->withInput();
            }
            $user->password = \Illuminate\Support\Facades\Hash::make($request->new_password);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar && !\Illuminate\Support\Str::startsWith($user->avatar, 'http') && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        } elseif ($request->filled('avatar_url')) {
            $user->avatar = trim($request->avatar_url);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        ActivityLogger::log('UPDATE', 'Profil Saya', "Memperbarui informasi profil pengguna: {$user->name} ({$user->email})");

        return back()->with('success', 'Profil dan informasi akun Anda berhasil diperbarui.');
    }

    public function visiMisi()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('dashboard.settings.visi_misi', compact('settings'));
    }

    public function sejarah()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('dashboard.settings.sejarah', compact('settings'));
    }

    public function aparatur()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('dashboard.settings.aparatur', compact('settings'));
    }

    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('dashboard.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'foto_sejarah' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif,jfif|max:5048',
            'foto_sejarah_url' => 'nullable|string|max:2000',
            'foto_atasan' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif,jfif|max:5048',
            'foto_atasan_url' => 'nullable|string|max:2000',
            'foto_lurah' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif,jfif|max:5048',
            'foto_lurah_url' => 'nullable|string|max:2000',
            'foto_lpmk' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif,jfif|max:5048',
            'foto_lpmk_url' => 'nullable|string|max:2000',
            'foto_sekretaris' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif,jfif|max:5048',
            'foto_sekretaris_url' => 'nullable|string|max:2000',
            'foto_kasi_pemerintahan' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif,jfif|max:5048',
            'foto_kasi_pemerintahan_url' => 'nullable|string|max:2000',
            'foto_kasi_trantib' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif,jfif|max:5048',
            'foto_kasi_trantib_url' => 'nullable|string|max:2000',
            'foto_kasi_kesra' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif,jfif|max:5048',
            'foto_kasi_kesra_url' => 'nullable|string|max:2000',
            'gambar_bagan_struktur' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif,jfif|max:5048',
            'gambar_bagan_struktur_url' => 'nullable|string|max:2000',
            'logo_kelurahan' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif,jfif|max:5048',
            'logo_kelurahan_url' => 'nullable|string|max:2000',
            'kadin_photo' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif,jfif|max:5048',
            'kadin_photo_url' => 'nullable|string|max:2000',
            'hero_background' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif,jfif|max:10240',
            'hero_background_url' => 'nullable|string|max:2000',
            'slides.*.background_file' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif,jfif|max:10240',
            'slides.*.background_url' => 'nullable|string|max:2000',
            'qr_code_image' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif,jfif|max:5048',
        ], [
            'foto_sejarah.mimes' => '🚫 AKSES DITOLAK! Format berkas foto sejarah tidak diperbolehkan. Hanya Foto/Gambar (JPG, PNG, JPEG, WEBP, GIF, SVG) yang diperbolehkan.',
            'foto_atasan.mimes' => '🚫 AKSES DITOLAK! Format berkas foto atasan tidak diperbolehkan. Hanya Foto/Gambar yang diperbolehkan.',
            'foto_lurah.mimes' => '🚫 AKSES DITOLAK! Format berkas foto lurah tidak diperbolehkan. Hanya Foto/Gambar yang diperbolehkan.',
            'slides.*.background_file.mimes' => '🚫 AKSES DITOLAK! Format gambar slide hero banner tidak diperbolehkan. Hanya Foto/Gambar yang diperbolehkan.',
            'qr_code_image.mimes' => '🚫 AKSES DITOLAK! Format berkas Kode QR tidak diperbolehkan. Hanya Foto/Gambar (JPG, PNG, JPEG, WEBP, GIF, SVG) yang diperbolehkan.',
        ]);

        $data = $request->except(['_token', '_method']);
        
        $imageFields = [
            'foto_atasan',
            'foto_lurah',
            'kadin_photo',
            'logo_kelurahan',
            'hero_background',
            'foto_sejarah',
            'foto_lpmk',
            'foto_sekretaris',
            'foto_kasi_pemerintahan',
            'foto_kasi_trantib',
            'foto_kasi_kesra',
            'gambar_bagan_struktur',
            'qr_code_image',
        ];

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('settings', 'public');
                $data[$field] = $path;
            } elseif ($request->filled($field . '_url')) {
                $data[$field] = trim($request->input($field . '_url'));
            } else {
                unset($data[$field]);
            }
            unset($data[$field . '_url']);

            // Sync foto_lurah and kadin_photo for compatibility
            if (isset($data[$field])) {
                if ($field === 'kadin_photo') {
                    $data['foto_lurah'] = $data[$field];
                } elseif ($field === 'foto_lurah') {
                    $data['kadin_photo'] = $data[$field];
                }
            }
        }

        // Sync demografi_total and jumlah_penduduk for compatibility
        if (isset($data['demografi_total'])) {
            $data['jumlah_penduduk'] = $data['demografi_total'];
        } elseif (isset($data['jumlah_penduduk'])) {
            $data['demografi_total'] = $data['jumlah_penduduk'];
        }

        // Sync whatsapp, wa_number, and telepon_wa for compatibility
        if (isset($data['whatsapp'])) {
            $data['wa_number'] = $data['whatsapp'];
            $data['telepon_wa'] = $data['whatsapp'];
        } elseif (isset($data['wa_number'])) {
            $data['whatsapp'] = $data['wa_number'];
            $data['telepon_wa'] = $data['wa_number'];
        } elseif (isset($data['telepon_wa'])) {
            $data['whatsapp'] = $data['telepon_wa'];
            $data['wa_number'] = $data['telepon_wa'];
        }

        // Process Dynamic Social Media List if submitted
        if ($request->has('social_media')) {
            $rawSocial = $request->input('social_media');
            if (is_string($rawSocial)) {
                $decoded = json_decode($rawSocial, true);
                if (is_array($decoded)) {
                    $cleanList = array_values(array_filter($decoded, function($item) {
                        return !empty($item['url']) && $item['url'] !== '#' && $item['url'] !== 'https://';
                    }));
                    $data['social_media'] = json_encode($cleanList);

                    // Sync legacy keys for backward compatibility
                    foreach ($cleanList as $s) {
                        $p = strtolower($s['platform'] ?? '');
                        if (in_array($p, ['instagram', 'youtube', 'tiktok', 'facebook', 'twitter', 'whatsapp'])) {
                            $data[$p] = $s['url'];
                        }
                    }
                }
            }
        }

        // Process Hero Banner Slides if submitted
        if ($request->has('slides') && is_array($request->slides)) {
            $processedSlides = [];
            foreach ($request->slides as $index => $slideData) {
                $bgPath = $slideData['background_old'] ?? '';

                // Check for file upload for this specific slide
                if ($request->hasFile("slides.{$index}.background_file")) {
                    $bgPath = $request->file("slides.{$index}.background_file")->store('settings/slides', 'public');
                } elseif (!empty($slideData['background_url'])) {
                    $bgPath = trim($slideData['background_url']);
                }

                $processedSlides[] = [
                    'tag' => $slideData['tag'] ?? 'Program Unggulan Kelurahan',
                    'title_1' => $slideData['title_1'] ?? '',
                    'title_2' => $slideData['title_2'] ?? '',
                    'subtitle' => $slideData['subtitle'] ?? '',
                    'background' => $bgPath,
                ];
            }

            if (!empty($processedSlides)) {
                $data['hero_slides'] = json_encode($processedSlides);

                // Sync slide #0 for backward compatibility
                $data['hero_tag'] = $processedSlides[0]['tag'] ?? '';
                $data['hero_title_1'] = $processedSlides[0]['title_1'] ?? '';
                $data['hero_title_2'] = $processedSlides[0]['title_2'] ?? '';
                $data['hero_subtitle'] = $processedSlides[0]['subtitle'] ?? '';
                if (!empty($processedSlides[0]['background'])) {
                    $data['hero_background'] = $processedSlides[0]['background'];
                }
            }
            unset($data['slides']);
        }

        // Process Dynamic Additional Aparatur / Staf Members if submitted
        if ($request->has('additional_aparatur_submitted') || $request->has('additional_aparatur')) {
            $processedAparatur = [];
            $rawAparatur = $request->input('additional_aparatur', []);
            if (is_array($rawAparatur)) {
                foreach ($rawAparatur as $index => $itemData) {
                    $photoPath = $itemData['photo_old'] ?? '';

                    // Check for file upload for this specific member
                    if ($request->hasFile("additional_aparatur_photo_file_{$index}")) {
                        $photoPath = $request->file("additional_aparatur_photo_file_{$index}")->store('settings/aparatur', 'public');
                    } elseif (!empty($itemData['photo_url'])) {
                        $photoPath = trim($itemData['photo_url']);
                    }

                    $nameVal = trim($itemData['name'] ?? '');
                    if ($nameVal !== '') {
                        $jabatanVal = trim($itemData['jabatan'] ?? '');
                        $processedAparatur[] = [
                            'name' => $nameVal,
                            'jabatan' => $jabatanVal !== '' ? $jabatanVal : 'Staf Kelurahan',
                            'nip' => trim($itemData['nip'] ?? ''),
                            'atasan' => trim($itemData['atasan'] ?? ''),
                            'photo' => $photoPath,
                        ];
                    }
                }
            }

            $data['additional_aparatur'] = json_encode($processedAparatur);
            unset($data['additional_aparatur_submitted']);
        }

        $keysUpdated = array_keys($data);
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        try {
            (new \App\Http\Controllers\Dashboard\UserController())->syncAparaturStaff();
        } catch (\Throwable $e) {
            // Log error silently if any
        }

        ActivityLogger::log('UPDATE', 'Pengaturan', "Mengubah pengaturan web/profil kelurahan (" . count($keysUpdated) . " item)", [
            'updated_keys' => array_slice($keysUpdated, 0, 10)
        ]);

        return back()->with('success', 'Pengaturan struktur aparatur & profil berhasil disimpan.');
    }

    public function destroyKey($key)
    {
        $setting = Setting::where('key', $key)->first();
        if ($setting) {
            $imageKeys = [
                'foto_atasan', 'foto_lurah', 'kadin_photo', 'logo_kelurahan', 'hero_background',
                'foto_sejarah', 'foto_lpmk', 'foto_sekretaris', 'foto_kasi_pemerintahan',
                'foto_kasi_trantib', 'foto_kasi_kesra', 'gambar_bagan_struktur', 'qr_code_image'
            ];

            if (in_array($key, $imageKeys) && $setting->value && !filter_var($setting->value, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($setting->value);
            }
            $setting->delete();

            // Also delete synced key if foto_lurah / kadin_photo
            if ($key === 'kadin_photo') {
                Setting::where('key', 'foto_lurah')->delete();
            } elseif ($key === 'foto_lurah') {
                Setting::where('key', 'kadin_photo')->delete();
            }

            ActivityLogger::log('DELETE', 'Pengaturan', "Menghapus item pengaturan: {$key}");
        }

        return back()->with('success', 'Data ' . str_replace('_', ' ', $key) . ' berhasil dihapus/dikosongkan.');
    }

    public function lapor()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('dashboard.integrations.lapor', compact('settings'));
    }

    public function halloSae()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('dashboard.integrations.hallo_sae', compact('settings'));
    }

    public function contactMaps()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('dashboard.integrations.contact_maps', compact('settings'));
    }

    public function updateComplaintStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:pending,processing,resolved,rejected']);
        $complaint = \App\Models\Complaint::findOrFail($id);
        $complaint->update(['status' => $request->status]);

        ActivityLogger::log('UPDATE', 'Pengaduan', "Mengubah status pengaduan ID #{$id} menjadi {$request->status}");

        return back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }

    public function destroyComplaint($id)
    {
        $complaint = \App\Models\Complaint::findOrFail($id);
        $title = $complaint->title;
        $complaint->delete();

        ActivityLogger::log('DELETE', 'Pengaduan', "Menghapus pengaduan: {$title}");

        return back()->with('success', 'Data pengaduan berhasil dihapus.');
    }
}
