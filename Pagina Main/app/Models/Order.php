<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $table = 'ordenes';

    protected $fillable = [
        'id_usuario',
        'id_metodo_pago',
        'numero_orden',
        'total',
        'estado',
        'comprobante_pago',
        'notas',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'id_metodo_pago');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'id_orden');
    }
}