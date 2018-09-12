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
        $this->call('BorrowingStatusesSeeder');
        $this->command->info('Borrowing statuses table seeded!');
        $this->call('InventoryItemStatusesSeeder');
        $this->command->info('Inventory item statuses table seeded!');
    }
}
