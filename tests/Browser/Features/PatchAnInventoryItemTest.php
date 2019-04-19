<?php

namespace Tests\Browser;

use App\Genre;
use App\InventoryItem;
use App\InventoryItemStatus;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\EditInventoryPage;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\PagesFromHomeEnum;
use Tests\DuskTestCase;

class PatchAnInventoryItemTest extends DuskTestCase
{
    use WithFaker;

    private $admin;
    private $inventoryItems;
    private $additionalGenres;

    protected function setUp() {
        Parent::setUp();
        $this->faker->seed(0);
        $inventoryItems = factory(InventoryItem::class, 10)->create();
        $this->inventoryItems = $inventoryItems;
        $additionalGenres = factory(Genre::class, 5)->create();
        $this->additionalGenres = $additionalGenres;
        $admin = factory(User::class)->state('admin')->create();
        $this->admin = $admin;
    }

    protected function tearDown() {
        $this->admin->delete();
        foreach ($this->inventoryItems as $inventoryItem) {
            foreach ($inventoryItem->genres()->get() as $genre) $genre->delete();
            $inventoryItem->delete();
        }
        foreach ($this->additionalGenres as $genre) $genre->delete();
    }

    public function testPatchInventoryItem() {
        // Defining values to use to patch the inventory item
        $inventoryItemToEdit = $this->inventoryItems[3];
        $inventoryItemToEditGenres = $inventoryItemToEdit->genres()->get();
        $inventoryItemToEditID = $inventoryItemToEdit->id;
        $fieldsValues = (object) [];
        $fieldsValues->frenchName = $this->faker->unique()->word;
        $fieldsValues->englishName = $this->faker->unique()->word;
        $fieldsValues->genresToAdd = [$this->additionalGenres[3], $this->additionalGenres[0]];
        $fieldsValues->genresToRemove = [$inventoryItemToEditGenres[0], $inventoryItemToEditGenres[2]];
        $fieldsValues->durationMin = $inventoryItemToEdit->duration_min + 5;
        $fieldsValues->durationMax = $inventoryItemToEdit->duration_max + 15;
        $fieldsValues->playersMin = $inventoryItemToEdit->players_min + 1;
        $fieldsValues->playersMax = $inventoryItemToEdit->players_max + 3;

        // Go to the edit inventory page and patch the inventory item
        $this->browse(function (Browser $browser) use ($fieldsValues, $inventoryItemToEditID) {
            $browser->loginAs($this->admin)
                ->visit(new HomePage())
                ->navigateTo(PagesFromHomeEnum::EDIT_INVENTORY)
                ->on(new EditInventoryPage())
                ->type("#nameFr-{$inventoryItemToEditID}", $fieldsValues->frenchName)
                ->type("#nameEn-{$inventoryItemToEditID}", $fieldsValues->englishName)
                ->type("#durationMin-{$inventoryItemToEditID}", $fieldsValues->durationMin)
                ->type("#durationMax-{$inventoryItemToEditID}", $fieldsValues->durationMax)
                ->type("#playersMin-{$inventoryItemToEditID}", $fieldsValues->playersMin)
                ->type("#playersMax-{$inventoryItemToEditID}", $fieldsValues->playersMax);
            foreach ($fieldsValues->genresToAdd as $genreToAdd) $browser->select("#add-genre-select-{$inventoryItemToEditID}", $genreToAdd->id);
            foreach ($fieldsValues->genresToRemove as $genreToRemove) $browser->pressOnRemoveGenreButton($inventoryItemToEditID, $genreToRemove->id);
            $browser->pressOnPatchItemButton($inventoryItemToEditID)
                ->waitForReload()
                ->assertPathIs('/edit-inventory');
        });

        // Format the data identifying the record
        $newItemIdentifiers = [
            'id' => $inventoryItemToEditID,
            'name_fr' => $fieldsValues->frenchName,
            'name_en' => $fieldsValues->englishName,
            'duration_min' => $fieldsValues->durationMin,
            'duration_max' => $fieldsValues->durationMax,
            'players_min' => $fieldsValues->playersMin,
            'players_max' => $fieldsValues->playersMax,
            'status_id' => InventoryItemStatus::IN_LCR_D4
        ];

        // Check the new record modification in the database
        $this->assertDatabaseHas('inventory_items', $newItemIdentifiers);

        // Check the genres relationships in the pivot table
        foreach($fieldsValues->genresToAdd as $genre) {
            $this->assertDatabaseHas('genre_inventory_item', [
                'inventory_item_id' => $inventoryItemToEditID,
                'genre_id' => $genre->id
            ]);
        }
        foreach($fieldsValues->genresToRemove as $genre) {
            $this->assertDatabaseMissing('genre_inventory_item', [
                'inventory_item_id' => $inventoryItemToEditID,
                'genre_id' => $genre->id
            ]);
            $genre->delete(); //clean up database
        }
    }
}
