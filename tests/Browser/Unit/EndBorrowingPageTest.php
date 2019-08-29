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

    protected function setUp(): void {
        Parent::setUp();
        $this->faker->seed(0);
        $lender = factory(User::class)->state('lender')->create();
        $this->lender = $lender;
    }

    protected function tearDown(): void {
        User::query()->delete();
        Borrowing::query()->delete();
        InventoryItem::query()->delete();
        Genre::query()->delete();
    }

    public function testBorrowingsPresence() {
        $borrowings = factory(Borrowing::class, 3)->create();

        $this->browse(function (Browser $browser) use ($borrowings) {
            $browser->loginAs($this->lender)
                ->visit(new EndBorrowingPage);

            foreach ($borrowings as $borrowing) {
                $browser->assertPresent("#borrowings-list-element-{$borrowing->id}");
            }
        });
    }

    public function testLateBorrowingsWarningsPresence()
    {
        $onTimeBorrowing = factory(Borrowing::class)->state('onTime')->create();
        $lateBorrowing = factory(Borrowing::class)->state('late')->create();
        $borrowings = [$onTimeBorrowing, $lateBorrowing];

        $this->browse(function (Browser $browser) use ($onTimeBorrowing, $lateBorrowing) {
            $browser->loginAs($this->lender)
                ->visit(new EndBorrowingPage)
                ->assertSeeIn("#borrowings-list-element-{$lateBorrowing->id}", __('messages.end_borrowing.late'))
                ->assertDontSeeIn("#borrowings-list-element-{$onTimeBorrowing->id}", __('messages.end_borrowing.late'));
        });
    }

    public function testBorrowingAdditionToCheckoutModal()
    {
        $borrowings = factory(Borrowing::class, 2)->create();

        $this->browse(function (Browser $browser) use ($borrowings) {
            $browser->loginAs($this->lender)
                ->visit(new EndBorrowingPage)
                ->clickOnBorrowingButton($borrowings[0]->id)
                ->click('@returnButton')
                ->whenAvailable('@endBorrowingModal', function (Browser $modal) use ($borrowings) {
                    $modal->assertSee($borrowings[0]->inventoryItem()->first()->name);
                });
        });
    }
}
