<?php

namespace Tests\Browser\Unit;

use App\Borrowing;
use App\Genre;
use App\InventoryItem;
use App\InventoryItemStatus;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\EditInventoryPage;
use Tests\DuskTestCase;

class EditInventoryPageDataPresenceTest extends DuskTestCase
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
        User::query()->delete();
        InventoryItem::query()->delete();
        Genre::query()->delete();
        Borrowing::query()->delete();
    }

    public function testInventoryItemsPresence() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage)
                ->waitForPageLoaded();

            $browser->click('@itemCollapseLink')
                ->whenAvailable('@itemsList', function($list) {
                    foreach ($this->inventoryItems as $inventoryItem) {
                        $list->assertSee($inventoryItem->name);
                    }
                });
        });
    }

    public function testGenresPresence() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage)
                ->waitForPageLoaded();

            $browser->click('@genreCollapseLink')
                ->whenAvailable('@genresList', function($list) {
                    foreach ($this->additionalGenres as $genre) {
                        $list->assertSee($genre->{'name_' . App::getLocale()});
                    }
                });
        });
    }

    public function testInventoryItemsDetailsPresence() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage)
                ->waitForPageLoaded();

            $inventoryItem = $this->inventoryItems[0];
            $browser->whenItemUpdateModalAvailable($inventoryItem->id, function(Browser $modal) use ($inventoryItem) {
                // Check main inputs
                $modal->assertInputValue('name', $inventoryItem->name)
                    ->assertInputValue('durationMin', $inventoryItem->duration_min)
                    ->assertInputValue('durationMax', $inventoryItem->duration_max)
                    ->assertInputValue('playersMin', $inventoryItem->players_min)
                    ->assertInputValue('playersMax', $inventoryItem->players_max);

                // Check genres
                $inventoryItemGenres = $inventoryItem->genres()->get();
                foreach ($inventoryItemGenres as $genre) {
                    $modal->assertChecked("genre-{$genre->id}");
                }
                foreach ($this->additionalGenres as $genre) {
                    $modal->assertNotChecked("genre-{$genre->id}");
                }

                // Check alt names
                $inventoryItemAltNames = $inventoryItem->altNames()->get();
                foreach ($inventoryItemAltNames as $altName) {
                    $modal->assertSee($altName->name);
                }

                // Check status
                $modal->assertSelected('status', $inventoryItem->status()->first()->id);
            });
        });
    }

    public function testGenresDetailsPresence() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage)
                ->waitForPageLoaded();

            $genre = $this->additionalGenres[0];
            $browser->whenGenreUpdateModalAvailable($genre->id, function(Browser $modal) use ($genre) {
                // Check main inputs
                $modal->assertInputValue('nameFr', $genre->name_fr)
                    ->assertInputValue('nameEn', $genre->name_en);
            });
        });
    }

    public function testBorrowedStatusOptionDisabled() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage)
                ->waitForPageLoaded();

            $inventoryItem = $this->inventoryItems[0];
            $browser->whenItemUpdateModalAvailable($inventoryItem->id, function(Browser $modal) {
                $modal->assertDisabled("#status-select option[value='" . InventoryItemStatus::BORROWED . "']");
            });
        });
    }

    public function testOtherStatusOptionsDisabledForBorrowedItem() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new EditInventoryPage)
                ->waitForPageLoaded();

            $browser->whenItemUpdateModalAvailable($this->borrowedInventoryItem->id, function(Browser $modal) {
                $modal->assertEnabled("#status-select option[value='" . InventoryItemStatus::BORROWED . "']")
                    ->assertDisabled("#status-select option[value='" . InventoryItemStatus::IN_LCR_D4 . "']")
                    ->assertDisabled("#status-select option[value='" . InventoryItemStatus::IN_F2 . "']")
                    ->assertDisabled("#status-select option[value='" . InventoryItemStatus::LOST . "']")
                    ->assertDisabled("#status-select option[value='" . InventoryItemStatus::UNKNOWN . "']");
            });
        });
    }
}
