<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = App\Models\User::select('id', 'name', 'email', 'role')->get();

echo "=== DAFTAR USER ===\n";
foreach ($users as $u) {
    echo "ID: {$u->id} | Nama: {$u->name} | Email: {$u->email} | Role: {$u->role}\n";
}
echo "Total: " . $users->count() . " user\n";
