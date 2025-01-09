<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use App\DTOs\CategoryDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use App\Traits\RespondsWithHttpStatus;

class CategoryController extends Controller
{
    use RespondsWithHttpStatus;

    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request): JsonResponse
    {
        $query = Category::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'LIKE', "%{$search}%");
            Log::info('Searching categories', ['search' => $search]);
        }

        $categories = $query->get();
        Log::info('Retrieved categories based on search criteria.');

        return $this->success(CategoryResource::collection($categories), 'Categories retrieved successfully');
    }

    public function show(Category $category): JsonResponse
    {
        Log::info('Displayed category', ['category_id' => $category->id]);
        return $this->success(new CategoryResource($category), 'Category details retrieved successfully');
    }

    public function store(CategoryRequest $request): JsonResponse
    {
        $validated = $request->validated();  // Ensure data is validated
        $dto = new CategoryDTO($validated['name'], $validated['parent_id'] ?? null);

        try {
            $category = $this->categoryService->create($dto);
            Log::info('Created a new category', ['category_id' => $category->id]);
            return $this->success(new CategoryResource($category), 'Category created successfully', JsonResponse::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error('Failed to create category', ['error' => $e->getMessage()]);
            return $this->error('Failed to create category', [], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        $validated = $request->validated();
        $dto = new CategoryDTO($validated['name'], $validated['parent_id'] ?? null);

        try {
            $updatedCategory = $this->categoryService->update($category, $dto);
            Log::info('Updated category', ['category_id' => $updatedCategory->id]);
            return $this->success(new CategoryResource($updatedCategory), 'Category updated successfully');
        } catch (\Exception $e) {
            Log::error('Failed to update category', ['error' => $e->getMessage()]);
            return $this->error('Failed to update category', [], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Category $category): JsonResponse
    {
        try {
            $this->categoryService->delete($category);
            Log::info('Deleted category', ['category_id' => $category->id]);
            return $this->success(null, 'Category deleted successfully', JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Failed to delete category', ['error' => $e->getMessage()]);
            return $this->error('Failed to delete category', [], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
