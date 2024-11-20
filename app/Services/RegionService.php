<?php

namespace App\Services;

use http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RegionService
{
    private const LIST_URL = 'region/list';

    private const API_RESULT_KEY = 'results';

    /**
     * @var $regionsList array
     * stores the region list and retrieve the random element
     */
    private array $regionsList = [];

    /**
     * @return string
     * return the identifier from a random region
     */
    public function getRandomRegion(): string
    {
        // get from cache if already loaded
        if (empty($this->regionsList)) {
            $this->fetch();
        }

        return empty($this->regionsList) ? '' : Arr::random($this->regionsList)['identifier'];
    }

    /**
     * @return void
     * fetch the region list from IUCN Red list Api
     */
    public function fetch(): void
    {
        /** @var Response $response */
        $response = Http::iucn()->get(self::LIST_URL);

        // handle error
        if (!$response->successful()) {
            Log::error("Cannot load regions from API: " .  $response->getResponseStatus());
        }

        // store results in cache, no need to display
        $this->regionsList = $response->json(self::API_RESULT_KEY)?? [];
    }
}
