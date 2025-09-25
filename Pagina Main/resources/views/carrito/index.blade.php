@extends('layouts.app')

@section('title', 'Carrito de Compras - Motorparts')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Carrito de Compras</h1>
        @if($cartItems->count() > 0)
          <a href="{{ route('orders.create') }}" class="btn btn-success">
            <i class="fas fa-credit-card me-1"></i>Proceder al Pago
          </a>
        @endif
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

      @php
        $cartItems = $cartItems ?? collect();
        $total = $total ?? 0;
      @endphp

      @if($cartItems->count() > 0)
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Producto</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th style="width: 100px;">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($cartItems as $item)
                    @if($item->product)
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
                        <td>${{ number_format($item->precio_unitario, 0, ',', '.') }}</td>
                        <td>
                          <form action="{{ route('cart.update', $item) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="number" name="cantidad" value="{{ $item->cantidad }}" min="1" max="{{ $item->product->stock }}" class="form-control form-control-sm" style="width: 80px;" onchange="this.form.submit()">
                          </form>
                        </td>
                        <td>${{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        <td>
                          <form action="{{ route('cart.remove', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar producto del carrito?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                              <i class="fas fa-trash"></i>
                            </button>
                          </form>
                        </td>
                      </tr>
                    @endif
                  @endforeach
                </tbody>
              </table>
            </div>
            
            <div class="row mt-4">
              <div class="col-md-6">
                <a href="{{ route('catalog') }}" class="btn btn-outline-primary">
                  <i class="fas fa-arrow-left me-1"></i>Seguir Comprando
                </a>
                <form action="{{ route('cart.clear') }}" method="POST" class="d-inline ms-2" onsubmit="return confirm('¿Vaciar carrito?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-outline-danger">
                    <i class="fas fa-trash me-1"></i>Vaciar Carrito
                  </button>
                </form>
              </div>
              <div class="col-md-6">
                <div class="card bg-light">
                  <div class="card-body text-end">
                    <h5 class="mb-0">Total: ${{ number_format($total, 0, ',', '.') }}</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @else
        <div class="text-center py-5">
          <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
          <h4 class="text-muted">Tu carrito está vacío</h4>
          <p class="text-muted">Agrega algunos productos para comenzar tu compra</p>
          <a href="{{ route('catalog') }}" class="btn btn-primary">
            <i class="fas fa-th-large me-1"></i>Ver Catálogo
          </a>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
