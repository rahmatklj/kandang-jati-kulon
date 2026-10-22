<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$logs = App\Models\ActivityLog::latest()->take(30)->get();
foreach ($logs as $l) {
    echo "[{$l->created_at}] Action: {$l->action} | Module: {$l->module} | Description: {$l->description}\n";
}
