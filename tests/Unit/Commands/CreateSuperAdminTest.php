<?php

use App\User;
use App\UserRole;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateSuperAdminTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Tests super admin creation command
     *
     * @return void
     */
    public function testCreateSuperAdminCommand()
    {
        $this->artisan('super-admin:create monika@root.ddlc rootroot --first-name=Kimona --last-name=Super')
            ->expectsOutput(__('messages.console.super_admin.creation_success'));

        $this->assertDatabaseHas('users', [
            'role_id' => UserRole::SUPER_ADMINISTRATOR,
            'first_name' => 'Kimona',
            'last_name' => 'Super',
            'email' => 'monika@root.ddlc',
        ]);
        $password = User::where('role_id', UserRole::SUPER_ADMINISTRATOR)->select('password')->first()->password;
        $this->assertTrue(Hash::check('rootroot', $password));
    }

    /**
     * Tests super admin creation command's requirements
     *
     * @return void
     */
    public function testCreateSuperAdminCommandRequirements() {
        $this->expectException(RuntimeException::class);
        $this->artisan('super-admin:create');
        $this->assertDatabaseMissing('users', ['role_id' => UserRole::SUPER_ADMINISTRATOR]);
    }

    /**
     * Tests super admin creation command's password requirement
     */
    public function testCreateSuperAdminCommandPasswordRequirement() {
        $this->expectException(RuntimeException::class);
        $this->artisan('super-admin:create monika@root.ddlc');
        $this->assertDatabaseMissing('users', ['role_id' => UserRole::SUPER_ADMINISTRATOR]);
    }

    /**
     * Tests impossibility to create a super admin when there is already one
     */
    public function testNoMoreThanOneSuperAdmin() {
        $superAdmin = factory(User::class)->state('super-admin')->create();

        $this->artisan('super-admin:create monika@root.ddlc rootroot')
            ->expectsOutput(__('messages.console.super_admin.already_one_super_admin'));

        $this->assertDatabaseHas('users', [
            'id' => $superAdmin->id,
            'role_id' => UserRole::SUPER_ADMINISTRATOR
        ]);
        $this->assertEquals(User::where('role_id', UserRole::SUPER_ADMINISTRATOR)->count(), 1);
    }
}
