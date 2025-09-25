@extends('layouts.app')

@section('title', 'Dashboard - Motorparts')

@section('content')

  <main class="container my-5">
    <div class="seccion-informacion mb-5">
      <div class="text-center mb-4">
        <h1 id="mensaje-bienvenida">¡Bienvenido</h1>
      </div>
      <div class="row text-center">
        <div class="col-md-4">
          <h4>Productos en Stock</h4>
          <p class="h2 text-primary" id="contador-productos">{{ $productos->count() }}</p>
        </div>
        <div class="col-md-4">
          <h4>Órdenes Pendientes</h4>
          <p class="h2 text-warning" id="contador-ordenes">{{ $ordenesPendientes ?? 0 }}</p>
        </div>
        <div class="col-md-4">
          <h4>Ventas del Mes</h4>
          <p class="h2 text-success" id="contador-ventas">{{ $ventasMes ?? 0 }}</p>
        </div>
      </div>
    </div>

    <div class="text-center mb-4">
      <h2>Más Opciones</h2>
      <p class="text-muted">Explora las secciones principales de tu dashboard</p>
    </div>
    <div class="rejilla-opciones">
      <div class="card tarjeta-opcion">
        <div class="card-body text-center">
          <div class="icono-tarjeta"><i class="fas fa-chart-line"></i></div>
          <h5 class="card-title">Estadísticas</h5>
          <p class="card-text">Visualiza gráficos y métricas de rendimiento.</p>
          <button class="btn btn-secondary boton-animado" disabled>Próximamente</button>
        </div>
      </div>
      <div class="card tarjeta-opcion">
        <div class="card-body text-center">
          <div class="icono-tarjeta"><i class="fas fa-box"></i></div>
          <h5 class="card-title">Productos</h5>
          <p class="card-text">Gestiona el inventario de productos.</p>
          <a href="{{ route('products.index') }}" class="btn btn-primary boton-animado">Ver Más</a>
        </div>
      </div>
      <div class="card tarjeta-opcion">
        <div class="card-body text-center">
          <div class="icono-tarjeta"><i class="fas fa-tags"></i></div>
          <h5 class="card-title">Marcas</h5>
          <p class="card-text">Administra las marcas de productos.</p>
          <a href="{{ route('brands.index') }}" class="btn btn-primary boton-animado">Ver Más</a>
        </div>
      </div>
      <div class="card tarjeta-opcion">
        <div class="card-body text-center">
          <div class="icono-tarjeta"><i class="fas fa-truck"></i></div>
          <h5 class="card-title">Proveedores</h5>
          <p class="card-text">Gestiona proveedores y sus datos.</p>
          <a href="{{ route('suppliers.index') }}" class="btn btn-primary boton-animado">Ver Más</a>
        </div>
      </div>
      <div class="card tarjeta-opcion">
        <div class="card-body text-center">
          <div class="icono-tarjeta"><i class="fas fa-clipboard-list"></i></div>
          <h5 class="card-title">Órdenes</h5>
          <p class="card-text">Revisa y gestiona las órdenes de compra.</p>
          <a href="{{ route('admin.orders.index') }}" class="btn btn-primary boton-animado">Ver Más</a>
        </div>
      </div>
      <div class="card tarjeta-opcion">
        <div class="card-body text-center">
          <div class="icono-tarjeta"><i class="fas fa-th-large"></i></div>
          <h5 class="card-title">Catálogo</h5>
          <p class="card-text">Vista previa del catálogo público.</p>
          <a href="{{ route('catalog') }}" class="btn btn-primary boton-animado">Ver Más</a>
        </div>
      </div>
    </div>
  </main>


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function actualizarDatosUsuario() {
      document.getElementById('contador-proyectos').textContent = Math.floor(Math.random() * 10) + 1;
      document.getElementById('contador-tareas').textContent = Math.floor(Math.random() * 20) + 1;
      document.getElementById('contador-mensajes').textContent = Math.floor(Math.random() * 15) + 1;
    }
    setInterval(actualizarDatosUsuario, 30000);
    const ahora = new Date();
    const hora = ahora.getHours();
    const saludo = hora < 12 ? '¡Buenos días' : (hora < 18 ? '¡Buenas tardes' : '¡Buenas noches');
    const nombreUsuario = "{{ $user->name }}";
    document.getElementById('mensaje-bienvenida').textContent = `${saludo}, ${nombreUsuario}!`;
  </script>
@endsection


