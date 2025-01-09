<?php

namespace App\Services;

use App\Models\Note;
use App\Models\Category;

class ValidationService
{
    /**
     * Validates that a note belongs to a specific category.
     *
     * @param Note $note
     * @param Category $category
     * @return bool
     */
    public function validateNoteCategory(Note $note, Category $category): bool
    {
        return $note->category_id === $category->id;
    }
}
