<?php

namespace Tests\Browser\Unit;

use App\Borrowing;
use App\Genre;
use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\AccountPage;
use Tests\DuskTestCase;

class AccountPageTest extends DuskTestCase
{
    use WithFaker;

    private $user;
    private $borrowings;

    protected function setUp(): void {
        Parent::setUp();
        $this->faker->seed(0);
        $user = factory(User::class)->create();
        $this->user = $user;
        $borrowings = factory(Borrowing::class, 3)->create([
            'borrower_id' => $this->user->id
        ]);
        $this->borrowings = $borrowings;
    }

    protected function tearDown(): void {
        User::query()->delete();
        Borrowing::query()->delete();
        InventoryItem::query()->delete();
        Genre::query()->delete();
    }

    public function testPersonalInfoPresence() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit(new AccountPage)
                ->waitForPageLoaded()
                ->assertSee($this->user->first_name)
                ->assertSee($this->user->last_name)
                ->assertSee($this->user->promotion)
                ->assertSee($this->user->email)
                ->assertSee($this->user->role->name);
        });
    }

    public function testPersonalBorrowingsPresence() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit(new AccountPage)
                ->waitForPageLoaded();

            foreach ($this->borrowings as $borrowing) {
                $browser->assertSee($borrowing->inventoryItem->name)
                    ->assertSee($borrowing->expected_return_date->format('d/m/Y'));
            }
        });
    }

    public function testAccessToModifyEmailPage() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit(new AccountPage)
                ->waitForPageLoaded()
                ->navigateToModifyEmailPage()
                ->waitForLocation('/email/change')
                ->assertPathIs('/email/change');
        });
    }

    public function testAccessToModifyPasswordPage() {
        $this->browse(function (Browser $browser) {
           $browser->loginAs($this->user)
               ->visit(new AccountPage)
               ->waitForPageLoaded()
               ->navigateToModifyPasswordPage()
               ->waitForLocation('/password/change')
               ->assertPathIs('/password/change');
        });
    }
}
