<?php

namespace Tests\Browser\Features;

use App\Borrowing;
use App\Genre;
use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\EditInventoryPage;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\PagesFromHomeEnum;
use Tests\DuskTestCase;

class DeleteAnInventoryItemTest extends DuskTestCase
{
    use WithFaker;

    private $admin;
    private $inventoryItems;
    private $genresToDeleteInTearDown;

    protected function setUp(): void {
        Parent::setUp();
        $this->faker->seed(0);
        $inventoryItems = factory(InventoryItem::class, 10)->create();
        $this->inventoryItems = $inventoryItems;
        $admin = factory(User::class)->state('admin')->create();
        $this->admin = $admin;
    }

    protected function tearDown(): void {
        User::query()->delete();
        Borrowing::query()->delete();
        InventoryItem::query()->delete();
        Genre::query()->delete();
    }

    public function testDeleteInventoryItem() {
        $inventoryItemToDelete = $this->inventoryItems[3];

        // Go to the edit inventory page and delete the inventory item
        $this->browse(function (Browser $browser) use ($inventoryItemToDelete) {
            $browser->loginAs($this->admin)
                ->visit(new HomePage)
                ->navigateTo(PagesFromHomeEnum::EDIT_INVENTORY)
                ->on(new EditInventoryPage)
                ->waitForPageLoaded()
                ->whenItemDeletionModalAvailable($inventoryItemToDelete->id, function (Browser $modal) {
                    $modal->click('@itemDeletionConfirmationButton');
                })
                ->waitForReload()
                ->assertPathIs('/');
        });

        // Check the record deletion from the database
        $this->assertDatabaseMissing('inventory_items', ['id' => $inventoryItemToDelete->id]);

        // Check the genres relationships deletion in the pivot table
        foreach($inventoryItemToDelete->genres()->get() as $genre) {
            $this->assertDatabaseMissing('genre_inventory_item', [
                'inventory_item_id' => $inventoryItemToDelete->id,
                'genre_id' => $genre->id
            ]);
        }

        // Check the alt names relationships deletion
        foreach($inventoryItemToDelete->altNames()->get() as $altName) {
            $this->assertDatabaseMissing('inventory_item_alt_names', [
                'inventory_item_id' => $inventoryItemToDelete->id,
                'name' => $altName->name
            ]);
        }
    }
}
