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
            $table->unsignedInteger('inventory_item_id');
            $table->unsignedInteger('borrower_id');
            $table->unsignedInteger('initial_lender_id');
            $table->unsignedInteger('return_lender_id')->nullable()->default(null);
            $table->float('guarantee');
            $table->unsignedInteger('status_id');
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
            $table->foreign('status_id')->references('id')->on('borrowing_statuses');
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
