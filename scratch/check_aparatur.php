<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$settings = App\Models\Setting::pluck('value', 'key')->all();
foreach ($settings as $k => $v) {
    if (str_contains($k, 'nama') || str_contains($k, 'foto') || str_contains($k, 'nip') || str_contains($k, 'jabatan')) {
        echo "Key: {$k} => {$v}\n";
    }
}
