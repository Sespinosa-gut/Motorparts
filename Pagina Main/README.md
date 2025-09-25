# 🚗 Motorparts - Tu Tienda de Repuestos Automotrices

¡Bienvenido a **Motorparts**, la tienda de repuestos automotrices más inteligente del mundo! 🎉

## 🌟 ¿Qué es Motorparts?

Motorparts es una aplicación web desarrollada en **Laravel** que te permite gestionar tu tienda de repuestos automotrices de manera súper eficiente. Es como tener un asistente personal que nunca se cansa de trabajar, nunca se queja, y siempre está disponible 24/7.

## ✨ Características Principales

### 🛍️ **Gestión de Productos**
- ✅ Agregar, editar y eliminar productos
- ✅ Subir imágenes de productos
- ✅ Gestionar stock e inventario
- ✅ Categorizar por marcas y proveedores
- ✅ Precios dinámicos y actualizables

### 🛒 **Carrito de Compras Inteligente**
- ✅ Agregar productos al carrito
- ✅ Calcular totales automáticamente
- ✅ Verificar stock disponible
- ✅ Actualizar cantidades en tiempo real
- ✅ Vaciar carrito cuando quieras

### 💳 **Métodos de Pago Flexibles**
- ✅ Efectivo
- ✅ Tarjeta de crédito/débito
- ✅ Nequi
- ✅ Daviplata
- ✅ Transferencia bancaria
- ✅ Y cualquier otro método que se te ocurra

### 📦 **Sistema de Órdenes**
- ✅ Crear órdenes de compra
- ✅ Subir comprobantes de pago
- ✅ Seguimiento de estados
- ✅ Verificación de administradores
- ✅ Historial completo de compras

### 👥 **Gestión de Usuarios**
- ✅ Registro de usuarios
- ✅ Roles de administrador y cliente
- ✅ Perfiles personalizados
- ✅ Seguridad robusta

### 🏭 **Gestión de Proveedores**
- ✅ Directorio de proveedores
- ✅ Información de contacto
- ✅ Productos por proveedor
- ✅ Historial de compras

### 🏷️ **Gestión de Marcas**
- ✅ Catálogo de marcas
- ✅ Productos por marca
- ✅ Marcas personalizadas
- ✅ Organización inteligente

## 🚀 Instalación

### Requisitos Previos
- PHP 8.0 o superior
- Composer
- MySQL o PostgreSQL
- Node.js (opcional, para assets)

### Pasos de Instalación

1. **Clona el repositorio**
```bash
git clone https://github.com/tu-usuario/motorparts.git
cd motorparts
```

2. **Instala las dependencias**
```bash
composer install
npm install
```

3. **Configura el entorno**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configura la base de datos**
```bash
# Edita el archivo .env con tus credenciales de base de datos
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=motorparts
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

5. **Ejecuta las migraciones**
```bash
php artisan migrate
php artisan db:seed
```

6. **Crea el enlace simbólico para el almacenamiento**
```bash
php artisan storage:link
```

7. **Inicia el servidor**
```bash
php artisan serve
```

¡Y listo! Tu tienda estará funcionando en `http://localhost:8000` 🎉

## 🎯 Uso de la Aplicación

### Para Administradores
1. **Gestiona productos**: Agrega, edita y elimina productos
2. **Gestiona proveedores**: Mantén tu directorio de proveedores actualizado
3. **Gestiona marcas**: Organiza tus productos por marcas
4. **Verifica órdenes**: Revisa y aprueba las órdenes de compra
5. **Gestiona usuarios**: Administra los usuarios del sistema

### Para Clientes
1. **Explora el catálogo**: Navega por todos los productos disponibles
2. **Agrega al carrito**: Selecciona los productos que necesitas
3. **Realiza compras**: Crea órdenes y sube comprobantes de pago
4. **Sigue tus órdenes**: Monitorea el estado de tus compras

## 🛠️ Tecnologías Utilizadas

- **Backend**: Laravel 10
- **Frontend**: Blade Templates + Bootstrap 5
- **Base de Datos**: MySQL/PostgreSQL
- **Autenticación**: Laravel Sanctum
- **Almacenamiento**: Laravel Storage
- **Validación**: Laravel Validation
- **Relaciones**: Eloquent ORM

## 📁 Estructura del Proyecto

```
motorparts/
├── app/
│   ├── Http/Controllers/     # Controladores de la aplicación
│   ├── Models/              # Modelos de Eloquent
│   └── ...
├── database/
│   ├── migrations/          # Migraciones de base de datos
│   └── seeders/            # Seeders para datos iniciales
├── resources/
│   └── views/              # Vistas Blade
├── routes/
│   └── web.php            # Rutas de la aplicación
└── storage/
    └── app/public/        # Archivos públicos
```

## 🤝 Contribuciones

¡Las contribuciones son bienvenidas! Si tienes ideas para mejorar la aplicación, no dudes en:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📝 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 👨‍💻 Autor

**Sergio** - *Desarrollador Principal* - [@tu-usuario](https://github.com/tu-usuario)

Con la ayuda de su IA favorita 🤖

## 🙏 Agradecimientos

- A Laravel por ser tan increíble
- A Bootstrap por hacer que todo se vea bonito
- A la comunidad de desarrolladores por su apoyo
- A mi IA favorita por no cansarse de ayudarme 😄

---

## 🎉 ¡Gracias por usar Motorparts!

Si te gusta este proyecto, ¡dale una estrella! ⭐

Y recuerda: **¡Nunca dejes que tu código se vea aburrido!** 🚀✨

---

*Desarrollado con ❤️ y mucho ☕ por Sergio*