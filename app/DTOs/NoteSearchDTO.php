<?php

namespace App\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class NoteSearchDTO extends DataTransferObject
{
    public ?string $title = null;
    public ?string $description = null;
    public ?int $category_id = null;
    public int $per_page = 15;
    public int $page = 1;
}
