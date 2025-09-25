@extends('layouts.app')

@section('title', 'Crear Orden - Motorparts')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Crear Orden</h1>
        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
          <i class="fas fa-arrow-left me-1"></i>Volver al Carrito
        </a>
      </div>

      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Productos en el Carrito</h5>
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
                    @foreach($cartItems as $item)
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
              <h5 class="mb-0">Información de Pago</h5>
            </div>
            <div class="card-body">
              <form method="POST" action="{{ route('orders.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                  <label class="form-label">Método de Pago *</label>
                  <select name="id_metodo_pago" class="form-select" required>
                    <option value="">Selecciona un método de pago</option>
                    @foreach($paymentMethods as $method)
                      <option value="{{ $method->id }}">{{ $method->nombre }}</option>
                    @endforeach
                  </select>
                  @error('id_metodo_pago')
                    <div class="text-danger small">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label class="form-label">Comprobante de Pago *</label>
                  <input type="file" name="comprobante_pago" class="form-control" accept="image/*,.pdf" required>
                  <div class="form-text">Sube una imagen o PDF del comprobante de pago</div>
                  @error('comprobante_pago')
                    <div class="text-danger small">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label class="form-label">Notas (Opcional)</label>
                  <textarea name="notas" class="form-control" rows="3" placeholder="Instrucciones especiales para la entrega..."></textarea>
                </div>

                <hr>

                <div class="d-flex justify-content-between mb-3">
                  <span><strong>Total:</strong></span>
                  <span><strong>${{ number_format($total, 0, ',', '.') }}</strong></span>
                </div>

                <button type="submit" class="btn btn-success w-100">
                  <i class="fas fa-credit-card me-1"></i>Confirmar Orden
                </button>
              </form>
            </div>
          </div>
          
          <div class="card mt-3">
            <div class="card-body">
              <h6 class="card-title">Información Importante</h6>
              <ul class="list-unstyled small">
                <li><i class="fas fa-info-circle text-info me-1"></i>Tu orden será verificada manualmente</li>
                <li><i class="fas fa-clock text-warning me-1"></i>El proceso puede tomar 1-2 días hábiles</li>
                <li><i class="fas fa-truck text-success me-1"></i>Te notificaremos cuando esté lista para envío</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


