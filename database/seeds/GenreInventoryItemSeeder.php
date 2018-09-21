<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GenreInventoryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('genre_inventory_item')->truncate();
        DB::table('genre_inventory_item')->insert(['inventory_item_id' => 1, 'genre_id' => 22]);
        DB::table('genre_inventory_item')->insert(['inventory_item_id' => 1, 'genre_id' => 5]);
        DB::table('genre_inventory_item')->insert(['inventory_item_id' => 2, 'genre_id' => 4]);
        DB::table('genre_inventory_item')->insert(['inventory_item_id' => 2, 'genre_id' => 10]);
        DB::table('genre_inventory_item')->insert(['inventory_item_id' => 2, 'genre_id' => 6]);
        DB::table('genre_inventory_item')->insert(['inventory_item_id' => 3, 'genre_id' => 1]);
        DB::table('genre_inventory_item')->insert(['inventory_item_id' => 3, 'genre_id' => 3]);
        DB::table('genre_inventory_item')->insert(['inventory_item_id' => 4, 'genre_id' => 7]);
        Schema::enableForeignKeyConstraints();
    }
}
