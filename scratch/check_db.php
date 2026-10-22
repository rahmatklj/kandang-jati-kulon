<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=db_kandangjati', 'root', '');
    $tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
    echo "db_kandangjati tables:\n";
    print_r($tables);
} catch (Exception $e) {
    echo "Error db_kandangjati: " . $e->getMessage() . "\n";
}

try {
    $pdo2 = new PDO('mysql:host=127.0.0.1;dbname=db_dkupp', 'root', '');
    $tables2 = $pdo2->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
    echo "db_dkupp tables:\n";
    print_r($tables2);
} catch (Exception $e) {
    echo "Error db_dkupp: " . $e->getMessage() . "\n";
}
