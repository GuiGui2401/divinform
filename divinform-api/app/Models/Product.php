<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'short_desc',
        'description',
        'images',
        'badge',
        'badge_color',
        'featured',
        'active',
        'views_count',
        'contact_count',
        'sort_order',
    ];

    protected $casts = [
        'images'        => 'array',
        'featured'      => 'boolean',
        'active'        => 'boolean',
        'views_count'   => 'integer',
        'contact_count' => 'integer',
    ];

    // ── Relations ─────────────────────────────────────
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function specs()
    {
        return $this->hasMany(ProductSpec::class)->orderBy('sort_order');
    }

    // ── Auto-slug ─────────────────────────────────────
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && ! $product->isDirty('slug')) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    // ── Scopes ────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'LIKE', "%{$term}%")
              ->orWhere('short_desc', 'LIKE', "%{$term}%")
              ->orWhere('description', 'LIKE', "%{$term}%");
        });
    }

    // ── Helpers ───────────────────────────────────────
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function incrementContact(): void
    {
        $this->increment('contact_count');
    }
}
