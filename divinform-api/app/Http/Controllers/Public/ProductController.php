<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * GET /api/v1/products
     * Params: ?search=&category=&featured=&page=&per_page=
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::active()
            ->with(['category', 'specs'])
            ->ordered();

        // Filtre par catégorie (slug ou id)
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category)
                  ->orWhere('id', $request->category);
            });
        }

        // Recherche textuelle
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Mis en avant uniquement
        if ($request->boolean('featured')) {
            $query->featured();
        }

        $perPage  = min((int) $request->get('per_page', 12), 50);
        $products = $query->paginate($perPage);

        return response()->json([
            'data'          => ProductResource::collection($products->items()),
            'total'         => $products->total(),
            'per_page'      => $products->perPage(),
            'current_page'  => $products->currentPage(),
            'last_page'     => $products->lastPage(),
        ]);
    }

    /**
     * GET /api/v1/products/{slug}
     */
    public function show(string $slug): JsonResponse
    {
        $product = Product::active()
            ->where('slug', $slug)
            ->with(['category', 'specs'])
            ->firstOrFail();

        return response()->json([
            'data' => new ProductResource($product),
        ]);
    }

    /**
     * POST /api/v1/products/{id}/view
     */
    public function trackView(int $id): JsonResponse
    {
        $product = Product::active()->findOrFail($id);
        $product->incrementViews();

        return response()->json(['message' => 'Vue enregistrée.']);
    }

    /**
     * POST /api/v1/products/{id}/contact
     */
    public function trackContact(int $id): JsonResponse
    {
        $product = Product::active()->findOrFail($id);
        $product->incrementContact();

        return response()->json(['message' => 'Contact enregistré.']);
    }
}
