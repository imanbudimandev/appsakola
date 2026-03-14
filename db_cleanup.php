<?php

use Illuminate\Support\Facades\DB;

define('LARAVEL_START', microtime(true));

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Starting Manual DB Cleanup...\n";
    
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    
    echo "Truncating order_items...\n";
    DB::table('order_items')->truncate();
    
    echo "Truncating orders...\n";
    DB::table('orders')->truncate();
    
    echo "Deleting members...\n";
    $count = DB::table('users')->where('role', 'member')->delete();
    echo "Deleted $count members.\n";
    
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    
    echo "SUCCESS: Database has been cleaned.\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
