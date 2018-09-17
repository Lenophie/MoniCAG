<?php

use App\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('user_roles')->truncate();
        UserRole::create(['name' => 'Aucun']);
        UserRole::create(['name' => 'Prêteur']);
        UserRole::create(['name' => 'Administrateur']);
        Schema::enableForeignKeyConstraints();
    }
}
