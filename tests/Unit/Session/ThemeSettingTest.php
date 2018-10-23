<?php

use Tests\TestCase;

class ThemeSettingTest extends TestCase
{
    /**
     * Tests theme variable setting in session.
     *
     * @return void
     */
    public function testThemeSetting()
    {
        $this->get('/theme/light')
            ->assertSessionHas('theme', 'light');

        $this->get('/theme/dark')
            ->assertSessionHas('theme', 'dark');
    }
}
