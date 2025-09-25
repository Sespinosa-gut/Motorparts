<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\InventoryMovement;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->orderBy('created_at', 'desc')->get();
        return view('ordenes.index', compact('orders'));
    }

    public function create()
    {
        $cartItems = Auth::user()->cartItems()->with('product.brand')->get();
        $paymentMethods = PaymentMethod::where('activo', true)->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'El carrito está vacío');
        }

        $total = $cartItems->sum('subtotal');
        
        return view('ordenes.create', compact('cartItems', 'total', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_metodo_pago' => 'required|exists:metodos_pago,id',
            'comprobante_pago' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $cartItems = Auth::user()->cartItems()->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return back()->with('error', 'El carrito está vacío');
        }

        $total = $cartItems->sum('subtotal');

        DB::beginTransaction();
        try {
            $order = Order::create([
                'id_usuario' => Auth::id(),
                'id_metodo_pago' => $request->id_metodo_pago,
                'numero_orden' => 'ORD-' . now()->format('YmdHis'),
                'total' => $total,
                'estado' => 'pendiente',
                'comprobante_pago' => $request->file('comprobante_pago')->store('comprobantes', 'public'),
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'id_orden' => $order->id,
                    'id_producto' => $item->id_producto,
                    'cantidad' => $item->cantidad,
                    'precio_unitario' => $item->precio_unitario,
                ]);

                $product = $item->product;
                $product->decrement('stock', $item->cantidad);
            }

            Auth::user()->cartItems()->delete();

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Orden creada exitosamente. Esperando verificación del comprobante.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al crear la orden: ' . $e->getMessage());
        }
    }

    public function show(Order $order)
    {
        if ($order->id_usuario !== Auth::id()) {
            return back()->with('error', 'No autorizado');
        }

        return view('ordenes.show', compact('order'));
    }

    public function adminIndex()
    {
        if (!Auth::user()->isAdmin()) {
            return back()->with('error', 'No autorizado');
        }

        $orders = Order::with(['user', 'paymentMethod'])->orderBy('created_at', 'desc')->get();
        return view('admin.ordenes.index', compact('orders'));
    }

    public function verify(Request $request, Order $order)
    {
        if (!Auth::user()->isAdmin()) {
            return back()->with('error', 'No autorizado');
        }

        $request->validate([
            'estado' => 'required|in:verificado,rechazado',
            'notas' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            if ($request->estado === 'rechazado') {
                $orderItems = $order->orderItems;
                foreach ($orderItems as $item) {
                    $product = Product::find($item->id_producto);
                    if ($product) {
                        $product->increment('stock', $item->cantidad);
                    }
                }
                
                $order->update([
                    'estado' => 'cancelado',
                    'notas' => $request->notas,
                ]);
            } else {
                $this->createSaleFromOrder($order);
                
                $order->update([
                    'estado' => 'verificado',
                    'notas' => $request->notas,
                ]);
            }

            DB::commit();
            return back()->with('success', 'Orden actualizada exitosamente');
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al procesar la orden: ' . $e->getMessage());
        }
    }

    private function createSaleFromOrder(Order $order)
    {
        $sale = Sale::create([
            'id_cliente' => null,
            'id_usuario' => $order->id_usuario,
            'id_metodo_pago' => $order->id_metodo_pago,
            'numero_comprobante' => 'VTA-' . now()->format('YmdHis'),
            'fecha' => now()->toDateString(),
            'hora' => now()->toTimeString(),
            'subtotal' => $order->total,
            'total' => $order->total,
        ]);

        foreach ($order->orderItems as $orderItem) {
            $product = $orderItem->product;
            
            SaleDetail::create([
                'id_venta' => $sale->id,
                'id_producto' => $product->id,
                'cantidad' => $orderItem->cantidad,
                'precio' => $orderItem->precio_unitario,
                'subtotal' => $orderItem->cantidad * $orderItem->precio_unitario,
            ]);

            InventoryMovement::create([
                'id_producto' => $product->id,
                'tipo' => 'out',
                'cantidad' => $orderItem->cantidad,
                'precio_unitario' => $orderItem->precio_unitario,
                'tipo_referencia' => 'venta_orden',
                'id_referencia' => $sale->id,
                'nota' => 'Venta generada desde orden #' . $order->numero_orden,
            ]);
        }
    }
}