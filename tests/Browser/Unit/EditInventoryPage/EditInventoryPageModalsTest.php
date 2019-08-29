<?php

namespace Tests\Browser\Unit;

use App\Borrowing;
use App\Genre;
use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\EditInventoryPage;
use Tests\DuskTestCase;

class EditInventoryPageModalsTest extends DuskTestCase
{
    use WithFaker;

    private $admin;
    private $inventoryItems;
    private $additionalGenres;

    protected function setUp(): void {
        Parent::setUp();
        $this->faker->seed(0);
        $admin = factory(User::class)->state('admin')->create();
        $this->admin = $admin;
        $inventoryItems = factory(InventoryItem::class, 2)->create();
        $this->inventoryItems = $inventoryItems;
        $additionalGenres = factory(Genre::class, 5)->create();
        $this->additionalGenres = $additionalGenres;
    }

    protected function tearDown(): void {
        User::query()->delete();
        InventoryItem::query()->delete();
        Genre::query()->delete();
        Borrowing::query()->delete();
    }

    public function testInventoryItemCreationModalOpening() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage)
                ->waitForPageLoaded();

            $browser->click('@itemCreationButton')
                ->whenAvailable('@itemCreationModal', function(Browser $modal) {
                    $modal->assertSee(__("messages.edit_inventory.add_item"));
                });
        });
    }

    public function testGenreCreationModalOpening() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage)
                ->waitForPageLoaded();

            $browser->click('@genreCreationButton')
                ->whenAvailable('@genreCreationModal', function(Browser $modal) {
                    $modal->assertSee(__("messages.edit_inventory.add_genre"));
                });
        });
    }

    public function testInventoryItemUpdateModalOpening() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage)
                ->waitForPageLoaded();

            $browser->click('@itemCollapseLink')
                ->whenAvailable('@itemsList', function(Browser $list) {
                    $list->clickOnItemButton($this->inventoryItems[0]->id);
                })->whenAvailable('@itemUpdateModal', function(Browser $modal) {
                    $modal->assertSee(__("messages.edit_inventory.edit_item"));
                });
        });
    }

    public function testGenreUpdateModalOpening() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage)
                ->waitForPageLoaded();

            $browser->click('@genreCollapseLink')
                ->whenAvailable('@genresList', function(Browser $list) {
                    $list->clickOnGenreButton($this->additionalGenres[0]->id);
                })->whenAvailable('@genreUpdateModal', function(Browser $modal) {
                    $modal->assertSee(__("messages.edit_inventory.edit_genre"));
                });
        });
    }

    public function testInventoryItemDeleteModalOpening() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage)
                ->waitForPageLoaded();

            $browser->click('@itemCollapseLink')
                ->whenAvailable('@itemsList', function(Browser $list) {
                    $list->clickOnItemDeletionButton($this->inventoryItems[0]->id);
                })->whenAvailable('@itemDeletionModal', function(Browser $modal) {
                    $modal->assertSee(__("messages.edit_inventory.delete_item"));
                });
        });
    }

    public function testGenreDeleteModalOpening() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage)
                ->waitForPageLoaded();

            $browser->click('@genreCollapseLink')
                ->whenAvailable('@genresList', function(Browser $list) {
                    $list->clickOnGenreDeletionButton($this->additionalGenres[0]->id);
                })->whenAvailable('@genreDeletionModal', function(Browser $modal) {
                    $modal->assertSee(__("messages.edit_inventory.delete_genre"));
                });
        });
    }
}
