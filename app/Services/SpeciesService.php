<?php

namespace App\Services;

use App\Models\Species;
use http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SpeciesService {
    
    private const URL = 'species/region/';
    private const REGION_PARAM = 'region/';
    private const PAGE_PARAM = 'page/';

    public function fetch(string $region, int $page): array
    {
        /** @var Response $response */
        $response = Http::iucn()->get(self::URL . self::REGION_PARAM . $region . self::PAGE_PARAM . $page);

        // handle error
        if (!$response->successful()) {
            Log::error("Cannot fetch species from API: " .  $response->getResponseStatus());
        }

        // return an array of species
        return collect($response->json('results'))->map(function ($item) {
            return new Species([
                'category'      => $item['category'],
                'class_name'    => $item['class_name'],
            ]);
        })->toArray();
    }
}
