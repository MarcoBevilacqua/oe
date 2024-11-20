<?php

namespace App\Services;

use App\Models\Species;
use http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SpeciesService {

    private const URL = 'species/';
    private const REGION_PARAM = 'region/';
    private const PAGE_PARAM = '/page/';

    private const API_RESULT_KEY = 'result';

    private RegionService $regionService;

    public function __construct(RegionService $regionService)
    {
        $this->regionService = $regionService;
    }

    /**
     * @param int $page
     * @return array
     *
     * fetch species
     */
    public function fetch(int $page = 0): array
    {
        // retrieve random region identifier
        $regionId = $this->regionService->getRandomRegion();

        if(!$regionId) {
            return [];
        }

        /** @var Response $response */
        $response = Http::iucn()->get(self::URL . self::REGION_PARAM . $regionId . self::PAGE_PARAM . $page);

        // handle error
        if (!$response->successful()) {
            Log::error("Cannot fetch species from API: " . $response->getResponseStatus());
            return [];
        }

        // return results as array of species
        return Arr::map($response->json(self::API_RESULT_KEY), function ($item) use ($regionId) {
            return new Species([
                'taxonid'    => $item['taxonid'],
                'category' => $item['category'],
                'class_name' => $item['class_name'],
                'region_id' => $regionId,
            ]);
        });
    }

    /**
     * @param array $species
     * @return array
     *
     * Add the measures text property to a species collection
     */
    public function addMeasures(array $species): array
    {
        return Arr::map($species, function ($speciesItem) {
            $speciesItem->measures = MeasuresService::getMeasuresForSpecies($speciesItem->taxonid, $speciesItem->region_id);
        });
    }
}
