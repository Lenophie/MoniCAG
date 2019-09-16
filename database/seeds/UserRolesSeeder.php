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
        UserRole::create(['name_fr' => 'Aucun', 'name_en' => 'None']);
        UserRole::create(['name_fr' => 'Prêteur', 'name_en' => 'Lender']);
        UserRole::create(['name_fr' => 'Administrateur', 'name_en' => 'Administrator']);
        UserRole::create(['name_fr' => 'Super Administrateur', 'name_en' => 'Super Administrator']);
        Schema::enableForeignKeyConstraints();
    }
}
