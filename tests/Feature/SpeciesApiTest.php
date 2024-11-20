<?php

namespace Tests\Feature;

use App\Models\Species;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SpeciesApiTest extends TestCase
{

    private array $species = [];
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
            'https://apiv3.iucnredlist.org/api/v3/measures/*' => Http::response(
                [
                    'result' => [
                        [
                            "code" => "1.1",
                            "title" => "Site/area protection",
                        ],
                        [
                            "code" => "1.2",
                            "title" => "Resource & habitat protection",
                        ]
                    ],
                ])
        ]);
    }

    public function test_should_return_one_endangered_species(): void
    {
        $this->setFakeResponseForSpeciesApi([Species::factory()->count(1)->endangered()]);
        $response = $this->get('/species/CR/category')->assertStatus(200);
        $this->assertCount(1, $response->json());
    }

    private function setFakeResponseForSpeciesApi($data): void
    {
        Http::fake([
            'https://apiv3.iucnredlist.org/api/v3/species/region/*' => Http::response(
                ['result' => $data]
            )
        ]);
    }

    public function test_should_return_one_not_endangered_species(): void
    {
        $this->setFakeResponseForSpeciesApi([Species::factory()->count(1)->notEndangered()]);
        $response = $this->get('/species/NT/category')->assertStatus(200);
        $this->assertCount(1, $response->json());
    }

    public function test_should_return_no_species(): void
    {
        $this->setFakeResponseForSpeciesApi(Species::factory()->count(1)->make(['category' => 'DD']));
        $response = $this->get('/species/CR/category')->assertStatus(200);
        $this->assertCount(0, $response->json());
    }

    public function test_should_return_only_mammalia_species(): void
    {
        $this->setFakeResponseForSpeciesApi([Species::factory()->count(1)->mammal()]);
        $response = $this->get('/species/MAMMALIA/class')->assertStatus(200);
        $this->assertCount(1, $response->json());
    }
    public function test_should_return_not_mammal_species(): void
    {
        $this->setFakeResponseForSpeciesApi(Species::factory()->count(1)->make(['class_name' => 'ACTINOPTERYGII']),);
        $response = $this->get('/species/ACTINOPTERYGII/class')->assertStatus(200);
        $this->assertCount(1, $response->json());
    }

}
