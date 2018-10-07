<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PagesAccessForGuestTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Tests home page access for guests.
     *
     * @return void
     */
    public function testHomePageAccessForGuest()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Tests new borrowing page access for guests.
     *
     * @return void
     */
    public function testNewBorrowingPageAccessForGuest()
    {
        $response = $this->get('/new-borrowing');
        $response->assertStatus(302);
    }

    /**
     * Tests end borrowing page access for guests.
     *
     * @return void
     */
    public function testEndBorrowingPageAccessForGuest()
    {
        $response = $this->get('/end-borrowing');
        $response->assertStatus(302);
    }

    /**
     * Tests borrowings history page access for guests.
     *
     * @return void
     */
    public function testBorrowingsHistoryPageAccessForGuest()
    {
        $response = $this->get('/borrowings-history');
        $response->assertStatus(302);
    }

    /**
     * Tests view inventory page access for guests.
     *
     * @return void
     */
    public function testViewInventoryPageAccessForGuest()
    {
        $response = $this->get('/view-inventory');
        $response->assertStatus(200);
    }

    /**
     * Tests edit inventory page access for guests.
     *
     * @return void
     */
    public function testEditInventoryPageAccessForGuest()
    {
        $response = $this->get('/edit-inventory');
        $response->assertStatus(302);
    }

    /**
     * Tests edit users page access for guests.
     *
     * @return void
     */
    public function testEditUsersPageAccessForGuest()
    {
        $response = $this->get('/edit-users');
        $response->assertStatus(302);
    }
}
