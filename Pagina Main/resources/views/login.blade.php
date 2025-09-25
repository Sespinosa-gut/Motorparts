<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
  <link rel="icon" type="image/x-icon" href="{{ asset('img/car-solid-full.svg') }}">
</head>
<body>
<div class="tarjeta-login">
  <h2>Bienvenido de nuevo</h2>
  <p>Inicia sesión para acceder a tu panel</p>
  <form method="POST" action="{{ url('/login') }}">
    @csrf
    <div class="mb-3">
      <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required value="{{ old('email') }}">
    </div>
    <div class="mb-3">
      <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
    </div>
    <button type="submit" class="boton-primario">Iniciar sesión</button>
  </form>
  @if ($errors->any())
    <div class="alert alert-danger mt-3">{{ $errors->first() }}</div>
  @endif
  <p class="mt-3">¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
  <p class="mt-3"><a href="{{ url('/') }}">Volver</a></p>
</div>
</body>
</html>


