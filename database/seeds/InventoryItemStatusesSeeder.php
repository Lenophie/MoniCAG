<?php

use App\InventoryItemStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InventoryItemStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('inventory_item_statuses')->truncate();
        InventoryItemStatus::create(['name' => 'Au local LCR D4']);
        InventoryItemStatus::create(['name' => 'Au local F2']);
        InventoryItemStatus::create(['name' => 'Emprunté']);
        InventoryItemStatus::create(['name' => 'Perdu']);
        InventoryItemStatus::create(['name' => 'Inconnu']);
        Schema::enableForeignKeyConstraints();
    }
}
