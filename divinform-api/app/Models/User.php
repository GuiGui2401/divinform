<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'active'            => 'boolean',
    ];

    // ── Rôles disponibles ─────────────────────────────
    const ROLES = ['super_admin', 'editor', 'viewer', 'farm_manager'];

    public function isFarmManager(): bool
    {
        return $this->role === 'farm_manager';
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isEditor(): bool
    {
        return in_array($this->role, ['super_admin', 'editor']);
    }

    // ── JWT ───────────────────────────────────────────
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [
            'role'  => $this->role,
            'email' => $this->email,
        ];
    }
}
