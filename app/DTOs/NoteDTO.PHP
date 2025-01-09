<?php

namespace App\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class NoteDTO extends DataTransferObject
{
    public string $title;
    public string $description;
    public ?int $category_id = null;
}
