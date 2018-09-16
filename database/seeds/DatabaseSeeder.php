<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BorrowingStatusesSeeder::class);
        $this->command->info('Borrowing statuses table seeded.');
        $this->call(InventoryItemStatusesSeeder::class);
        $this->command->info('Inventory item statuses table seeded.');

        if (App::environment() === 'local') {
            $this->call(InventoryItemsSeeder::class);
            $this->command->info('Inventory items table seeded. (local environment)');
        }
    }
}
