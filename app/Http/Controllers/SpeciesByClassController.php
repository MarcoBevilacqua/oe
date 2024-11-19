<?php

namespace App\Http\Controllers;

use App\Http\Resources\SpeciesResource;
use App\Interfaces\Filter;
use App\Services\RegionService;
use App\Services\SpeciesService;
use Illuminate\Http\JsonResponse;

class SpeciesByClassController extends Controller
{
    public function __construct(protected Filter $filter)
    {}

    public function index(string $classId, RegionService $regionService): JsonResponse
    {
        // init species service to inject dependency
        $speciesService = new SpeciesService($regionService);

        // load species from a random region (filter by category)
        $speciesList = $speciesService->fetch();

        // apply filter
        $species = $this->filter->apply($speciesList, $classId);

        // return resource with concatenated text property
        return response()->json(
            collect($species)->map(function ($species) use ($regionService) {
                return new SpeciesResource($species);
            })
        );
    }
}
