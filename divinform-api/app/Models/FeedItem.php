<?php

namespace App\Models;

use App\Exceptions\StockException;
use Illuminate\Database\Eloquent\Model;

class FeedItem extends Model
{
    protected $fillable = ['name', 'unit', 'current_qty', 'alert_threshold', 'unit_cost', 'active'];

    protected $casts = [
        'current_qty'     => 'decimal:3',
        'alert_threshold' => 'decimal:3',
        'unit_cost'       => 'integer',
        'active'          => 'boolean',
    ];

    protected $appends = ['is_low'];

    public function movements()
    {
        return $this->hasMany(FeedMovement::class);
    }

    /** Un seuil à 0 signifie « pas d'alerte ». */
    public function getIsLowAttribute(): bool
    {
        return (float) $this->alert_threshold > 0
            && (float) $this->current_qty <= (float) $this->alert_threshold;
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeLowStock($query)
    {
        return $query->where('alert_threshold', '>', 0)
                     ->whereColumn('current_qty', '<=', 'alert_threshold');
    }

    /**
     * Recalcule le stock en rejouant tout l'historique des mouvements.
     *
     * Le stock n'est jamais incrémenté « à l'aveugle » : il est dérivé des
     * mouvements. Une suppression, une saisie antidatée ou un inventaire
     * repartent donc toujours d'un état cohérent.
     *
     * @throws StockException si le stock deviendrait négatif à un instant donné.
     */
    public function recomputeStock(): void
    {
        $running = 0.0;

        $movements = $this->movements()
            ->orderBy('occurred_on')
            ->orderBy('id')
            ->get();

        foreach ($movements as $movement) {
            $qty = (float) $movement->quantity;

            $running = match ($movement->type) {
                'entree'     => $running + $qty,
                'sortie',
                'perte'      => $running - $qty,
                'ajustement' => $qty,   // inventaire physique : valeur absolue
                default      => $running,
            };

            if ($running < 0) {
                throw new StockException(
                    "Stock négatif pour « {$this->name} » au {$movement->occurred_on->format('d/m/Y')} : "
                    . 'la quantité sortie dépasse le stock disponible à cette date.'
                );
            }

            if ((float) $movement->qty_after !== $running) {
                $movement->forceFill(['qty_after' => $running])->saveQuietly();
            }
        }

        $this->forceFill(['current_qty' => $running])->save();
    }
}
