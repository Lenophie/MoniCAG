<?php

use Illuminate\Database\Seeder;
use App\InventoryItem;

class InventoryItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('inventory_items')->truncate();
        InventoryItem::create(['name' => 'Dixit', 'status_id' => 0]);
        InventoryItem::create(['name' => 'Shadow Hunters', 'status_id' => 0]);
        InventoryItem::create(['name' => 'Puissance 4 géant', 'status_id' => 1]);
        InventoryItem::create(['name' => 'Wii U', 'status_id' => 2]);
        Schema::enableForeignKeyConstraints();
    }
}
