<?php

use Illuminate\Database\Seeder;
use App\BorrowingStatus;

class BorrowingStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('borrowing_statuses')->truncate();
        BorrowingStatus::create(['name' => 'A venir']);
        BorrowingStatus::create(['name' => 'En cours']);
        BorrowingStatus::create(['name' => 'Terminé']);
        BorrowingStatus::create(['name' => 'Annulé']);
    }
}
