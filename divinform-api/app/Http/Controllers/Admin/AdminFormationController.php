<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\FormationResource;
use App\Models\Formation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AdminFormationController extends Controller
{
    /**
     * GET /api/admin/formations
     */
    public function index(Request $request): JsonResponse
    {
        $query = Formation::with('sessions')->ordered();

        if ($request->filled('search')) $query->search($request->search);
        if ($request->filled('level'))  $query->level($request->level);
        if ($request->filled('active')) $query->where('active', $request->boolean('active'));

        $perPage    = min((int) $request->get('per_page', 15), 100);
        $formations = $query->paginate($perPage);

        return response()->json([
            'data'         => FormationResource::collection($formations->items()),
            'total'        => $formations->total(),
            'per_page'     => $formations->perPage(),
            'current_page' => $formations->currentPage(),
            'last_page'    => $formations->lastPage(),
        ]);
    }

    /**
     * POST /api/admin/formations
     */
    public function store(Request $request): JsonResponse
    {
        $this->normalizeInput($request);

        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->fails()) {
            return response()->json(['message' => 'Données invalides.', 'errors' => $validator->errors()], 422);
        }

        $data = $this->prepare($validator->validated());
        $data['slug'] = Str::slug($data['title']);
        $data['images'] = $this->collectImages($request);

        $formation = Formation::create($data);

        return response()->json([
            'message' => 'Formation créée avec succès.',
            'data'    => new FormationResource($formation->load('sessions')),
        ], 201);
    }

    /**
     * GET /api/admin/formations/{formation}
     */
    public function show(Formation $formation): JsonResponse
    {
        return response()->json(['data' => new FormationResource($formation->load('sessions'))]);
    }

    /**
     * PUT /api/admin/formations/{formation}
     */
    public function update(Request $request, Formation $formation): JsonResponse
    {
        $this->normalizeInput($request);

        $validator = Validator::make($request->all(), $this->rules($formation->id));

        if ($validator->fails()) {
            return response()->json(['message' => 'Données invalides.', 'errors' => $validator->errors()], 422);
        }

        $data = $this->prepare($validator->validated());
        if (isset($data['title'])) $data['slug'] = Str::slug($data['title']);

        if ($request->boolean('manage_images') || $request->hasFile('images')) {
            $data['images'] = $this->collectImages($request);
        }

        $formation->update($data);

        return response()->json([
            'message' => 'Formation mise à jour.',
            'data'    => new FormationResource($formation->fresh()->load('sessions')),
        ]);
    }

    /**
     * DELETE /api/admin/formations/{formation}
     */
    public function destroy(Formation $formation): JsonResponse
    {
        foreach ($formation->images ?? [] as $imagePath) {
            Storage::delete(str_replace('/storage/', 'public/', $imagePath));
        }
        $formation->delete();

        return response()->json(['message' => 'Formation supprimée.']);
    }

    // ── Private ───────────────────────────────────────

    private function rules(?int $ignoreId = null): array
    {
        $unique  = 'unique:formations,title' . ($ignoreId ? ",{$ignoreId}" : '');
        $require = $ignoreId ? 'sometimes' : 'required';

        return [
            'title'         => "{$require}|string|max:200|{$unique}",
            'summary'       => "{$require}|string|max:300",
            'description'   => 'nullable|string',
            'level'         => 'nullable|in:' . implode(',', Formation::LEVELS),
            'duration'      => 'nullable|string|max:60',
            'prerequisites' => 'nullable|string',
            'certification' => 'nullable|string|max:150',
            'price'         => 'nullable|integer|min:0',
            'currency'      => 'nullable|string|max:8',
            'badge'         => 'nullable|string|max:30',
            'badge_color'   => 'nullable|string|max:10',
            'featured'      => 'nullable|boolean',
            'active'        => 'nullable|boolean',
            'sort_order'    => 'nullable|integer',
            'images.*'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_urls'    => 'nullable|array',
            'image_urls.*'  => 'nullable|string|max:1000',
            'objectives'    => 'nullable|array',
            'objectives.*'  => 'string|max:300',
            'program'       => 'nullable|array',
            'program.*.title'  => 'required_with:program|string|max:150',
            'program.*.detail' => 'nullable|string|max:600',
        ];
    }

    /** Retire les clés qui ne sont pas des colonnes de la table. */
    private function prepare(array $data): array
    {
        unset($data['image_urls']);
        return $data;
    }

    /**
     * Le formulaire (multipart) envoie booléens et tableaux en chaînes.
     */
    private function normalizeInput(Request $request): void
    {
        foreach (['featured', 'active'] as $field) {
            if ($request->has($field)) {
                $request->merge([$field => $request->boolean($field)]);
            }
        }

        // `objectives` et `program` transitent en JSON dans un FormData.
        foreach (['objectives', 'program'] as $field) {
            $value = $request->input($field);
            if (is_string($value)) {
                $decoded = json_decode($value, true);
                $request->merge([$field => is_array($decoded) ? $decoded : []]);
            }
        }

        // Un tarif vide signifie « nous consulter », pas zéro.
        if ($request->has('price') && $request->input('price') === '') {
            $request->merge(['price' => null]);
        }
    }

    private function collectImages(Request $request): array
    {
        $urls = array_values(array_filter((array) $request->input('image_urls', []), fn ($u) => filled($u)));
        return array_merge($urls, $this->handleImageUploads($request));
    }

    private function handleImageUploads(Request $request): array
    {
        $paths = [];

        if ($request->hasFile('images')) {
            $manager = new ImageManager(new Driver());

            foreach ($request->file('images') as $file) {
                $filename = Str::uuid() . '.webp';

                $image = $manager->read($file->getRealPath())
                    ->scaleDown(width: 1200, height: 900)
                    ->toWebp(quality: 85);

                Storage::put("public/formations/{$filename}", (string) $image);
                $paths[] = Storage::url("public/formations/{$filename}");
            }
        }

        return $paths;
    }
}
