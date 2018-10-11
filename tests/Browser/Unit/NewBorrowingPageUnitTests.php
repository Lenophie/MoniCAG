<?php

namespace Tests\Browser;

use App\InventoryItem;
use App\User;
use Illuminate\Support\Facades\App;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\NewBorrowingPage;
use Tests\DuskTestCase;

class NewBorrowingPageUnitTests extends DuskTestCase
{
    public $lender;

    protected function setUp() {
        Parent::setUp();
        $lender = factory(User::class)->state('lender')->create();
        $this->lender = $lender;
    }

    public function testInventoryItemsPresence() {
        $inventoryItems = factory(InventoryItem::class, 3)->create();

        $this->browse(function (Browser $browser) use ($inventoryItems) {
            $browser->loginAs($this->lender)
                ->visit(new NewBorrowingPage());

            foreach ($inventoryItems as $inventoryItem) {
                $browser->assertPresent('#inventory-item-button-' . $inventoryItem->id);
            }
        });
    }

    public function testIncrementationCheckoutCounter()
    {
        $inventoryItems = factory(InventoryItem::class, 2)->create();

        $this->browse(function (Browser $browser) use ($inventoryItems) {
            $browser->loginAs($this->lender)
                ->visit(new NewBorrowingPage())
                ->assertSeeIn('@checkoutCounter', 0)
                ->clickOnInventoryItemButton($inventoryItems[0]->id)
                ->assertSeeIn('@checkoutCounter', 1)
                ->clickOnInventoryItemButton($inventoryItems[1]->id)
                ->assertSeeIn('@checkoutCounter', 2);
        });
    }

    public function testInventoryItemAdditionToCheckoutModal()
    {
        $inventoryItems = factory(InventoryItem::class, 2)->create();

        $this->browse(function (Browser $browser) use ($inventoryItems) {
            $browser->loginAs($this->lender)
                ->visit(new NewBorrowingPage())
                ->clickOnInventoryItemButton($inventoryItems[0]->id)
                ->assertSeeIn('@checkoutCounter', 1)
                ->click('@checkoutLink')
                ->whenAvailable('@newBorrowingModal', function ($modal) use ($inventoryItems) {
                    $modal->waitForInventoryItemInBorrowingList($inventoryItems[0]->id)
                        ->assertSee($inventoryItems[0]->{'name_' . App::getLocale()});
                });
        });
    }

    public function testInventoryItemRemovalFromCheckoutModalThroughModal()
    {
        $inventoryItems = factory(InventoryItem::class, 2)->create();

        $this->browse(function (Browser $browser) use ($inventoryItems) {
            $browser->loginAs($this->lender)
                ->visit(new NewBorrowingPage())
                ->clickOnInventoryItemButton($inventoryItems[0]->id)
                ->click('@checkoutLink')
                ->whenAvailable('@newBorrowingModal', function ($modal) use ($inventoryItems) {
                    $modal->waitForInventoryItemInBorrowingList($inventoryItems[0]->id)
                        ->clickOnInventoryItemRemovalFromBorrowingButton($inventoryItems[0]->id)
                        ->pause(1000)
                        ->assertMissing('#to-borrow-list-element-' . $inventoryItems[0]->id)
                        ->click('.close');
                })
                ->assertSeeIn('@checkoutCounter', 0);
        });
    }

    public function testInventoryItemRemovalFromCheckoutModalThroughButton()
    {
        $inventoryItems = factory(InventoryItem::class, 2)->create();

        $this->browse(function (Browser $browser) use ($inventoryItems) {
            $browser->loginAs($this->lender)
                ->visit(new NewBorrowingPage())
                ->clickOnInventoryItemButton($inventoryItems[0]->id)
                ->assertSeeIn('@checkoutCounter', 1)
                ->clickOnInventoryItemButton($inventoryItems[0]->id)
                ->assertSeeIn('@checkoutCounter', 0);
        });
    }
}
