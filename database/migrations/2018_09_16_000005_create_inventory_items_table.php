<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\InventoryItemStatus;

class CreateInventoryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('duration_min')->unsigned()->nullable();
            $table->integer('duration_max')->unsigned()->nullable();
            $table->integer('players_min')->unsigned()->nullable();
            $table->integer('players_max')->unsigned()->nullable();
            $table->integer('status_id')->unsigned()->default(InventoryItemStatus::INCONNU);
            $table->foreign('status_id')->references('id')->on('inventory_item_statuses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_items');
    }
}
