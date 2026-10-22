<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Http\Controllers\Dashboard\UserController;

$controller = new UserController();

echo "Before delete: Total users = " . User::count() . "\n";

// Find one staff user to delete
$staffToDelete = User::where('role', 'staf')->where('email', 'mohridwan@gmail.com')->first();
if ($staffToDelete) {
    echo "Deleting staff: {$staffToDelete->name} ({$staffToDelete->email})\n";
    $controller->destroy($staffToDelete);
}

// Now simulate reloading index
$view = $controller->index();
$usersAfter = $view->getData()['users'];

echo "After delete & reload index: Total users = " . count($usersAfter) . "\n";
foreach ($usersAfter as $u) {
    echo "- {$u->name} ({$u->email}) [Role: {$u->role}]\n";
}
