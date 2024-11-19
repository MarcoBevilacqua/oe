<?php

namespace App\Http\Filters;

use App\Interfaces\Filter;

class SpeciesClassFilter implements Filter
{
    public function apply(array $list, string $identifier): array
    {
        return collect($list)->filter(function ($species) use ($identifier) {
            return $species->class_name === $identifier;
        })->toArray();
    }
}
