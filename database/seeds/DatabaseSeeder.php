<?php

use Illuminate\Database\Seeder;

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
        $this->command->info('Borrowing statuses table seeded!');
        $this->call(InventoryItemStatusesSeeder::class);
        $this->command->info('Inventory item statuses table seeded!');
    }
}
