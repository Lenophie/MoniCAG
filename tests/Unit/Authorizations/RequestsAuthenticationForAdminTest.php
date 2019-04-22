<?php

use App\Genre;
use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RequestsAuthenticationForAdminTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp()
    {
        Parent::setUp();
        $admin = factory(User::class)->state('admin')->create();
        $this->actingAs($admin, 'api');
    }

    /**
     * Tests admin allowed to post a new borrowing.
     *
     * @return void
     */
    public function testNewBorrowingRequestAllowedForAdmin()
    {
        $response = $this->json('POST', '/api/borrowings', []);
        $response->assertStatus(422);
    }

    /**
     * Tests admin allowed to end a borrowing.
     *
     * @return void
     */
    public function testEndBorrowingRequestAllowedForAdmin()
    {
        $response = $this->json('PATCH', '/api/borrowings', []);
        $response->assertStatus(422);
    }

    /**
     * Tests admin allowed to add a new inventory item.
     *
     * @return void
     */
    public function testAddInventoryItemRequestAllowedForAdmin()
    {
        $response = $this->json('POST', '/api/inventoryItems', []);
        $response->assertStatus(422);
    }

    /**
     * Tests admin allowed to delete an inventory item.
     *
     * @return void
     */
    public function testDeleteInventoryItemRequestAllowedForAdmin()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('DELETE', '/api/inventoryItems/' . $inventoryItem->id, []);
        $response->assertStatus(200);
    }

    /**
     * Tests admin allowed to patch an inventory item.
     *
     * @return void
     */
    public function testPatchInventoryItemRequestAllowedForAdmin()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItem->id, []);
        $response->assertStatus(422);
    }

    /**
     * Tests admin allowed to patch a user.
     *
     * @return void
     */
    public function testPatchUserRequestAllowedForAdmin()
    {
        $user = factory(User::class)->create();
        $response = $this->json('PATCH', '/api/users/' . $user->id . '/role', []);
        $response->assertStatus(422);
    }

    /**
     * Tests admin allowed to delete a user.
     *
     * @return void
     */
    public function testDeleteUserRequestAllowedForAdmin()
    {
        $user = factory(User::class)->create();
        $response = $this->json('DELETE', '/api/users/' . $user->id, []);
        $response->assertStatus(200);
    }

    /**
     * Tests admin allowed to add a genre.
     *
     * @return void
     */
    public function testAddGenreAllowedForAdmin()
    {
        $response = $this->json('POST', 'api/genres/', []);
        $response->assertStatus(422);
    }

    /**
     * Tests admin allowed to update a genre.
     *
     * @return void
     */
    public function testUpdateGenreAllowedForAdmin()
    {
        $genre = factory(Genre::class)->create();
        $response = $this->json('PATCH', 'api/genres/' . $genre->id, []);
        $response->assertStatus(422);
    }
}
