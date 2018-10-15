<?php

namespace Tests\Browser\Unit;

use App\InventoryItem;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\ViewInventoryPage;
use Tests\DuskTestCase;

class ViewInventoryPageTest extends DuskTestCase
{
    public function testInventoryItemsPresence() {
        $inventoryItems = factory(InventoryItem::class, 3)->create();

        $this->browse(function (Browser $browser) use ($inventoryItems) {
            $browser->visit(new ViewInventoryPage());

            foreach ($inventoryItems as $inventoryItem) {
                $browser->assertPresent('#inventory-item-' . $inventoryItem->id);
            }
        });

        foreach ($inventoryItems as $inventoryItem) {
            foreach ($inventoryItem->genres()->get() as $genre) $genre->delete();
            $inventoryItem->delete();
        }
    }

    public function testInventoryItemDescriptionPresence() {
        $inventoryItem = factory(InventoryItem::class)->create();

        $this->browse(function (Browser $browser) use ($inventoryItem) {
            $inventoryItemDivSelector = '#inventory-item-' . $inventoryItem->id;
            $browser->visit(new ViewInventoryPage())
                ->assertSeeIn($inventoryItemDivSelector, $inventoryItem->duration_min)
                ->assertSeeIn($inventoryItemDivSelector, $inventoryItem->duration_max)
                ->assertSeeIn($inventoryItemDivSelector, $inventoryItem->players_min)
                ->assertSeeIn($inventoryItemDivSelector, $inventoryItem->players_max);
            foreach ($inventoryItem->genres()->get() as $genre) {
                $browser->assertSeeIn($inventoryItemDivSelector, $genre->name);
            }
        });

        foreach ($inventoryItem->genres()->get() as $genre) $genre->delete();
        $inventoryItem->delete();
    }

    public function testGenreFiltering() {
        $inventoryItems = factory(InventoryItem::class, 2)->create();

        $this->browse(function (Browser $browser) use ($inventoryItems) {
            $genreToSelect = $inventoryItems[0]->genres()->get()[0];
            $browser->visit(new ViewInventoryPage())
                ->select('@genreSelect', $genreToSelect->id)
                ->assertPresent('#inventory-item-' . $inventoryItems[0]->id)
                ->assertMissing('#inventory-item-' . $inventoryItems[1]->id);
        });

        foreach ($inventoryItems as $inventoryItem) {
            foreach ($inventoryItem->genres()->get() as $genre) $genre->delete();
            $inventoryItem->delete();
        }
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
                '#inventory-item-' . $inventoryItems[0]->id,
                '#inventory-item-' . $inventoryItems[1]->id
            ];
            $browser->visit(new ViewInventoryPage())
                ->type('@durationInput', 20)
                ->assertPresent($inventoryItemDivSelectors[0])
                ->assertPresent($inventoryItemDivSelectors[1])
                ->type('@durationInput', 25)
                ->assertPresent($inventoryItemDivSelectors[0])
                ->assertMissing($inventoryItemDivSelectors[1])
                ->type('@durationInput', 35)
                ->assertMissing($inventoryItemDivSelectors[0])
                ->assertMissing($inventoryItemDivSelectors[1]);
        });


        foreach ($inventoryItems as $inventoryItem) {
            foreach ($inventoryItem->genres()->get() as $genre) $genre->delete();
            $inventoryItem->delete();
        }
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
                '#inventory-item-' . $inventoryItems[0]->id,
                '#inventory-item-' . $inventoryItems[1]->id
            ];
            $browser->visit(new ViewInventoryPage())
                ->type('@playersInput', 5)
                ->assertPresent($inventoryItemDivSelectors[0])
                ->assertPresent($inventoryItemDivSelectors[1])
                ->type('@playersInput', 3)
                ->assertPresent($inventoryItemDivSelectors[0])
                ->assertMissing($inventoryItemDivSelectors[1])
                ->type('@playersInput', 30)
                ->assertMissing($inventoryItemDivSelectors[0])
                ->assertMissing($inventoryItemDivSelectors[1]);
        });

        foreach ($inventoryItems as $inventoryItem) {
            foreach ($inventoryItem->genres()->get() as $genre) $genre->delete();
            $inventoryItem->delete();
        }
    }
}
