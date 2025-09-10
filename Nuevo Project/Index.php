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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavegacion" aria-controls="menuNavegacion" aria-expanded="false" aria-label="Alternar navegación">
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
    </nav>

    
    <header class="encabezado-principal text-center">
        <div>
            <h1>Partes de Motor de Calidad</h1>
            <p class="fs-4 mt-3">Encuentra las mejores piezas para tu vehículo</p>
            <button class="botonestilo "><p>Botón Principal</p></button>
            <button class="botonestilo"><p>Botón Secundario</p></button>
        </div>
    </header><br><br>

    
    <section id="productos" class="seccion-productos container">
    <h2 class="text-center mb-5">Partes De Motor</h2>
    <div class="row g-4">

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

    <section id="nosotros" class="py-5 bg-white">
        <div class="container">
            <h2 class="text-center mb-4">Sobre Nosotros</h2><br><br>
            <p class="text-justify fs-5 mx-auto" style="max-width: 1291px;">
                Somos una empresa dedicada a la venta de partes de motor con más de 10 años de experiencia. Nuestro compromiso es ofrecer productos de calidad y un servicio excepcional para que tu vehículo siempre esté en las mejores condiciones.
            </p>
        </div>
    </section><br><br>

    <section id="FAQ" class="py-5 bg-white">
        <div class="container">
            <h2 class="text-center mb-4">Preguntas Frecuentes</h2><br><br>
            <p class="text-justify fs-5 mx-auto" style="max-width: 1291px;">
                <strong>¿Cuál es el tiempo de entrega?</strong>
                <br />
                El tiempo de entrega varía según la ubicación, pero generalmente es de 3 a 5 días hábiles.
                <br /><br />
                <strong>¿Hacen envíos a todo el país?</strong>
                <br />
                Sí, realizamos envíos a todas las ciudades de Colombia.
                <br /><br />
                <strong>¿Puedo devolver un producto si no estoy satisfecho?</strong>
                <br />
                Sí, aceptamos devoluciones dentro de los 30 días posteriores a la compra 
                <br><br>
                <strong>¿Qué Métodos de Pago Recibimos?</strong>
                <br/>
                Aceptamos pagos en efectivo, tarjetas de crédito y débito, Nequi, Daviplata y transferencias bancarias.
            </p>
        </div>
    </section><br><br>

   
    <section id="contacto" class="py-5 bg-light">
            <h1>Contactanos</h1><br><br>
            <p>📍 Calle 1 C #19 D - 54</p>
            <p>📞 Teléfono: 320 955 66 91</p>
            <p>✉️ Email: Motorpartssas@gmail.com</p>
            <p>🕒 Horario: Lunes a Sábado de 8:00am a 6:00pm</p>
    </section>

    
    <footer class="pie-pagina">
        <div class="container">
            <p>© 2024 Motorparts. Todos los derechos reservados.</p>
        </div>
    </footer>

  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

