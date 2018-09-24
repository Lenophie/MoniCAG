<?php

use App\InventoryItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
        InventoryItem::create([
            'name_fr' => 'Dixit',
            'name_en' => 'Dixit',
            'status_id' => 1,
            'duration_min' => 10,
            'duration_max' => 60,
            'players_min' => 3,
            'players_max' => 12]);
        InventoryItem::create([
            'name_fr' => 'Shadow Hunters',
            'name_en' => 'Shadow Hunters',
            'status_id' => 1,
            'duration_min' => 20,
            'duration_max' => 60,
            'players_min' => 4,
            'players_max' => 9]);
        InventoryItem::create([
            'name_fr' => 'Puissance 4 géant',
            'name_en' => 'Giant Connect 4',
            'status_id' => 2]);
        InventoryItem::create([
            'name_fr' => 'Wii U',
            'name_en' => 'Wii U',
            'status_id' => 1]);
        Schema::enableForeignKeyConstraints();
    }
}
