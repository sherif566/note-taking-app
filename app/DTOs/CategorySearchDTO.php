<?php

namespace App\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class CategorySearchDTO extends DataTransferObject
{
    public ?string $name = null;        // Nullable: Search by category name
    public ?int $parent_id = null;      // Nullable: Filter by parent_id
    public int $per_page = 15;          // Default: 15 items per page
    public int $page = 1;               // Default: First page
}
