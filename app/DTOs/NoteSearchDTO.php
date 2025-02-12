<?php

namespace App\DTOs;


class NoteSearchDTO extends PaginationDTO
{
    public function __construct(
    public ?string $title = null,
    public ?string $description = null,
    public ?int $category_id = null,
        ) {}
}
