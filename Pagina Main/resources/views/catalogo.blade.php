@extends('layouts.app')

@section('title', 'Catálogo - Motorparts')

@section('content')
<main>
<header class="encabezado-principal-2 text-center">
  <div>
    <h1>Partes de Motor de Calidad</h1>
    <p class="fs-4 mt-3">Encuentra las mejores piezas para tu vehículo</p>
  </div>
</header><br><br>

<div class="container my-4">
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

  <div class="row mb-4">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form method="GET" action="{{ route('catalog') }}" class="d-flex">
            <div class="input-group">
              <input type="text" 
                     class="form-control" 
                     name="search" 
                     value="{{ $searchTerm }}" 
                     placeholder="Buscar productos por nombre, descripción o marca..."
                     aria-label="Buscar productos">
              <button class="btn btn-outline-primary" type="submit">
                <i class="fas fa-search"></i> Buscar
              </button>
              @if($searchTerm)
                <a href="{{ route('catalog') }}" class="btn btn-outline-secondary">
                  <i class="fas fa-times"></i> Limpiar
                </a>
              @endif
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  @if($searchTerm)
    <div class="row mb-3">
      <div class="col-12">
        <div class="alert alert-info">
          <i class="fas fa-info-circle"></i>
          @if($productos->count() > 0)
            Se encontraron {{ $productos->count() }} producto(s) para "{{ $searchTerm }}"
          @else
            No se encontraron productos para "{{ $searchTerm }}"
          @endif
        </div>
      </div>
    </div>
  @endif

  @if($productos->count() > 0)
    <div class="row g-3">
      @foreach ($productos as $p)
        <div class="col-md-2 col-sm-4 col-6">
          <div class="card tarjeta-producto h-100">
            <img src="{{ route('image', $p->id) }}" class="card-img-top" alt="{{ $p->nombre }}" />
            <div class="card-body">
              <h6 class="card-title">{{ $p->nombre }}</h6>
              <p class="card-text">Marca: {{ $p->brand->nombre ?? 'Sin marca' }}<br>Stock: {{ $p->stock }}</p>
            </div>
            <div class="card-footer">
              <span class="fw-bold text-primary">${{ number_format($p->precio, 0, ',', '.') }}</span>
              @auth
                @if(Auth::user()->isCustomer())
                  <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="id_producto" value="{{ $p->id }}">
                    <input type="hidden" name="cantidad" value="1">
                    <button type="submit" class="btn btn-sm btn-outline-primary float-end">Comprar</button>
                  </form>
                @else
                  <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-primary float-end">Ver</a>
                @endif
              @else
                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary float-end">Comprar</a>
              @endauth
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @else
    <div class="row">
      <div class="col-12">
        <div class="text-center py-5">
          <i class="fas fa-search fa-3x text-muted mb-3"></i>
          <h4 class="text-muted">No se encontraron productos</h4>
          <p class="text-muted">
            @if($searchTerm)
              Intenta con otros términos de búsqueda o 
              <a href="{{ route('catalog') }}" class="text-decoration-none">ver todos los productos</a>
            @else
              No hay productos disponibles en este momento.
            @endif
          </p>
        </div>
      </div>
    </div>
  @endif
</div>

</main>
@endsection


