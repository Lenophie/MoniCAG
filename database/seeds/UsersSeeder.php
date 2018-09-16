<?php

use Illuminate\Database\Seeder;
use App\User;

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
            'role' => 0]);
        Schema::enableForeignKeyConstraints();
    }
}
