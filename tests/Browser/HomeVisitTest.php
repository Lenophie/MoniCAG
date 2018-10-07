<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class HomeVisitTest extends DuskTestCase
{
    public function testHomeVisit()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('MoniCAG');
        });
    }
}
