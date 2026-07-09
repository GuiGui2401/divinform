<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    /**
     * GET /api/v1/categories
     */
    public function index(): JsonResponse
    {
        $categories = Cache::remember('public:categories', 600, function () {
            return Category::active()
                ->ordered()
                ->withCount(['products' => fn ($q) => $q->where('active', true)])
                ->get();
        });

        return response()->json([
            'data' => CategoryResource::collection($categories),
        ]);
    }

    /**
     * GET /api/v1/categories/{slug}
     */
    public function show(string $slug): JsonResponse
    {
        $category = Category::active()
            ->where('slug', $slug)
            ->withCount(['products' => fn ($q) => $q->where('active', true)])
            ->firstOrFail();

        $products = $category->products()
            ->active()
            ->with('specs')
            ->ordered()
            ->paginate(12);

        return response()->json([
            'data'     => new CategoryResource($category),
            'products' => $products,
        ]);
    }
}
