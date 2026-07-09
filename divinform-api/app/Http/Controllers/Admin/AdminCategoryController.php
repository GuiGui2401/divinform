<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    /**
     * GET /api/admin/categories
     */
    public function index(): JsonResponse
    {
        $categories = Category::ordered()
            ->withCount('products')
            ->get();

        return response()->json([
            'data' => CategoryResource::collection($categories),
        ]);
    }

    /**
     * POST /api/admin/categories
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:100|unique:categories,name',
            'icon'        => 'nullable|string|max:10',
            'image'       => 'nullable|string|max:1000',
            'description' => 'nullable|string|max:500',
            'color'       => 'nullable|string|max:10',
            'sort_order'  => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Données invalides.', 'errors' => $validator->errors()], 422);
        }

        $data         = $validator->validated();
        $data['slug'] = Str::slug($data['name']);

        $category = Category::create($data);

        $this->clearCategoryCache();

        return response()->json([
            'message' => 'Catégorie créée avec succès.',
            'data'    => new CategoryResource($category),
        ], 201);
    }

    /**
     * GET /api/admin/categories/{category}
     */
    public function show(Category $category): JsonResponse
    {
        $category->loadCount('products');
        return response()->json(['data' => new CategoryResource($category)]);
    }

    /**
     * PUT /api/admin/categories/{category}
     */
    public function update(Request $request, Category $category): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'        => "required|string|max:100|unique:categories,name,{$category->id}",
            'icon'        => 'nullable|string|max:10',
            'image'       => 'nullable|string|max:1000',
            'description' => 'nullable|string|max:500',
            'color'       => 'nullable|string|max:10',
            'active'      => 'nullable|boolean',
            'sort_order'  => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Données invalides.', 'errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category->update($data);
        $this->clearCategoryCache();

        return response()->json([
            'message' => 'Catégorie mise à jour.',
            'data'    => new CategoryResource($category->fresh()),
        ]);
    }

    /**
     * DELETE /api/admin/categories/{category}
     */
    public function destroy(Category $category): JsonResponse
    {
        if ($category->products()->count() > 0) {
            return response()->json([
                'message' => 'Impossible de supprimer une catégorie contenant des produits. Déplacez-les d\'abord.',
            ], 409);
        }

        $category->delete();
        $this->clearCategoryCache();

        return response()->json(['message' => 'Catégorie supprimée.']);
    }

    private function clearCategoryCache(): void
    {
        Cache::forget('public:categories');
    }
}
