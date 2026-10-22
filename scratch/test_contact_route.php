<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $settingsRaw = \App\Models\Setting::all();
    $settings = $settingsRaw->pluck('value', 'key')->toArray();
    $html = view('contact', compact('settings'))->render();
    echo "Render SUCCESS! Rendered " . strlen($html) . " bytes.\n";
} catch (\Throwable $e) {
    echo "Render ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo $e->getTraceAsString() . "\n";
}
