<?php

namespace Tests\Browser\Pages;

use Facebook\WebDriver\Exception\TimeOutException;
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

    public function waitForPageLoaded(Browser $browser) {
        $browser->waitUntilVue('flags.isMounted', true, '#app', 30);
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@itemCollapseLink' => '#inventory-item-collapse-link',
            '@genreCollapseLink' => '#genre-collapse-link',
            '@itemCreationButton' => '#inventory-item-creation-modal-open-button',
            '@genreCreationButton' => '#genre-creation-modal-open-button',
            '@itemCreationModal' => '#inventory-item-creation-modal',
            '@genreCreationModal' => '#genre-creation-modal',
            '@itemUpdateModal' => '#inventory-item-update-modal',
            '@genreUpdateModal' => '#genre-update-modal',
            '@itemDeletionModal' => '#inventory-item-deletion-modal',
            '@genreDeletionModal' => '#genre-deletion-modal',
            '@itemsList' => '#inventory-item-collapsible-list',
            '@genresList' => '#genre-collapsible-list',
            '@itemCreationConfirmationButton' => '#inventory-item-creation-confirmation-button',
            '@genreCreationConfirmationButton' => '#genre-creation-confirmation-button',
            '@itemUpdateConfirmationButton' => '#inventory-item-update-confirmation-button',
            '@genreUpdateConfirmationButton' => '#genre-update-confirmation-button',
            '@itemDeletionConfirmationButton' => '#inventory-item-deletion-confirmation-button',
            '@genreDeletionConfirmationButton' => '#genre-deletion-confirmation-button',
        ];
    }

    // Clicks

    public function clickOnItemButton(Browser $browser, $id) {
        $idString = "#inventory-item-card-button-{$id}";
        $browser->click($idString);
    }

    public function clickOnGenreButton(Browser $browser, $id) {
        $idString = "#genre-card-button-{$id}";
        $browser->click($idString);
    }

    public function clickOnItemDeletionButton(Browser $browser, $id) {
        $idString = "#inventory-item-card-deletion-button-{$id}";
        $browser->click($idString);
    }

    public function clickOnGenreDeletionButton(Browser $browser, $id) {
        $idString = "#genre-card-deletion-button-{$id}";
        $browser->click($idString);
    }

    public function clickOnRemoveAltNameTag(Browser $browser, $altName) {
        $idString = "#remove-alt-name-tag-{$altName}";
        $browser->click($idString);
    }

    // Modals opening

    /**
     * Clicks on the item collapse link then on a given inventory item button
     * @param Browser $browser
     * @param $id
     * @param $function
     * @throws TimeOutException
     */
    public function whenItemUpdateModalAvailable(Browser $browser, $id, $function) {
        $browser->click('@itemCollapseLink')
            ->whenAvailable('@itemsList', function (Browser $list) use ($id) {
                $list->clickOnItemButton($id);
            })
            ->waitFor('@itemUpdateModal')->with('@itemUpdateModal', $function);
    }

    /**
     * Clicks on the item collapse link then on a given inventory item deletion button
     * @param Browser $browser
     * @param $id
     * @param $function
     * @throws TimeOutException
     */
    public function whenItemDeletionModalAvailable(Browser $browser, $id, $function) {
        $browser->click('@itemCollapseLink')
            ->whenAvailable('@itemsList', function (Browser $list) use ($id) {
                $list->clickOnItemDeletionButton($id);
            })
            ->waitFor('@itemDeletionModal')->with('@itemDeletionModal', $function);
    }

    /**
     * Clicks on the genre collapse link then on a given genre button
     * @param Browser $browser
     * @param $id
     * @param $function
     * @throws TimeOutException
     */
    public function whenGenreUpdateModalAvailable(Browser $browser, $id, $function) {
        $browser->click('@genreCollapseLink')
            ->whenAvailable('@genresList', function (Browser $list) use ($id) {
                $list->clickOnGenreButton($id);
            })
            ->waitFor('@genreUpdateModal')->with('@genreUpdateModal', $function);
    }

    /**
     * Clicks on the genre collapse link then on a given genre deletion button
     * @param Browser $browser
     * @param $id
     * @param $function
     * @throws TimeOutException
     */
    public function whenGenreDeletionModalAvailable(Browser $browser, $id, $function) {
        $browser->click('@genreCollapseLink')
            ->whenAvailable('@genresList', function (Browser $list) use ($id) {
                $list->clickOnGenreDeletionButton($id);
            })
            ->waitFor('@genreDeletionModal')->with('@genreDeletionModal', $function);
    }
}
