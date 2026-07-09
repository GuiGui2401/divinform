<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FarmBatch extends Model
{
    public const STATUSES = ['en_cours', 'disponible', 'termine'];

    protected $fillable = [
        'farm_unit_id', 'product_id', 'code', 'species', 'breed',
        'started_on', 'expected_end_on', 'initial_qty', 'current_qty',
        'avg_weight_g', 'status', 'notes',
    ];

    protected $casts = [
        'started_on'      => 'date',
        'expected_end_on' => 'date',
        'initial_qty'     => 'integer',
        'current_qty'     => 'integer',
        'avg_weight_g'    => 'integer',
    ];

    protected $appends = ['mortality_count', 'mortality_rate'];

    // ── Relations ─────────────────────────────────────
    public function unit()
    {
        return $this->belongsTo(FarmUnit::class, 'farm_unit_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function movements()
    {
        return $this->hasMany(FeedMovement::class);
    }

    public function healthEvents()
    {
        return $this->hasMany(HealthEvent::class);
    }

    public function animals()
    {
        return $this->hasMany(FarmAnimal::class);
    }

    // ── Indicateurs ───────────────────────────────────
    public function getMortalityCountAttribute(): int
    {
        return max(0, $this->initial_qty - $this->current_qty);
    }

    public function getMortalityRateAttribute(): float
    {
        if (! $this->initial_qty) {
            return 0.0;
        }

        return round($this->mortality_count / $this->initial_qty * 100, 2);
    }

    /**
     * L'effectif vivant est dérivé : effectif initial moins les mortalités
     * enregistrées. Supprimer un événement de mortalité saisi par erreur
     * restaure donc l'effectif sans intervention.
     */
    public function recomputeHeadcount(): void
    {
        $dead = (int) $this->healthEvents()->where('type', 'mortalite')->sum('quantity');

        $this->forceFill([
            'current_qty' => max(0, $this->initial_qty - $dead),
        ])->save();
    }

    /**
     * Indice de consommation : kilos d'aliment distribués par kilo de poids vif.
     * Retourne null tant que le poids moyen n'est pas renseigné.
     */
    public function feedConversionRatio(): ?float
    {
        if (! $this->avg_weight_g || ! $this->current_qty) {
            return null;
        }

        $feedKg = (float) $this->movements()->where('type', 'sortie')->sum('quantity');
        $liveKg = $this->current_qty * $this->avg_weight_g / 1000;

        return $liveKg > 0 ? round($feedKg / $liveKg, 3) : null;
    }

    // ── Scopes ────────────────────────────────────────
    public function scopeAvailable($query)
    {
        return $query->where('status', 'disponible');
    }

    public function scopeOpen($query)
    {
        return $query->whereIn('status', ['en_cours', 'disponible']);
    }
}
