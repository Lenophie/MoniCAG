<?php

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LocalizationFileRequestTest extends TestCase
{

    /**
     * Tests localization file request.
     *
     * @return void
     */
    public function testLocalizationFileRequest()
    {
        Storage::fake('public');

        $this->artisan('lang:generate');

        // French file
        $response = $this->withHeader('X-Localization', 'fr')
            ->json('GET', '/storage/lang.json', []);
        $response->assertStatus(302)
            ->assertHeader("location", asset('storage/lang/fr.json'));

        // English file
        $response = $this->withHeader('X-Localization', 'en')
            ->json('GET', '/storage/lang.json', []);
        $response->assertStatus(302)
            ->assertHeader("location", asset('storage/lang/en.json'));
    }
}
