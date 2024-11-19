<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategorySpeciesResource;
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

        // return filtered list
        $species = $this->filter->filter($speciesList, $classId);

        // return resource with concatenated text property
        return response()->json(
            collect($species)->map(function ($species) use ($regionService) {
                return new CategorySpeciesResource($species);
            })
        );
    }
}
