<?php

use App\Genre;
use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RequestsAuthenticationForGuestTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Tests guest prevented from posting a new borrowing.
     *
     * @return void
     */
    public function testNoNewBorrowingRequestAllowedForGuest()
    {
        $response = $this->json('POST', '/api/borrowings', []);
        $response->assertStatus(401);
    }

    /**
     * Tests guest prevented from ending a borrowing.
     *
     * @return void
     */
    public function testNoEndBorrowingRequestAllowedForGuest()
    {
        $response = $this->json('PATCH', '/api/borrowings', []);
        $response->assertStatus(401);
    }

    /**
     * Tests guest prevented from adding a new inventory item.
     *
     * @return void
     */
    public function testNoAddInventoryItemRequestAllowedForGuest()
    {
        $response = $this->json('POST', '/api/inventoryItems', []);
        $response->assertStatus(401);
    }

    /**
     * Tests guest prevented from deleting an inventory item.
     *
     * @return void
     */
    public function testNoDeleteInventoryItemRequestAllowedForGuest()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('DELETE', '/api/inventoryItems/' . $inventoryItem->id, []);
        $response->assertStatus(401);
    }

    /**
     * Tests guest prevented from patching an inventory item.
     *
     * @return void
     */
    public function testNoPatchInventoryItemRequestAllowedForGuest()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItem->id, []);
        $response->assertStatus(401);
    }

    /**
     * Tests guest prevented from patching a user.
     *
     * @return void
     */
    public function testNoPatchUserRequestAllowedForGuest()
    {
        $user = factory(User::class)->create();
        $response = $this->json('PATCH', '/api/users/' . $user->id . '/role', []);
        $response->assertStatus(401);
    }

    /**
     * Tests guest prevented from deleting a user.
     *
     * @return void
     */
    public function testNoDeleteUserRequestAllowedForGuest()
    {
        $user = factory(User::class)->create();
        $response = $this->json('DELETE', '/api/users/' . $user->id, []);
        $response->assertStatus(401);
    }

    /**
     * Tests guest prevented from adding a genre.
     *
     * @return void
     */
    public function testNoAddGenreAllowedForGuest()
    {
        $response = $this->json('POST', 'api/genres/', []);
        $response->assertStatus(401);
    }

    /**
     * Tests guest prevented from updating a genre.
     *
     * @return void
     */
    public function testNoUpdateGenreAllowedForGuest()
    {
        $genre = factory(Genre::class)->create();
        $response = $this->json('PATCH', 'api/genres/' . $genre->id, []);
        $response->assertStatus(401);
    }

    /**
     * Tests guest prevented from deleting a genre.
     *
     * @return void
     */
    public function testNoDeleteGenreAllowedForGuest()
    {
        $genre = factory(Genre::class)->create();
        $response = $this->json('DELETE', 'api/genres/' . $genre->id, []);
        $response->assertStatus(401);
    }
}
