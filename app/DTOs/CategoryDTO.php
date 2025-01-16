<?php

namespace App\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class CategoryDTO extends DataTransferObject
{
    public string $name;
    public ?int $parent_id;
}
