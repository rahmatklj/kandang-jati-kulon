<?php
chdir(__DIR__ . '/..');
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Document;
use App\Models\Category;

echo "=== CEK DATA DOKUMEN ===\n";
$total = Document::count();
echo "Total dokumen di database: $total\n\n";

if ($total > 0) {
    echo "=== DAFTAR DOKUMEN ===\n";
    foreach (Document::select('id','title','category','status','published_date')->latest()->take(10)->get() as $d) {
        echo "  [{$d->id}] {$d->title} | cat: {$d->category} | {$d->status} | {$d->published_date}\n";
    }
}

echo "\n=== CEK KATEGORI DOKUMEN ===\n";
$cats = Category::where('module', 'dokumen')->get();
echo "Total kategori dokumen: " . $cats->count() . "\n";
foreach ($cats as $c) {
    echo "  [{$c->id}] {$c->name} | slug: {$c->slug} | status: {$c->status}\n";
}
