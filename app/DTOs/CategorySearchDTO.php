<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class CategorySearchDTO extends Data
{
    public ?string $name = null;
    public ?int $parent_id = null;
    public int $per_page = 15;
    public int $page = 1;
}
