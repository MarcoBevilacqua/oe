<?php

namespace App\Services;

use http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MeasuresService
{
    private const MEASURES_URL = 'measures/species/id/';

    /**
     * @param int $speciesId
     * @param string $region
     * @return string
     *
     * retrieve measures for given species and region
     * return as a concatenated text property
     */
    public static function getMeasuresForSpecies(int $speciesId, string $region): string {

        $measures = [];

        /** @var Response $response */
        $response = Http::iucn()->get(${self::MEASURES_URL . $speciesId . "/region/" . $region });

        // handle error
        if (!$response->successful()) {
            Log::error("Cannot fetch measures from API: " .  $response->getResponseStatus());
        }

        foreach ($response->json('result') as $measure) {
            $measures[] = $measure['title'];
        }

        return Arr::join($measures, ",");
    }

}
