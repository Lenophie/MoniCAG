<?php

namespace Tests\Browser\Unit;

use App\Borrowing;
use App\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\AccountPage;
use Tests\DuskTestCase;

class AccountPageTest extends DuskTestCase
{
    private $user;

    protected function setUp(): void {
        Parent::setUp();
        $user = factory(User::class)->create();
        $this->user = $user;
    }

    protected function tearDown(): void {
        $this->user->delete();
    }

    public function testPersonalInfoPresence() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit(new AccountPage())
                ->waitForPageLoaded()
                ->assertSee($this->user->first_name)
                ->assertSee($this->user->last_name)
                ->assertSee($this->user->promotion)
                ->assertSee($this->user->email)
                ->assertSee($this->user->role->name);
        });
    }

    public function testPersonalBorrowingsPresence() {
        $borrowings = factory(Borrowing::class, 3)->create([
            'borrower_id' => $this->user->id
        ]);

        $this->browse(function (Browser $browser) use ($borrowings) {
            $browser->loginAs($this->user)
                ->visit(new AccountPage())
                ->waitForPageLoaded();

            foreach ($borrowings as $borrowing) {
                $browser->assertSee($borrowing->inventoryItem->name)
                    ->assertSee($borrowing->expected_return_date->format('d/m/Y'));
            }
        });

        foreach ($borrowings as $borrowing) {
            foreach ($borrowing->inventoryItem()->first()->genres()->get() as $genre) $genre->delete();
            $borrowing->inventoryItem()->first()->delete();
            $borrowing->initialLender()->first()->delete();
            $borrowing->delete();
        }
    }

    public function testAccessToModifyEmailPage() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit(new AccountPage())
                ->waitForPageLoaded()
                ->navigateToModifyEmailPage()
                ->waitForLocation('/email/change')
                ->assertPathIs('/email/change');
        });
    }

    public function testAccessToModifyPasswordPage() {
        $this->browse(function (Browser $browser) {
           $browser->loginAs($this->user)
               ->visit(new AccountPage())
               ->waitForPageLoaded()
               ->navigateToModifyPasswordPage()
               ->waitForLocation('/password/change')
               ->assertPathIs('/password/change');
        });
    }
}
