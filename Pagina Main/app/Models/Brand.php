<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'marcas';

    protected $fillable = [
        'nombre',
    ];

    protected $primaryKey = 'id';
    
    public function getRouteKeyName()
    {
        return 'id';
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'id_marca');
    }
}
