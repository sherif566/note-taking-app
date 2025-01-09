<?php

namespace App\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class CategoryDTO extends DataTransferObject
{
    public string $name;
    public ?int $parent_id;

    public static function from(array $data): self
    {
        return new self([
            'name' => $data['name'],
            'parent_id' => $data['parent_id'] ?? null,
        ]);
    }
}
