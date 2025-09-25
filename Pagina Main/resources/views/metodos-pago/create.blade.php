@extends('layouts.app')

@section('title', 'Nuevo Método de Pago - Motorparts')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <h1 class="h3 mb-3">Nuevo Método de Pago</h1>
      <form method="POST" action="{{ route('payment-methods.store') }}" class="card card-body">
        @csrf
        <div class="row g-3">
          <div class="col-md-8">
            <label class="form-label">Nombre *</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" required>
            @error('nombre')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-4">
            <div class="form-check mt-4">
              <input type="checkbox" name="activo" value="1" class="form-check-input" {{ old('activo', true) ? 'checked' : '' }}>
              <label class="form-check-label">Activo</label>
            </div>
            @error('activo')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>
        </div>
        <div class="d-flex gap-2 mt-3">
          <a href="{{ route('payment-methods.index') }}" class="btn btn-outline-secondary">Cancelar</a>
          <button class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection