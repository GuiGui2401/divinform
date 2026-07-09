<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FarmUnit extends Model
{
    public const TYPES = ['aviculture', 'pisciculture', 'porcin', 'cuniculture', 'autre'];

    protected $fillable = [
        'name', 'type', 'location', 'capacity', 'active', 'notes', 'sort_order',
    ];

    protected $casts = [
        'active'   => 'boolean',
        'capacity' => 'integer',
    ];

    public function batches()
    {
        return $this->hasMany(FarmBatch::class);
    }

    public function animals()
    {
        return $this->hasMany(FarmAnimal::class);
    }

    /** Effectif total vivant : bandes en cours + individus actifs. */
    public function getHeadcountAttribute(): int
    {
        return (int) $this->batches()->whereIn('status', ['en_cours', 'disponible'])->sum('current_qty')
             + (int) $this->animals()->where('status', 'actif')->count();
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
