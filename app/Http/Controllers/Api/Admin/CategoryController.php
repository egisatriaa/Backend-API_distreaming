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
        $categories = Category::whereNull('deleted_at')->get();
        return response()->json([
            'success' => true,
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
            'success' => true,
            'message' => 'Category berhasil ditambahkan.',
            'data' => $category,
        ], 201);
    }

    public function show(string $category): JsonResponse
    {
        if (!is_numeric($category)) {
            return response()->json([
                'success' => false,
                'message' => 'ID category tidak valid.',
            ], 400);
        }

        $category = Category::withTrashed()->find((int) $category);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Categori tidak ditemukan',
            ], 404);
        }

        if ($category->deleted_at) {
            return response()->json([
                'success' => false,
                'message' => 'Category ini sudah di soft delete.',
            ], 404);
        }

        return response()->json([
            'success' => true,
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
            'success' => true,
            'message' => 'Category berhasil update.',
            'data' => $category,
        ]);
    }

    public function destroy(Request $request, string $category): JsonResponse
    {
        if (!is_numeric($category)) {
            return response()->json([
                'success' => false,
                'message' => 'ID tidak valid'
            ], 400);
        }

        $category = Category::withTrashed()->find((int) $category);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category tidak ditemukan'
            ], 404);
        }
        $force = $request->boolean('force');

        if ($force) {
            // Hanya boleh hard delete jika sudah di soft delete
            if (is_null($category->deleted_at)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak bisa menghapus permanen category yang masih aktif. Silakan soft delete terlebih dahulu.',
                ], 422);
            }

            $category->forceDelete();
            $message = 'Category dihapus permanen.';
        } else {
            // Soft delete hanya jika belum dihapus
            if (!is_null($category->deleted_at)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category ini sudah di soft delete.',
                ], 400);
            }

            $category->delete();
            $message = 'Category berhasil di soft delete.';
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }
}
