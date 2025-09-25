<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para ver el carrito');
        }

        try {
            $cartItems = Auth::user()->cartItems()->with('product.brand')->get();
            $total = $cartItems->sum('subtotal');
            
            \Log::info('CartController@index - Carrito cargado', [
                'user_id' => Auth::id(),
                'items_count' => $cartItems->count(),
                'total' => $total,
                'items_with_products' => $cartItems->filter(function($item) { return $item->product !== null; })->count()
            ]);
            
            return view('carrito.index', compact('cartItems', 'total'));
        } catch (\Exception $e) {
            \Log::error('CartController@index - Error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);
            
            $cartItems = collect();
            $total = 0;
            return view('carrito.index', compact('cartItems', 'total'))
                ->with('error', 'Error al cargar el carrito: ' . $e->getMessage());
        }
    }

    public function add(Request $request)
    {
        $request->validate([
            'id_producto' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        try {
            $product = Product::findOrFail($request->id_producto);
            
            if ($product->stock < $request->cantidad) {
                return back()->with('error', 'No hay suficiente stock disponible');
            }

            $existingItem = CartItem::where('id_usuario', Auth::id())
                ->where('id_producto', $request->id_producto)
                ->first();

            if ($existingItem) {
                $existingItem->update([
                    'cantidad' => $existingItem->cantidad + $request->cantidad,
                ]);
            } else {
                CartItem::create([
                    'id_usuario' => Auth::id(),
                    'id_producto' => $request->id_producto,
                    'cantidad' => $request->cantidad,
                    'precio_unitario' => $product->precio,
                ]);
            }

            return back()->with('success', 'Producto agregado al carrito');
        } catch (\Exception $e) {
            \Log::error('Error en CartController@add', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Error al agregar producto: ' . $e->getMessage());
        }
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        if ($cartItem->id_usuario !== Auth::id()) {
            return back()->with('error', 'No autorizado');
        }

        if ($cartItem->product->stock < $request->cantidad) {
            return back()->with('error', 'No hay suficiente stock disponible');
        }

        $cartItem->update(['cantidad' => $request->cantidad]);

        return back()->with('success', 'Cantidad actualizada');
    }

    public function remove(CartItem $cartItem)
    {
        if ($cartItem->id_usuario !== Auth::id()) {
            return back()->with('error', 'No autorizado');
        }

        $cartItem->delete();

        return back()->with('success', 'Producto eliminado del carrito');
    }

    public function clear()
    {
        Auth::user()->cartItems()->delete();

        return back()->with('success', 'Carrito vaciado');
    }
}