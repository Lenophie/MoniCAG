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

    protected function setUp() {
        Parent::setUp();
        $lender = factory(User::class)->state('lender')->create();
        $this->lender = $lender;
        $inventoryItems = factory(InventoryItem::class, 2)->create();
        $this->inventoryItems = $inventoryItems;
    }

    protected function tearDown() {
        foreach ($this->inventoryItems as $inventoryItem) {
            foreach ($inventoryItem->genres()->get() as $genre) $genre->delete();
            $inventoryItem->delete();
        }
        $this->lender->delete();
    }

    public function testInventoryItemsPresence() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->lender)
                ->visit(new NewBorrowingPage());

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
                ->clickOnInventoryItemButton($this->inventoryItems[0]->id)
                ->assertSeeIn('@checkoutCounter', 1)
                ->click('@checkoutLink')
                ->whenAvailable('@newBorrowingModal', function ($modal){
                    $modal->waitForInventoryItemInBorrowingList($this->inventoryItems[0]->id)
                        ->assertSee($this->inventoryItems[0]->{'name_' . App::getLocale()});
                });
        });
    }

    public function testInventoryItemRemovalFromCheckoutModalThroughModal()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->lender)
                ->visit(new NewBorrowingPage())
                ->clickOnInventoryItemButton($this->inventoryItems[0]->id)
                ->click('@checkoutLink')
                ->whenAvailable('@newBorrowingModal', function ($modal) {
                    $modal->waitForInventoryItemInBorrowingList($this->inventoryItems[0]->id)
                        ->clickOnInventoryItemRemovalFromBorrowingButton($this->inventoryItems[0]->id)
                        ->pause(1000)
                        ->assertMissing("#to-borrow-list-element-{$this->inventoryItems[0]->id}")
                        ->click('.close');
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
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->lender)
                ->visit(new NewBorrowingPage())
                ->clickOnInventoryItemButton($this->inventoryItems[0]->id)
                ->assertSeeIn('@checkoutCounter', 1)
                ->clickOnInventoryItemButton($this->inventoryItems[0]->id)
                ->assertSeeIn('@checkoutCounter', 0);
        });

        foreach ($this->inventoryItems as $inventoryItem) {
            foreach ($inventoryItem->genres()->get() as $genre) $genre->delete();
            $inventoryItem->delete();
        }
    }
}
