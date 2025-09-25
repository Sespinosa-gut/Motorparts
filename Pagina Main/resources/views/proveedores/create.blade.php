@extends('layouts.app')

@section('title', 'Nuevo Proveedor - Motorparts')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <h1 class="h3 mb-3">Nuevo Proveedor</h1>
      <form method="POST" action="{{ route('suppliers.store') }}" class="card card-body">
        @csrf
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nombre *</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" required>
            @error('nombre')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Nombre de Contacto</label>
            <input type="text" name="contacto" value="{{ old('contacto') }}" class="form-control">
            @error('contacto')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Correo</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control">
            @error('email')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono') }}" class="form-control">
            @error('telefono')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>
          <div class="col-12">
            <label class="form-label">Dirección</label>
            <textarea name="direccion" class="form-control" rows="3">{{ old('direccion') }}</textarea>
            @error('direccion')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>
        </div>
        <div class="d-flex gap-2 mt-3">
          <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">Cancelar</a>
          <button class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection