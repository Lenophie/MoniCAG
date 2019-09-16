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
            'first_name' => 'Monika',
            'last_name' => 'RoOt',
            'promotion' => 2021,
            'email' => 'monika@root.ddlc',
            'password' => bcrypt('root'),
            'role_id' => UserRole::SUPER_ADMINISTRATOR]);
        User::create([
            'first_name' => 'Sayori',
            'last_name' => 'ROot',
            'promotion' => 2020,
            'email' => 'sayori@root.ddlc',
            'password' => bcrypt('root'),
            'role_id' => UserRole::ADMINISTRATOR]);
        User::create([
            'first_name' => 'Natsuki',
            'last_name' => 'NotROot',
            'promotion' => 2020,
            'email' => 'natsuki@root.ddlc',
            'password' => bcrypt('notroot'),
            'role_id' => UserRole::LENDER]);
        User::create([
            'first_name' => 'Yuri',
            'last_name' => 'NotROot',
            'promotion' => 2020,
            'email' => 'yuri@root.ddlc',
            'password' => bcrypt('notroot'),
            'role_id' => UserRole::NONE]);
        Schema::enableForeignKeyConstraints();
    }
}
