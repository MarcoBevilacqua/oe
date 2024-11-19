<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategorySpeciesResource;
use App\Interfaces\Filter;
use App\Services\RegionService;
use App\Services\SpeciesService;
use Illuminate\Http\JsonResponse;

class SpeciesByCategoryController extends Controller
{
    public function index(string $regionId, string $categoryId, RegionService $regionService, Filter $filter): JsonResponse
    {
        // init species service to inject dependency
        $speciesService = new SpeciesService($regionService);

        // load species from a random region (filter by category)
        $speciesList = $speciesService->fetch($regionId);

        // return filtered list
        $species = $filter->filter($speciesList, $categoryId);

        // return resource with concatenated text property
        return response()->json(
            collect($species)->map(function ($species) use ($regionService) {
                return new CategorySpeciesResource($species);
            })
        );
    }
}
