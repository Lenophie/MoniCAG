<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class NewBorrowingPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/new-borrowing';
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
            '@checkoutLink' => '#checkout-link',
            '@newBorrowingModal' => '#borrowing-creation-modal',
            '@newBorrowingSubmitButton' => '#borrowing-creation-confirmation-button',
            '@checkoutCounter' => '#checkout-counter'
        ];
    }

    public function clickOnInventoryItemButton(Browser $browser, $id)
    {
        $browser->press("#inventory-item-button-{$id}");
    }

    public function clickOnInventoryItemRemovalFromBorrowingButton(Browser $browser, $id)
    {
        $browser->press("#remove-item-borrow-list-button-{$id}");
    }

    public function waitForInventoryItemInBorrowingList(Browser $browser, $id)
    {
        $browser->waitFor("#remove-item-borrow-list-button-{$id}");
    }
}
