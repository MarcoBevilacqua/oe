<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategorySpeciesResource;
use App\Interfaces\Filter;
use App\Services\RegionService;
use App\Services\SpeciesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SpeciesByCategoryController extends Controller
{
    public function __construct(protected Filter $filter)
    {}

    public function index(Request $request, string $categoryId, RegionService $regionService): JsonResponse
    {
        dd($request->getRequestUri());

        // init species service to inject dependency
        $speciesService = new SpeciesService($regionService);

        // load species from a random region (filter by category)
        $speciesList = $speciesService->fetch();

        // return filtered list
        $species = $this->filter->filter($speciesList, $categoryId);

        // return resource with concatenated text property
        return response()->json(
            collect($species)->map(function ($species) use ($regionService) {
                return new CategorySpeciesResource($species);
            })
        );
    }
}
