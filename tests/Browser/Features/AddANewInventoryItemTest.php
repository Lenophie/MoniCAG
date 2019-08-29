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

class AddANewInventoryItemTest extends DuskTestCase
{
    use WithFaker;

    private $admin;
    private $genres;

    protected function setUp(): void {
        Parent::setUp();
        $this->faker->seed(0);
        $genres = factory(Genre::class, 5)->create();
        $this->genres = $genres;
        $admin = factory(User::class)->state('admin')->create();
        $this->admin = $admin;
    }

    protected function tearDown(): void {
        $this->admin->delete();
        foreach ($this->genres as $genre) $genre->delete();
    }

    public function testAddANewInventoryItem() {
        // Defining values to use to create the new inventory item
        $fieldsValues = (object) [];
        $fieldsValues->frenchName = $this->faker->unique()->word;
        $fieldsValues->englishName = $this->faker->unique()->word;
        $fieldsValues->genres = [$this->genres[3], $this->genres[0]];
        $fieldsValues->durationMin = rand(1, 20);
        $fieldsValues->durationMax = rand($fieldsValues->durationMin, 180);
        $fieldsValues->playersMin = rand(1, 8);
        $fieldsValues->playersMax = rand($fieldsValues->playersMin, 60);

        // Go to the edit inventory page and create a new item
        $this->browse(function (Browser $browser) use ($fieldsValues) {
            $browser->loginAs($this->admin)
                ->visit(new HomePage)
                ->navigateTo(PagesFromHomeEnum::EDIT_INVENTORY)
                ->on(new EditInventoryPage)
                ->type('@newItemFrenchNameInput', $fieldsValues->frenchName)
                ->type('@newItemEnglishNameInput', $fieldsValues->englishName)
                ->type('@newItemDurationMinInput', $fieldsValues->durationMin)
                ->type('@newItemDurationMaxInput', $fieldsValues->durationMax)
                ->type('@newItemPlayersMinInput', $fieldsValues->playersMin)
                ->type('@newItemPlayersMaxInput', $fieldsValues->playersMax);
            foreach ($fieldsValues->genres as $genre) {
                $browser->select('@newItemGenreSelect', $genre->id);
            }
            $browser->press('@newItemSubmitButton')
                ->waitForReload()
                ->assertPathIs('/edit-inventory');
        });

        // Format the data identifying the new record
        $newItemIdentifiers = [
            'name_fr' => $fieldsValues->frenchName,
            'name_en' => $fieldsValues->englishName,
            'duration_min' => $fieldsValues->durationMin,
            'duration_max' => $fieldsValues->durationMax,
            'players_min' => $fieldsValues->playersMin,
            'players_max' => $fieldsValues->playersMax,
            'status_id' => InventoryItemStatus::IN_LCR_D4
        ];

        // Check the new record addition to the database
        $this->assertDatabaseHas('inventory_items', $newItemIdentifiers);

        $createdInventoryItemID = InventoryItem::where($newItemIdentifiers)->first()->id;
        foreach($fieldsValues->genres as $genre) {
            $this->assertDatabaseHas('genre_inventory_item', [
                'inventory_item_id' => $createdInventoryItemID,
                'genre_id' => $genre->id
            ]);
        }

        // Remove new item from database
        InventoryItem::find($createdInventoryItemID)->delete();
    }
}
