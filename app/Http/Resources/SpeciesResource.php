<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpeciesResource extends JsonResource
{
    public static function collection($resource)
    {
        return SpeciesResource::collection($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
                'id' => $this->taxonid,
                'class_name' => $this->class_name,
                'category' => $this->category,
                'measures' => $this->measures
            ];
    }
}
