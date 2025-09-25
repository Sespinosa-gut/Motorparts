@extends('layouts.app')

@section('title', 'Mis Órdenes - Motorparts')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Mis Órdenes</h1>
        <a href="{{ route('catalog') }}" class="btn btn-primary">
          <i class="fas fa-plus me-1"></i>Nueva Compra
        </a>
      </div>
      
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      @if($orders->count() > 0)
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Número de Orden</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th style="width: 100px;">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($orders as $order)
                    <tr>
                      <td>{{ $order->numero_orden }}</td>
                      <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                      <td>${{ number_format($order->total, 0, ',', '.') }}</td>
                      <td>
                        @switch($order->estado)
                          @case('pendiente')
                            <span class="badge bg-warning">Pendiente</span>
                            @break
                          @case('verificado')
                            <span class="badge bg-info">Verificado</span>
                            @break
                          @case('en_embalaje')
                            <span class="badge bg-primary">En Embalaje</span>
                            @break
                          @case('enviado')
                            <span class="badge bg-success">Enviado</span>
                            @break
                          @case('entregado')
                            <span class="badge bg-success">Entregado</span>
                            @break
                          @case('cancelado')
                            <span class="badge bg-danger">Cancelado</span>
                            @break
                        @endswitch
                      </td>
                      <td>
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-info">
                          <i class="fas fa-eye"></i>
                        </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      @else
        <div class="text-center py-5">
          <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
          <h4 class="text-muted">No tienes órdenes</h4>
          <p class="text-muted">Comienza agregando productos a tu carrito</p>
          <a href="{{ route('catalog') }}" class="btn btn-primary">
            <i class="fas fa-th-large me-1"></i>Ver Catálogo
          </a>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection



