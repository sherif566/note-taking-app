<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
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

    // Get notes by category name
    public function getNotesByCategory($categoryName)
    {
        $notes = $this->categoryService->getNotesByCategory($categoryName);

        // If no notes found, return a 404 error
        if (!$notes) {
            return response()->json(['error' => 'Category not found or no notes available'], 404);
        }

        // Return notes associated with the category
        return response()->json($notes, 200);
    }

    // Get a category by ID
    public function show($id)
    {
        $category = $this->categoryService->findCategoryById($id);
        return response()->json($category);
    }

    // Create a new category

    public function store(StoreCategoryRequest $request)
    {
        return $this->categoryService->createCategory($request->validated());
    }

    // Update a category
    public function update(UpdateCategoryRequest $request, $id)
    {
        return $this->categoryService->updateCategory($id, $request->validated());
    }

    // Delete a category
    public function destroy($id)
    {
        $category = $this->categoryService->findCategoryById($id);

        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $this->categoryService->deleteCategory($category);

        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}
