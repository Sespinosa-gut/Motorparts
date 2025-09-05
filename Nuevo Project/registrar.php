<?php
include "PHP/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre     = trim($_POST["nombre"]);
    $apellido   = trim($_POST["apellido"]);
    $email      = trim($_POST["email"]);
    $contrasena = trim($_POST["contrasena"]);

    // Verificar si ya existe el correo
    $sql = "SELECT id_usuario FROM usuario WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "⚠️ Ese correo ya está registrado.";
    } else {
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuario (nombre, apellido, email, contrasena) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $apellido, $email, $contrasena_hash);

        if ($stmt->execute()) {
            header("Location: login.php?msg=registrado");
            exit;
        } else {
            $error = "⚠️ Error en el registro: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="CSS/login.css">
  <link rel="stylesheet" href="CSS/estilos.css">
  <link rel="icon" type="image/x-icon" href="car-solid-full.svg">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fugaz+One&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fugaz+One&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Bagel+Fat+One&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
</head>
<body>
<div class="tarjeta-login">
  <h2>Crear cuenta</h2>
  <form method="POST">
    <div class="mb-3">
      <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
    </div>
    <div class="mb-3">
      <input type="text" name="apellido" class="form-control" placeholder="Apellido" required>
    </div>
    <div class="mb-3">
      <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
    </div>
    <div class="mb-3">
      <input type="password" name="contrasena" class="form-control" placeholder="Contraseña" required>
    </div>
    <button type="submit" class="boton-primario">Registrarme</button>
  </form>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger mt-3"><?= $error ?></div>
  <?php endif; ?>
  <p class="mt-3">¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
</div>
</body>
</html>
