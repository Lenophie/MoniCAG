<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
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
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Tests new borrowing page access for basic users.
     *
     * @return void
     */
    public function testNewBorrowingPageAccessForUser()
    {
        $response = $this->get('/new-borrowing');
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests end borrowing page access for basic users.
     *
     * @return void
     */
    public function testEndBorrowingPageAccessForUser()
    {
        $response = $this->get('/end-borrowing');
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests borrowings history page access for basic users.
     *
     * @return void
     */
    public function testBorrowingsHistoryPageAccessForUser()
    {
        $response = $this->get('/borrowings-history');
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests view inventory page access for basic users.
     *
     * @return void
     */
    public function testViewInventoryPageAccessForUser()
    {
        $response = $this->get('/view-inventory');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Tests edit inventory page access for basic users.
     *
     * @return void
     */
    public function testEditInventoryPageAccessForUser()
    {
        $response = $this->get('/edit-inventory');
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests edit users page access for basic users.
     *
     * @return void
     */
    public function testEditUsersPageAccessForUser()
    {
        $response = $this->get('/edit-users');
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
