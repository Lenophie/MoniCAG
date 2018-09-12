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
            $table->integer('inventory_item_id');
            $table->integer('borrower_id');
            $table->integer('initial_lender_id');
            $table->integer('return_lender_id');
            $table->float('guarantee');
            $table->integer('status_id');
            $table->date('start_date');
            $table->date('expected_return_date');
            $table->date('return_date');
            $table->text('notes_before');
            $table->text('notes_after');
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
        Schema::dropIfExists('borrowings');
    }
}
