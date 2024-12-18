<?php

namespace App\Http\Controllers;
use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->getAllCategories();
        return response()->json($categories);
    }

    public function getNotesByCategory($categoryName)
    {
        $notes = $this->categoryService->getNotesByCategory($categoryName);

        if (!$notes) {
            return response()->json(['error' => 'Category not found or no notes available'], 404);
        }

        return response()->json($notes, 200);
    }

    public function show($id)
    {
        $category = $this->categoryService->findCategoryById($id);
        return response()->json($category);
    }


    public function store(CategoryRequest $request)
    {
        return $this->categoryService->createCategory($request->validated());
    }

    public function update(CategoryRequest $request, $id)
    {
        return $this->categoryService->updateCategory($id, $request->validated());
    }

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
