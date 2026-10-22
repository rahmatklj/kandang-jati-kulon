<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$menus = \App\Models\NavigationMenu::with('children')->whereNull('parent_id')->orderBy('order')->get();
foreach ($menus as $m) {
    echo "ID: {$m->id} | Title: {$m->title} | URL: {$m->url}\n";
    foreach ($m->children as $c) {
        echo "   -> Child ID: {$c->id} | Title: {$c->title} | URL: {$c->url}\n";
    }
}
