<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class EditUsersPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/edit-users';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        //
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [

        ];
    }

    public function pressOnConfirmButton(Browser $browser, $userId) {
        $browser->press("#edit-user-{$userId}-button");
    }

    public function pressOnDeleteUserButton(Browser $browser, $userId) {
        $browser->press("#delete-user-{$userId}-button");
    }
}