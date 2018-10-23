<?php

use Tests\TestCase;

class LocaleSettingTest extends TestCase
{
    /**
     * Tests locale variable setting in session.
     *
     * @return void
     */
    public function testLocaleSetting()
    {
        $this->get('/lang/fr')
            ->assertSessionHas('locale_lang', 'fr');

        $this->get('/lang/en')
            ->assertSessionHas('locale_lang', 'en');
    }
}
