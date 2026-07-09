<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    public const STATUSES = ['nouvelle', 'contactee', 'confirmee', 'annulee'];

    protected $fillable = [
        'formation_id',
        'formation_session_id',
        'formation_title',
        'name',
        'phone',
        'email',
        'message',
        'status',
        'admin_note',
        'ip',
    ];

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function session()
    {
        return $this->belongsTo(FormationSession::class, 'formation_session_id');
    }

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeNew($query)
    {
        return $query->where('status', 'nouvelle');
    }
}
