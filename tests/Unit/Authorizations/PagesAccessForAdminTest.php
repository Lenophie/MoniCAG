<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class PagesAccessForAdminTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        Parent::setUp();
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin);
    }

    /**
     * Tests home page access for admins.
     *
     * @return void
     */
    public function testHomePageAccessForAdmin()
    {
        $response = $this->get('/');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Tests new borrowing page access for admins.
     *
     * @return void
     */
    public function testNewBorrowingPageAccessForAdmin()
    {
        $response = $this->get('/new-borrowing');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Tests end borrowing page access for admins.
     *
     * @return void
     */
    public function testEndBorrowingPageAccessForAdmin()
    {
        $response = $this->get('/end-borrowing');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Tests borrowings history page access for admins.
     *
     * @return void
     */
    public function testBorrowingsHistoryPageAccessForAdmin()
    {
        $response = $this->get('/borrowings-history');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Tests view inventory page access for admins.
     *
     * @return void
     */
    public function testViewInventoryPageAccessForAdmin()
    {
        $response = $this->get('/view-inventory');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Tests edit inventory page access for admins.
     *
     * @return void
     */
    public function testEditInventoryPageAccessForAdmin()
    {
        $response = $this->get('/edit-inventory');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Tests edit users page access for admins.
     *
     * @return void
     */
    public function testEditUsersPageAccessForAdmin()
    {
        $response = $this->get('/edit-users');
        $response->assertStatus(Response::HTTP_OK);
    }
}
