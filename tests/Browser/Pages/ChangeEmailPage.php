<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class ChangeEmailPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/email/change';
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
            '@changeEmailConfirmationButton' => '#confirm-email-change'
        ];
    }
}
