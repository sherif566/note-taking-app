<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class PaginationDTO extends Data
{
    public function __construct(
        public int $per_page = 15,
        public int $page = 1
    ) {}
}
