<?php

namespace Tests\Browser\Unit;

use App\Borrowing;
use App\Genre;
use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\ViewInventoryPage;
use Tests\DuskTestCase;

class ViewInventoryPageTest extends DuskTestCase
{
    use WithFaker;

    protected function setUp(): void {
        Parent::setUp();
        $this->faker->seed(0);
    }

    protected function tearDown(): void
    {
        User::query()->delete();
        Borrowing::query()->delete();
        InventoryItem::query()->delete();
        Genre::query()->delete();
    }

    public function testInventoryItemsPresence() {
        $inventoryItems = factory(InventoryItem::class, 3)->create();

        $this->browse(function (Browser $browser) use ($inventoryItems) {
            $browser->visit(new ViewInventoryPage)
                ->waitForPageLoaded();

            foreach ($inventoryItems as $inventoryItem) {
                $browser->assertPresent('#inventory-item-card-' . $inventoryItem->id);
            }
        });
    }

    public function testInventoryItemDescriptionPresence() {
        $inventoryItem = factory(InventoryItem::class)->create();

        $this->browse(function (Browser $browser) use ($inventoryItem) {
            $inventoryItemDivSelector = '#inventory-item-card-' . $inventoryItem->id;
            $browser->visit(new ViewInventoryPage)
                ->waitForPageLoaded()
                ->assertSeeIn($inventoryItemDivSelector, $inventoryItem->duration_min)
                ->assertSeeIn($inventoryItemDivSelector, $inventoryItem->duration_max)
                ->assertSeeIn($inventoryItemDivSelector, $inventoryItem->players_min)
                ->assertSeeIn($inventoryItemDivSelector, $inventoryItem->players_max);
            foreach ($inventoryItem->genres()->get() as $genre) {
                $browser->assertSeeIn($inventoryItemDivSelector, $genre->name);
            }
        });
    }

    public function testGenreFiltering() {
        $inventoryItems = factory(InventoryItem::class, 2)->create();

        $this->browse(function (Browser $browser) use ($inventoryItems) {
            $genreToSelect = $inventoryItems[0]->genres()->get()[0];
            $browser->visit(new ViewInventoryPage)
                ->waitForPageLoaded()
                ->clickOptionFromGenreDropdown($genreToSelect->id)
                ->pause(100)
                ->assertPresent("#inventory-item-card-{$inventoryItems[0]->id}")
                ->assertMissing("#inventory-item-card-{$inventoryItems[1]->id}");
        });
    }

    public function testDurationFiltering() {
        $inventoryItems = [
            factory(InventoryItem::class)->create([
                'duration_min' => 10,
                'duration_max' => 30
            ]),
            factory(InventoryItem::class)->create([
                'duration_min' => 5,
                'duration_max' => 20
            ])
        ];

        $this->browse(function (Browser $browser) use ($inventoryItems) {
            $inventoryItemDivSelectors = [
                "#inventory-item-card-{$inventoryItems[0]->id}",
                "#inventory-item-card-{$inventoryItems[1]->id}"
            ];
            $browser->visit(new ViewInventoryPage)
                ->waitForPageLoaded()
                ->type('duration', 20)
                ->pause(100)
                ->assertPresent($inventoryItemDivSelectors[0])
                ->assertPresent($inventoryItemDivSelectors[1]);

            $browser->visit(new ViewInventoryPage)
                ->waitForPageLoaded()
                ->type('duration', 25)
                ->pause(100)
                ->assertPresent($inventoryItemDivSelectors[0])
                ->assertMissing($inventoryItemDivSelectors[1]);

            $browser->visit(new ViewInventoryPage)
                ->waitForPageLoaded()
                ->type('duration', 35)
                ->pause(100)
                ->assertMissing($inventoryItemDivSelectors[0])
                ->assertMissing($inventoryItemDivSelectors[1]);
        });
    }

    public function testPlayersFiltering() {
        $inventoryItems = [
            factory(InventoryItem::class)->create([
                'players_min' => 2,
                'players_max' => 6
            ]),
            factory(InventoryItem::class)->create([
                'players_min' => 4,
                'players_max' => 20
            ])
        ];

        $this->browse(function (Browser $browser) use ($inventoryItems) {
            $inventoryItemDivSelectors = [
                "#inventory-item-card-{$inventoryItems[0]->id}",
                "#inventory-item-card-{$inventoryItems[1]->id}"
            ];
            $browser->visit(new ViewInventoryPage)
                ->waitForPageLoaded()
                ->type('players', 5)
                ->pause(100)
                ->assertPresent($inventoryItemDivSelectors[0])
                ->assertPresent($inventoryItemDivSelectors[1]);

            $browser->visit(new ViewInventoryPage)
                ->waitForPageLoaded()
                ->type('players', 3)
                ->pause(100)
                ->assertPresent($inventoryItemDivSelectors[0])
                ->assertMissing($inventoryItemDivSelectors[1]);

            $browser->visit(new ViewInventoryPage)
                ->waitForPageLoaded()
                ->type('players', 30)
                ->pause(100)
                ->assertMissing($inventoryItemDivSelectors[0])
                ->assertMissing($inventoryItemDivSelectors[1]);
        });
    }
}
