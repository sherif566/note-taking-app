<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function store(Request $request)
    {
        $category = $this->categoryService->create($request);
        return response()->json($category, 201);
    }

    public function index()
    {
        $categories = $this->categoryService->getAll();
        return response()->json($categories);
    }

    public function show($id)
    {
        $category = $this->categoryService->get($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $category = $this->categoryService->update($request, $id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        return response()->json($category);
    }

    public function destroy($id)
    {
        $result = $this->categoryService->delete($id);
        if (!$result) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        return response()->json(['message' => 'Category deleted successfully']);
    }
}

