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
        InventoryItemStatus::create(['name_fr' => 'Au local LCR D4', 'name_en' => 'In LCR D4']);
        InventoryItemStatus::create(['name_fr' => 'Au local F2', 'name_en' => 'In F2']);
        InventoryItemStatus::create(['name_fr' => 'Emprunté', 'name_en' => 'Borrowed']);
        InventoryItemStatus::create(['name_fr' => 'Perdu', 'name_en' => 'Lost']);
        InventoryItemStatus::create(['name_fr' => 'Inconnu', 'name_en' => 'Unknown']);
        Schema::enableForeignKeyConstraints();
    }
}
