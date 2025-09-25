<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['customer', 'paymentMethod', 'saleDetails.product'])->get();
        return view('ventas.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::with('brand')->get();
        $customers = Customer::all();
        $paymentMethods = PaymentMethod::where('activo', true)->get();
        return view('ventas.create', compact('products', 'customers', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_cliente' => 'nullable|exists:clientes,id',
            'id_metodo_pago' => 'required|exists:metodos_pago,id',
            'products' => 'required|array|min:1',
            'products.*.id_producto' => 'required|exists:productos,id',
            'products.*.cantidad' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $sale = Sale::create([
                'id_cliente' => $validated['id_cliente'],
                'id_usuario' => auth()->id(),
                'id_metodo_pago' => $validated['id_metodo_pago'],
                'numero_comprobante' => 'VTA-' . now()->format('YmdHis'),
                'fecha' => now()->toDateString(),
                'hora' => now()->toTimeString(),
                'subtotal' => 0,
                'total' => 0,
            ]);

            $subtotal = 0;
            foreach ($validated['products'] as $item) {
                $product = Product::findOrFail($item['id_producto']);
                $quantity = $item['cantidad'];
                $price = $product->precio;
                $itemSubtotal = $quantity * $price;

                SaleDetail::create([
                    'id_venta' => $sale->id,
                    'id_producto' => $product->id,
                    'cantidad' => $quantity,
                    'precio' => $price,
                    'subtotal' => $itemSubtotal,
                ]);

                $product->decrement('stock', $quantity);

                InventoryMovement::create([
                    'id_producto' => $product->id,
                    'tipo' => 'salida',
                    'cantidad' => $quantity,
                    'precio_unitario' => $price,
                    'tipo_referencia' => 'venta',
                    'id_referencia' => $sale->id,
                    'nota' => 'Venta #' . $sale->numero_comprobante,
                ]);

                $subtotal += $itemSubtotal;
            }

            $sale->update([
                'subtotal' => $subtotal,
                'total' => $subtotal,
            ]);

            DB::commit();

            return redirect()->route('sales.show', $sale)
                ->with('success', 'Venta realizada exitosamente');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al procesar la venta: ' . $e->getMessage());
        }
    }

    public function show(Sale $sale)
    {
        $sale->load(['customer', 'paymentMethod', 'saleDetails.product.brand']);
        return view('ventas.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
    }

    public function update(Request $request, Sale $sale)
    {
    }

    public function destroy(Sale $sale)
    {
    }
}