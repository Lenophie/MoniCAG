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

    public function waitForPageLoaded(Browser $browser) {
        $browser->waitFor('.inventory-item-button')
            ->waitFor('@checkoutLink');
    }

    public function openNewBorrowingModal(Browser $browser) {
        $browser->click('@checkoutLink')->waitFor('@newBorrowingModal');
    }

    public function clickOnInventoryItemButton(Browser $browser, $id)
    {
        $idString = "#inventory-item-button-{$id}";
        $browser->press($idString);
    }

    public function clickOnInventoryItemRemovalFromBorrowingButton(Browser $browser, $id)
    {
        $idString = "#remove-item-borrow-list-button-{$id}";
        $browser->press($idString);
    }

    public function waitForInventoryItemInBorrowingList(Browser $browser, $id) {
        $idString = "#to-borrow-list-element-{$id}";
        $browser->waitFor($idString);
    }
}
