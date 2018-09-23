<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenreInventoryItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genre_inventory_item', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventory_item_id')->unsigned();
            $table->integer('genre_id')->unsigned();

            $table->foreign('inventory_item_id')
                ->references('id')
                ->on('inventory_items');

            $table->foreign('genre_id')
                ->references('id')
                ->on('genres');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genre_inventory_item');
    }
}
