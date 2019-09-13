<?php

namespace Tests\Browser\Pages;

use Facebook\WebDriver\WebDriverBy;
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

    public function waitForPageLoaded(Browser $browser) {
        $browser->waitUntilVue('flags.isMounted', true, '#app');
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
            '@userRoleUpdateModal' => '#user-role-update-modal',
            '@userDeletionModal' => '#user-deletion-modal',
            '@userRoleUpdateConfirmationButton' => '#user-role-update-confirmation-button',
            '@userDeletionConfirmationButton' => '#user-deletion-confirmation-button',
        ];
    }

    // Necessary because value is not a string
    public function clickOptionFromRoleDropdown(Browser $browser, $id) : void {
        $selector = "//select[@name='role']/option[@id='role-option-{$id}']";
        $browser->driver->findElement(WebDriverBy::xpath($selector))->click();
    }

    public function clickOnUserButton(Browser $browser, $id) {
        $idString = "#user-card-button-{$id}";
        $browser->click($idString);
    }

    public function clickOnUserDeleteButton(Browser $browser, $id) {
        $idString = "#user-card-deletion-button-{$id}";
        $browser->click($idString);
    }
}
