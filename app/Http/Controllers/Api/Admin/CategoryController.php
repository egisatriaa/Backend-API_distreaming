<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\Admin\CategoryAdminResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

class CategoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->integer('per_page', 10), 100);

        $categories = Category::withTrashed()
            ->orderByDesc('created_at')
            ->paginate($perPage);

        return ApiResponse::success(
            CategoryAdminResource::collection($categories->items()),
            'Categories fetched successfully.',
            200,
            [
                'current_page' => $categories->currentPage(),
                'last_page' => $categories->lastPage(),
                'per_page' => $categories->perPage(),
                'total' => $categories->total(),
            ]
        );
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = Category::create($request->validated());

        return ApiResponse::success(
            new CategoryAdminResource($category),
            'Category created successfully.',
            201
        );
    }

    public function show(Category $category): JsonResponse
    {
        return ApiResponse::success(
            new CategoryAdminResource($category),
            'Category detail fetched successfully.'
        );
    }

    public function update(
        UpdateCategoryRequest $request,
        Category $category
    ): JsonResponse {
        $category->update($request->validated());

        return ApiResponse::success(
            new CategoryAdminResource($category),
            'Category updated successfully.'
        );
    }

    public function destroy(
        Request $request,
        Category $category
    ): JsonResponse {
        $force = $request->boolean('force');

        if ($force) {
            if (!$category->trashed()) {
                return ApiResponse::error(
                    'Hard delete hanya bisa dilakukan setelah soft delete.',
                    422
                );
            }

            $category->forceDelete();

            return ApiResponse::success(
                null,
                'Category permanently deleted.'
            );
        }

        if ($category->trashed()) {
            return ApiResponse::error(
                'Category already soft deleted.',
                400
            );
        }

        $category->delete();

        return ApiResponse::success(
            null,
            'Category soft deleted.'
        );
    }
}
