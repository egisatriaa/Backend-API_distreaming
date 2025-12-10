<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::all();
        return response()->json([
            'message' => 'Categories berhasil ditampilkan.',
            'data' => $categories,
        ]);
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $data = $request->validated();

        $category = Category::create([
            'category_name' => $data['category_name'],
            'description' => $data['description'] ?? null,
        ]);

        return response()->json([
            'message' => 'Category berhasil ditambahkan.',
            'data' => $category,
        ], 201);
    }

    public function show(Category $category): JsonResponse
    {
        return response()->json([
            'message' => 'Category berhasil ditampilkan.',
            'data' => $category,
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $data = $request->validated();

        $category->update([
            'category_name' => $data['category_name'] ?? $category->category_name,
            'description' => $data['description'] ?? $category->description,
        ]);

        return response()->json([
            'message' => 'Category berhasil update.',
            'data' => $category,
        ]);
    }

    public function destroy(Request $request, Category $category): JsonResponse
    {
        $force = $request->boolean('force');

        if ($force) {
            $category->forceDelete();
            $message = 'Category dihapus permanen.';
        } else {
            $category->delete();
            $message = 'Category di soft delete';
        }

        return response()->json(['message' => $message]);
    }
}