@extends('layouts.app')

@section('title', 'Nueva Venta - Motorparts')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <h1 class="h3 mb-3">Nueva Venta</h1>
      <form method="POST" action="{{ route('sales.store') }}" class="card card-body">
        @csrf
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label class="form-label">Cliente</label>
            <select name="id_cliente" class="form-select">
              <option value="">Cliente General</option>
              @foreach($customers as $customer)
                <option value="{{ $customer->id }}" {{ old('id_cliente') == $customer->id ? 'selected' : '' }}>
                  {{ $customer->nombre }} - {{ $customer->documento }}
                </option>
              @endforeach
            </select>
            @error('id_cliente')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Método de Pago *</label>
            <select name="id_metodo_pago" class="form-select" required>
              <option value="">Seleccionar método</option>
              @foreach($paymentMethods as $method)
                <option value="{{ $method->id }}" {{ old('id_metodo_pago') == $method->id ? 'selected' : '' }}>
                  {{ $method->nombre }}
                </option>
              @endforeach
            </select>
            @error('id_metodo_pago')<div class="text-danger small">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="mb-3">
          <h5>Productos</h5>
          <div id="products-container">
            <div class="row g-3 product-row">
              <div class="col-md-5">
                <label class="form-label">Producto *</label>
                <select name="products[0][id_producto]" class="form-select product-select" required>
                  <option value="">Seleccionar producto</option>
                  @foreach($products as $product)
                    <option value="{{ $product->id }}" data-price="{{ $product->precio_venta }}" data-stock="{{ $product->stock }}">
                      {{ $product->nombre }} - Stock: {{ $product->stock }} - ${{ number_format($product->precio_venta, 0, ',', '.') }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <label class="form-label">Cantidad *</label>
                <input type="number" name="products[0][cantidad]" class="form-control quantity-input" min="1" required>
              </div>
              <div class="col-md-3">
                <label class="form-label">Precio Unitario</label>
                <input type="text" class="form-control price-input" readonly>
              </div>
              <div class="col-md-1">
                <label class="form-label">&nbsp;</label>
                <button type="button" class="btn btn-danger btn-sm remove-product" style="display: none;">×</button>
              </div>
            </div>
          </div>
          <button type="button" id="add-product" class="btn btn-outline-primary btn-sm mt-2">+ Agregar Producto</button>
        </div>

        <div class="row g-3">
          <div class="col-md-6">
            <div class="card bg-light">
              <div class="card-body">
                <h6>Resumen de Venta</h6>
                <div class="d-flex justify-content-between">
                  <span>Subtotal:</span>
                  <span id="subtotal">$0</span>
                </div>
                <div class="d-flex justify-content-between fw-bold">
                  <span>Total:</span>
                  <span id="total">$0</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="d-flex gap-2 mt-3">
          <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">Cancelar</a>
          <button class="btn btn-primary">Procesar Venta</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let productIndex = 1;
    
    document.getElementById('add-product').addEventListener('click', function() {
        const container = document.getElementById('products-container');
        const newRow = document.querySelector('.product-row').cloneNode(true);
        
        newRow.querySelectorAll('select, input').forEach(input => {
            if (input.name) {
                input.name = input.name.replace('[0]', '[' + productIndex + ']');
            }
            if (input.type !== 'hidden') {
                input.value = '';
            }
        });
        
        newRow.querySelector('.remove-product').style.display = 'block';
        
        container.appendChild(newRow);
        productIndex++;
    });
    
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-product')) {
            e.target.closest('.product-row').remove();
            calculateTotal();
        }
    });
    
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('product-select')) {
            const row = e.target.closest('.product-row');
            const priceInput = row.querySelector('.price-input');
            const quantityInput = row.querySelector('.quantity-input');
            const selectedOption = e.target.selectedOptions[0];
            
            if (selectedOption && selectedOption.dataset.price) {
                priceInput.value = '$' + parseFloat(selectedOption.dataset.price).toLocaleString();
                quantityInput.max = selectedOption.dataset.stock;
            } else {
                priceInput.value = '';
                quantityInput.max = '';
            }
            calculateTotal();
        }
    });
    
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('quantity-input')) {
            calculateTotal();
        }
    });
    
    function calculateTotal() {
        let subtotal = 0;
        
        document.querySelectorAll('.product-row').forEach(row => {
            const select = row.querySelector('.product-select');
            const quantityInput = row.querySelector('.quantity-input');
            
            if (select.value && quantityInput.value) {
                const price = parseFloat(select.selectedOptions[0].dataset.price);
                const quantity = parseInt(quantityInput.value);
                subtotal += price * quantity;
            }
        });
        
        document.getElementById('subtotal').textContent = '$' + subtotal.toLocaleString();
        document.getElementById('total').textContent = '$' + subtotal.toLocaleString();
    }
});
</script>
@endsection