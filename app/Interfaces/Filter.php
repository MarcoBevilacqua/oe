<?php

namespace App\Interfaces;

interface Filter
{
    public function apply(array $list, string $identifier): array;
}
