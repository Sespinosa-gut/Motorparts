<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'metodos_pago';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

 
   
  
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'id_metodo_pago');
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class, 'id_metodo_pago');
    }
}
