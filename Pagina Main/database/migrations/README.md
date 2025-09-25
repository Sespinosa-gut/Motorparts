# Migraciones de Motorparts

## Migración Unificada

### `2025_09_18_045202_create_unified_database_schema.php`

Esta es la **única migración** necesaria para configurar toda la base de datos del sistema Motorparts. Incluye todas las tablas y relaciones necesarias para el funcionamiento completo del sistema.

## Estructura de la Base de Datos

### Tablas Principales

#### **1. Sistema de Usuarios y Roles**
- **`roles`** - Roles del sistema (Admin, Usuario)
- **`usuarios`** - Usuarios del sistema con autenticación

#### **2. Gestión de Productos**
- **`marcas`** - Marcas de productos
- **`proveedores`** - Proveedores de productos
- **`productos`** - Catálogo de productos

#### **3. Sistema de Ventas**
- **`ventas`** - Registro de ventas
- **`detalles_venta`** - Detalles de cada venta
- **`movimientos_inventario`** - Control de inventario

#### **4. E-commerce**
- **`items_carrito`** - Carrito de compras
- **`ordenes`** - Órdenes de compra
- **`items_orden`** - Items de cada orden

#### **5. Configuración**
- **`metodos_pago`** - Métodos de pago disponibles
- **`clientes`** - Base de datos de clientes

## Características de la Migración

### ✅ **Completamente Unificada**
- Una sola migración para toda la base de datos
- Incluye todos los campos necesarios
- Relaciones de claves foráneas correctas

### ✅ **Optimizada para Producción**
- Campos con tipos de datos apropiados
- Índices únicos donde es necesario
- Restricciones de integridad referencial

### ✅ **Sistema de E-commerce Completo**
- Carrito de compras funcional
- Sistema de órdenes con estados
- Integración con ventas automáticas
- Control de inventario en tiempo real

## Uso

### Instalación Inicial
```bash
php artisan migrate
```

### Reset Completo
```bash
php artisan migrate:fresh
```

### Rollback
```bash
php artisan migrate:rollback
```

## Estados de Órdenes

- **`pendiente`** - Orden creada, esperando verificación
- **`verificado`** - Orden verificada por administrador
- **`en_embalaje`** - Orden siendo preparada
- **`enviado`** - Orden enviada al cliente
- **`entregado`** - Orden entregada exitosamente
- **`cancelado`** - Orden cancelada

## Tipos de Movimientos de Inventario

- **`in`** - Entrada de productos (compra, devolución)
- **`out`** - Salida de productos (venta, pérdida)

## Notas Importantes

- La migración está diseñada para ser **idempotente**
- Todas las tablas tienen timestamps automáticos
- Las claves foráneas están configuradas correctamente
- El sistema es completamente funcional después de ejecutar esta migración

---

**Motorparts** - Sistema de Gestión de Repuestos Automotrices 🚗⚙️