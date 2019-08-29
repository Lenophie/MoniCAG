<?php

namespace Tests\Browser\Features;

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

    protected function setUp(): void {
        Parent::setUp();
        $this->faker->seed(0);
        $inventoryItems = factory(InventoryItem::class, 10)->create();
        $this->inventoryItems = $inventoryItems;
        $additionalGenres = factory(Genre::class, 5)->create();
        $this->additionalGenres = $additionalGenres;
        $admin = factory(User::class)->state('admin')->create();
        $this->admin = $admin;
    }

    protected function tearDown(): void {
        $this->admin->delete();
        foreach ($this->inventoryItems as $inventoryItem)
            $inventoryItem->delete();
        Genre::query()->delete();
    }

    public function testPatchInventoryItem() {
        // Defining values to use to patch the inventory item
        $inventoryItemToEdit = $this->inventoryItems[3];
        $inventoryItemToEditGenres = $inventoryItemToEdit->genres()->get();
        $inventoryItemToEditAltNames = $inventoryItemToEdit->altNames()->get();

        $fieldsValues = (object) [];
        $fieldsValues->name = $this->faker->unique()->word;
        $fieldsValues->genresToAdd = [$this->additionalGenres[3]->id, $this->additionalGenres[0]->id];
        $fieldsValues->genresToRemove = [$inventoryItemToEditGenres[0]->id, $inventoryItemToEditGenres[2]->id];
        $fieldsValues->altNamesToAdd = [$this->faker->unique()->word, $this->faker->unique()->word];
        $fieldsValues->altNamesToRemove = [$inventoryItemToEditAltNames[0]->name];
        $fieldsValues->durationMin = $inventoryItemToEdit->duration_min + 5;
        $fieldsValues->durationMax = $inventoryItemToEdit->duration_max + 15;
        $fieldsValues->playersMin = $inventoryItemToEdit->players_min + 1;
        $fieldsValues->playersMax = $inventoryItemToEdit->players_max + 3;
        $fieldsValues->status = InventoryItemStatus::LOST;

        // Go to the edit inventory page and patch the inventory item
        $this->browse(function (Browser $browser) use ($fieldsValues, $inventoryItemToEdit) {
            $browser->loginAs($this->admin)
                ->visit(new HomePage)
                ->navigateTo(PagesFromHomeEnum::EDIT_INVENTORY)
                ->on(new EditInventoryPage)
                ->waitForPageLoaded()
                ->whenItemUpdateModalAvailable($inventoryItemToEdit->id, function (Browser $modal) use ($fieldsValues) {
                    $modal
                        ->type('name', $fieldsValues->name)
                        ->type('durationMin', $fieldsValues->durationMin)
                        ->type('durationMax', $fieldsValues->durationMax)
                        ->type('playersMin', $fieldsValues->playersMin)
                        ->type('playersMax', $fieldsValues->playersMax);
                    foreach ($fieldsValues->genresToAdd as $genre)
                        $modal->check("genre-{$genre}");
                    foreach ($fieldsValues->genresToRemove as $genre)
                        $modal->uncheck("genre-{$genre}");
                    foreach ($fieldsValues->altNamesToAdd as $altName) {
                        $modal->type("altName", $altName)
                            ->keys("input[name='altName']", "{enter}");
                    }
                    foreach ($fieldsValues->altNamesToRemove as $altName) {
                        $modal->clickOnRemoveAltNameTag($altName);
                    }
                    $modal->select('status', $fieldsValues->status);
                    $modal->click('@itemUpdateConfirmationButton');
                })
                ->waitForReload()
                ->assertPathIs('/');
        });

        // Format the data identifying the record
        $newItemIdentifiers = [
            'id' => $inventoryItemToEdit->id,
            'name' => $fieldsValues->name,
            'duration_min' => $fieldsValues->durationMin,
            'duration_max' => $fieldsValues->durationMax,
            'players_min' => $fieldsValues->playersMin,
            'players_max' => $fieldsValues->playersMax,
            'status_id' => $fieldsValues->status
        ];

        // Check the new record modification in the database
        $this->assertDatabaseHas('inventory_items', $newItemIdentifiers);

        // Check the genres relationships in the pivot table
        foreach($fieldsValues->genresToAdd as $genre) {
            $this->assertDatabaseHas('genre_inventory_item', [
                'inventory_item_id' => $inventoryItemToEdit->id,
                'genre_id' => $genre
            ]);
        }
        foreach($fieldsValues->genresToRemove as $genre) {
            $this->assertDatabaseMissing('genre_inventory_item', [
                'inventory_item_id' => $inventoryItemToEdit->id,
                'genre_id' => $genre
            ]);
        }

        // Check the alt names relationships
        foreach($fieldsValues->altNamesToAdd as $altName) {
            $this->assertDatabaseHas('inventory_item_alt_names', [
                'inventory_item_id' => $inventoryItemToEdit->id,
                'name' => $altName
            ]);
        }
        foreach($fieldsValues->altNamesToRemove as $altName) {
            $this->assertDatabaseMissing('inventory_item_alt_names', [
                'inventory_item_id' => $inventoryItemToEdit->id,
                'name' => $altName
            ]);
        }
    }
}
