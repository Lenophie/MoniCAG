<?php

namespace Tests\Browser\Unit;

use App\Genre;
use App\InventoryItem;
use App\InventoryItemStatus;
use App\User;
use Illuminate\Support\Facades\App;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\EditInventoryPage;
use Tests\DuskTestCase;

class EditInventoryPageTest extends DuskTestCase
{
    private $admin;
    private $inventoryItems;
    private $additionalGenres;

    protected function setUp() {
        Parent::setUp();
        $admin = factory(User::class)->state('admin')->create();
        $this->admin = $admin;
        $inventoryItems = factory(InventoryItem::class, 2)->create();
        $this->inventoryItems = $inventoryItems;
        $additionalGenres = factory(Genre::class, 5)->create();
        $this->additionalGenres = $additionalGenres;
    }

    protected function tearDown() {
        foreach ($this->inventoryItems as $inventoryItem) {
            foreach ($inventoryItem->genres()->get() as $genre) $genre->delete();
            $inventoryItem->delete();
        }
        $this->admin->delete();
        foreach ($this->additionalGenres as $genre) $genre->delete();
    }

    public function testInventoryItemsPresence() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage());

            foreach ($this->inventoryItems as $inventoryItem) {
                $browser->assertPresent("#modify-item-{$inventoryItem->id}");
            }
        });
    }

    public function testInventoryItemsDetailsPresence() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage());

            foreach ($this->inventoryItems as $inventoryItem) {
                $browser->assertInputValue("#nameFr-{$inventoryItem->id}", $inventoryItem->name_fr)
                    ->assertInputValue("#nameEn-{$inventoryItem->id}", $inventoryItem->name_en)
                    ->assertInputValue("#durationMin-{$inventoryItem->id}", $inventoryItem->duration_min)
                    ->assertInputValue("#durationMax-{$inventoryItem->id}", $inventoryItem->duration_max)
                    ->assertInputValue("#playersMin-{$inventoryItem->id}", $inventoryItem->players_min)
                    ->assertInputValue("#playersMax-{$inventoryItem->id}", $inventoryItem->players_max);
                foreach ($inventoryItem->genres()->get() as $genre) {
                    $liElement = "#genre-{$genre->id}-for-{$inventoryItem->id}-li";
                    $browser->assertPresent($liElement)
                        ->assertSeeIn($liElement, $genre->name);
                }
            }
        });
    }

    public function testGenreAdditionToNewInventoryItem() {
        $genreToAdd = $this->additionalGenres[1];
        $this->browse(function (Browser $browser) use ($genreToAdd) {
            $liElement = "#genre-{$genreToAdd->id}-for-new-li";
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage())
                ->assertMissing($liElement)
                ->select('@newItemGenreSelect', $genreToAdd->id)
                ->assertPresent($liElement)
                ->assertSeeIn($liElement, $genreToAdd->{'name_' . App::getLocale()});
        });
    }

    public function testGenreAdditionToNewInventoryItemAfterGenresError() {
        $genreToAdd = $this->additionalGenres[1];
        $this->browse(function (Browser $browser) use ($genreToAdd) {
            $liElement = "#genre-{$genreToAdd->id}-for-new-li";
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage())
                ->press('@newItemSubmitButton')
                ->pause(500)
                ->select('@newItemGenreSelect', $genreToAdd->id)
                ->assertPresent($liElement)
                ->assertSeeIn($liElement, $genreToAdd->{'name_' . App::getLocale()});
        });
    }

    public function testGenreAdditionToExistingInventoryItem() {
        $genreToAdd = $this->additionalGenres[1];
        $inventoryItemToPatch = $this->inventoryItems[1];
        $this->browse(function (Browser $browser) use ($genreToAdd, $inventoryItemToPatch) {
            $liElement = "#genre-{$genreToAdd->id}-for-{$inventoryItemToPatch->id}-li";
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage())
                ->assertMissing($liElement)
                ->select("#add-genre-select-{$inventoryItemToPatch->id}", $genreToAdd->id)
                ->assertPresent($liElement)
                ->assertSeeIn($liElement, $genreToAdd->{'name_' . App::getLocale()});
        });
    }

    public function testGenreAdditionToExistingInventoryItemAfterGenresError() {
        $genreToAdd = $this->additionalGenres[1];
        $inventoryItemToPatch = $this->inventoryItems[1];
        $this->browse(function (Browser $browser) use ($genreToAdd, $inventoryItemToPatch) {
            $liElement = "#genre-{$genreToAdd->id}-for-{$inventoryItemToPatch->id}-li";
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage());
            foreach ($inventoryItemToPatch->genres()->get() as $genre) {
                $browser->pressOnRemoveGenreButton($inventoryItemToPatch->id, $genre->id);
            }
            $browser->pressOnPatchItemButton($inventoryItemToPatch->id)
                ->pause(500)
                ->select("#add-genre-select-{$inventoryItemToPatch->id}", $genreToAdd->id)
                ->assertPresent($liElement)
                ->assertSeeIn($liElement, $genreToAdd->{'name_' . App::getLocale()});
        });
    }

    public function testGenreRemovalFromNewInventoryItem() {
        $genreToAddAndRemove = $this->additionalGenres[1];
        $this->browse(function (Browser $browser) use ($genreToAddAndRemove) {
            $liElement = "#genre-{$genreToAddAndRemove->id}-for-new-li";
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage())
                ->select('@newItemGenreSelect', $genreToAddAndRemove->id)
                ->pressOnRemoveGenreButton('new', $genreToAddAndRemove->id)
                ->assertMissing($liElement);
        });
    }

    public function testGenreRemovalFromExistingInventoryItem() {
        $inventoryItemToPatch = $this->inventoryItems[1];
        $genreToRemove = $inventoryItemToPatch->genres()->get()[1];
        $this->browse(function (Browser $browser) use ($genreToRemove, $inventoryItemToPatch) {
            $liElement = "#genre-{$genreToRemove->id}-for-{$inventoryItemToPatch->id}-li";
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage())
                ->select("#add-genre-select-{$inventoryItemToPatch->id}", $genreToRemove->id)
                ->pressOnRemoveGenreButton($inventoryItemToPatch->id, $genreToRemove->id)
                ->assertMissing($liElement);
        });
    }

    public function testExistingItemGenresOptionsDisabled() {
        $inventoryItemToPatch = $this->inventoryItems[1];
        $this->browse(function (Browser $browser) use ($inventoryItemToPatch) {
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage());
            foreach ($inventoryItemToPatch->genres()->get() as $genre) $browser->assertDisabled("#add-genre-{$genre->id}-to-{$inventoryItemToPatch->id}-option");
        });
    }

    public function testGenresOptionsDisablingOnSelection() {
        $inventoryItemToPatch = $this->inventoryItems[1];
        $genreToAdd = $this->additionalGenres[1];
        $this->browse(function (Browser $browser) use ($inventoryItemToPatch, $genreToAdd) {
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage())
                ->select("#add-genre-select-{$inventoryItemToPatch->id}", $genreToAdd->id)
                ->assertDisabled("#add-genre-{$genreToAdd->id}-to-{$inventoryItemToPatch->id}-option")
                ->select("@newItemGenreSelect", $genreToAdd->id)
                ->assertDisabled("#add-genre-{$genreToAdd->id}-to-new-option");
        });
    }

    public function testGenresOptionsEnablingAfterRemoval() {
        $inventoryItemToPatch = $this->inventoryItems[1];
        $genreToAddAndRemoveToNewItem = $this->additionalGenres[1];
        $this->browse(function (Browser $browser) use ($inventoryItemToPatch, $genreToAddAndRemoveToNewItem) {
            $genreToRemoveFromPatchedItem = $inventoryItemToPatch->genres()->get()[1];
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage())
                ->pressOnRemoveGenreButton($inventoryItemToPatch->id, $genreToRemoveFromPatchedItem->id)
                ->assertEnabled("#add-genre-{$genreToRemoveFromPatchedItem->id}-to-{$inventoryItemToPatch->id}-option")
                ->select('@newItemGenreSelect', $genreToAddAndRemoveToNewItem->id)
                ->pressOnRemoveGenreButton('new', $genreToAddAndRemoveToNewItem->id)
                ->assertEnabled("#add-genre-{$genreToAddAndRemoveToNewItem->id}-to-new-option");
        });
    }

    public function testBorrowedStatusOptionDisabled() {
        $inventoryItemToPatch = $this->inventoryItems[1];
        $this->browse(function (Browser $browser) use ($inventoryItemToPatch) {
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage())
                ->assertDisabled("#status-{$inventoryItemToPatch->id} option[value='" . InventoryItemStatus::BORROWED . "']");
        });
    }

    public function testOtherStatusOptionsDisabledForBorrowedItem() {
        $inventoryItemToPatch = factory(InventoryItem::class)->state('borrowed')->create();
        $this->browse(function (Browser $browser) use ($inventoryItemToPatch) {
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage())
                ->assertEnabled("#status-{$inventoryItemToPatch->id} option[value='" . InventoryItemStatus::BORROWED . "']")
                ->assertDisabled("#status-{$inventoryItemToPatch->id} option[value='" . InventoryItemStatus::IN_LCR_D4 . "']")
                ->assertDisabled("#status-{$inventoryItemToPatch->id} option[value='" . InventoryItemStatus::IN_F2 . "']")
                ->assertDisabled("#status-{$inventoryItemToPatch->id} option[value='" . InventoryItemStatus::LOST . "']")
                ->assertDisabled("#status-{$inventoryItemToPatch->id} option[value='" . InventoryItemStatus::UNKNOWN . "']");
        });

        //clean up database
        foreach ($inventoryItemToPatch->genres()->get() as $genre) $genre->delete();
        $inventoryItemToPatch->delete();
    }

    public function testCorrectItemBeingDeletedWhenOpeningSeveralModals() {
        $this->browse(function (Browser $browser) {
           $browser->loginAs($this->admin)
               ->visit(new EditInventoryPage())
               ->pressOnDeleteItemButton($this->inventoryItems[0]->id)
               ->whenAvailable('@deletionConfirmationModal', function($modal) {
                   $modal->press("header a:first-of-type");
               })
               ->pressOnDeleteItemButton($this->inventoryItems[1]->id)
               ->whenAvailable('@deletionConfirmationModal', function($modal) {
                   $modal->press("#delete-confirm-button");
               })
               ->waitForReload();
        });

        // Check the record deletion from the database
        $this->assertDatabaseMissing('inventory_items', ['id' => $this->inventoryItems[1]->id]);

        // Check the other record presence
        $this->assertDatabaseHas('inventory_items', ['id' => $this->inventoryItems[0]->id]);

    }
}
