<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Total Posts: " . \App\Models\Post::count() . "\n";
foreach (\App\Models\Post::all() as $post) {
    echo "ID: {$post->id} | Title: {$post->title} | Published: {$post->published_at}\n";
}

echo "\nCategories:\n";
foreach (\App\Models\Category::all() as $cat) {
    echo "ID: {$cat->id} | Name: {$cat->name} | Module: {$cat->module}\n";
}
