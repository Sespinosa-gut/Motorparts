# Sistema de Repuestos Motorparts - Instalación

## Requisitos
- PHP 8.0+
- Composer
- MySQL/MariaDB
- XAMPP (recomendado)

## Instalación Rápida

1. **Clonar/Descargar el proyecto**
   ```bash
   cd C:\xampp\htdocs\motorparts
   ```

2. **Instalar dependencias**
   ```bash
   composer install
   ```

3. **Configurar base de datos**
   - Crear base de datos: `motorparts`
   - Copiar `.env.example` a `.env`
   - Configurar en `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=motorparts
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generar clave de aplicación**
   ```bash
   php artisan key:generate
   ```

5. **Ejecutar migraciones unificadas**
   ```bash
   php artisan migrate
   ```
   
   **Nota:** El sistema usa una migración unificada que crea toda la estructura de la base de datos en una sola operación.

6. **Crear enlace simbólico para imágenes**
   ```bash
   php artisan storage:link
   ```

7. **Poblar datos iniciales (opcional)**
   ```bash
   php artisan db:seed
   ```
   
   **Nota:** Esto creará roles básicos (Admin, Usuario) y datos de prueba.

8. **Iniciar servidor**
   ```bash
   php artisan serve
   ```

9. **Acceder al sistema**
   - URL: http://localhost:8000
   - Registrar usuario para comenzar
   - **Admin:** Acceso completo al sistema
   - **Usuario:** Acceso al catálogo y carrito de compras

## Estructura de Base de Datos

El sistema incluye las siguientes tablas en español:

### Tablas Principales
- `roles` - Roles del sistema (Admin, Usuario)
- `usuarios` - Usuarios del sistema con roles asignados
- `marcas` - Marcas de repuestos
- `proveedores` - Proveedores
- `productos` - Productos/repuestos
- `metodos_pago` - Métodos de pago
- `clientes` - Clientes
- `ventas` - Ventas
- `detalles_venta` - Detalles de cada venta
- `movimientos_inventario` - Movimientos de inventario

### Tablas del Sistema E-commerce
- `items_carrito` - Items en el carrito de compras
- `ordenes` - Órdenes de compra
- `items_orden` - Items de cada orden

**Nota:** Todas las tablas se crean mediante una migración unificada que respeta las foreign keys y relaciones.

## Funcionalidades

### Sistema de Gestión
- ✅ CRUD completo para todas las entidades
- ✅ Sistema de autenticación con roles
- ✅ Gestión de inventario
- ✅ Sistema de ventas
- ✅ Subida de imágenes para productos
- ✅ Interfaz en español
- ✅ Diseño responsive

### Sistema E-commerce
- ✅ Catálogo de productos
- ✅ Carrito de compras
- ✅ Sistema de órdenes
- ✅ Verificación manual de pagos
- ✅ Gestión de estados de órdenes
- ✅ Historial de compras

### Características Técnicas
- ✅ Migración unificada de base de datos
- ✅ Sistema de roles (Admin/Usuario)
- ✅ Middleware de autenticación
- ✅ Validaciones en español
- ✅ Manejo de archivos e imágenes

## Comandos Útiles

### Desarrollo
```bash
# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Reinstalar completamente
php artisan migrate:fresh --seed

# Ver estado de migraciones
php artisan migrate:status
```

### Producción
```bash
# Optimizar para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Notas Importantes
- ✅ Todas las tablas y campos están en español
- ✅ Una sola migración unificada crea todo el esquema
- ✅ Compatible con MySQL y MariaDB
- ✅ Sistema de roles integrado
- ✅ Carrito de compras funcional
- ✅ Gestión completa de órdenes

