<?php

namespace App\Http\Controllers;

use App\Interfaces\Filter;
use App\Services\RegionService;
use App\Services\SpeciesService;
use Illuminate\Http\JsonResponse;

class SpeciesByClassController extends Controller
{
    public function index(string $classId, RegionService $regionService, Filter $filter): JsonResponse
    {
        // init species service to inject dependency
        $speciesService = new SpeciesService($regionService);

        // load species from a random region (filter by category)
        $speciesService->fetch(0, $filter);

        // return resource with concatenated text property
        return response()->json();
    }
}
