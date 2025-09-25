<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar las migraciones.
     * 
     * Esta migración unificada crea toda la estructura de la base de datos
     * del sistema Motorparts en una sola operación.
     */
    public function up()
    {
        // Tabla de roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });

        // Tabla de usuarios
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->foreignId('id_rol')->default(2)->constrained('roles');
            $table->rememberToken();
            $table->timestamps();
        });

        // Tabla de marcas
        Schema::create('marcas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Tabla de proveedores
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('contacto')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->text('direccion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Tabla de productos
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 12, 2);
            $table->integer('stock')->default(0);
            $table->string('imagen')->nullable();
            $table->foreignId('id_marca')->nullable()->constrained('marcas');
            $table->foreignId('id_proveedor')->nullable()->constrained('proveedores');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Tabla de métodos de pago
        Schema::create('metodos_pago', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Tabla de clientes
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('documento');
            $table->string('nombre');
            $table->string('correo')->nullable();
            $table->string('telefono')->nullable();
            $table->text('direccion')->nullable();
            $table->timestamps();
        });

        // Tabla de ventas
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_cliente')->nullable()->constrained('clientes');
            $table->foreignId('id_usuario')->nullable()->constrained('usuarios');
            $table->foreignId('id_metodo_pago')->nullable()->constrained('metodos_pago');
            $table->string('numero_comprobante')->nullable();
            $table->date('fecha');
            $table->time('hora');
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->timestamps();
        });

        // Tabla de detalles de venta
        Schema::create('detalles_venta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_venta')->constrained('ventas');
            $table->foreignId('id_producto')->constrained('productos');
            $table->integer('cantidad');
            $table->decimal('precio', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });

        // Tabla de movimientos de inventario
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_producto')->constrained('productos');
            $table->enum('tipo', ['in', 'out']);
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 12, 2)->default(0);
            $table->string('tipo_referencia')->nullable();
            $table->unsignedBigInteger('id_referencia')->nullable();
            $table->text('nota')->nullable();
            $table->timestamps();
        });

        // Tabla de items del carrito
        Schema::create('items_carrito', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('id_producto')->constrained('productos')->onDelete('cascade');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 12, 2);
            $table->timestamps();
        });

        // Tabla de órdenes
        Schema::create('ordenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')->constrained('usuarios');
            $table->foreignId('id_metodo_pago')->nullable()->constrained('metodos_pago');
            $table->string('numero_orden')->unique();
            $table->decimal('total', 12, 2);
            $table->enum('estado', ['pendiente', 'verificado', 'en_embalaje', 'enviado', 'entregado', 'cancelado'])->default('pendiente');
            $table->string('comprobante_pago')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });

        // Tabla de items de órdenes
        Schema::create('items_orden', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_orden')->constrained('ordenes')->onDelete('cascade');
            $table->foreignId('id_producto')->constrained('productos');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Revertir las migraciones.
     * 
     * Elimina todas las tablas en el orden correcto
     * respetando las restricciones de claves foráneas.
     */
    public function down()
    {
        // Eliminar tablas en orden inverso (respetando foreign keys)
        Schema::dropIfExists('items_orden');
        Schema::dropIfExists('ordenes');
        Schema::dropIfExists('items_carrito');
        Schema::dropIfExists('movimientos_inventario');
        Schema::dropIfExists('detalles_venta');
        Schema::dropIfExists('ventas');
        Schema::dropIfExists('clientes');
        Schema::dropIfExists('metodos_pago');
        Schema::dropIfExists('productos');
        Schema::dropIfExists('proveedores');
        Schema::dropIfExists('marcas');
        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('roles');
    }
};
