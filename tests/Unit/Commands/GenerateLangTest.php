<?php

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GenerateLangTest extends TestCase
{
    /**
     * Tests language files generation command
     *
     * @return void
     */
    public function testGenerateLangCommand()
    {
        Storage::fake('public');

        $this->artisan('lang:generate')
            ->expectsOutput(__('messages.console.lang_generate.success'));

        Storage::disk('public')
            ->assertExists('lang/fr.json')
            ->assertExists('lang/en.json');
    }
}
