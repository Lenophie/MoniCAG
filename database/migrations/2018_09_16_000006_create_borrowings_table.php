<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBorrowingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventory_item_id')->unsigned();
            $table->integer('borrower_id')->unsigned();
            $table->integer('initial_lender_id')->unsigned();
            $table->integer('return_lender_id')->unsigned()->nullable()->default(null);
            $table->float('guarantee');
            $table->boolean('finished')->default(false);
            $table->date('start_date');
            $table->date('expected_return_date');
            $table->date('return_date')->nullable()->default(null);
            $table->text('notes_before')->nullable();
            $table->text('notes_after')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('inventory_item_id')->references('id')->on('inventory_items');
            $table->foreign('borrower_id')->references('id')->on('users');
            $table->foreign('initial_lender_id')->references('id')->on('users');
            $table->foreign('return_lender_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('borrowings');
    }
}
