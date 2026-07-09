<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedMovement extends Model
{
    public const TYPES = ['entree', 'sortie', 'perte', 'ajustement'];

    protected $fillable = [
        'feed_item_id', 'farm_batch_id', 'user_id', 'type',
        'quantity', 'qty_after', 'unit_cost', 'occurred_on', 'note',
    ];

    protected $casts = [
        'quantity'    => 'decimal:3',
        'qty_after'   => 'decimal:3',
        'unit_cost'   => 'integer',
        'occurred_on' => 'date',
    ];

    public function item()
    {
        return $this->belongsTo(FeedItem::class, 'feed_item_id');
    }

    public function batch()
    {
        return $this->belongsTo(FarmBatch::class, 'farm_batch_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Une ration : sortie de stock affectée à une bande. */
    public function scopeRations($query)
    {
        return $query->where('type', 'sortie')->whereNotNull('farm_batch_id');
    }
}
