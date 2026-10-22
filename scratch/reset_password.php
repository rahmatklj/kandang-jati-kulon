<?php
chdir(__DIR__ . '/..');
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Update password user admin
$user = User::where('email', 'admin@kandangjati.id')->first();
if ($user) {
    $user->password = Hash::make('Admin1234!');
    $user->save();
    echo "✅ Password berhasil direset!\n";
    echo "   Email : " . $user->email . "\n";
    echo "   Password : Admin1234!\n";
    echo "   Role  : " . $user->role . "\n";
} else {
    // Buat user baru jika tidak ada
    $user = User::create([
        'name'     => 'Admin',
        'email'    => 'admin@kandangjati.id',
        'password' => Hash::make('Admin1234!'),
        'role'     => 'admin',
    ]);
    echo "✅ User admin baru dibuat!\n";
    echo "   Email : " . $user->email . "\n";
    echo "   Password : Admin1234!\n";
}

// Tampilkan semua user
echo "\n=== SEMUA USER DI DATABASE ===\n";
foreach (User::select('id', 'name', 'email', 'role')->get() as $u) {
    echo "  [{$u->id}] {$u->name} | {$u->email} | {$u->role}\n";
}
