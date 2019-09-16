<?php

use App\Borrowing;
use App\Genre;
use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class RequestsAuthenticationForSuperAdminTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        Parent::setUp();
        $superAdmin = factory(User::class)->state('super-admin')->create();
        $this->actingAs($superAdmin, 'api');
    }

    /**
     * Tests super admin prevented from posting a new borrowing.
     *
     * @return void
     */
    public function testNewBorrowingRequestRejectedForSuperAdmin()
    {
        $response = $this->json('POST', route('borrowings.store'), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests super admin prevented from ending a borrowing.
     *
     * @return void
     */
    public function testEndBorrowingRequestRejectedForSuperAdmin()
    {
        $borrowing = factory(Borrowing::class)->state('onTime')->create();
        $response = $this->json('PATCH', route('borrowings.return', $borrowing->id), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests super admin prevented from adding a new inventory item.
     *
     * @return void
     */
    public function testInventoryItemCreationRejectedForSuperAdmin()
    {
        $response = $this->json('POST', route('inventoryItems.store'), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests super admin prevented from deleting an inventory item.
     *
     * @return void
     */
    public function testInventoryItemDeletionRejectedForSuperAdmin()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('DELETE', route('inventoryItems.destroy', $inventoryItem->id), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests super admin prevented from patching an inventory item.
     *
     * @return void
     */
    public function testInventoryItemPatchingRejectedForSuperAdmin()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests super admin allowed to patch a user role.
     *
     * @return void
     */
    public function testUserRolePatchingAllowedForSuperAdmin()
    {
        $user = factory(User::class)->create();
        $response = $this->json('PATCH', route('users.changeRole', $user->id), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Tests super admin allowed from deleting a user.
     *
     * @return void
     */
    public function testUserDeletionAllowedForSuperAdmin()
    {
        $user = factory(User::class)->create();
        $response = $this->json('DELETE', route('users.destroy', $user->id), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Tests super admin prevented from adding a genre.
     *
     * @return void
     */
    public function testGenreCreationRejectedForSuperAdmin()
    {
        $response = $this->json('POST', route('genres.store'), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests super admin prevented from updating a genre.
     *
     * @return void
     */
    public function testGenrePatchingRejectedForSuperAdmin()
    {
        $genre = factory(Genre::class)->create();
        $response = $this->json('PATCH', route('genres.update', $genre->id), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Tests super admin prevented from deleting a genre.
     *
     * @return void
     */
    public function testGenreDeletionRejectedForSuperAdmin()
    {
        $genre = factory(Genre::class)->create();
        $response = $this->json('DELETE', route('genres.destroy', $genre->id), []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
