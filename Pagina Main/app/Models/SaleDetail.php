<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleDetail extends Model
{
    use HasFactory;

    protected $table = 'detalles_venta';

    protected $fillable = [
        'id_venta',
        'id_producto',
        'cantidad',
        'precio',
        'subtotal',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'id_venta');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'id_producto');
    }
}
