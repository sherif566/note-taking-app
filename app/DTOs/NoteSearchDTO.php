<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class NoteSearchDTO extends Data
{
    public function __construct(
    public ?string $title = null,
    public ?string $description = null,
    public ?int $category_id = null,
    public int $per_page = 15,
    public int $page = 1,
    ) {}
}
