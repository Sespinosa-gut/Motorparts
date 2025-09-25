@extends('layouts.app')

@section('title', 'Métodos de Pago - Motorparts')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Métodos de Pago</h1>
        <a href="{{ route('payment-methods.create') }}" class="btn btn-primary">Nuevo Método</a>
      </div>
      
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ session('error') }}
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
                  <th>Estado</th>
                  <th style="width: 160px;">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @forelse($paymentMethods as $method)
                  <tr>
                    <td>{{ $method->nombre }}</td>
                    <td>
                      <span class="badge {{ $method->activo ? 'bg-success' : 'bg-secondary' }}">
                        {{ $method->activo ? 'Activo' : 'Inactivo' }}
                      </span>
                    </td>
                    <td>
                      <div class="btn-group" role="group">
                        <a href="{{ route('payment-methods.edit', $method) }}" 
                           class="btn btn-sm btn-primary" 
                           title="Editar">
                          <i class="fas fa-edit"></i> Editar
                        </a>
                        
                        <form action="{{ route('payment-methods.destroy', $method) }}" 
                              method="POST" 
                              class="d-inline" 
                              onsubmit="return confirm('¿Estás seguro de eliminar este método de pago?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" 
                                  class="btn btn-sm btn-danger" 
                                  title="Eliminar">
                            <i class="fas fa-trash"></i> Eliminar
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="3" class="text-center text-muted">No hay métodos de pago registrados</td>
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