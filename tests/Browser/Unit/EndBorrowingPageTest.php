<?php

namespace Tests\Browser\Features;

use App\Borrowing;
use App\Genre;
use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\EndBorrowingPage;
use Tests\DuskTestCase;

class EndBorrowingPageTest extends DuskTestCase
{
    use WithFaker;

    private $lender;
    private $borrowings;
    private $onTimeBorrowing;
    private $lateBorrowing;

    protected function setUp(): void {
        Parent::setUp();
        $this->faker->seed(0);

        $lender = factory(User::class)->state('lender')->create();
        $this->lender = $lender;

        $borrowings = factory(Borrowing::class, 3)->create();
        $this->borrowings = $borrowings;

        $onTimeBorrowing = factory(Borrowing::class)->state('onTime')->create();
        $lateBorrowing = factory(Borrowing::class)->state('late')->create();
        $this->onTimeBorrowing = $onTimeBorrowing;
        $this->lateBorrowing = $lateBorrowing;
    }

    protected function tearDown(): void {
        User::query()->delete();
        Borrowing::query()->delete();
        InventoryItem::query()->delete();
        Genre::query()->delete();
    }

    public function testBorrowingsPresence() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->lender)
                ->visit(new EndBorrowingPage)
                ->waitForPageLoaded();

            foreach ($this->borrowings as $borrowing) {
                $browser->assertPresent("#borrowings-list-element-{$borrowing->id}");
            }
        });
    }

    public function testLateBorrowingsWarningsPresence()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->lender)
                ->visit(new EndBorrowingPage)
                ->waitForPageLoaded()
                ->assertSeeIn("#borrowings-list-element-{$this->lateBorrowing->id}", __('messages.end_borrowing.late'))
                ->assertDontSeeIn("#borrowings-list-element-{$this->onTimeBorrowing->id}", __('messages.end_borrowing.late'));
        });
    }

    public function testBorrowingAdditionToCheckoutModal()
    {
        $borrowing = $this->borrowings[0];
        $this->browse(function (Browser $browser) use ($borrowing) {
            $browser->loginAs($this->lender)
                ->visit(new EndBorrowingPage)
                ->waitForPageLoaded()
                ->clickOnBorrowingButton($borrowing->id)
                ->click('@returnButton')
                ->whenAvailable('@borrowingsEndingModal', function (Browser $modal) use ($borrowing) {
                    $modal->assertSee($borrowing->inventoryItem()->first()->name);
                });
        });
    }
}
