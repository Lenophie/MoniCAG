<?php

namespace Tests\Browser\Features;

use App\Borrowing;
use App\Genre;
use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\NewBorrowingPage;
use Tests\DuskTestCase;

class NewBorrowingPageTest extends DuskTestCase
{
    use WithFaker;

    private $lender;
    private $inventoryItems;

    protected function setUp(): void {
        Parent::setUp();
        $this->faker->seed(0);
        $lender = factory(User::class)->state('lender')->create();
        $this->lender = $lender;
        $inventoryItems = factory(InventoryItem::class, 2)->create();
        $this->inventoryItems = $inventoryItems;
    }

    protected function tearDown(): void {
        User::query()->delete();
        Borrowing::query()->delete();
        InventoryItem::query()->delete();
        Genre::query()->delete();
    }

    public function testInventoryItemsPresence() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->lender)
                ->visit(new NewBorrowingPage)
                ->waitForPageLoaded($browser);

            foreach ($this->inventoryItems as $inventoryItem) {
                $browser->assertPresent("#inventory-item-card-button-{$inventoryItem->id}");
            }
        });
    }

    public function testIncrementationCheckoutCounter()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->lender)
                ->visit(new NewBorrowingPage)
                ->waitForPageLoaded()
                ->assertSeeIn('@checkoutCounter', 0)
                ->clickOnInventoryItemButton($this->inventoryItems[0]->id)
                ->assertSeeIn('@checkoutCounter', 1)
                ->clickOnInventoryItemButton($this->inventoryItems[1]->id)
                ->assertSeeIn('@checkoutCounter', 2);
        });
    }

    public function testInventoryItemAdditionToCheckoutModal()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->lender)
                ->visit(new NewBorrowingPage)
                ->waitForPageLoaded($browser)
                ->clickOnInventoryItemButton($this->inventoryItems[0]->id)
                ->assertSeeIn('@checkoutCounter', 1)
                ->openNewBorrowingModal($browser)
                ->whenAvailable('@newBorrowingModal', function ($modal){
                    $modal->waitForInventoryItemInBorrowingList($this->inventoryItems[0]->id)
                        ->assertSee($this->inventoryItems[0]->name);
                });
        });
    }

    public function testInventoryItemRemovalFromCheckoutModalThroughModal()
    {
        $id = $this->inventoryItems[0]->id;
        $this->browse(function (Browser $browser) use ($id) {
            $browser->loginAs($this->lender)
                ->visit(new NewBorrowingPage)
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
    }

    public function testInventoryItemRemovalFromCheckoutModalThroughButton()
    {
        $id = $this->inventoryItems[0]->id;
        $this->browse(function (Browser $browser) use ($id) {
            $browser->loginAs($this->lender)
                ->visit(new NewBorrowingPage)
                ->waitForPageLoaded($browser)
                ->clickOnInventoryItemButton($id)
                ->assertSeeIn('@checkoutCounter', 1)
                ->clickOnInventoryItemButton($id)
                ->assertSeeIn('@checkoutCounter', 0);
        });
    }
}
