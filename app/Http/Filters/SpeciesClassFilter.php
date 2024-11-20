<?php

namespace App\Http\Filters;

use App\Interfaces\Filter;
use Illuminate\Support\Arr;

class SpeciesClassFilter implements Filter
{
    public function apply(array $list, string $identifier): array
    {
        return Arr::where($list, function ($species) use ($identifier) {
            return $species->class_name === $identifier;
        });
    }
}
