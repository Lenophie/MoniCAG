<?php

namespace Tests\Browser\Pages;

use Facebook\WebDriver\WebDriverBy;
use Laravel\Dusk\Browser;

class ViewInventoryPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/view-inventory';
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

    // Necessary because value is not a string
    public function clickOptionFromGenreDropdown(Browser $browser, $id) : void {
        $selector = "//select[@name='genre']/option[@id='genre-option-{$id}']";
        $browser->driver->findElement(WebDriverBy::xpath($selector))->click();
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [

        ];
    }
}
