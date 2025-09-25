<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create([
            'nombre' => 'Administrador',
            'descripcion' => 'Acceso completo al sistema, puede gestionar productos, ventas y usuarios',
        ]);

        Role::create([
            'nombre' => 'Usuario',
            'descripcion' => 'Puede ver el catálogo, agregar productos al carrito y realizar compras',
        ]);
    }
}