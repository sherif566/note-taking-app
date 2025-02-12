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

    public function __construct(private CategoryService $categoryService) {}

    public function index(CategorySearchRequest $request): JsonResponse
    {
        Log::info('Category retrieval started.', ['request' => $request->validated()]);

        $dto = CategorySearchDTO::from($request->validated());
        $categories = $this->categoryService->getAll($dto);

        Log::info('Category retrieval completed.', [
            'request' => $request->validated(),
            'categories_count' => $categories->count()
        ]);

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
        Log::info('Category storing started.', ['request' => $request->validated()]);

        $dto = CategoryDTO::from($request->validated());
        $category = $this->categoryService->create($dto);

        Log::info('Created a new category', ['category_id' => $category->id]);

        return $this->success(new CategoryResource($category), 'Category created successfully', JsonResponse::HTTP_CREATED);
    }

    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        Log::info('Category updating started.', ['request' => $request->validated()]);

        $dto = CategoryDTO::from($request->validated());
        $updatedCategory = $this->categoryService->update($category, $dto);

        Log::info('Updated the category', ['category_id' => $updatedCategory->id]);

        return $this->success(new CategoryResource($updatedCategory), 'Category updated successfully');
    }

    public function destroy(Category $category): JsonResponse
    {
        Log::info('Category deletion started.', ['category_id' => $category->id, 'category_name' => $category->name]);

        $this->categoryService->delete($category);

        Log::info('Category deletion completed.', ['category_id' => $category->id]);

        return $this->success(null, 'Category deleted successfully', JsonResponse::HTTP_OK);
    }

}
