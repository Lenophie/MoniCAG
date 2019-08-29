<?php

namespace Tests\Browser\Unit;

use Illuminate\Support\Facades\Lang;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\HomePage;
use Tests\DuskTestCase;

class LocaleSettingTest extends DuskTestCase
{
    public function testEnglishLocaleSetting() {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage)
                ->changeLocale('en')
                ->assertSee(Lang::get('messages.titles.borrowings_management', [], 'en'))
                ->assertSee(Lang::get('messages.titles.inventory_management', [], 'en'))
                ->assertSee(Lang::get('messages.titles.users_management', [], 'en'));
        });
    }

    public function testFrenchLocaleSetting() {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage)
                ->changeLocale('fr')
                ->assertSee(Lang::get('messages.titles.borrowings_management', [], 'fr'))
                ->assertSee(Lang::get('messages.titles.inventory_management', [], 'fr'))
                ->assertSee(Lang::get('messages.titles.users_management', [], 'fr'));
        });
    }
}
