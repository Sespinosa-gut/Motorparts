<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
    protected $table = 'usuarios';
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'id_rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'id_rol');
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'id_usuario');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'id_usuario');
    }

    public function isAdmin(): bool
    {
        return $this->id_rol === 1;
    }

    public function isCustomer(): bool
    {
        return $this->id_rol === 2;
    }
}
