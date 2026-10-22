<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$controller = new App\Http\Controllers\Dashboard\UserController();
$view = $controller->index();
echo "Rendered view name: " . $view->name() . "\n";
echo "Total users passed to view: " . count($view->getData()['users']) . "\n";
foreach ($view->getData()['users'] as $u) {
    echo "- {$u->name} | Role: {$u->role} | Email: {$u->email}\n";
}
