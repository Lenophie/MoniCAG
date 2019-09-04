<?php

use App\Http\Middleware\ApiLocalization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class ApiLocalizationMiddlewareTest extends TestCase
{
    public function testFrenchLocalization() {
        $apiLocalizationMiddleware = new ApiLocalization();
        $request = new Request();

        $request->headers->set('X-Localization', 'fr');
        $apiLocalizationMiddleware->handle($request, function () {
           $this->assertEquals(App::getLocale(), 'fr');
        });
    }

    public function testEnglishLocalization() {
        $apiLocalizationMiddleware = new ApiLocalization();
        $request = new Request();

        $request->headers->set('X-Localization', 'en');
        $apiLocalizationMiddleware->handle($request, function () {
            $this->assertEquals(App::getLocale(), 'en');
        });
    }
}
