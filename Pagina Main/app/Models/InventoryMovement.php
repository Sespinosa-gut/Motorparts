<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;


class InventoryMovement extends Model
{
    use HasFactory;

    protected $table = 'movimientos_inventario';

    protected $fillable = [
        'id_producto',
        'tipo',
        'cantidad',
        'precio_unitario',
        'tipo_referencia',
        'id_referencia',
        'nota',
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'id_producto');
    }

    public function reference(): MorphTo
    {
        return $this->morphTo();
    }
}
