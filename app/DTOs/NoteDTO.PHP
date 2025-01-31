<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class NoteDTO extends Data
{
    public string $title;
    public string $description;
    public ?int $category_id;
}

