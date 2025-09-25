@extends('layouts.app')

@section('title', 'Editar Cliente - Motorparts')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <h1 class="h3 mb-3">Editar Cliente</h1>
      <form method="POST" action="{{ route('customers.update', $customer) }}" class="card card-body">
        @csrf
        @method('PUT')
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Documento *</label>
            <input type="text" name="documento" value="{{ old('documento', $customer->documento) }}" class="form-control" required>
            @error('documento')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Nombre *</label>
            <input type="text" name="nombre" value="{{ old('nombre', $customer->nombre) }}" class="form-control" required>
            @error('nombre')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Correo</label>
            <input type="email" name="correo" value="{{ old('correo', $customer->correo) }}" class="form-control">
            @error('correo')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono', $customer->telefono) }}" class="form-control">
            @error('telefono')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>
          <div class="col-12">
            <label class="form-label">Dirección</label>
            <textarea name="direccion" class="form-control" rows="3">{{ old('direccion', $customer->direccion) }}</textarea>
            @error('direccion')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>
        </div>
        <div class="d-flex gap-2 mt-3">
          <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">Cancelar</a>
          <button class="btn btn-primary">Actualizar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection