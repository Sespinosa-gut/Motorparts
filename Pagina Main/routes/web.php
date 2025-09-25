<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;


Route::get('/', [ProductController::class, 'home'])->name('home');
Route::get('/catalogo', [ProductController::class, 'catalog'])->name('catalog');
Route::get('/imagen/{id}', [ProductController::class, 'image'])->name('image');

Route::get('/comprobante/{filename}', function ($filename) {
    $path = storage_path('app/public/comprobantes/' . $filename);
    
    if (!file_exists($path)) {
        abort(404);
    }
    
    return response()->file($path);
})->name('receipt.show');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/registrar', [AuthController::class, 'showRegister'])->name('register');
Route::post('/registrar', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('web')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});



Route::middleware(['auth', 'admin'])->group(function () {

    Route::resource('marcas', BrandController::class)->names('brands')->parameters(['marcas' => 'brand']);


    Route::resource('proveedores', SupplierController::class)->names('suppliers')->parameters(['proveedores' => 'supplier']);


    Route::resource('clientes', CustomerController::class)->names('customers')->parameters(['clientes' => 'customer']);


    Route::resource('metodos-pago', PaymentMethodController::class)->names('payment-methods')->parameters(['metodos-pago' => 'payment-method']);
    Route::patch('/metodos-pago/{payment-method}/toggle', [PaymentMethodController::class, 'toggle'])->name('payment-methods.toggle');


    Route::resource('ventas', SaleController::class)->names('sales')->parameters(['ventas' => 'sale']);
    

    Route::get('/productos', [ProductController::class, 'index'])->name('products.index');
    Route::get('/agregar-producto', [ProductController::class, 'create'])->name('products.create');
    Route::post('/agregar-producto', [ProductController::class, 'store'])->name('products.store');
    Route::get('/productos/{product}/editar', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/productos/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/productos/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::delete('/productos/{product}/forzar', [ProductController::class, 'forceDelete'])->name('products.force-delete');
});


Route::middleware('auth')->group(function () {
    Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
    Route::post('/carrito/agregar', [CartController::class, 'add'])->name('cart.add');
    Route::put('/carrito/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/carrito/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/carrito', [CartController::class, 'clear'])->name('cart.clear');
    
    Route::get('/mis-ordenes', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/ordenes/crear', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/ordenes', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/ordenes/{order}', [OrderController::class, 'show'])->name('orders.show');
    

    Route::middleware('admin')->group(function () {
        Route::get('/admin/ordenes', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
        Route::post('/admin/ordenes/{order}/verificar', [OrderController::class, 'verify'])->name('admin.orders.verify');
    });
});
