@extends('layouts.app')

@section('title', 'Nueva Marca - Motorparts')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <h1 class="h3 mb-3">Nueva Marca</h1>
      <form method="POST" action="{{ route('brands.store') }}" class="card card-body">
        @csrf
        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" required>
          @error('nombre')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="d-flex gap-2">
          <a href="{{ route('brands.index') }}" class="btn btn-outline-secondary">Cancelar</a>
          <button class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection