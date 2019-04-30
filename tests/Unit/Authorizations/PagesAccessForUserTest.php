<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PagesAccessForUserTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        Parent::setUp();
        $user = factory(User::class)->create();
        $this->actingAs($user);
    }

    /**
     * Tests home page access for basic users.
     *
     * @return void
     */
    public function testHomePageAccessForUser()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Tests new borrowing page access for basic users.
     *
     * @return void
     */
    public function testNewBorrowingPageAccessForUser()
    {
        $response = $this->get('/new-borrowing');
        $response->assertStatus(403);
    }

    /**
     * Tests end borrowing page access for basic users.
     *
     * @return void
     */
    public function testEndBorrowingPageAccessForUser()
    {
        $response = $this->get('/end-borrowing');
        $response->assertStatus(403);
    }

    /**
     * Tests borrowings history page access for basic users.
     *
     * @return void
     */
    public function testBorrowingsHistoryPageAccessForUser()
    {
        $response = $this->get('/borrowings-history');
        $response->assertStatus(403);
    }

    /**
     * Tests view inventory page access for basic users.
     *
     * @return void
     */
    public function testViewInventoryPageAccessForUser()
    {
        $response = $this->get('/view-inventory');
        $response->assertStatus(200);
    }

    /**
     * Tests edit inventory page access for basic users.
     *
     * @return void
     */
    public function testEditInventoryPageAccessForUser()
    {
        $response = $this->get('/edit-inventory');
        $response->assertStatus(403);
    }

    /**
     * Tests edit users page access for basic users.
     *
     * @return void
     */
    public function testEditUsersPageAccessForUser()
    {
        $response = $this->get('/edit-users');
        $response->assertStatus(403);
    }
}
