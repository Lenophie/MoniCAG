<?php

use App\Borrowing;
use App\Genre;
use App\InventoryItem;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class RequestsAuthenticationForAdminTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
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
        $response = $this->json('POST', route('borrowings.store'), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Tests admin allowed to end a borrowing.
     *
     * @return void
     */
    public function testEndBorrowingRequestAllowedForAdmin()
    {
        $borrowing = factory(Borrowing::class)->state('onTime')->create();
        $response = $this->json('PATCH', route('borrowings.return', $borrowing->id), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Tests admin allowed to create an inventory item.
     *
     * @return void
     */
    public function testInventoryItemRequestCreationAllowedForAdmin()
    {
        $response = $this->json('POST', route('inventoryItems.store'), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Tests admin allowed to delete an inventory item.
     *
     * @return void
     */
    public function testInventoryItemDeletionAllowedForAdmin()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('DELETE', route('inventoryItems.destroy', $inventoryItem->id), []);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Tests admin allowed to patch an inventory item.
     *
     * @return void
     */
    public function testInventoryItemPatchingAllowedForAdmin()
    {
        $inventoryItem = factory(InventoryItem::class)->create();
        $response = $this->json('PATCH', route('inventoryItems.update', $inventoryItem->id), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Tests admin allowed to patch a user role.
     *
     * @return void
     */
    public function testUserRolePatchingAllowedForAdmin()
    {
        $user = factory(User::class)->create();
        $response = $this->json('PATCH', route('users.changeRole', $user->id), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Tests admin allowed to delete a user.
     *
     * @return void
     */
    public function testUserDeletionAllowedForAdmin()
    {
        $user = factory(User::class)->create();
        $response = $this->json('DELETE', route('users.destroy', $user->id), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Tests admin allowed to create a genre.
     *
     * @return void
     */
    public function testGenreCreationAllowedForAdmin()
    {
        $response = $this->json('POST', route('genres.store'), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Tests admin allowed to update a genre.
     *
     * @return void
     */
    public function testGenrePatchingForAdmin()
    {
        $genre = factory(Genre::class)->create();
        $response = $this->json('PATCH', route('genres.update', $genre->id), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Tests admin allowed to delete a genre.
     *
     * @return void
     */
    public function testGenreDeletionAllowedForAdmin()
    {
        $genre = factory(Genre::class)->create();
        $response = $this->json('DELETE', route('genres.destroy', $genre->id), []);
        $response->assertStatus(Response::HTTP_OK);
    }
}
