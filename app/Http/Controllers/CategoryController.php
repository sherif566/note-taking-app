<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategorySearchRequest;
use App\Services\CategoryService;
use App\DTOs\CategoryDTO;
use App\DTOs\CategorySearchDTO;
use Illuminate\Http\JsonResponse;
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

    public function index(CategorySearchRequest $request): JsonResponse
    {
        $dto = new CategorySearchDTO($request->validated());

        $categories = $this->categoryService->searchCategories($dto);

        Log::info('Retrieved categories based on search criteria.', $request->validated());

        return $this->success(
            CategoryResource::collection($categories),
            'Categories retrieved successfully'
        );
    }

    public function show(Category $category): JsonResponse
    {
        Log::info('Displayed category', ['category_id' => $category->id]);
        return $this->success(new CategoryResource($category), 'Category details retrieved successfully');
    }

    public function store(CategoryRequest $request): JsonResponse
    {
        $dto = new CategoryDTO($request->validated());
        $category = $this->categoryService->create($dto);
        Log::info('Created a new category', ['category_id' => $category->id]);
        return $this->success(new CategoryResource($category), 'Category created successfully', JsonResponse::HTTP_CREATED);
    }

    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        $dto = new CategoryDTO($request->validated());
        $updatedCategory = $this->categoryService->update($category, $dto);
        Log::info('Updated category', ['category_id' => $updatedCategory->id]);
        return $this->success(new CategoryResource($updatedCategory), 'Category updated successfully');
    }

    public function destroy(Category $category): JsonResponse
    {
        $this->categoryService->delete($category);
        Log::info('Deleted category', ['category_id' => $category->id]);
        return $this->success(null, 'Category deleted successfully', JsonResponse::HTTP_OK);
    }
}
