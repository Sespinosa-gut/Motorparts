<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            ['nombre' => 'Efectivo', 'activo' => true],
            ['nombre' => 'Tarjeta', 'activo' => true],
            ['nombre' => 'Daviplata', 'activo' => true],
            ['nombre' => 'Nequi', 'activo' => true],
            ['nombre' => 'Transferencia', 'activo' => true],
        ];

        foreach ($methods as $method) {
            PaymentMethod::firstOrCreate(['nombre' => $method['nombre']], $method);
        }
    }
}
