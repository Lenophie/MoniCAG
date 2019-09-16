<?php

use App\User;
use App\UserRole;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UpdateSuperAdminTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Tests super admin update command
     *
     * @return void
     */
    public function testUpdateSuperAdminCommand()
    {
        $superAdmin = factory(User::class)->state('super-admin')->create();

        $this->artisan('super-admin:update --email=monika@root.ddlc --password=rootroot --first-name=Monika --last-name=Root')
            ->expectsOutput(__('messages.console.super_admin.update_success'));

        $this->assertDatabaseHas('users', [
            'id' => $superAdmin->id,
            'role_id' => UserRole::SUPER_ADMINISTRATOR,
            'first_name' => 'Monika',
            'last_name' => 'Root',
            'email' => 'monika@root.ddlc',
        ]);

        $newPasswordHash = User::find($superAdmin->id)->password;
        $this->assertTrue(Hash::check('rootroot', $newPasswordHash));
    }

    /**
     * Tests super admin update command's rejection when no option is provided
     *
     * @return void
     */
    public function testOptionLessUpdateSuperAdminCommand() {
        $superAdminPassword = 'a not s00 g00d/password';
        $superAdmin = factory(User::class)->state('super-admin')->create([
            'password' => bcrypt($superAdminPassword)
        ]);

        $this->artisan('super-admin:update')
            ->expectsOutput(__('messages.console.super_admin.no_update_option'));

        $this->assertDatabaseHas('users', [
            'id' => $superAdmin->id,
            'first_name' => $superAdmin->first_name,
            'last_name' => $superAdmin->last_name,
            'email' => $superAdmin->email,
            'role_id' => UserRole::SUPER_ADMINISTRATOR
        ]);

        $this->assertTrue(Hash::check($superAdminPassword, $superAdmin->password));
    }

    /**
     * Tests super admin update command's rejection when no super admin exists
     */
    public function testUpdateSuperAdminCommandRejectionWhenNoSuperAdmin() {
        $this->artisan('super-admin:update --password=mynewpassword')
            ->expectsOutput(__('messages.console.super_admin.no_super_admin'));

        $this->assertDatabaseMissing('users', [
            'role_id' => UserRole::SUPER_ADMINISTRATOR
        ]);
    }
}
