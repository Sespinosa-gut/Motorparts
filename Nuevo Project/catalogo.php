<?php
include_once "PHP/conexion.php";


$sql = "SELECT i.id_inventario, i.nombre_repuesto, i.stock, i.precio, 
               m.nombre AS marca
        FROM inventario i
        LEFT JOIN marca m ON i.id_marca = m.id_marca";

$result = $conn->query($sql);
$productos = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Motorparts</title>
    <link rel="icon" type="image/x-icon" href="car-solid-full.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fugaz+One&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fugaz+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bagel+Fat+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="CSS/estilos.css">
</head>
<body>

<nav class="barra-navegacion navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      <img src="IMG/car-solid-full.svg" width="30" height="30" class="d-inline-block align-top" alt="">
      Motorparts Diesel
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavegacion">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="menuNavegacion">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="linkestilo " href="index.php">Inicio</a></li>
        <li class="nav-item"><a class="linkestilo " href="catalogo.php">Catálogo</a></li>
        <li class="nav-item"><a class="linkestilo " href="#nosotros">Nosotros</a></li>
        <li class="nav-item"><a class="linkestilo-inicio" href="login.php">Inicio Sesión</a></li>
      </ul>
    </div>
  </div>
</nav><br><br>

<header class="encabezado-principal-2 text-center">
  <div>
    <h1>Partes de Motor de Calidad</h1>
    <p class="fs-4 mt-3">Encuentra las mejores piezas para tu vehículo</p>
  </div>
</header><br><br>

<section class="seccion-filtros">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <input type="text" class="form-control campo-buscar" id="busqueda" placeholder="Buscar producto..." onkeyup="filtrarProductos()">
      </div>
      <div class="col-md-6 d-flex justify-content-center">
        <select class="form-select" id="filtroCategoria" onchange="filtrarProductos()">
          <option value="">Todas las Categorías</option>
          <option value="frenos">Frenos</option>
          <option value="llantas">Llantas</option>
          <option value="amortiguadores">Amortiguadores</option>
          <option value="escape">Escape</option>
          <option value="motor">Motor</option>
        </select>
      </div>
    </div>
  </div>
</section><br><br>

<div class="container my-4">
  <div class="row g-3">
    <?php foreach ($productos as $p): ?>
      <div class="col-md-2 col-sm-4 col-6">
        <div class="card tarjeta-producto h-100">
          <img src="mostrar_imagen.php?id=<?= $p['id_inventario']; ?>" 
               class="card-img-top" 
               alt="<?= htmlspecialchars($p['nombre_repuesto']); ?>" />
          <div class="card-body">
            <h6 class="card-title"><?= htmlspecialchars($p['nombre_repuesto']); ?></h6>
            <p class="card-text">
              Marca: <?= htmlspecialchars($p['marca']); ?><br>
              Stock: <?= $p['stock']; ?>
            </p>
          </div>
          <div class="card-footer">
            <span class="fw-bold text-primary">
              $<?= number_format($p['precio'], 0, ',', '.'); ?>
            </span>
            <a href="#" class="btn btn-sm btn-outline-primary float-end">Comprar</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>




<footer class="pie-pagina">
  <div class="container">
    <p>© 2024 Motopartes Express. Todos los derechos reservados. | <a href="#" class="text-white">Términos y Condiciones</a></p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function filtrarProductos() {
  const busqueda = document.getElementById('busqueda').value.toLowerCase();
  const filtroCategoria = document.getElementById('filtroCategoria').value;
  const productos = document.querySelectorAll('.tarjeta-producto2');

  productos.forEach(function(producto) {
    const titulo = producto.querySelector('.titulo-producto').textContent.toLowerCase();
    const categoria = producto.getAttribute('data-categoria');
    const coincideBusqueda = titulo.includes(busqueda);
    const coincideCategoria = !filtroCategoria || categoria === filtroCategoria;

    if (coincideBusqueda && coincideCategoria) {
      producto.style.display = 'block';
    } else {
      producto.style.display = 'none';
    }
  });
}
</script>
</body>
</html>

