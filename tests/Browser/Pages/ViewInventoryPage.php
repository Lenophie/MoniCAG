<?php

namespace Tests\Browser\Pages;

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

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@genreSelect' => '#genre-select',
            '@durationInput' => '#duration-input',
            '@playersInput' => '#players-input'
        ];
    }
}
