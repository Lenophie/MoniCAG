<?php

use Illuminate\Database\Seeder;
use App\UserRole;

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
