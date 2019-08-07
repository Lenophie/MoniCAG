<?php

use Illuminate\Http\Response;
use Tests\TestCase;

class PagesAccessForGuestTest extends TestCase
{
    /**
     * Tests home page access for guests.
     *
     * @return void
     */
    public function testHomePageAccessForGuest()
    {
        $response = $this->get('/');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Tests new borrowing page access for guests.
     *
     * @return void
     */
    public function testNewBorrowingPageAccessForGuest()
    {
        $response = $this->get('/new-borrowing');
        $response->assertStatus(Response::HTTP_FOUND);
    }

    /**
     * Tests end borrowing page access for guests.
     *
     * @return void
     */
    public function testEndBorrowingPageAccessForGuest()
    {
        $response = $this->get('/end-borrowing');
        $response->assertStatus(Response::HTTP_FOUND);
    }

    /**
     * Tests borrowings history page access for guests.
     *
     * @return void
     */
    public function testBorrowingsHistoryPageAccessForGuest()
    {
        $response = $this->get('/borrowings-history');
        $response->assertStatus(Response::HTTP_FOUND);
    }

    /**
     * Tests view inventory page access for guests.
     *
     * @return void
     */
    public function testViewInventoryPageAccessForGuest()
    {
        $response = $this->get('/view-inventory');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Tests edit inventory page access for guests.
     *
     * @return void
     */
    public function testEditInventoryPageAccessForGuest()
    {
        $response = $this->get('/edit-inventory');
        $response->assertStatus(Response::HTTP_FOUND);
    }

    /**
     * Tests edit users page access for guests.
     *
     * @return void
     */
    public function testEditUsersPageAccessForGuest()
    {
        $response = $this->get('/edit-users');
        $response->assertStatus(Response::HTTP_FOUND);
    }
}
