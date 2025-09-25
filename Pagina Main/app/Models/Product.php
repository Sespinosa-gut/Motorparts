<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'imagen',
        'id_marca',
        'id_proveedor',
        'activo',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'id_marca');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'id_proveedor');
    }

    public function saleDetails(): HasMany
    {
        return $this->hasMany(SaleDetail::class, 'id_producto');
    }

    public function inventoryMovements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class, 'id_producto');
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'id_producto');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'id_producto');
    }
}
