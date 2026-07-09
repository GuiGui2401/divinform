<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $editor;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin    = User::factory()->create(['role' => 'super_admin', 'active' => true]);
        $this->editor   = User::factory()->create(['role' => 'editor', 'active' => true]);
        $this->category = Category::factory()->create(['active' => true]);
    }

    // ── PUBLIC ────────────────────────────────────────
    public function test_public_can_list_active_products(): void
    {
        Product::factory(5)->create(['category_id' => $this->category->id, 'active' => true]);
        Product::factory(2)->create(['category_id' => $this->category->id, 'active' => false]);

        $this->getJson('/api/v1/products')
             ->assertStatus(200)
             ->assertJsonCount(5, 'data');
    }

    public function test_public_can_filter_products_by_category(): void
    {
        $other = Category::factory()->create();
        Product::factory(3)->create(['category_id' => $this->category->id, 'active' => true]);
        Product::factory(2)->create(['category_id' => $other->id, 'active' => true]);

        $this->getJson("/api/v1/products?category={$this->category->slug}")
             ->assertStatus(200)
             ->assertJsonCount(3, 'data');
    }

    public function test_public_can_search_products(): void
    {
        Product::factory()->create([
            'category_id' => $this->category->id,
            'name'        => 'Scanner IRM Haute Résolution',
            'active'      => true,
        ]);
        Product::factory(3)->create(['category_id' => $this->category->id, 'active' => true]);

        $this->getJson('/api/v1/products?search=Scanner')
             ->assertStatus(200)
             ->assertJsonCount(1, 'data');
    }

    public function test_public_can_view_product_detail(): void
    {
        $product = Product::factory()->create([
            'category_id' => $this->category->id,
            'active'      => true,
        ]);

        $this->getJson("/api/v1/products/{$product->slug}")
             ->assertStatus(200)
             ->assertJsonPath('data.id', $product->id);
    }

    public function test_track_view_increments_counter(): void
    {
        $product = Product::factory()->create(['category_id' => $this->category->id, 'active' => true]);
        $initial = $product->views_count;

        $this->postJson("/api/v1/products/{$product->id}/view")
             ->assertStatus(200);

        $this->assertEquals($initial + 1, $product->fresh()->views_count);
    }

    // ── ADMIN ─────────────────────────────────────────
    public function test_admin_can_create_product(): void
    {
        $token = auth('api')->login($this->admin);

        $this->withHeader('Authorization', "Bearer {$token}")
             ->postJson('/api/admin/products', [
                 'name'        => 'Scanner Test XR-2000',
                 'category_id' => $this->category->id,
                 'short_desc'  => 'Scanner de test haute performance',
                 'description' => 'Description complète du scanner de test.',
             ])
             ->assertStatus(201)
             ->assertJsonPath('data.name', 'Scanner Test XR-2000');
    }

    public function test_editor_can_create_product(): void
    {
        $token = auth('api')->login($this->editor);

        $this->withHeader('Authorization', "Bearer {$token}")
             ->postJson('/api/admin/products', [
                 'name'        => 'Microscope Éditeur',
                 'category_id' => $this->category->id,
                 'short_desc'  => 'Microscope pour test éditeur',
             ])
             ->assertStatus(201);
    }

    public function test_guest_cannot_create_product(): void
    {
        $this->postJson('/api/admin/products', [
            'name'        => 'Produit intrus',
            'category_id' => $this->category->id,
            'short_desc'  => 'Tentative non autorisée',
        ])->assertStatus(401);
    }

    public function test_admin_can_update_product(): void
    {
        $product = Product::factory()->create(['category_id' => $this->category->id]);
        $token   = auth('api')->login($this->admin);

        $this->withHeader('Authorization', "Bearer {$token}")
             ->putJson("/api/admin/products/{$product->id}", [
                 'name'       => 'Nom modifié',
                 'short_desc' => 'Description modifiée',
             ])
             ->assertStatus(200)
             ->assertJsonPath('data.name', 'Nom modifié');
    }

    public function test_admin_can_delete_product(): void
    {
        $product = Product::factory()->create(['category_id' => $this->category->id]);
        $token   = auth('api')->login($this->admin);

        $this->withHeader('Authorization', "Bearer {$token}")
             ->deleteJson("/api/admin/products/{$product->id}")
             ->assertStatus(200);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_create_product_validates_required_fields(): void
    {
        $token = auth('api')->login($this->admin);

        $this->withHeader('Authorization', "Bearer {$token}")
             ->postJson('/api/admin/products', [])
             ->assertStatus(422)
             ->assertJsonStructure(['errors']);
    }
}
