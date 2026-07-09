<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Formation;
use App\Models\FormationSession;
use App\Models\Inscription;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class AdminStatsController extends Controller
{
    /**
     * GET /api/admin/stats
     */
    public function index(): JsonResponse
    {
        $stats = Cache::remember('admin:stats', 300, function () {
            return array_merge($this->formationStats(), [
                // ── Produits de la ferme (volet secondaire) ──
                'products_count'    => Product::where('active', true)->count(),
                'categories_count'  => Category::where('active', true)->count(),
                'users_count'       => User::count(),
                'views_total'       => Product::sum('views_count'),
                'contacts_total'    => Product::sum('contact_count'),

                'top_products' => Product::active()
                    ->select('id', 'name', 'views_count', 'contact_count')
                    ->orderByDesc('views_count')
                    ->limit(5)
                    ->get(),

                'by_category' => Category::active()
                    ->withCount(['products' => fn ($q) => $q->where('active', true)])
                    ->ordered()
                    ->get()
                    ->map(fn ($c) => [
                        'name'  => $c->name,
                        'icon'  => $c->icon,
                        'count' => $c->products_count,
                    ]),
            ]);
        });

        return response()->json(['data' => $stats]);
    }

    /**
     * Indicateurs du centre de formation.
     *
     * Renvoie des valeurs neutres tant que les migrations du module Formation
     * n'ont pas été appliquées, pour ne pas casser le tableau de bord.
     */
    private function formationStats(): array
    {
        if (! Schema::hasTable('formations')) {
            return [
                'formations_ready'    => false,
                'formations_count'    => 0,
                'sessions_upcoming'   => 0,
                'inscriptions_new'    => 0,
                'inscriptions_total'  => 0,
                'formation_views'     => 0,
                'top_formations'      => [],
                'recent_inscriptions' => [],
            ];
        }

        return [
            'formations_ready'   => true,
            'formations_count'   => Formation::where('active', true)->count(),
            'sessions_upcoming'  => FormationSession::upcoming()->count(),
            'inscriptions_new'   => Inscription::new()->count(),
            'inscriptions_total' => Inscription::count(),
            'formation_views'    => Formation::sum('views_count'),

            // Top 5 formations les plus consultées
            'top_formations' => Formation::active()
                ->select('id', 'title', 'views_count', 'contact_count')
                ->orderByDesc('views_count')
                ->limit(5)
                ->get(),

            // Dernières demandes d'inscription
            'recent_inscriptions' => Inscription::latest()
                ->select('id', 'name', 'phone', 'formation_title', 'status', 'created_at')
                ->limit(5)
                ->get(),
        ];
    }
}
