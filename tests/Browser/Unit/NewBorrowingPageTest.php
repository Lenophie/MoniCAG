<?php

namespace Tests\Browser;

use App\InventoryItem;
use App\User;
use Illuminate\Support\Facades\App;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\NewBorrowingPage;
use Tests\DuskTestCase;

class NewBorrowingPageTest extends DuskTestCase
{
    private $lender;
    private $inventoryItems;

    protected function setUp(): void {
        Parent::setUp();
        $lender = factory(User::class)->state('lender')->create();
        $this->lender = $lender;
        $inventoryItems = factory(InventoryItem::class, 2)->create();
        $this->inventoryItems = $inventoryItems;
    }

    protected function tearDown(): void {
        foreach ($this->inventoryItems as $inventoryItem) {
            foreach ($inventoryItem->genres()->get() as $genre) $genre->delete();
            $inventoryItem->delete();
        }
        $this->lender->delete();
    }

    public function testInventoryItemsPresence() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->lender)
                ->visit(new NewBorrowingPage())
                ->waitForPageLoaded($browser);

            foreach ($this->inventoryItems as $inventoryItem) {
                $browser->assertPresent("#inventory-item-button-{$inventoryItem->id}");
            }
        });
    }

    public function testIncrementationCheckoutCounter()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->lender)
                ->visit(new NewBorrowingPage())
                ->waitForPageLoaded()
                ->assertSeeIn('@checkoutCounter', 0)
                ->clickOnInventoryItemButton($this->inventoryItems[0]->id)
                ->assertSeeIn('@checkoutCounter', 1)
                ->clickOnInventoryItemButton($this->inventoryItems[1]->id)
                ->assertSeeIn('@checkoutCounter', 2);
        });

        foreach ($this->inventoryItems as $inventoryItem) {
            foreach ($inventoryItem->genres()->get() as $genre) $genre->delete();
            $inventoryItem->delete();
        }
    }

    public function testInventoryItemAdditionToCheckoutModal()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->lender)
                ->visit(new NewBorrowingPage())
                ->waitForPageLoaded($browser)
                ->clickOnInventoryItemButton($this->inventoryItems[0]->id)
                ->assertSeeIn('@checkoutCounter', 1)
                ->openNewBorrowingModal($browser)
                ->whenAvailable('@newBorrowingModal', function ($modal){
                    $modal->waitForInventoryItemInBorrowingList($this->inventoryItems[0]->id)
                        ->assertSee($this->inventoryItems[0]->{'name_' . App::getLocale()});
                });
        });
    }

    public function testInventoryItemRemovalFromCheckoutModalThroughModal()
    {
        $id = $this->inventoryItems[0]->id;
        $this->browse(function (Browser $browser) use ($id) {
            $browser->loginAs($this->lender)
                ->visit(new NewBorrowingPage())
                ->waitForPageLoaded($browser)
                ->clickOnInventoryItemButton($id)
                ->openNewBorrowingModal($browser)
                ->whenAvailable('@newBorrowingModal', function ($modal) use ($id) {
                    $modal->waitForInventoryItemInBorrowingList($id)
                        ->clickOnInventoryItemRemovalFromBorrowingButton($id)
                        ->waitUntilMissing("#to-borrow-list-element-{$id}")
                        ->assertMissing("#to-borrow-list-element-{$id}")
                        ->click('.delete');
                })
                ->assertSeeIn('@checkoutCounter', 0);
        });

        foreach ($this->inventoryItems as $inventoryItem) {
            foreach ($inventoryItem->genres()->get() as $genre) $genre->delete();
            $inventoryItem->delete();
        }
    }

    public function testInventoryItemRemovalFromCheckoutModalThroughButton()
    {
        $id = $this->inventoryItems[0]->id;
        $this->browse(function (Browser $browser) use ($id) {
            $browser->loginAs($this->lender)
                ->visit(new NewBorrowingPage())
                ->waitForPageLoaded($browser)
                ->clickOnInventoryItemButton($id)
                ->assertSeeIn('@checkoutCounter', 1)
                ->clickOnInventoryItemButton($id)
                ->assertSeeIn('@checkoutCounter', 0);
        });

        foreach ($this->inventoryItems as $inventoryItem) {
            foreach ($inventoryItem->genres()->get() as $genre) $genre->delete();
            $inventoryItem->delete();
        }
    }
}
