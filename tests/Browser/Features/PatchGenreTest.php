<?php

namespace Tests\Browser\Features;

use App\Genre;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\EditInventoryPage;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\PagesFromHomeEnum;
use Tests\DuskTestCase;

class PatchGenreTest extends DuskTestCase
{
    use WithFaker;

    private $admin;
    private $genres;

    protected function setUp(): void {
        Parent::setUp();
        $this->faker->seed(0);
        $admin = factory(User::class)->state('admin')->create();
        $this->admin = $admin;
        $genres = factory(Genre::class, 5)->create();
        $this->genres = $genres;
    }

    protected function tearDown(): void {
        Genre::query()->delete();
        User::query()->delete();
    }

    public function testAddAGenre() {
        // Defining values to use to create the new genre
        $fieldsValues = (object) [];
        $fieldsValues->nameFr = $this->faker->unique()->word;
        $fieldsValues->nameEn = $this->faker->unique()->word;

        $genreToPatch = $this->genres[3];

        // Go to the edit inventory page and create a new item
        $this->browse(function (Browser $browser) use ($fieldsValues, $genreToPatch) {
            $browser->loginAs($this->admin)
                ->visit(new HomePage)
                ->navigateTo(PagesFromHomeEnum::EDIT_INVENTORY)
                ->on(new EditInventoryPage)
                ->waitForPageLoaded()
                ->whenGenreUpdateModalAvailable($genreToPatch->id, function (Browser $modal) use ($fieldsValues) {
                    $modal->type('nameFr', $fieldsValues->nameFr)
                        ->type('nameEn', $fieldsValues->nameEn)
                        ->click('@genreUpdateConfirmationButton');
                })
                ->waitForReload()
                ->assertPathIs('/');
        });

        // Check the record update to the database
        $this->assertDatabaseHas('genres', [
            'name_fr' => $fieldsValues->nameFr,
            'name_en' => $fieldsValues->nameEn
        ]);
    }
}
