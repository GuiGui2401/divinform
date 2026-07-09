<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormationSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'formation_id',
        'starts_on',
        'ends_on',
        'location',
        'seats',
        'seats_taken',
        'registration_open',
    ];

    protected $casts = [
        'starts_on'         => 'date',
        'ends_on'           => 'date',
        'seats'             => 'integer',
        'seats_taken'       => 'integer',
        'registration_open' => 'boolean',
    ];

    protected $appends = ['seats_left', 'is_full'];

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    /** Sessions futures dont les inscriptions sont ouvertes. */
    public function scopeUpcoming($query)
    {
        return $query->where('registration_open', true)
                     ->whereDate('starts_on', '>=', now()->toDateString());
    }

    /** `seats = 0` signifie « places non plafonnées ». */
    public function getSeatsLeftAttribute(): ?int
    {
        if (! $this->seats) {
            return null;
        }

        return max(0, $this->seats - $this->seats_taken);
    }

    public function getIsFullAttribute(): bool
    {
        return $this->seats > 0 && $this->seats_taken >= $this->seats;
    }
}
