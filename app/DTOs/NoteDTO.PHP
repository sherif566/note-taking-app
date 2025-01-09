<?php

namespace App\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class NoteDTO extends DataTransferObject
{
    public string $title;
    public string $description;
    public ?int $category_id;

    public static function from(array $data): self
    {
        return new self([
            'title' => $data['title'],
            'description' => $data['description'],
            'category_id' => $data['category_id'] ?? null,
        ]);
    }
}
