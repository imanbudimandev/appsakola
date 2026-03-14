<?php
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;

try {
    echo "Starting cleanup process...\n";
    
    // Disable foreign key checks to avoid issues during truncation/deletion
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    
    // 1. Clear Order Items
    echo "Clearing order_items table...\n";
    DB::table('order_items')->truncate();
    
    // 2. Clear Orders
    echo "Clearing orders table...\n";
    DB::table('orders')->truncate();
    
    // 3. Clear Members (Users with role 'member')
    echo "Clearing member users...\n";
    $count = DB::table('users')->where('role', 'member')->delete();
    echo "Deleted $count members.\n";
    
    // Re-enable foreign key checks
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    
    echo "Cleanup finished successfully!\n";
} catch (\Exception $e) {
    echo "Error during cleanup: " . $e->getMessage() . "\n";
}
