<?php

use App\BorrowingStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BorrowingStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('borrowing_statuses')->truncate();
        BorrowingStatus::create(['name' => 'En cours']);
        BorrowingStatus::create(['name' => 'Terminé']);
        BorrowingStatus::create(['name' => 'Annulé']);
        Schema::enableForeignKeyConstraints();
    }
}
