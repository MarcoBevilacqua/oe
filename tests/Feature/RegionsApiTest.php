<?php

namespace Tests\Feature;

use App\Services\RegionService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RegionsApiTest extends TestCase
{
    use WithoutMiddleware;

    public function setup(): void
    {
        parent::setup();
        Http::preventStrayRequests();

        Http::fake([
            'https://apiv3.iucnredlist.org/api/v3/region/*' => Http::response(
                [
                    'count' => 2,
                    'results' => [[
                        "name" => "Northeastern Africa",
                        "identifier" => "northeastern_africa"
                    ],
                        [
                            "name" => "Europe",
                            "identifier" => "europe"
                        ]],
                ]),
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_region_service_returns_identifier(): void
    {
        $regionService = new RegionService();
        $randomRegion = $regionService->getRandomRegion();
        $this->assertIsString($randomRegion);
        $this->assertContains($randomRegion, ["northeastern_africa", "europe"]);
    }
}
