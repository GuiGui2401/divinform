<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthEvent extends Model
{
    public const TYPES = ['traitement', 'vaccination', 'visite', 'mortalite'];

    protected $fillable = [
        'farm_batch_id', 'farm_animal_id', 'user_id', 'type', 'label',
        'medicine', 'dose', 'quantity', 'occurred_on', 'next_due_on',
        'withdrawal_until', 'cost', 'note',
    ];

    protected $casts = [
        'quantity'         => 'integer',
        'cost'             => 'integer',
        'occurred_on'      => 'date',
        'next_due_on'      => 'date',
        'withdrawal_until' => 'date',
    ];

    public function batch()
    {
        return $this->belongsTo(FarmBatch::class, 'farm_batch_id');
    }

    public function animal()
    {
        return $this->belongsTo(FarmAnimal::class, 'farm_animal_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Rappels de vaccination arrivant à échéance. */
    public function scopeDueBy($query, $date)
    {
        return $query->whereNotNull('next_due_on')->whereDate('next_due_on', '<=', $date);
    }

    public function scopeType($query, string $type)
    {
        return $query->where('type', $type);
    }
}
