<?php

namespace App\Services;

use http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RegionService
{
    private const LIST_URL = 'region/list';

    /**
     * @var $regionsList array
     * stores the region list and retrieve the random element
     */
    private array $regionsList = [];

    public function getRandomRegion(): array
    {
        return Arr::random($this->regionsList);
    }

    /**
     * @return void
     * get the region list from IUCN Api
     */
    private function getRegionList(): void
    {
        /** @var Response $response */
        $response = Http::iucn()
            ->get(self::LIST_URL);

        // handle error
        if (!$response->successful()) {
            Log::error("Cannot load regions from API: " .  $response->getResponseStatus());
        }

        $this->regionsList = $response->json('results');
    }
}
