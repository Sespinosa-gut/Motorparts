@extends('layouts.app')

@section('title', 'Detalle de Venta - Motorparts')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Detalle de Venta #{{ $sale->numero_comprobante }}</h1>
        <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">Volver</a>
      </div>

      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Productos Vendidos</h5>
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
                    @foreach($sale->saleDetails as $detail)
                      <tr>
                        <td>{{ $detail->product->nombre }}</td>
                        <td>{{ $detail->cantidad }}</td>
                        <td>${{ number_format($detail->precio, 0, ',', '.') }}</td>
                        <td>${{ number_format($detail->subtotal, 0, ',', '.') }}</td>
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
              <h5 class="mb-0">Información de la Venta</h5>
            </div>
            <div class="card-body">
              <div class="mb-3">
                <strong>Comprobante:</strong><br>
                {{ $sale->numero_comprobante }}
              </div>
              
              <div class="mb-3">
                <strong>Cliente:</strong><br>
                {{ $sale->customer->nombre ?? 'Cliente General' }}
                @if($sale->customer)
                  <br><small class="text-muted">{{ $sale->customer->documento }}</small>
                @endif
              </div>
              
              <div class="mb-3">
                <strong>Método de Pago:</strong><br>
                {{ $sale->paymentMethod->nombre }}
              </div>
              
              <div class="mb-3">
                <strong>Fecha y Hora:</strong><br>
                {{ $sale->fecha->format('d/m/Y') }} a las {{ $sale->hora }}
              </div>
              
              <div class="mb-3">
                <strong>Vendedor:</strong><br>
                {{ $sale->user->name ?? 'Usuario' }}
              </div>
              
              <hr>
              
              <div class="d-flex justify-content-between">
                <span><strong>Subtotal:</strong></span>
                <span><strong>${{ number_format($sale->subtotal, 0, ',', '.') }}</strong></span>
              </div>
              
              <div class="d-flex justify-content-between">
                <span><strong>Total:</strong></span>
                <span><strong>${{ number_format($sale->total, 0, ',', '.') }}</strong></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection