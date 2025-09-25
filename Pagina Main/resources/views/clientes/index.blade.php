@extends('layouts.app')

@section('title', 'Clientes - Motorparts')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Clientes</h1>
        <a href="{{ route('customers.create') }}" class="btn btn-primary">Nuevo Cliente</a>
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
                  <th>Documento</th>
                  <th>Nombre</th>
                  <th>Correo</th>
                  <th>Teléfono</th>
                  <th style="width: 160px;">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @forelse($customers as $customer)
                  <tr>
                    <td>{{ $customer->documento }}</td>
                    <td>{{ $customer->nombre }}</td>
                    <td>{{ $customer->correo ?? '-' }}</td>
                    <td>{{ $customer->telefono ?? '-' }}</td>
                    <td>
                      <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-primary">Editar</a>
                      <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar cliente?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center text-muted">No hay clientes registrados</td>
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