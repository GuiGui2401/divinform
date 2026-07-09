<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AdminStatsController extends Controller
{
    /**
     * GET /api/admin/stats
     */
    public function index(): JsonResponse
    {
        $stats = Cache::remember('admin:stats', 300, function () {
            return [
                'products_count'    => Product::where('active', true)->count(),
                'categories_count'  => Category::where('active', true)->count(),
                'users_count'       => User::count(),
                'views_total'       => Product::sum('views_count'),
                'contacts_total'    => Product::sum('contact_count'),

                // Top 5 produits les plus consultés
                'top_products' => Product::active()
                    ->select('id', 'name', 'views_count', 'contact_count')
                    ->orderByDesc('views_count')
                    ->limit(5)
                    ->get(),

                // Répartition par catégorie
                'by_category' => Category::active()
                    ->withCount(['products' => fn ($q) => $q->where('active', true)])
                    ->ordered()
                    ->get()
                    ->map(fn ($c) => [
                        'name'  => $c->name,
                        'icon'  => $c->icon,
                        'count' => $c->products_count,
                    ]),
            ];
        });

        return response()->json(['data' => $stats]);
    }
}
