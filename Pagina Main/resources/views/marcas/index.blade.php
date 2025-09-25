@extends('layouts.app')

@section('title', 'Marcas - Motorparts')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Marcas</h1>
        <a href="{{ route('brands.create') }}" class="btn btn-primary">Nueva Marca</a>
      </div>
      
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th style="width: 160px;">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @forelse($brands as $brand)
                  <tr>
                    <td>{{ $brand->nombre }}</td>
                    <td>
                      <a href="{{ route('brands.edit', $brand) }}" class="btn btn-sm btn-primary">Editar</a>
                      <form action="{{ route('brands.destroy', $brand) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar marca?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="2" class="text-center text-muted">No hay marcas registradas</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection