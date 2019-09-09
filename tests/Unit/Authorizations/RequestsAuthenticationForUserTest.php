<?php

use App\Borrowing;
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
        $response = $this->json('POST', route('borrowings.store'), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests basic user prevented from ending a borrowing.
     *
     * @return void
     */
    public function testNoEndBorrowingRequestAllowedForUser()
    {
        $borrowing = factory(Borrowing::class)->state('onTime')->create();
        $response = $this->json('PATCH', route('borrowings.return', $borrowing->id), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests basic user prevented from adding a new inventory item.
     *
     * @return void
     */
    public function testInventoryItemCreationRejectedForUser()
    {
        $response = $this->json('POST', route('inventoryItems.store'), []);
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
        $response = $this->json('DELETE', route('inventoryItems.destroy', $inventoryItem->id), []);
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
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), []);
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
        $response = $this->json('PATCH', route('users.changeRole', $user->id), []);
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
        $response = $this->json('DELETE', route('users.destroy', $user->id), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests basic user prevented from adding a genre.
     *
     * @return void
     */
    public function testGenreCreationRejectedForUser()
    {
        $response = $this->json('POST', route('genres.store'), []);
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
        $response = $this->json('PATCH', route('genres.update', $genre->id), []);
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
        $response = $this->json('DELETE', route('genres.destroy', $genre->id), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
