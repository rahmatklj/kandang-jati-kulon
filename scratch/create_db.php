<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1', 'root', '');
    $pdo->exec('CREATE DATABASE IF NOT EXISTS webkel_kandangjati CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    echo "Database webkel_kandangjati created/exists successfully.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
