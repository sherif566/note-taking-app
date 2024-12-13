<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    // Constructor to inject CategoryService
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    // Get all categories
    public function index()
    {
        $categories = $this->categoryService->getAllCategories();
        return response()->json($categories);
    }

    // Get a category by ID
    public function show($id)
    {
        $category = $this->categoryService->findCategoryById($id);
        return response()->json($category);
    }

    // Create a new category
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = $this->categoryService->createCategory($data);
        return response()->json($category, 201);
    }

    // Update a category
    public function update(Request $request, $id)
    {
        $category = $this->categoryService->findCategoryById($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $updatedCategory = $this->categoryService->updateCategory($category, $data);
        return response()->json($updatedCategory);
    }

    // Delete a category
    public function destroy($id)
    {
        $category = $this->categoryService->findCategoryById($id);

        $this->categoryService->deleteCategory($category);
        return response()->json(null, 204);
    }
}
