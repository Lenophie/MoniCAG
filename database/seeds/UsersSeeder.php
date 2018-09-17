<?php

use App\User;
use App\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        User::create([
            'firstName' => 'Monika',
            'lastName' => 'Root',
            'promotion' => 2019,
            'email' => 'monika@root.ddlc',
            'password' => bcrypt('root'),
            'role' => UserRole::ADMINISTRATEUR]);
        Schema::enableForeignKeyConstraints();
    }
}
