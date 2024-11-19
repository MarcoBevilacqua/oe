<?php

namespace App\Http\Resources;

use App\Services\MeasuresService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategorySpeciesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
            [
                'id' => $this->taxonid,
                'class_name' => $this->class_name,
                'category' => $this->category,
                'measures' => MeasuresService::getMeasuresForSpecies($this->taxonid, $request->regionId)
            ];
    }
}
