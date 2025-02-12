<?php

namespace App\DTOs;

class CategorySearchDTO extends PaginationDTO
{
    public function __construct(
        public ?string $name = null,
        public ?int $parent_id = null,

    ) {}
}
