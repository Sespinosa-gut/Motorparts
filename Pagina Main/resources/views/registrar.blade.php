<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
  <link rel="icon" type="image/x-icon" href="{{ asset('img/car-solid-full.svg') }}">
</head>
<body>
<div class="tarjeta-login">
  <h2>Crear cuenta</h2>
  <form method="POST" action="{{ url('/registrar') }}">
    @csrf
    <div class="mb-3">
      <input type="text" name="name" class="form-control" placeholder="Nombre completo" required value="{{ old('name') }}">
    </div>
    <div class="mb-3">
      <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required value="{{ old('email') }}">
    </div>
    <div class="mb-3">
      <input type="tel" name="telefono" class="form-control" placeholder="Número de teléfono" required value="{{ old('telefono') }}">
    </div>
    <div class="mb-3">
      <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
    </div>
    <div class="mb-3">
      <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar contraseña" required>
    </div>
    <button type="submit" class="boton-primario">Registrarme</button>
  </form>
  @if ($errors->any())
    <div class="alert alert-danger mt-3">{{ $errors->first() }}</div>
  @endif
  <p class="mt-3">¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a></p>
</div>
</body>
</html>


