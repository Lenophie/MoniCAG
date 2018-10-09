<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class HomePage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/';
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
            '@newBorrowingButton' => '#new-borrowing-button',
            '@endBorrowingButton' => '#end-borrowing-button',
            '@borrowingsHistoryButton' => '#borrowings-history-button',
            '@viewInventoryButton' => '#view-inventory-button',
            '@editInventoryButton' => '#edit-inventory-button',
            '@editUsersButton' => '#edit-users-button',
            '@githubLink' => '#github-link'
        ];
    }

    public function navigateTo(Browser $browser, $page) {
        switch ($page) {
            case 'new-borrowing':
                $browser->click('@newBorrowingButton');
                break;
            case 'end-borrowing':
                $browser->click('@endBorrowingButton');
                break;
            case 'borrowings-history':
                $browser->click('@borrowingsHistoryButton');
                break;
            case 'view-inventory':
                $browser->click('@viewInventoryButton');
                break;
            case 'edit-inventory':
                $browser->click('@editInventoryButton');
                break;
            case 'edit-users':
                $browser->click('@editUsersButton');
                break;
            case 'github':
                $browser->click('@githubLink');
                break;
        }
    }
}
