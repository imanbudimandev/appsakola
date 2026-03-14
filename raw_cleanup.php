<?php
$host = '127.0.0.1';
$db   = 'appsakola';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "CONNECTED TO DB\n";
    
    $pdo->exec("SET FOREIGN_KEY_CHECKS=0");
    
    echo "Truncating order_items...\n";
    $pdo->exec("TRUNCATE TABLE order_items");
    
    echo "Truncating orders...\n";
    $pdo->exec("TRUNCATE TABLE orders");
    
    echo "Deleting members...\n";
    $count = $pdo->exec("DELETE FROM users WHERE role = 'member'");
    echo "Deleted $count members.\n";
    
    $pdo->exec("SET FOREIGN_KEY_CHECKS=1");
    
    echo "FINISH_CLEANUP\n";
} catch (\PDOException $e) {
    echo "DB_ERROR: " . $e->getMessage() . "\n";
}
