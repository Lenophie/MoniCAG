<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PagesAccessForLenderTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp()
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
        $response->assertStatus(200);
    }

    /**
     * Tests new borrowing page access for lenders.
     *
     * @return void
     */
    public function testNewBorrowingPageAccessForLender()
    {
        $response = $this->get('/new-borrowing');
        $response->assertStatus(200);
    }

    /**
     * Tests end borrowing page access for lenders.
     *
     * @return void
     */
    public function testEndBorrowingPageAccessForLender()
    {
        $response = $this->get('/end-borrowing');
        $response->assertStatus(200);
    }

    /**
     * Tests borrowings history page access for lenders.
     *
     * @return void
     */
    public function testBorrowingsHistoryPageAccessForLender()
    {
        $response = $this->get('/borrowings-history');
        $response->assertStatus(200);
    }

    /**
     * Tests view inventory page access for lenders.
     *
     * @return void
     */
    public function testViewInventoryPageAccessForLender()
    {
        $response = $this->get('/view-inventory');
        $response->assertStatus(200);
    }

    /**
     * Tests edit inventory page access for lenders.
     *
     * @return void
     */
    public function testEditInventoryPageAccessForLender()
    {
        $response = $this->get('/edit-inventory');
        $response->assertStatus(403);
    }

    /**
     * Tests edit users page access for lenders.
     *
     * @return void
     */
    public function testEditUsersPageAccessForLender()
    {
        $response = $this->get('/edit-users');
        $response->assertStatus(403);
    }
}
