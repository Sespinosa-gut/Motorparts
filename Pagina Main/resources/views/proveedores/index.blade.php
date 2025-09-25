@extends('layouts.app')

@section('title', 'Proveedores - Motorparts')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Proveedores</h1>
        <a href="{{ route('suppliers.create') }}" class="btn btn-primary">Nuevo Proveedor</a>
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
                  <th>Contacto</th>
                  <th>Correo</th>
                  <th>Teléfono</th>
                  <th style="width: 160px;">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @forelse($suppliers as $supplier)
                  <tr>
                    <td>{{ $supplier->nombre }}</td>
                    <td>{{ $supplier->contacto ?? '-' }}</td>
                    <td>{{ $supplier->email ?? '-' }}</td>
                    <td>{{ $supplier->telefono ?? '-' }}</td>
                    <td>
                      <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-sm btn-primary">Editar</a>
                      <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar proveedor?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center text-muted">No hay proveedores registrados</td>
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