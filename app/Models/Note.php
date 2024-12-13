<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'category_id'];

    // A note belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
