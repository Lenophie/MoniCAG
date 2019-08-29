<?php

use App\Genre;
use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class RequestsAuthenticationForUserTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        Parent::setUp();
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');
    }

    /**
     * Tests basic user prevented from posting a new borrowing.
     *
     * @return void
     */
    public function testNoNewBorrowingRequestAllowedForUser()
    {
        $response = $this->json('POST', '/api/borrowings', []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests basic user prevented from ending a borrowing.
     *
     * @return void
     */
    public function testNoEndBorrowingRequestAllowedForUser()
    {
        $response = $this->json('PATCH', '/api/borrowings', []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests basic user prevented from adding a new inventory item.
     *
     * @return void
     */
    public function testInventoryItemCreationRejectedForUser()
    {
        $response = $this->json('POST', '/api/inventoryItems', []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests basic user prevented from deleting an inventory item.
     *
     * @return void
     */
    public function testInventoryItemDeletionRejectedForUser()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('DELETE', '/api/inventoryItems/' . $inventoryItem->id, []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests basic user prevented from patching an inventory item.
     *
     * @return void
     */
    public function testInventoryItemPatchingRejectedForUser()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', '/api/inventoryItems/' . $inventoryItem->id, []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests basic user prevented from patching a user role.
     *
     * @return void
     */
    public function testUserRolePatchingRejectedForUser()
    {
        $user = factory(User::class)->create();
        $response = $this->json('PATCH', '/api/users/' . $user->id . '/role', []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests basic user prevented from deleting a user.
     *
     * @return void
     */
    public function testUserDeletionRejectedForUser()
    {
        $user = factory(User::class)->create();
        $response = $this->json('DELETE', '/api/users/' . $user->id, []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests basic user prevented from adding a genre.
     *
     * @return void
     */
    public function testGenreCreationRejectedForUser()
    {
        $response = $this->json('POST', 'api/genres/', []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests basic user prevented from updating a genre.
     *
     * @return void
     */
    public function testGenrePatchingRejectedForUser()
    {
        $genre = factory(Genre::class)->create();
        $response = $this->json('PATCH', 'api/genres/' . $genre->id, []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests basic user prevented from deleting a genre.
     *
     * @return void
     */
    public function testGenreDeletionRejectedForUser()
    {
        $genre = factory(Genre::class)->create();
        $response = $this->json('DELETE', 'api/genres/' . $genre->id, []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
