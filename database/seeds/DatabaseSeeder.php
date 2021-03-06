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
        $this->call(InventoryItemStatusesSeeder::class);
        $this->command->info('Inventory item statuses table seeded.');
        $this->call(UserRolesSeeder::class);
        $this->command->info('User roles table seeded.');

        if (App::environment() === 'local') {
            $this->call(GenresSeeder::class);
            $this->command->info('Genres table seeded. (local environment)');
            $this->call(InventoryItemsSeeder::class);
            $this->command->info('Inventory items table seeded. (local environment)');
            $this->call(GenreInventoryItemSeeder::class);
            $this->command->info('Inventory item genre pivot table seeded. (local environment)');
            $this->call(UsersSeeder::class);
            $this->command->info('Users table seeded. (local environment)');
        }
    }
}
