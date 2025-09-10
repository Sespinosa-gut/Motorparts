<?php
include_once "PHP/conexion.php"; // tu conexión a MySQL

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre   = trim($_POST["nombre_repuesto"]);
    $descripcion = trim($_POST["descripcion"]);
    $stock    = intval($_POST["stock"]);
    $id_proveedor = intval($_POST["id_proveedor"]);
    $id_orden = !empty($_POST["id_ordenes_compra"]) ? intval($_POST["id_ordenes_compra"]) : null;
    $id_marca = intval($_POST["id_marca"]);
    $precio   = floatval(str_replace('.', '', $_POST["precio"]));

    // Procesar imagen
    $imagen = null;
    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
        $imagen = file_get_contents($_FILES["imagen"]["tmp_name"]);
    }

    $sql = "INSERT INTO inventario 
    (imagen, nombre_repuesto, movimientos, stock, id_ordenes_compra, id_proveedor, id_marca, precio)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("❌ Error en la consulta SQL: " . $conn->error);
    }


    $stmt->bind_param(
        "bssiiiii", 
        $imagen,
        $nombre,
        $movimientos,
        $stock,
        $id_orden,
        $id_proveedor,
        $id_marca,
        $precio
    );

    // enviar imagen en chunks //cosa importantisima ni se te ocurra borrar esto
    if ($imagen !== null) {
        $stmt->send_long_data(0, $imagen);
    }

    if ($stmt->execute()) {
        $mensaje = "✅ Producto agregado correctamente";
    } else {
        $mensaje = "❌ Error al agregar producto: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Inventario</title>
  <link rel="icon" type="image/x-icon" href="IMG/car-solid-full.svg">
  <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@100..900&family=Fugaz+One&family=Montserrat:wght@100..900&family=Bagel+Fat+One&family=Roboto+Condensed:wght@100..900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="CSS/estilos.css">
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
            <li class="nav-item"><a class="linkestilo" href="catalogo.php">Catálogo</a></li>
            <li class="nav-item"><a class="linkestilo" href="#">Partes</a></li>
            <li class="nav-item"><a class="linkestilo-inicio" href="logout.php">Cerrar Sesión</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <main class="container my-5">
    <section id="add-product" class="mb-5">
      <h2 class="fugaz-one-regular text-center mb-4">Agregar Nuevo Producto</h2>

      <?php if ($mensaje): ?>
        <div class="alert alert-info text-center"><?= htmlspecialchars($mensaje) ?></div>
      <?php endif; ?>

      <form id="product-form" class="p-4 shadow rounded bg-light" action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="nombre_repuesto" class="form-label">Nombre del Producto</label>
          <input type="text" id="nombre_repuesto" name="nombre_repuesto" class="form-control" required value="<?= htmlspecialchars($_POST['nombre_repuesto'] ?? '') ?>">
        </div>

        <div class="mb-3">
          <label for="descripcion" class="form-label">Descripción</label>
          <textarea id="descripcion" name="descripcion" rows="3" class="form-control"><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>
        </div>

        <div class="row g-3">
          <div class="col-md-4">
            <label for="stock" class="form-label">Cantidad en Stock</label>
            <input type="number" id="stock" name="stock" min="0" class="form-control" required value="<?= htmlspecialchars($_POST['stock'] ?? '0') ?>">
          </div>

          <div class="col-md-4">
            <label for="precio" class="form-label">Precio</label>
            <input type="text" id="precio" name="precio" class="form-control" required value="<?= htmlspecialchars($_POST['precio'] ?? '') ?>">
          </div>

          <label for="id_marca" class="form-label">Marca</label>
          <select id="id_marca" name="id_marca" class="form-select" required>
              <option value="1">Toyota</option>
              <option value="2">Nissan</option>
              <option value="3">Mazda</option>
              <option value="4">Chevrolet</option>
              <option value="5">Ford</option>
          </select>

            <input type="text" id="marca_nueva" name="marca_nueva" class="form-control mt-2" placeholder="Nombre nueva marca (si aplica)" style="display:none;" value="<?= htmlspecialchars($_POST['marca_nueva'] ?? '') ?>">
          </div>
        </div>

        <div class="row g-3 mt-2">
          <div class="col-md-6">
            <label for="id_proveedor" class="form-label">ID Proveedor</label>
            <input type="number" id="id_proveedor" name="id_proveedor" class="form-control" required value="<?= htmlspecialchars($_POST['id_proveedor'] ?? '') ?>">
          </div>
          <div class="col-md-6">
            <label for="id_ordenes_compra" class="form-label">ID Orden de Compra</label>
            <input type="number" id="id_ordenes_compra" name="id_ordenes_compra" class="form-control" value="<?= htmlspecialchars($_POST['id_ordenes_compra'] ?? '') ?>">
          </div>
        </div>

        <div class="mt-3">
          <label for="imagen" class="form-label">Imagen del Producto</label>
          <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*">
        </div>

        <div class="text-center mt-4">
          <button type="submit" class="botonestilo">Agregar Producto</button>
        </div>
      </form>
    </section>

    <section id="product-list">
      <h2 class="fugaz-one-regular text-center mb-4">Productos en Catálogo</h2>
      <div class="table-responsive shadow rounded">
        <table class="table table-striped align-middle text-center">
          <thead class="table-dark">
            <tr>
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Cantidad</th>
              <th>Precio</th>
              <th>Marca</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </section>

  </main>

  <footer class="pie-pagina">
    <div class="container">
      <p>&copy; Motorparts Dashboard. Todos los derechos reservados.</p>
    </div>
  </footer>

  <script>
    // formato de precio con separador de miles (no cambia tu estilo)
    document.addEventListener("DOMContentLoaded", function() {
      const inputPrecio = document.getElementById("precio");
      inputPrecio.addEventListener("input", function(e) {
        // solo números -> remover todo lo que no sea dígito
        let raw = e.target.value.replace(/\D/g, "");
        if (raw === "") { e.target.value = ""; return; }
        e.target.value = new Intl.NumberFormat('es-CO').format(raw);
      });

      // toggle campo marca nueva
      const selectMarca = document.getElementById("id_marca");
      const marcaNueva = document.getElementById("marca_nueva");
      function toggleMarcaNueva() {
        if (selectMarca.value === "0") {
          marcaNueva.style.display = "block";
          marcaNueva.required = true;
        } else {
          marcaNueva.style.display = "none";
          marcaNueva.required = false;
        }
      }
      selectMarca.addEventListener("change", toggleMarcaNueva);
      toggleMarcaNueva(); // inicial
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

