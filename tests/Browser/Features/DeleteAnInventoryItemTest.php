<?php

namespace Tests\Browser;

use App\InventoryItem;
use App\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\EditInventoryPage;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\PagesFromHomeEnum;
use Tests\DuskTestCase;

class DeleteAnInventoryItemTest extends DuskTestCase
{
    private $admin;
    private $inventoryItems;
    private $borrowedItem;
    private $genresToDeleteInTearDown;

    protected function setUp() {
        Parent::setUp();
        $inventoryItems = factory(InventoryItem::class, 10)->create();
        $this->inventoryItems = $inventoryItems;
        $borrowedItem = factory(InventoryItem::class)->state('borrowed')->create();
        $this->borrowedItem = $borrowedItem;
        $admin = factory(User::class)->state('admin')->create();
        $this->admin = $admin;
        $this->genresToDeleteInTearDown = $this->inventoryItems[3]->genres()->get();
    }

    protected function tearDown() {
        $this->admin->delete();
        foreach ($this->inventoryItems as $inventoryItem) {
            foreach ($inventoryItem->genres()->get() as $genre) $genre->delete();
            $inventoryItem->delete();
        }
        foreach ($this->borrowedItem->genres()->get() as $genre) $genre->delete();
        $this->borrowedItem->delete();
        foreach ($this->genresToDeleteInTearDown as $genre) $genre->delete();
    }

    public function testDeleteInventoryItem() {
        $inventoryItemToDelete = $this->inventoryItems[3];

        // Go to the edit inventory page and delete the inventory item
        $this->browse(function (Browser $browser) use ($inventoryItemToDelete) {
            $browser->loginAs($this->admin)
                ->visit(new HomePage())
                ->navigateTo(PagesFromHomeEnum::EDIT_INVENTORY)
                ->on(new EditInventoryPage())
                ->pressOnDeleteItemButton($inventoryItemToDelete->id)
                ->whenAvailable('@deletionConfirmationModal', function($modal) use ($inventoryItemToDelete) {
                    $modal->press('#delete-confirm-button');
                })
                ->waitForReload()
                ->assertPathIs('/edit-inventory');
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
    }
}
