<?php

namespace Tests\Browser\Unit;

use App\Genre;
use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\EditInventoryPage;
use Tests\DuskTestCase;

class EditInventoryPageDataFunctionalTest extends DuskTestCase
{
    use WithFaker;

    private $admin;
    private $inventoryItems;
    private $additionalGenres;
    private $borrowedInventoryItem;

    protected function setUp(): void {
        Parent::setUp();
        $this->faker->seed(0);
        $admin = factory(User::class)->state('admin')->create();
        $this->admin = $admin;
        $inventoryItems = factory(InventoryItem::class, 2)->create();
        $this->inventoryItems = $inventoryItems;
        $additionalGenres = factory(Genre::class, 5)->create();
        $this->additionalGenres = $additionalGenres;
        $borrowedInventoryItem = factory(InventoryItem::class)->state('borrowed')->create();
        $this->borrowedInventoryItem = $borrowedInventoryItem;
    }

    protected function tearDown(): void {
        foreach ($this->inventoryItems as $inventoryItem) {
            foreach ($inventoryItem->genres()->get() as $genre) $genre->delete();
            $inventoryItem->delete();
        }
        $this->admin->delete();
        foreach ($this->additionalGenres as $genre) $genre->delete();
        foreach ($this->borrowedInventoryItem->genres()->get() as $genre) $genre->delete();
        $this->borrowedInventoryItem->delete();
    }

    public function testCorrectItemBeingDeletedWhenOpeningSeveralModals() {
        $this->browse(function (Browser $browser) {
           $browser->loginAs($this->admin)
               ->visit(new EditInventoryPage)
               ->waitForPageLoaded();

            $browser->whenItemDeletionModalAvailable($this->inventoryItems[0]->id, function(Browser $modal) {
                   $modal->press(".delete");
               });
            $browser->waitUntilMissing('@itemDeletionModal')
                ->clickOnItemDeletionButton($this->inventoryItems[1]->id);
            $browser->whenAvailable('@itemDeletionModal', function (Browser $modal) {
                $modal->click('@itemDeletionConfirmationButton');
            })
               ->waitForReload();
        });

        // Check the record deletion from the database
        $this->assertDatabaseMissing('inventory_items', ['id' => $this->inventoryItems[1]->id]);

        // Check the other record presence
        $this->assertDatabaseHas('inventory_items', ['id' => $this->inventoryItems[0]->id]);

    }

    public function testCorrectGenreBeingDeletedWhenOpeningSeveralModals() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage)
                ->waitForPageLoaded();

            $browser->whenGenreDeletionModalAvailable($this->additionalGenres[0]->id, function(Browser $modal) {
                $modal->press(".delete");
            });
            $browser->waitUntilMissing('@genreDeletionModal')
                ->clickOnGenreDeletionButton($this->additionalGenres[1]->id);
            $browser->whenAvailable('@genreDeletionModal', function (Browser $modal) {
                $modal->click('@genreDeletionConfirmationButton');
            })
                ->waitForReload();
        });

        // Check the record deletion from the database
        $this->assertDatabaseMissing('genres', ['id' => $this->additionalGenres[1]->id]);

        // Check the other record presence
        $this->assertDatabaseHas('genres', ['id' => $this->additionalGenres[0]->id]);

    }
}
