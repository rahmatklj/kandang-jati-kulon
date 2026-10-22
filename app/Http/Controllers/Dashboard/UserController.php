<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\ActivityLogger;

class UserController extends Controller
{
    /**
     * Otomatis sinkronisasi aparatur staf kelurahan (Sekretaris, Kasi, LPMK, dsb) ke tabel users
     */
    public function syncAparaturStaff()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->all();

        $deletedEmails = [];
        if (!empty($settings['deleted_staff_emails'])) {
            $decoded = json_decode($settings['deleted_staff_emails'], true);
            if (is_array($decoded)) {
                $deletedEmails = array_map('strtolower', $decoded);
            }
        }

        $aparaturList = [
            [
                'key_name' => 'nama_sekretaris',
                'key_photo' => 'foto_sekretaris',
                'default_name' => 'Budi Santoso, S.Sos',
                'email_prefix' => 'budisantoso',
                'username' => 'budisantoso',
                'phone' => '081234567891',
                'ref' => 'STF101',
            ],
            [
                'key_name' => 'nama_kasi_pemerintahan',
                'key_photo' => 'foto_kasi_pemerintahan',
                'default_name' => 'Hendra Setiawan, S.AP',
                'email_prefix' => 'hendrasetiawan',
                'username' => 'hendrasetiawan',
                'phone' => '081234567892',
                'ref' => 'STF102',
            ],
            [
                'key_name' => 'nama_kasi_trantib',
                'key_photo' => 'foto_kasi_trantib',
                'default_name' => 'M. Rizky Pratama, S.IP',
                'email_prefix' => 'mrizkypratama',
                'username' => 'mrizkypratama',
                'phone' => '081234567893',
                'ref' => 'STF103',
            ],
            [
                'key_name' => 'nama_kasi_kesra',
                'key_photo' => 'foto_kasi_kesra',
                'default_name' => 'Nurul Hidayah, SE., MM',
                'email_prefix' => 'nurulhidayah',
                'username' => 'nurulhidayah',
                'phone' => '081234567894',
                'ref' => 'STF104',
            ],
        ];

        foreach ($aparaturList as $item) {
            $name = !empty($settings[$item['key_name']]) ? trim($settings[$item['key_name']]) : $item['default_name'];
            $photo = $settings[$item['key_photo']] ?? null;
            $email = $item['email_prefix'] . '@gmail.com';
            $username = $item['username'];

            // Skip jika akun email / username / nama ini telah dihapus oleh admin secara eksplisit
            if (in_array(strtolower($email), $deletedEmails) || in_array(strtolower($username), $deletedEmails) || in_array(strtolower($name), $deletedEmails)) {
                continue;
            }

            $user = User::where('email', $email)
                ->orWhere('username', $username)
                ->orWhere('name', $name)
                ->first();

            if (!$user) {
                User::create([
                    'name' => $name,
                    'username' => $username,
                    'email' => $email,
                    'password' => bcrypt('Kelurahan!4329'),
                    'role' => 'staf',
                    'phone' => $item['phone'],
                    'referral_code' => $item['ref'],
                    'avatar' => $photo,
                ]);
            } else {
                $user->update([
                    'name' => $name,
                    'avatar' => $photo ?: $user->avatar,
                ]);
            }
        }

        if (!empty($settings['additional_aparatur'])) {
            $additionalList = json_decode($settings['additional_aparatur'], true);
            if (is_array($additionalList)) {
                foreach ($additionalList as $idx => $stafItem) {
                    $stafName = trim($stafItem['name'] ?? '');
                    if (empty($stafName)) continue;

                    $slug = \Illuminate\Support\Str::slug($stafName, '');
                    $email = $slug . '@gmail.com';
                    $username = $slug;
                    $photo = $stafItem['photo'] ?? null;

                    if (in_array(strtolower($email), $deletedEmails) || in_array(strtolower($username), $deletedEmails) || in_array(strtolower($stafName), $deletedEmails)) {
                        continue;
                    }

                    $user = User::where('email', $email)
                        ->orWhere('username', $username)
                        ->orWhere('name', $stafName)
                        ->first();

                    if (!$user) {
                        User::create([
                            'name' => $stafName,
                            'username' => $username,
                            'email' => $email,
                            'password' => bcrypt('Kelurahan!4329'),
                            'role' => 'staf',
                            'phone' => '081234567' . (800 + $idx),
                            'referral_code' => 'STF' . (200 + $idx),
                            'avatar' => $photo,
                        ]);
                    } else {
                        $user->update([
                            'name' => $stafName,
                            'avatar' => $photo ?: $user->avatar,
                        ]);
                    }
                }
            }
        }
    }

    public function index()
    {
        $this->syncAparaturStaff();
        $users = User::orderBy('role')->orderBy('name')->get();
        return view('dashboard.users.index', compact('users'));
    }

    public function create()
    {
        return view('dashboard.users.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,staf',
            'phone' => 'nullable|string|max:30',
            'referral_code' => 'nullable|string|max:50',
            'avatar' => 'nullable|file|mimes:jpeg,png,jpg,webp,gif,svg|max:5120',
        ], [
            'name.required' => 'Nama lengkap pengguna wajib diisi.',
            'email.required' => 'Email resmi administrator wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar dalam sistem.',
            'username.unique' => 'Username ini sudah digunakan.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'avatar.mimes' => '🚫 AKSES DITOLAK! Format berkas foto profil pengguna tidak diperbolehkan. Hanya Foto/Gambar (JPG, PNG, JPEG, WEBP, GIF, SVG) yang diperbolehkan.',
        ]);

        // Hapus dari daftar deleted_staff_emails jika dibuat kembali oleh admin secara manual
        $deletedSetting = \App\Models\Setting::where('key', 'deleted_staff_emails')->value('value');
        if ($deletedSetting) {
            $deletedList = json_decode($deletedSetting, true) ?: [];
            $cleanList = array_values(array_filter($deletedList, function($e) use ($request) {
                $checkE = strtolower($e);
                return $checkE !== strtolower($request->email) && $checkE !== strtolower($request->username) && $checkE !== strtolower($request->name);
            }));
            \App\Models\Setting::updateOrCreate(
                ['key' => 'deleted_staff_emails'],
                ['value' => json_encode($cleanList)]
            );
        }

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $newUser = User::create([
            'name' => $request->name,
            'username' => $request->username ?: strtolower(str_replace(' ', '', $request->name)),
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'referral_code' => $request->referral_code,
            'avatar' => $avatarPath,
        ]);

        ActivityLogger::log('CREATE', 'Pengguna', "Menambahkan pengguna baru: {$newUser->name} ({$newUser->email}) sebagai {$newUser->role}", [
            'user_id' => $newUser->id,
            'role' => $newUser->role
        ]);

        return redirect()->route('dashboard.users.index')->with('success', 'Akun pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('dashboard.users.form', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,staf',
            'phone' => 'nullable|string|max:30',
            'referral_code' => 'nullable|string|max:50',
            'avatar' => 'nullable|file|mimes:jpeg,png,jpg,webp,gif,svg|max:5120',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8';
        }

        $request->validate($rules, [
            'name.required' => 'Nama lengkap pengguna wajib diisi.',
            'email.required' => 'Email resmi administrator wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar dalam sistem.',
            'username.unique' => 'Username ini sudah digunakan.',
            'avatar.mimes' => '🚫 AKSES DITOLAK! Format berkas foto profil pengguna tidak diperbolehkan. Hanya Foto/Gambar (JPG, PNG, JPEG, WEBP, GIF, SVG) yang diperbolehkan.',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username ?: strtolower(str_replace(' ', '', $request->name)),
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone,
            'referral_code' => $request->referral_code,
        ];

        if ($request->hasFile('avatar')) {
            if ($user->avatar && !\Illuminate\Support\Str::startsWith($user->avatar, 'http') && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        ActivityLogger::log('UPDATE', 'Pengguna', "Mengubah data pengguna: {$user->name} ({$user->email})", [
            'user_id' => $user->id,
            'role' => $user->role
        ]);

        return redirect()->route('dashboard.users.index')->with('success', 'Akun pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $deletedName = $user->name;
        $deletedEmail = strtolower($user->email);
        $deletedUsername = strtolower($user->username ?? '');

        // Simpan ke daftar deleted_staff_emails agar tidak di-recreate otomatis oleh syncAparaturStaff
        $deletedSetting = \App\Models\Setting::where('key', 'deleted_staff_emails')->value('value');
        $deletedList = $deletedSetting ? json_decode($deletedSetting, true) : [];
        if (!is_array($deletedList)) {
            $deletedList = [];
        }

        if (!in_array($deletedEmail, $deletedList)) {
            $deletedList[] = $deletedEmail;
        }
        if ($deletedUsername && !in_array($deletedUsername, $deletedList)) {
            $deletedList[] = $deletedUsername;
        }
        if ($deletedName && !in_array(strtolower($deletedName), $deletedList)) {
            $deletedList[] = strtolower($deletedName);
        }

        \App\Models\Setting::updateOrCreate(
            ['key' => 'deleted_staff_emails'],
            ['value' => json_encode(array_values($deletedList))]
        );

        $user->delete();

        ActivityLogger::log('DELETE', 'Pengguna', "Menghapus akun pengguna: {$deletedName} ({$deletedEmail})");

        return redirect()->route('dashboard.users.index')->with('success', "Akun pengguna '{$deletedName}' berhasil dihapus.");
    }
}

