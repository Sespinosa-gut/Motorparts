<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->isAdmin()) {
            return redirect()->route('catalog')->with('error', 'No tienes permisos para acceder a esta sección');
        }

        $user = Auth::user();
        
        $productos = Product::all();
        $ordenesPendientes = Order::where('estado', 'pendiente')->count();
        $ventasMes = Order::where('estado', 'verificado')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        return view('dashboard', compact('user', 'productos', 'ordenesPendientes', 'ventasMes'));
    }
}


