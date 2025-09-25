<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Supplier;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\SaleDetail;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['brand', 'supplier'])->get();
        return view('agregar_producto', compact('products'));
    }

    public function home()
    {
        $productos = Product::with('brand')->get();
        return view('home', compact('productos'));
    }

    public function catalog(Request $request)
    {
        $query = Product::with('brand');
        
        if ($request->filled('search')) {
            $searchTerm = $request->get('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('nombre', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('descripcion', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('brand', function($brandQuery) use ($searchTerm) {
                      $brandQuery->where('nombre', 'LIKE', "%{$searchTerm}%");
                  });
            });
        }
        
        $productos = $query->get();
        $searchTerm = $request->get('search', '');
        
        return view('catalogo', compact('productos', 'searchTerm'));
    }

    public function image(int $id)
    {
        $product = Product::find($id);
        
        if ($product && $product->imagen && !empty($product->imagen)) {
            $imagePath = storage_path('app/public/' . $product->imagen);
            if (file_exists($imagePath)) {
                return response()->file($imagePath);
            }
        }
        
        $defaultImagePath = public_path('img/car-solid-full.svg');
        if (file_exists($defaultImagePath)) {
            return response()->file($defaultImagePath);
        }
        
        return response('Image not found', 404);
    }


    public function create()
    {
        $brands = Brand::all();
        $suppliers = Supplier::all();
        $products = Product::with(['brand', 'supplier'])->get();
        return view('agregar_producto', compact('brands', 'suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_repuesto' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'id_proveedor' => 'nullable|integer|exists:proveedores,id',
            'id_marca' => 'nullable|integer',
            'marca_nueva' => 'nullable|string|max:255',
            'precio' => 'required',
            'imagen' => 'nullable|image'
        ]);

        $precioNumerico = preg_replace('/\D/', '', (string) $validated['precio']);
        $salePrice = $precioNumerico === '' ? 0 : (float) $precioNumerico;

        $brandId = null;
        if ($validated['id_marca'] === 0 && !empty($validated['marca_nueva'])) {
            $brand = Brand::firstOrCreate(['nombre' => $validated['marca_nueva']]);
            $brandId = $brand->id;
        } elseif ($validated['id_marca'] !== 0) {
            $brandId = $validated['id_marca'];
        }

        $supplierId = $validated['id_proveedor'] ?? null;
        if ($supplierId && !Supplier::where('id', $supplierId)->exists()) {
            $supplierId = null;
        }

        $imagePath = null;
        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');
            $imagePath = $image->store('products', 'public');
        }

        Product::create([
            'nombre' => $validated['nombre_repuesto'],
            'descripcion' => $validated['descripcion'] ?? null,
            'precio' => $salePrice,
            'stock' => $validated['stock'],
            'imagen' => $imagePath,
            'id_marca' => $brandId,
            'id_proveedor' => $supplierId,
            'activo' => true,
        ]);

        return back()->with('mensaje', '✅ Producto agregado correctamente');
    }

    public function edit(Product $product)
    {
        $brands = Brand::all();
        $suppliers = Supplier::all();
        $products = Product::with(['brand', 'supplier'])->get();
        return view('agregar_producto', compact('product', 'brands', 'suppliers', 'products'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'nombre_repuesto' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'id_proveedor' => 'nullable|integer|exists:proveedores,id',
            'id_marca' => 'nullable|integer',
            'marca_nueva' => 'nullable|string|max:255',
            'precio' => 'required',
            'imagen' => 'nullable|image'
        ]);

        $precioNumerico = preg_replace('/\D/', '', (string) $validated['precio']);
        $salePrice = $precioNumerico === '' ? 0 : (float) $precioNumerico;

        $brandId = null;
        if ($validated['id_marca'] === 0 && !empty($validated['marca_nueva'])) {
            $brand = Brand::firstOrCreate(['nombre' => $validated['marca_nueva']]);
            $brandId = $brand->id;
        } elseif ($validated['id_marca'] !== 0) {
            $brandId = $validated['id_marca'];
        }

        $supplierId = $validated['id_proveedor'] ?? null;
        if ($supplierId && !Supplier::where('id', $supplierId)->exists()) {
            $supplierId = null;
        }

        $imagePath = $product->imagen;
        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');
            $imagePath = $image->store('products', 'public');
        }

        $product->update([
            'nombre' => $validated['nombre_repuesto'],
            'descripcion' => $validated['descripcion'] ?? null,
            'precio' => $salePrice,
            'stock' => $validated['stock'],
            'imagen' => $imagePath,
            'id_marca' => $brandId,
            'id_proveedor' => $supplierId,
            'activo' => true,
        ]);

        return redirect()->route('products.index')->with('success', 'Producto actualizado correctamente');
    }

    public function destroy(Product $product)
    {
        try {
            if ($product->cartItems()->count() > 0) {
                return redirect()->route('products.index')->with('error', 'No se puede eliminar el producto porque está en carritos de compra. Primero debe ser removido de todos los carritos.');
            }

            if ($product->orderItems()->count() > 0) {
                return redirect()->route('products.index')->with('error', 'No se puede eliminar el producto porque está en órdenes de compra. El producto tiene historial de compras.');
            }

            if ($product->saleDetails()->count() > 0) {
                return redirect()->route('products.index')->with('error', 'No se puede eliminar el producto porque tiene ventas asociadas. El producto tiene historial de ventas.');
            }

            if ($product->inventoryMovements()->count() > 0) {
                return redirect()->route('products.index')->with('error', 'No se puede eliminar el producto porque tiene movimientos de inventario. El producto tiene historial de inventario.');
            }

            $product->delete();
            return redirect()->route('products.index')->with('success', 'Producto eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Error al eliminar el producto: ' . $e->getMessage());
        }
    }

    public function forceDelete(Product $product)
    {
        try {
            $product->cartItems()->delete();
            
            $product->orderItems()->delete();
            
            $product->saleDetails()->delete();
            
            $product->inventoryMovements()->delete();
            
            $product->delete();
            return redirect()->route('products.index')->with('success', 'Producto eliminado completamente (incluyendo elementos de carritos, órdenes, detalles de venta y movimientos de inventario)');
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Error al eliminar el producto: ' . $e->getMessage());
        }
    }
}


