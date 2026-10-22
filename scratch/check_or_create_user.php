<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

$admin = User::where('email', 'admin@kandangjatikulon.go.id')
    ->orWhere('username', 'admin')
    ->first();

if (!$admin) {
    $admin = User::first();
}

if ($admin) {
    $admin->username = 'admin';
    $admin->email = 'admin@kandangjatikulon.go.id';
    $admin->password = Hash::make('admin123');
    $admin->name = 'Administrator Kelurahan';
    if (Schema::hasColumn('users', 'role')) {
        $admin->role = 'admin';
    }
    $admin->save();
    echo "SUCCESS_UPDATED: ID={$admin->id}\n";
} else {
    $admin = new User();
    $admin->name = 'Administrator Kelurahan';
    $admin->username = 'admin';
    $admin->email = 'admin@kandangjatikulon.go.id';
    $admin->password = Hash::make('admin123');
    if (Schema::hasColumn('users', 'role')) {
        $admin->role = 'admin';
    }
    $admin->save();
    echo "SUCCESS_CREATED: ID={$admin->id}\n";
}
