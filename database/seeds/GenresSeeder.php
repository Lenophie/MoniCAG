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
        Genre::create(['name_fr' => 'Plein air', 'name_en' => 'Outdoors']);
        Genre::create(['name_fr' => 'Physique', 'name_en' => 'Physical']);
        Genre::create(['name_fr' => 'Réflexion', 'name_en' => 'Reflexion']);
        Genre::create(['name_fr' => 'Déduction sociale', 'name_en' => 'Social deduction']);
        Genre::create(['name_fr' => 'Cartes', 'name_en' => 'Cards']);
        Genre::create(['name_fr' => 'Dés', 'name_en' => 'Dice']);
        Genre::create(['name_fr' => 'Console', 'name_en' => 'Console']);
        Genre::create(['name_fr' => 'Jeu vidéo', 'name_en' => 'Video game']);
        Genre::create(['name_fr' => 'Manuel', 'name_en' => 'Manual']);
        Genre::create(['name_fr' => 'Jeu de rôle', 'name_en' => 'Role-playing game']);
        Genre::create(['name_fr' => 'Bluff', 'name_en' => 'Bluff']);
        Genre::create(['name_fr' => 'Chant', 'name_en' => 'Singing']);
        Genre::create(['name_fr' => 'Puzzle', 'name_en' => 'Puzzle']);
        Genre::create(['name_fr' => 'Mémoire', 'name_en' => 'Memory']);
        Genre::create(['name_fr' => 'Observation', 'name_en' => 'Observation']);
        Genre::create(['name_fr' => 'Hasard', 'name_en' => 'Randomness']);
        Genre::create(['name_fr' => 'Dessin', 'name_en' => 'Drawing']);
        Genre::create(['name_fr' => 'Rapidité', 'name_en' => 'Speed']);
        Genre::create(['name_fr' => 'Adresse', 'name_en' => 'Dexterity']);
        Genre::create(['name_fr' => 'Coopération', 'name_en' => 'Cooperation']);
        Genre::create(['name_fr' => 'Comédie', 'name_en' => 'Comedy']);
        Genre::create(['name_fr' => 'Imagination', 'name_en' => 'Imagination']);
        Genre::create(['name_fr' => 'Asymétrique', 'name_en' => 'Asymmetrical']);
        Schema::enableForeignKeyConstraints();
    }
}
