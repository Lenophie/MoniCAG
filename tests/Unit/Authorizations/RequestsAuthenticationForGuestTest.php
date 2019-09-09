<?php

use App\Borrowing;
use App\Genre;
use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
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
        $response = $this->json('POST', route('borrowings.store'), []);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Tests guest prevented from ending a borrowing.
     *
     * @return void
     */
    public function testNoEndBorrowingRequestAllowedForGuest()
    {
        $borrowing = factory(Borrowing::class)->state('onTime')->create();
        $response = $this->json('PATCH', route('borrowings.return', $borrowing->id), []);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Tests guest prevented from adding a new inventory item.
     *
     * @return void
     */
    public function testInventoryItemCreationRejectedForGuest()
    {
        $response = $this->json('POST', route('inventoryItems.store'), []);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Tests guest prevented from deleting an inventory item.
     *
     * @return void
     */
    public function testInventoryItemDeletionRejectedForGuest()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('DELETE', route('inventoryItems.destroy', $inventoryItem->id), []);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Tests guest prevented from patching an inventory item.
     *
     * @return void
     */
    public function testInventoryItemPatchingRejectedForGuest()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), []);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Tests guest prevented from patching a user role.
     *
     * @return void
     */
    public function testUserRolePatchingRejectedForGuest()
    {
        $user = factory(User::class)->create();
        $response = $this->json('PATCH', route('users.changeRole', $user->id), []);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Tests guest prevented from deleting a user.
     *
     * @return void
     */
    public function testUserDeletionRejectedForGuest()
    {
        $user = factory(User::class)->create();
        $response = $this->json('DELETE', route('users.destroy', $user->id), []);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Tests guest prevented from adding a genre.
     *
     * @return void
     */
    public function testGenreCreationRejectedForGuest()
    {
        $response = $this->json('POST', route('genres.store'), []);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Tests guest prevented from updating a genre.
     *
     * @return void
     */
    public function testGenrePatchingRejectedForGuest()
    {
        $genre = factory(Genre::class)->create();
        $response = $this->json('PATCH', route('genres.update', $genre->id), []);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Tests guest prevented from deleting a genre.
     *
     * @return void
     */
    public function testGenreDeletionRejectedForGuest()
    {
        $genre = factory(Genre::class)->create();
        $response = $this->json('DELETE', route('genres.destroy', $genre->id), []);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
