<?php

namespace App\Http\Controllers;

use App\Http\Resources\SpeciesResource;
use App\Interfaces\Filter;
use App\Services\RegionService;
use App\Services\SpeciesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

class SpeciesByCategoryController extends Controller
{
    // inject filter interface
    public function __construct(protected Filter $filter)
    {}

    public function index(string $categoryId, RegionService $regionService): JsonResponse
    {
        // init species service to inject dependency
        $speciesService = new SpeciesService($regionService);

        // load species from a random region (filter by category)
        $speciesList = $speciesService->fetch();

        // apply filter
        $species = $this->filter->apply($speciesList, $categoryId);

        // add measures to species array
        $speciesService->addMeasures($species);

        // return resource with concatenated text property
        return response()->json(
            Arr::map($species, function ($item) {
                return new SpeciesResource($item);
            })
        );
    }
}
