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

        /** @var Response $response */
        $response = Http::iucn()->get(self::URL . self::REGION_PARAM . $regionId . self::PAGE_PARAM . $page);

        // handle error
        if (!$response->successful()) {
            Log::error("Cannot fetch species from API: " . $response->getResponseStatus());
        }

        // return results as array of species (with region_id)
        return
            collect($response->json('results'))->map(function ($item) use ($regionId) {
                return new Species([
                    'category' => $item['category'],
                    'class_name' => $item['class_name'],
                    'region_id' => $regionId,
                ]);
            })->toArray();
    }

    /**
     * @param array $species
     * @return array
     *
     * Add the measures text property to a species collection
     */
    public function addMeasures(array $species): array
    {
        return collect($species)->map(function ($item) {
            $item['measures'] = MeasuresService::getMeasuresForSpecies($item->id, $item->region_id);
        })->toArray();
    }
}
