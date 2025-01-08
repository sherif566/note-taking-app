<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use App\DTOs\CategoryDTO;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        $categories = $this->categoryService->getAll();
        Log::info('Retrieved all categories');
        return CategoryResource::collection($categories);
    }

    public function show(Category $category): CategoryResource
    {
        Log::info('Displayed category', ['category_id' => $category->id]);
        return new CategoryResource($category);
    }

    public function store(CategoryRequest $request): CategoryResource
    {
        $dto = new CategoryDTO(
            name: $request->get('name'),
            parent_id: $request->get('parent_id')
        );

        $category = $this->categoryService->create($dto);
        Log::info('Created a new category', ['category_id' => $category->id]);
        return new CategoryResource($category);
    }

    public function update(CategoryRequest $request, Category $category): CategoryResource
    {
        $dto = new CategoryDTO(
            name: $request->get('name'),
            parent_id: $request->get('parent_id')
        );

        $updatedCategory = $this->categoryService->update($category, $dto);
        Log::info('Updated category', ['category_id' => $category->id]);
        return new CategoryResource($updatedCategory);
    }

    public function destroy(Category $category): JsonResponse
    {
        $this->categoryService->delete($category);
        Log::info('Deleted category', ['category_id' => $category->id]);
        return response()->json(['message' => 'Category deleted successfully'], Response::HTTP_OK);
    }
}
