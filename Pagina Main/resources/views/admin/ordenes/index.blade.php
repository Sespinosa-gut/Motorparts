@extends('layouts.app')

@section('title', 'Gestión de Órdenes - Motorparts')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Gestión de Órdenes</h1>
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
                  <th>Número de Orden</th>
                  <th>Cliente</th>
                  <th>Método de Pago</th>
                  <th>Fecha</th>
                  <th>Total</th>
                  <th>Estado</th>
                  <th>Comprobante</th>
                  <th style="width: 200px;">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @forelse($orders as $order)
                  <tr>
                    <td>{{ $order->numero_orden }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->paymentMethod->nombre ?? 'No especificado' }}</td>
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
                      @if($order->comprobante_pago)
                        <a href="{{ route('receipt.show', basename($order->comprobante_pago)) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                          <i class="fas fa-eye"></i>
                        </a>
                      @else
                        <span class="text-muted">Sin comprobante</span>
                      @endif
                    </td>
                    <td>
                      @if($order->estado === 'pendiente')
                        <form action="{{ route('admin.orders.verify', $order) }}" method="POST" class="d-inline">
                          @csrf
                          <input type="hidden" name="estado" value="verificado">
                          <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('¿Verificar esta orden?')">
                            <i class="fas fa-check me-1"></i>Verificar
                          </button>
                        </form>
                        <form action="{{ route('admin.orders.verify', $order) }}" method="POST" class="d-inline">
                          @csrf
                          <input type="hidden" name="estado" value="rechazado">
                          <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Rechazar esta orden?')">
                            <i class="fas fa-times me-1"></i>Rechazar
                          </button>
                        </form>
                      @elseif($order->estado === 'verificado')
                        <form action="{{ route('admin.orders.verify', $order) }}" method="POST" class="d-inline">
                          @csrf
                          <input type="hidden" name="estado" value="en_embalaje">
                          <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('¿Marcar como en embalaje?')">
                            <i class="fas fa-box me-1"></i>En Embalaje
                          </button>
                        </form>
                      @elseif($order->estado === 'en_embalaje')
                        <form action="{{ route('admin.orders.verify', $order) }}" method="POST" class="d-inline">
                          @csrf
                          <input type="hidden" name="estado" value="enviado">
                          <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('¿Marcar como enviado?')">
                            <i class="fas fa-truck me-1"></i>Enviar
                          </button>
                        </form>
                      @elseif($order->estado === 'enviado')
                        <form action="{{ route('admin.orders.verify', $order) }}" method="POST" class="d-inline">
                          @csrf
                          <input type="hidden" name="estado" value="entregado">
                          <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('¿Marcar como entregado?')">
                            <i class="fas fa-check-circle me-1"></i>Entregado
                          </button>
                        </form>
                      @endif
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="text-center text-muted">No hay órdenes registradas</td>
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


