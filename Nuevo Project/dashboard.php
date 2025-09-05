<?php
session_start();
if (empty($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}
$nombre   = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
$email    = $_SESSION['email'];
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gestión de Productos - Intercambios y Ventas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="icon" type="image/x-icon" href="car-solid-full.svg">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@100;200;300;400;500;600;700;800;900&family=Fugaz+One&family=Montserrat:wght@100..900&family=Bagel+Fat+One&family=Roboto+Condensed:wght@100..900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="CSS/estilos.css">
  <link rel="stylesheet" href="CSS/dashboard.css">
</head>

<body>

  <header>
    <nav class="barra-navegacion navbar navbar-expand-lg navbar-dark">
      <div class="container">
        <a class="navbar-brand fugaz-one-regular" href="#">
          <img src="IMG/car-solid-full.svg" width="30" height="30" class="d-inline-block align-top" alt="">
          Motorparts Diesel
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavegacion">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menuNavegacion">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="linkestilo" href="#">Usuarios</a></li>
            <li class="nav-item"><a class="linkestilo" href=".html">Catálogo</a></li>
            <li class="nav-item"><a class="linkestilo" href="agregar_producto.php">Partes</a></li>
            <li class="nav-item"><a class="linkestilo-inicio" href="logout.php">Cerrar Sesión</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>


  <main class="container my-5">
    <div class="seccion-informacion mb-5">
      <div class="text-center mb-4">
        <h1 id="mensaje-bienvenida">¡Bienvenido</h1>
      </div>
      <div class="row text-center">
        <div class="col-md-4">
          <h4>Proyectos Activos</h4>
          <p class="h2 text-primary" id="contador-proyectos">5</p>
        </div>
        <div class="col-md-4">
          <h4>Tareas Pendientes</h4>
          <p class="h2 text-warning" id="contador-tareas">12</p>
        </div>
        <div class="col-md-4">
          <h4>Mensajes No Leídos</h4>
          <p class="h2 text-success" id="contador-mensajes">7</p>
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
          <div class="icono-tarjeta"><i class="bi bi-bar-chart-line"></i></div>
          <h5 class="card-title">Estadísticas</h5>
          <p class="card-text">Visualiza gráficos y métricas de rendimiento.</p>
          <button class="btn btn-primary boton-animado" onclick="alert('Navegando a Estadísticas')">Ver Más</button>
        </div>
      </div>
      <div class="card tarjeta-opcion">
        <div class="card-body text-center">
          <div class="icono-tarjeta"><i class="bi bi-people"></i></div>
          <h5 class="card-title">Usuarios</h5>
          <p class="card-text">Gestiona usuarios y permisos.</p>
          <button class="btn btn-primary boton-animado" onclick="alert('Navegando a Usuarios')">Ver Más</button>
        </div>
      </div>
      <div class="card tarjeta-opcion">
        <div class="card-body text-center">
          <div class="icono-tarjeta"><i class="bi bi-gear"></i></div>
          <h5 class="card-title">Configuraciones</h5>
          <p class="card-text">Ajusta preferencias y opciones del sistema.</p>
          <button class="btn btn-primary boton-animado" onclick="alert('Navegando a Configuraciones')">Ver Más</button>
        </div>
      </div>
      <div class="card tarjeta-opcion">
        <div class="card-body text-center">
          <div class="icono-tarjeta"><i class="bi bi-envelope"></i></div>
          <h5 class="card-title">Mensajes</h5>
          <p class="card-text">Lee y responde tus mensajes.</p>
          <button class="btn btn-primary boton-animado" onclick="alert('Navegando a Mensajes')">Ver Más</button>
        </div>
      </div>
      <div class="card tarjeta-opcion">
        <div class="card-body text-center">
          <div class="icono-tarjeta"><i class="bi bi-folder"></i></div>
          <h5 class="card-title">Archivos</h5>
          <p class="card-text">Organiza y sube tus archivos.</p>
          <button class="btn btn-primary boton-animado" onclick="alert('Navegando a Archivos')">Ver Más</button>
        </div>
      </div>
      <div class="card tarjeta-opcion">
        <div class="card-body text-center">
          <div class="icono-tarjeta"><i class="bi bi-star"></i></div>
          <h5 class="card-title">Favoritos</h5>
          <p class="card-text">Accede a tus elementos marcados como favoritos.</p>
          <button class="btn btn-primary boton-animado" onclick="alert('Navegando a Favoritos')">Ver Más</button>
        </div>
      </div>
    </div>
  </main>

    <footer class="pie-pagina">
        <div class="container">
            <p>© 2024 MotorParts. Todos los derechos reservados.</p>
        </div>
    </footer>


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
    const saludo = hora < 12 
        ? '¡Buenos días' 
        : hora < 18 
            ? '¡Buenas tardes' 
            : '¡Buenas noches';

    const nombreUsuario = "<?= htmlspecialchars($nombre) ?>";

    document.getElementById('mensaje-bienvenida').textContent = `${saludo}, ${nombreUsuario}!`;
  </script>
</body>
</html>
