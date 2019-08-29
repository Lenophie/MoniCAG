<?php

namespace Tests\Browser\Visits;

use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\PagesFromHomeEnum;
use Tests\DuskTestCase;

class AccessesFromHomeTest extends DuskTestCase
{
    use WithFaker;

    private $admin;
    private $lender;

    protected function setUp(): void {
        Parent::setUp();
        $this->faker->seed(0);
        $lender = factory(User::class)->state('lender')->create();
        $this->lender = $lender;
        $admin = factory(User::class)->state('admin')->create();
        $this->admin = $admin;
    }

    protected function tearDown(): void
    {
        User::query()->delete();
    }

    public function testAccessToNewBorrowingPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->lender)
                ->visit(new HomePage)
                ->navigateTo(PagesFromHomeEnum::NEW_BORROWING)
                ->assertPathIs('/new-borrowing');
        });
    }

    public function testAccessToEndBorrowingPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->lender)
                ->visit(new HomePage)
                ->navigateTo(PagesFromHomeEnum::END_BORROWING)
                ->assertPathIs('/end-borrowing');
        });
    }

    public function testAccessToBorrowingsHistoryPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->lender)
                ->visit(new HomePage)
                ->navigateTo(PagesFromHomeEnum::BORROWINGS_HISTORY)
                ->assertPathIs('/borrowings-history');
        });
    }

    public function testAccessToViewInventoryPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage)
                ->navigateTo(PagesFromHomeEnum::VIEW_INVENTORY)
                ->assertPathIs('/view-inventory');
        });
    }

    public function testAccessToEditInventoryPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new HomePage)
                ->navigateTo(PagesFromHomeEnum::EDIT_INVENTORY)
                ->assertPathIs('/edit-inventory');
        });
    }

    public function testAccessToEditUsersPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new HomePage)
                ->navigateTo(PagesFromHomeEnum::EDIT_USERS)
                ->assertPathIs('/edit-users');
        });
    }

    public function testAccessToGithubPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage)
                ->navigateTo(PagesFromHomeEnum::GITHUB)
                ->assertHostIs('github.com')
                ->assertPathIs('/Lenophie/MoniCAG/');
        });
    }

    public function testAccessToAccountPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
                ->visit(new HomePage)
                ->navigateTo(PagesFromHomeEnum::ACCOUNT)
                ->assertPathIs('/account');
        });
    }
}
