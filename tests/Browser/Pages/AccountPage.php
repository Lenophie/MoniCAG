<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class AccountPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/account';
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
            '@modifyEmailLink' => '#modify-email-link',
            '@modifyPasswordLink' => '#modify-password-link',
            '@deleteAccountLink' => '#delete-account-link',
            '@accountDeletionModal' => '#account-deletion-confirmation-modal',
            '@accountDeletionConfirmationButton' => '#account-deletion-confirmation-button'
        ];
    }

    public function waitForPageLoaded(Browser $browser) {
        $browser->waitFor('@deleteAccountLink');
    }

    public function navigateToModifyEmailPage(Browser $browser) {
        $browser->click('@modifyEmailLink');
    }

    public function navigateToModifyPasswordPage(Browser $browser) {
        $browser->click('@modifyPasswordLink');
    }

    public function openAccountDeletionModal(Browser $browser) {
        $browser->click('@deleteAccountLink')->waitFor('@accountDeletionModal');
    }
}
