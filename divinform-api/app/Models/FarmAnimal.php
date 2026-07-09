<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FarmAnimal extends Model
{
    public const STATUSES = ['actif', 'vendu', 'reforme', 'mort'];

    protected $fillable = [
        'farm_unit_id', 'farm_batch_id', 'tag', 'name', 'species', 'breed',
        'sex', 'born_on', 'entered_on', 'status', 'notes',
    ];

    protected $casts = [
        'born_on'    => 'date',
        'entered_on' => 'date',
    ];

    public function unit()
    {
        return $this->belongsTo(FarmUnit::class, 'farm_unit_id');
    }

    public function batch()
    {
        return $this->belongsTo(FarmBatch::class, 'farm_batch_id');
    }

    public function healthEvents()
    {
        return $this->hasMany(HealthEvent::class, 'farm_animal_id');
    }

    public function scopeAlive($query)
    {
        return $query->where('status', 'actif');
    }
}
