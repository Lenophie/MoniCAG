<?php

namespace Tests\Browser\Features;

use App\Genre;
use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\EditInventoryPage;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\PagesFromHomeEnum;
use Tests\DuskTestCase;

class DeleteGenreTest extends DuskTestCase
{
    use WithFaker;

    private $admin;
    private $genres;
    private $inventoryItems;

    protected function setUp(): void {
        Parent::setUp();
        $this->faker->seed(0);
        $admin = factory(User::class)->state('admin')->create();
        $this->admin = $admin;
        $genres = factory(Genre::class, 5)->create();
        $this->genres = $genres;
        $inventoryItems = factory(InventoryItem::class, 3)->create();
        $this->inventoryItems = $inventoryItems;
    }

    protected function tearDown(): void {
        Genre::query()->delete();
        InventoryItem::query()->delete();
        User::query()->delete();
    }

    public function testDeleteGenre() {
        $genreToDelete = $this->genres[3];
        $this->inventoryItems[1]->genres()->save($genreToDelete);

        // Check genre item relationship creation
        $this->assertDatabaseHas('genre_inventory_item', [
            'genre_id' => $genreToDelete->id,
            'inventory_item_id' => $this->inventoryItems[1]->id
        ]);

        // Go to the edit inventory page and delete the genre
        $this->browse(function (Browser $browser) use ($genreToDelete) {
            $browser->loginAs($this->admin)
                ->visit(new HomePage)
                ->navigateTo(PagesFromHomeEnum::EDIT_INVENTORY)
                ->on(new EditInventoryPage)
                ->waitForPageLoaded()
                ->whenGenreDeletionModalAvailable($genreToDelete->id, function (Browser $modal) {
                    $modal->click('@genreDeletionConfirmationButton');
                })
                ->waitForReload()
                ->assertPathIs('/');
        });

        // Check the record update to the database
        $this->assertDatabaseMissing('genres', [
            'id' => $genreToDelete->id
        ]);

        // Check genre deletion cascade
        $this->assertDatabaseMissing('genre_inventory_item', [
            'genre_id' => $genreToDelete->id
        ]);
    }
}
