<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AdminProductController extends Controller
{
    /**
     * GET /api/admin/products
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::with(['category', 'specs'])->ordered();

        if ($request->filled('search'))   $query->search($request->search);
        if ($request->filled('category')) $query->where('category_id', $request->category);
        if ($request->filled('active'))   $query->where('active', $request->boolean('active'));

        $perPage  = min((int) $request->get('per_page', 15), 100);
        $products = $query->paginate($perPage);

        return response()->json([
            'data'         => ProductResource::collection($products->items()),
            'total'        => $products->total(),
            'per_page'     => $products->perPage(),
            'current_page' => $products->currentPage(),
            'last_page'    => $products->lastPage(),
        ]);
    }

    /**
     * POST /api/admin/products
     */
    public function store(Request $request): JsonResponse
    {
        $this->normalizeBooleans($request);

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:200|unique:products,name',
            'short_desc'  => 'required|string|max:300',
            'description' => 'nullable|string',
            'badge'       => 'nullable|string|max:30',
            'badge_color' => 'nullable|string|max:10',
            'featured'    => 'nullable|boolean',
            'active'      => 'nullable|boolean',
            'sort_order'  => 'nullable|integer',
            'images.*'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_urls'  => 'nullable|array',
            'image_urls.*' => 'nullable|string|max:1000',
            'specs'       => 'nullable|array',
            'specs.*.label' => 'required_with:specs|string|max:100',
            'specs.*.value' => 'required_with:specs|string|max:200',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Données invalides.', 'errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        unset($data['image_urls']);
        $data['slug'] = Str::slug($data['name']);
        $urls = array_values(array_filter((array) $request->input('image_urls', []), fn ($u) => filled($u)));
        $data['images'] = array_merge($urls, $this->handleImageUploads($request));

        $product = Product::create($data);

        if (! empty($data['specs'])) {
            foreach ($data['specs'] as $i => $spec) {
                $product->specs()->create(['label' => $spec['label'], 'value' => $spec['value'], 'sort_order' => $i]);
            }
        }

        return response()->json([
            'message' => 'Produit créé avec succès.',
            'data'    => new ProductResource($product->load(['category', 'specs'])),
        ], 201);
    }

    /**
     * GET /api/admin/products/{product}
     */
    public function show(Product $product): JsonResponse
    {
        return response()->json(['data' => new ProductResource($product->load(['category', 'specs']))]);
    }

    /**
     * PUT /api/admin/products/{product}
     */
    public function update(Request $request, Product $product): JsonResponse
    {
        $this->normalizeBooleans($request);

        $validator = Validator::make($request->all(), [
            'category_id' => 'sometimes|exists:categories,id',
            'name'        => "sometimes|string|max:200|unique:products,name,{$product->id}",
            'short_desc'  => 'sometimes|string|max:300',
            'description' => 'nullable|string',
            'badge'       => 'nullable|string|max:30',
            'badge_color' => 'nullable|string|max:10',
            'featured'    => 'nullable|boolean',
            'active'      => 'nullable|boolean',
            'sort_order'  => 'nullable|integer',
            'images.*'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_urls'  => 'nullable|array',
            'image_urls.*' => 'nullable|string|max:1000',
            'specs'       => 'nullable|array',
            'specs.*.label' => 'required_with:specs|string|max:100',
            'specs.*.value' => 'required_with:specs|string|max:200',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Données invalides.', 'errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        unset($data['image_urls']);
        if (isset($data['name'])) $data['slug'] = Str::slug($data['name']);

        // Le formulaire envoie la liste complète des images (URLs conservées + uploads).
        if ($request->boolean('manage_images') || $request->hasFile('images')) {
            $urls = array_values(array_filter((array) $request->input('image_urls', []), fn ($u) => filled($u)));
            $data['images'] = array_merge($urls, $this->handleImageUploads($request));
        }

        $product->update($data);

        if (array_key_exists('specs', $data)) {
            $product->specs()->delete();
            foreach ($data['specs'] as $i => $spec) {
                $product->specs()->create(['label' => $spec['label'], 'value' => $spec['value'], 'sort_order' => $i]);
            }
        }

        return response()->json([
            'message' => 'Produit mis à jour.',
            'data'    => new ProductResource($product->fresh()->load(['category', 'specs'])),
        ]);
    }

    /**
     * DELETE /api/admin/products/{product}
     */
    public function destroy(Product $product): JsonResponse
    {
        foreach ($product->images ?? [] as $imagePath) {
            Storage::delete(str_replace('/storage/', 'public/', $imagePath));
        }
        $product->delete();
        return response()->json(['message' => 'Produit supprimé.']);
    }

    /**
     * POST /api/admin/products/{product}/images
     */
    public function uploadImages(Request $request, Product $product): JsonResponse
    {
        $request->validate([
            'images'   => 'required|array|max:5',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $newImages = $this->handleImageUploads($request);
        $product->update(['images' => array_merge($product->images ?? [], $newImages)]);

        return response()->json([
            'message' => 'Images uploadées avec succès.',
            'data'    => new ProductResource($product->fresh()),
        ]);
    }

    /**
     * DELETE /api/admin/products/{product}/images/{index}
     */
    public function deleteImage(Product $product, int $index): JsonResponse
    {
        $images = $product->images ?? [];
        if (! isset($images[$index])) {
            return response()->json(['message' => 'Image introuvable.'], 404);
        }
        Storage::delete(str_replace('/storage/', 'public/', $images[$index]));
        array_splice($images, $index, 1);
        $product->update(['images' => $images]);
        return response()->json(['message' => 'Image supprimée.', 'data' => new ProductResource($product->fresh())]);
    }

    // ── Private ───────────────────────────────────────

    /**
     * Le formulaire (multipart) envoie les selects sous forme de chaînes
     * "true"/"false" que la règle `boolean` de Laravel rejette. On les
     * convertit en vrais booléens avant validation.
     */
    private function normalizeBooleans(Request $request): void
    {
        foreach (['featured', 'active'] as $field) {
            if ($request->has($field)) {
                $request->merge([$field => $request->boolean($field)]);
            }
        }
    }

    private function handleImageUploads(Request $request): array
    {
        $paths = [];

        if ($request->hasFile('images')) {
            $manager = new ImageManager(new Driver());

            foreach ($request->file('images') as $file) {
                $filename  = Str::uuid() . '.webp';
                $directory = 'public/products';

                // Intervention Image v3 API
                $image = $manager->read($file->getRealPath())
                    ->scaleDown(width: 1200, height: 900)
                    ->toWebp(quality: 85);

                Storage::put("{$directory}/{$filename}", (string) $image);
                $paths[] = Storage::url("{$directory}/{$filename}");
            }
        }

        return $paths;
    }
}
