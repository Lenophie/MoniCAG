<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class EditInventoryPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/edit-inventory';
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
            '@newItemFrenchNameInput' => '#nameFr-new',
            '@newItemEnglishNameInput' => '#nameEn-new',
            '@newItemGenreSelect' => '#add-genre-select-new',
            '@newItemGenresList' => '#genres-ul-new',
            '@newItemDurationMinInput' => '#durationMin-new',
            '@newItemDurationMaxInput' => '#durationMax-new',
            '@newItemPlayersMinInput' => '#playersMin-new',
            '@newItemPlayersMaxInput' => '#playersMax-new',
            '@newItemSubmitButton' => '#add-item-submit-button',
            '@deletionConfirmationModal' => '#delete-confirm-modal',
            '@deletionConfirmationButton' => '#delete-confirm-button'
        ];
    }

    public function pressOnRemoveGenreButton(Browser $browser, $itemId, $genreId) {
        $browser->click("#button-remove-genre-{$genreId}-for-{$itemId}");
    }

    public function pressOnPatchItemButton(Browser $browser, $itemId) {
        $browser->press("#edit-item-{$itemId}-submit-button");
    }

    public function pressOnDeleteItemButton(Browser $browser, $itemId) {
        $browser->press("#delete-button-{$itemId}");
    }
}
