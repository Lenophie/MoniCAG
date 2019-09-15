<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class EndBorrowingPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/end-borrowing';
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

    public function waitForPageLoaded(Browser $browser) {
        $browser->waitUntilVue('isMounted', true, '#app');
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@returnButton' => '#return-button',
            '@lostButton' => '#lost-button',
            '@borrowingsEndingModal' => '#borrowings-ending-modal',
            '@borrowingsEndingConfirmationButton' => '#borrowings-ending-confirmation-button'
        ];
    }

    public function clickOnBorrowingButton(Browser $browser, $id)
    {
        $browser->click("#borrowings-list-element-{$id}");
    }
}
