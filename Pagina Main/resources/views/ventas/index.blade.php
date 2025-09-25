@extends('layouts.app')

@section('title', 'Ventas - Motorparts')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Ventas</h1>
        <a href="{{ route('sales.create') }}" class="btn btn-primary">Nueva Venta</a>
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
                  <th>Comprobante</th>
                  <th>Cliente</th>
                  <th>Fecha</th>
                  <th>Hora</th>
                  <th>Total</th>
                  <th style="width: 100px;">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @forelse($sales as $sale)
                  <tr>
                    <td>{{ $sale->numero_comprobante }}</td>
                    <td>{{ $sale->customer->nombre ?? 'Cliente General' }}</td>
                    <td>{{ $sale->fecha->format('d/m/Y') }}</td>
                    <td>{{ $sale->hora }}</td>
                    <td>${{ number_format($sale->total, 0, ',', '.') }}</td>
                    <td>
                      <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-info">Ver</a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center text-muted">No hay ventas registradas</td>
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