<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Formation extends Model
{
    use HasFactory;

    public const LEVELS = ['debutant', 'intermediaire', 'avance'];

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'description',
        'level',
        'duration',
        'prerequisites',
        'objectives',
        'program',
        'certification',
        'price',
        'currency',
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
        'objectives'    => 'array',
        'program'       => 'array',
        'images'        => 'array',
        'featured'      => 'boolean',
        'active'        => 'boolean',
        'price'         => 'integer',
        'views_count'   => 'integer',
        'contact_count' => 'integer',
    ];

    // ── Relations ─────────────────────────────────────
    public function sessions()
    {
        return $this->hasMany(FormationSession::class)->orderBy('starts_on');
    }

    /** Sessions à venir, encore ouvertes aux inscriptions. */
    public function upcomingSessions()
    {
        return $this->hasMany(FormationSession::class)
                    ->upcoming()
                    ->orderBy('starts_on');
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    // ── Auto-slug ─────────────────────────────────────
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($formation) {
            if (empty($formation->slug)) {
                $formation->slug = Str::slug($formation->title);
            }
        });

        static::updating(function ($formation) {
            if ($formation->isDirty('title') && ! $formation->isDirty('slug')) {
                $formation->slug = Str::slug($formation->title);
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
        return $query->orderBy('sort_order')->orderBy('title');
    }

    public function scopeLevel($query, string $level)
    {
        return $query->where('level', $level);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('title', 'LIKE', "%{$term}%")
              ->orWhere('summary', 'LIKE', "%{$term}%")
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
