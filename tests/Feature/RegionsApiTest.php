<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RegionsApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_should_call_regions_api(): void
    {
        Http::fake();

        $this->get('/regions')->assertStatus(200)
            ->assertJsonStructure(['title', 'identifier']);
    }
}
