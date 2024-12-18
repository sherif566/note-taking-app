<?php

namespace Database\Factories;

use App\Models\Note;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
    protected $model = Note::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'category_id' => Category::factory()->create()->id

        ];
    }
}
