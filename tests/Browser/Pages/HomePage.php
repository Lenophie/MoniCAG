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
            '@githubLink' => '#github-link',
            '@englishLink' => '#english-link',
            '@frenchLink' => '#french-link',
            '@lightThemeLink' => '#light-theme-link',
            '@darkThemeLink' => '#dark-theme-link',
            '@accountButton' => '#account-link'
        ];
    }

    public function navigateTo(Browser $browser, $page) {
        switch ($page) {
            case PagesFromHomeEnum::NEW_BORROWING:
                $browser->click('@newBorrowingButton');
                break;
            case PagesFromHomeEnum::END_BORROWING:
                $browser->click('@endBorrowingButton');
                break;
            case PagesFromHomeEnum::BORROWINGS_HISTORY:
                $browser->click('@borrowingsHistoryButton');
                break;
            case PagesFromHomeEnum::VIEW_INVENTORY:
                $browser->click('@viewInventoryButton');
                break;
            case PagesFromHomeEnum::EDIT_INVENTORY:
                $browser->click('@editInventoryButton');
                break;
            case PagesFromHomeEnum::EDIT_USERS:
                $browser->click('@editUsersButton');
                break;
            case PagesFromHomeEnum::ACCOUNT:
                $browser->click('@accountButton');
                break;
            case PagesFromHomeEnum::GITHUB:
                $browser->click('@githubLink');
                break;
        }
    }

    public function changeLocale(Browser $browser, $locale) {
        switch ($locale) {
            case 'gb': case 'en':
                $browser->click('@englishLink');
                break;
            case 'fr':
                $browser->click('@frenchLink');
                break;
        }
    }

    public function changeTheme(Browser $browser, $theme) {
        switch ($theme) {
            case 'light':
                $browser->click('@lightThemeLink');
                break;
            case 'dark':
                $browser->click('@darkThemeLink');
                break;
        }
    }
}
