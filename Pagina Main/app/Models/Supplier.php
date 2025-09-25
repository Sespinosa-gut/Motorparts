<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'contacto',
        'email',
        'telefono',
        'direccion',
        'activo',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'id_proveedor');
    }

}
