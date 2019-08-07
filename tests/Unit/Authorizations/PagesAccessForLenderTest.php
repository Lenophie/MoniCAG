<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class PagesAccessForLenderTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        Parent::setUp();
        $lender = factory(User::class)->state('lender')->create();
        $this->actingAs($lender);
    }

    /**
     * Tests home page access for lenders.
     *
     * @return void
     */
    public function testHomePageAccessForLender()
    {
        $response = $this->get('/');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Tests new borrowing page access for lenders.
     *
     * @return void
     */
    public function testNewBorrowingPageAccessForLender()
    {
        $response = $this->get('/new-borrowing');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Tests end borrowing page access for lenders.
     *
     * @return void
     */
    public function testEndBorrowingPageAccessForLender()
    {
        $response = $this->get('/end-borrowing');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Tests borrowings history page access for lenders.
     *
     * @return void
     */
    public function testBorrowingsHistoryPageAccessForLender()
    {
        $response = $this->get('/borrowings-history');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Tests view inventory page access for lenders.
     *
     * @return void
     */
    public function testViewInventoryPageAccessForLender()
    {
        $response = $this->get('/view-inventory');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Tests edit inventory page access for lenders.
     *
     * @return void
     */
    public function testEditInventoryPageAccessForLender()
    {
        $response = $this->get('/edit-inventory');
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests edit users page access for lenders.
     *
     * @return void
     */
    public function testEditUsersPageAccessForLender()
    {
        $response = $this->get('/edit-users');
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
