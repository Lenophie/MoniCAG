<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFinishedColumnFromBorrowingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->dropColumn('finished');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->boolean('finished')->after('guarantee')->default(false);
        });

        DB::table('borrowings')
            ->whereNotNull('return_date')
            ->update(['finished' => true]);

    }
}
