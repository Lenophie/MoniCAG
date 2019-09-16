<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class PagesAccessForSuperAdminTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        Parent::setUp();
        $superAdmin = factory(User::class)->state('super-admin')->create();
        $this->actingAs($superAdmin);
    }

    /**
     * Tests home page access for super admins.
     *
     * @return void
     */
    public function testHomePageAccessForSuperAdmin()
    {
        $response = $this->get('/');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Tests new borrowing page access for superAdmins.
     *
     * @return void
     */
    public function testNewBorrowingPageAccessForSuperAdmin()
    {
        $response = $this->get('/new-borrowing');
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests end borrowing page access for superAdmins.
     *
     * @return void
     */
    public function testEndBorrowingPageAccessForSuperAdmin()
    {
        $response = $this->get('/end-borrowing');
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests borrowings history page access for superAdmins.
     *
     * @return void
     */
    public function testBorrowingsHistoryPageAccessForSuperAdmin()
    {
        $response = $this->get('/borrowings-history');
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests view inventory page access for superAdmins.
     *
     * @return void
     */
    public function testViewInventoryPageAccessForSuperAdmin()
    {
        $response = $this->get('/view-inventory');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Tests edit inventory page access for superAdmins.
     *
     * @return void
     */
    public function testEditInventoryPageAccessForSuperAdmin()
    {
        $response = $this->get('/edit-inventory');
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests edit users page access for superAdmins.
     *
     * @return void
     */
    public function testEditUsersPageAccessForSuperAdmin()
    {
        $response = $this->get('/edit-users');
        $response->assertStatus(Response::HTTP_OK);
    }
}
