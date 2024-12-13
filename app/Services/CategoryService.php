<?php
namespace App\Services;

use App\Models\Category;
use App\Models\Note;
use Illuminate\Http\Request;

class CategoryService
{
    //Create new category
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id'
        ]);
        return Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ]);
    }

    //Get all Categories
    public function getAll()
    {
        return Category::with('parent')->get();
    }

    //Get a specific Category
    public function get($id)
    {
        return Category::with('parent')->find($id);
    }

    //Update a Category
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id'
        ]);
        $category = Category::find($id);
        if (!$category) {
            return null;
        }
        $category->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ]);
        return $category;
    }

    //Delete a category
    public function delete($id)
    {
        $category= Category::find($id);
        if (!$category) {
            return null;
        }
        $category->delete();
        return true;

    }
}
