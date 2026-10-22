<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $lembagas = \App\Models\Lembaga::where('is_active', true)->orderBy('sort_order')->get();
    $html = view('lembaga.index', compact('lembagas'))->render();
    echo "Render SUCCESS! Rendered " . strlen($html) . " bytes.\n";
} catch (\Throwable $e) {
    echo "Render ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
