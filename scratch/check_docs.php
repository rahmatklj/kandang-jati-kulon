<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Document;
use App\Models\Category;

echo "Total Documents in DB: " . Document::count() . "\n";
foreach (Document::all() as $doc) {
    echo "ID: {$doc->id} | Title: {$doc->title} | Category: {$doc->category}\n";
}

echo "\nDocument Categories:\n";
foreach (Category::where('module', 'dokumen')->get() as $cat) {
    echo "ID: {$cat->id} | Name: {$cat->name} | Slug: {$cat->slug}\n";
}
