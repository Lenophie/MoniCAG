<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryItemAltNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_item_alt_names', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventory_item_id')->unsigned();
            $table->string('name');

            $table->foreign('inventory_item_id')->references('id')->on('inventory_items')->onDelete('cascade');
        });

        $old_en_inventory_item_names = DB::table('inventory_items')
            ->select(['id as inventory_item_id', 'name_en as name'])
            ->whereNotNull('name_en')
            ->get();
        $old_en_inventory_item_names = json_decode($old_en_inventory_item_names, true);

        DB::table('inventory_item_alt_names')->insert($old_en_inventory_item_names);

        Schema::table('inventory_items', function (Blueprint $table) {
            $table->dropColumn('name_en');
            $table->renameColumn('name_fr', 'name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_items', function (Blueprint $table) {
           $table->string('name_en')->after('name')->nullable();
           $table->renameColumn('name', 'name_fr');
        });

        Schema::dropIfExists('inventory_item_alt_names');
    }
}
