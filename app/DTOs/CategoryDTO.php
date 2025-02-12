<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class CategoryDTO extends Data
{
    public function __construct(
        public string $name,
        public ?int $parent_id = null
    ) {}
}
