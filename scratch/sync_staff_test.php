<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Setting;

$settings = Setting::pluck('value', 'key')->all();

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
    [
        'key_name' => 'nama_lpmk',
        'key_photo' => 'foto_lpmk',
        'default_name' => 'H. Moh. Ridwan, M.Pd',
        'email_prefix' => 'mohridwan',
        'username' => 'mohridwan',
        'phone' => '081234567895',
        'ref' => 'STF105',
    ],
];

foreach ($aparaturList as $item) {
    $name = !empty($settings[$item['key_name']]) ? $settings[$item['key_name']] : $item['default_name'];
    $photo = $settings[$item['key_photo']] ?? null;
    $email = $item['email_prefix'] . '@gmail.com';
    $username = $item['username'];

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
        echo "Created staff: {$name} ({$email})\n";
    } else {
        $user->update([
            'name' => $name,
            'avatar' => $photo ?: $user->avatar,
            'role' => 'staf',
        ]);
        echo "Updated staff: {$name} ({$email})\n";
    }
}

echo "Total users now: " . User::count() . "\n";
