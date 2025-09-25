@extends('layouts.app')

@section('title', 'Detalle de Orden - Motorparts')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Orden #{{ $order->numero_orden }}</h1>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
          <i class="fas fa-arrow-left me-1"></i>Volver
        </a>
      </div>

      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Productos</h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Producto</th>
                      <th>Cantidad</th>
                      <th>Precio Unitario</th>
                      <th>Subtotal</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($order->orderItems ?? [] as $item)
                      <tr>
                        <td>
                          <div class="d-flex align-items-center">
                            <img src="{{ route('image', $item->product->id) }}" alt="{{ $item->product->nombre }}" class="me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                              <h6 class="mb-0">{{ $item->product->nombre }}</h6>
                              <small class="text-muted">{{ $item->product->brand->nombre ?? 'Sin marca' }}</small>
                            </div>
                          </div>
                        </td>
                        <td>{{ $item->cantidad }}</td>
                        <td>${{ number_format($item->precio_unitario, 0, ',', '.') }}</td>
                        <td>${{ number_format($item->subtotal, 0, ',', '.') }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Información de la Orden</h5>
            </div>
            <div class="card-body">
              <div class="mb-3">
                <strong>Número de Orden:</strong><br>
                {{ $order->numero_orden }}
              </div>
              
              <div class="mb-3">
                <strong>Estado:</strong><br>
                @switch($order->estado)
                  @case('pendiente')
                    <span class="badge bg-warning">Pendiente de Verificación</span>
                    @break
                  @case('verificado')
                    <span class="badge bg-info">Verificado - En Proceso</span>
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
              </div>
              
              <div class="mb-3">
                <strong>Fecha de Creación:</strong><br>
                {{ $order->created_at->format('d/m/Y H:i') }}
              </div>
              
              @if($order->comprobante_pago)
                <div class="mb-3">
                  <strong>Comprobante de Pago:</strong><br>
                  <a href="{{ route('receipt.show', basename($order->comprobante_pago)) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-eye me-1"></i>Ver Comprobante
                  </a>
                </div>
              @endif
              
              @if($order->notas)
                <div class="mb-3">
                  <strong>Notas:</strong><br>
                  <p class="text-muted">{{ $order->notas }}</p>
                </div>
              @endif
              
              <hr>
              
              <div class="d-flex justify-content-between">
                <span><strong>Total:</strong></span>
                <span><strong>${{ number_format($order->total, 0, ',', '.') }}</strong></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
