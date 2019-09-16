<?php

use App\Borrowing;
use App\Genre;
use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class RequestsAuthenticationForLenderTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        Parent::setUp();
        $lender = factory(User::class)->state('lender')->create();
        $this->actingAs($lender, 'api');
    }

    /**
     * Tests lender allowed to post a new borrowing.
     *
     * @return void
     */
    public function testNewBorrowingRequestAllowedForLender()
    {
        $response = $this->json('POST', route('borrowings.store'), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Tests lender allowed to end a borrowing.
     *
     * @return void
     */
    public function testEndBorrowingRequestAllowedForLender()
    {
        $borrowing = factory(Borrowing::class)->state('onTime')->create();
        $response = $this->json('PATCH', route('borrowings.return', $borrowing->id), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Tests lender prevented from adding a new inventory item.
     *
     * @return void
     */
    public function testInventoryItemCreationRejectedForLender()
    {
        $response = $this->json('POST', route('inventoryItems.store'), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests lender prevented from deleting an inventory item.
     *
     * @return void
     */
    public function testInventoryItemDeletionRejectedForLender()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('DELETE', route('inventoryItems.destroy', $inventoryItem->id), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests lender prevented from patching an inventory item.
     *
     * @return void
     */
    public function testInventoryItemPatchingRejectedForLender()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests lender prevented from patching a user role.
     *
     * @return void
     */
    public function testUserRolePatchingRejectedForLender()
    {
        $user = factory(User::class)->create();
        $response = $this->json('PATCH', route('users.changeRole', $user->id), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests lender prevented from deleting a user.
     *
     * @return void
     */
    public function testUserDeletionRejectedForLender()
    {
        $user = factory(User::class)->create();
        $response = $this->json('DELETE', route('users.destroy', $user->id), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests lender prevented from adding a genre.
     *
     * @return void
     */
    public function testGenreCreationRejectedForLender()
    {
        $response = $this->json('POST', route('genres.store'), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests lender prevented from updating a genre.
     *
     * @return void
     */
    public function testGenrePatchingRejectedForLender()
    {
        $genre = factory(Genre::class)->create();
        $response = $this->json('PATCH', route('genres.update', $genre->id), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests lender prevented from deleting a genre.
     *
     * @return void
     */
    public function testGenreDeletionRejectedForLender()
    {
        $genre = factory(Genre::class)->create();
        $response = $this->json('DELETE', route('genres.destroy', $genre->id), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
