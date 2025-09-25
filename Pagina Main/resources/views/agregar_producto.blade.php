@extends('layouts.app')
@section('title', 'Gestión de Productos - Motorparts')
@section('content')
<main>
<div class="container my-5">
  <section id="add-product" class="mb-5">
    <h2 class="fugaz-one-regular text-center mb-4">
      {{ isset($product) ? 'Editar Producto' : 'Agregar Nuevo Producto' }}
    </h2>

    @if (session('mensaje'))
      <div class="alert alert-info text-center">{{ session('mensaje') }}</div>
    @endif

    @if (session('success'))
      <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if (session('error'))
      <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <form id="product-form" class="p-4 shadow rounded bg-light" 
          action="{{ isset($product) ? route('products.update', $product) : route('products.store') }}" 
          method="POST" enctype="multipart/form-data">
      @csrf
      @if(isset($product))
        @method('PUT')
      @endif
      <div class="mb-3">
        <label for="nombre_repuesto" class="form-label">Nombre del Producto</label>
        <input type="text" id="nombre_repuesto" name="nombre_repuesto" class="form-control" required 
               value="{{ old('nombre_repuesto', $product->nombre ?? '') }}">
        @error('nombre_repuesto')
          <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea id="descripcion" name="descripcion" rows="3" class="form-control">{{ old('descripcion', $product->descripcion ?? '') }}</textarea>
        @error('descripcion')
          <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="row g-3">
        <div class="col-md-4">
          <label for="stock" class="form-label">Cantidad en Stock</label>
          <input type="number" id="stock" name="stock" min="0" class="form-control" required 
                 value="{{ old('stock', $product->stock ?? 0) }}">
          @error('stock')
            <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-4">
          <label for="precio" class="form-label">Precio</label>
          <input type="text" id="precio" name="precio" class="form-control" required 
                 value="{{ old('precio', $product->precio_venta ?? '') }}">
          @error('precio')
            <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-4">
          <label for="id_marca" class="form-label">Marca</label>
          <select id="id_marca" name="id_marca" class="form-select">
              <option value="">Seleccionar marca</option>
              @foreach($brands ?? [] as $brand)
                  <option value="{{ $brand->id }}" 
                          {{ old('id_marca', $product->id_marca ?? '') == $brand->id ? 'selected' : '' }}>
                      {{ $brand->nombre }}
                  </option>
              @endforeach
              <option value="0">Nueva marca</option>
          </select>
          <input type="text" id="marca_nueva" name="marca_nueva" class="form-control mt-2" placeholder="Nombre nueva marca (si aplica)" style="display:none;" value="{{ old('marca_nueva') }}">
          @error('id_marca')
            <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <div class="row g-3 mt-2">
        <div class="col-md-6">
          <label for="id_proveedor" class="form-label">Proveedor</label>
          <select id="id_proveedor" name="id_proveedor" class="form-select">
              <option value="">Seleccionar proveedor</option>
              @foreach($suppliers ?? [] as $supplier)
                  <option value="{{ $supplier->id }}" 
                          {{ old('id_proveedor', $product->id_proveedor ?? '') == $supplier->id ? 'selected' : '' }}>
                      {{ $supplier->nombre }}
                  </option>
              @endforeach
          </select>
          @error('id_proveedor')
            <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>
        <div class="col-md-6">
          <label for="stock_minimo" class="form-label">Stock Mínimo</label>
          <input type="number" id="stock_minimo" name="stock_minimo" class="form-control" min="0" 
                 value="{{ old('stock_minimo', $product->stock_minimo ?? 0) }}">
          @error('stock_minimo')
            <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <div class="mt-3">
        <label for="imagen" class="form-label">Imagen del Producto</label>
        <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*">
        @if(isset($product) && $product->imagen)
          <div class="mt-2">
            <img src="{{ route('image', $product->id) }}" alt="{{ $product->nombre }}" style="max-width: 100px; max-height: 100px;">
            <small class="text-muted">Imagen actual</small>
          </div>
        @endif
        @error('imagen')
          <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="text-center mt-4">
        <button type="submit" class="botonestilo">
          {{ isset($product) ? 'Actualizar Producto' : 'Agregar Producto' }}
        </button>
        @if(isset($product))
          <a href="{{ route('products.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
        @endif
      </div>
    </form>
  </section>

  <section id="product-list">
    <h2 class="fugaz-one-regular text-center mb-4">Productos en Catálogo</h2>
    <div class="table-responsive shadow rounded">
      <table class="table table-striped align-middle text-center">
        <thead class="table-dark">
          <tr>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Marca</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @forelse($products ?? [] as $product)
            <tr>
              <td>
                @if($product->imagen)
                  <img src="{{ route('image', $product->id) }}" alt="{{ $product->nombre }}" style="width: 50px; height: 50px; object-fit: cover;">
                @else
                  <i class="fas fa-image text-muted"></i>
                @endif
              </td>
              <td>{{ $product->nombre }}</td>
              <td>{{ $product->descripcion ?? 'Sin descripción' }}</td>
              <td>{{ $product->stock }}</td>
              <td>${{ number_format($product->precio, 0, ',', '.') }}</td>
              <td>{{ $product->brand->nombre ?? 'Sin marca' }}</td>
              <td>
                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-edit"></i> Editar
                </a>
                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" 
                      onsubmit="return confirm('¿Estás seguro de que quieres eliminar este producto?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger">
                    <i class="fas fa-trash"></i> Eliminar
                  </button>
                </form>
                <form action="{{ route('products.force-delete', $product) }}" method="POST" class="d-inline ms-1" 
                      onsubmit="return confirm('⚠️ ADVERTENCIA: Esto eliminará el producto y todos sus elementos de carritos y órdenes. ¿Continuar?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-warning" title="Eliminar forzadamente (incluye carritos y órdenes)">
                    <i class="fas fa-exclamation-triangle"></i> Forzar
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center">No hay productos registrados</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </section>
</div>
</main>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const inputPrecio = document.getElementById("precio");
    inputPrecio.addEventListener("input", function(e) {
      let raw = e.target.value.replace(/\D/g, "");
      if (raw === "") { e.target.value = ""; return; }
      e.target.value = new Intl.NumberFormat('es-CO').format(raw);
    });
    
    const selectMarca = document.getElementById("id_marca");
    const marcaNueva = document.getElementById("marca_nueva");
    function toggleMarcaNueva() {
      if (selectMarca.value === "0") {
        marcaNueva.style.display = "block";
        marcaNueva.required = true;
      } else {
        marcaNueva.style.display = "none";
        marcaNueva.required = false;
      }
    }
    selectMarca.addEventListener("change", toggleMarcaNueva);
    toggleMarcaNueva();
  });
</script>
@endsection