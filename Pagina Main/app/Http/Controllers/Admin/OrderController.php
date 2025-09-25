<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        if (!Auth::user()->isAdmin()) {
            return back()->with('error', 'No autorizado');
        }

        $ordenes = Orden::with(['usuario', 'metodoPago'])->orderBy('created_at', 'desc')->get();
        return view('admin.ordenes.index', compact('ordenes'));
    }

    public function verify(Request $request, Orden $orden)
    {
        if (!Auth::user()->isAdmin()) {
            return back()->with('error', 'No autorizado');
        }

        $request->validate([
            'estado' => 'required|in:verificado,rechazado,en_embalaje,enviado,entregado',
            'notas' => 'nullable|string',
        ]);

        \Log::info('Verificando orden: ' . $orden->id . ' con estado: ' . $request->estado);

        try {
            if ($request->estado === 'rechazado') {
                $ordenItems = $orden->itemsOrden;
                foreach ($ordenItems as $item) {
                    $product = \App\Models\Producto::find($item->id_producto);
                    if ($product) {
                        $product->increment('stock', $item->cantidad);
                    }
                }
                
                $orden->update([
                    'estado' => 'cancelado',
                    'notas' => $request->notas,
                ]);
            } else {
                $this->createSaleFromOrder($orden);
                
                $orden->update([
                    'estado' => 'verificado',
                    'notas' => $request->notas,
                ]);
            }

            return back()->with('success', 'Orden actualizada exitosamente');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al procesar la orden: ' . $e->getMessage());
        }
    }

    private function createSaleFromOrder(Orden $orden)
    {
        \Log::info('Creando venta desde orden: ' . $orden->id);
        
        $sale = \App\Models\Venta::create([
            'id_cliente' => null,
            'id_usuario' => $orden->id_usuario,
            'id_metodo_pago' => $orden->id_metodo_pago,
            'numero_comprobante' => 'VTA-' . now()->format('YmdHis'),
            'fecha' => now()->toDateString(),
            'hora' => now()->toTimeString(),
            'subtotal' => $orden->total,
            'total' => $orden->total,
        ]);
        
        \Log::info('Venta creada con ID: ' . $sale->id);

        foreach ($orden->itemsOrden as $ordenItem) {
            $product = $ordenItem->producto;
            
            \App\Models\DetalleVenta::create([
                'id_venta' => $sale->id,
                'id_producto' => $product->id,
                'cantidad' => $ordenItem->cantidad,
                'precio' => $ordenItem->precio_unitario,
                'subtotal' => $ordenItem->cantidad * $ordenItem->precio_unitario,
            ]);

            \App\Models\MovimientoInventario::create([
                'id_producto' => $product->id,
                'tipo' => 'out',
                'cantidad' => $ordenItem->cantidad,
                'precio_unitario' => $ordenItem->precio_unitario,
                'tipo_referencia' => 'venta_orden',
                'id_referencia' => $sale->id,
                'nota' => 'Venta generada desde orden #' . $orden->numero_orden,
            ]);
        }
    }
}




