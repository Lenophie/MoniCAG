<?php

use App\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GenresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('genres')->truncate();
        Genre::create(['name' => 'Plein air']);
        Genre::create(['name' => 'Physique']);
        Genre::create(['name' => 'Réflexion']);
        Genre::create(['name' => 'Déduction sociale']);
        Genre::create(['name' => 'Cartes']);
        Genre::create(['name' => 'Dés']);
        Genre::create(['name' => 'Console']);
        Genre::create(['name' => 'Jeu vidéo']);
        Genre::create(['name' => 'Manuel']);
        Genre::create(['name' => 'Jeu de rôle']);
        Genre::create(['name' => 'Bluff']);
        Genre::create(['name' => 'Chant']);
        Genre::create(['name' => 'Puzzle']);
        Genre::create(['name' => 'Mémoire']);
        Genre::create(['name' => 'Observation']);
        Genre::create(['name' => 'Hasard']);
        Genre::create(['name' => 'Dessin']);
        Genre::create(['name' => 'Rapidité']);
        Genre::create(['name' => 'Adresse']);
        Genre::create(['name' => 'Coopération']);
        Genre::create(['name' => 'Comédie']);
        Genre::create(['name' => 'Imagination']);
        Schema::enableForeignKeyConstraints();
    }
}
