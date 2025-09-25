<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::all();
        return view('metodos-pago.index', compact('paymentMethods'));
    }

    public function create()
    {
        return view('metodos-pago.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:metodos_pago,nombre',
            'activo' => 'boolean',
        ]);

        $validated['activo'] = $request->has('activo');

        PaymentMethod::create($validated);

        return redirect()->route('payment-methods.index')
            ->with('success', 'Método de pago creado exitosamente');
    }

    public function show(PaymentMethod $paymentMethod)
    {
        return view('metodos-pago.show', compact('paymentMethod'));
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('metodos-pago.edit', compact('paymentMethod'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:metodos_pago,nombre,' . $paymentMethod->id,
            'activo' => 'boolean',
        ]);

        $validated['activo'] = $request->has('activo');

        $paymentMethod->update($validated);

        return redirect()->route('payment-methods.index')
            ->with('success', 'Método de pago actualizado exitosamente');
    }

    public function toggle(PaymentMethod $paymentMethod)
    {
        try {
            $paymentMethod->update([
                'activo' => !$paymentMethod->activo
            ]);

            $status = $paymentMethod->activo ? 'activado' : 'desactivado';
            return redirect()->route('payment-methods.index')
                ->with('success', "Método de pago {$status} exitosamente");
        } catch (\Exception $e) {
            return redirect()->route('payment-methods.index')
                ->with('error', 'Error al cambiar el estado: ' . $e->getMessage());
        }
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        try {
            $ordersCount = $paymentMethod->orders()->count();
            $salesCount = $paymentMethod->sales()->count();
            
            if ($ordersCount > 0 || $salesCount > 0) {
                $message = 'No se puede eliminar el método de pago porque tiene ';
                if ($ordersCount > 0 && $salesCount > 0) {
                    $message .= "órdenes ($ordersCount) y ventas ($salesCount) asociadas";
                } elseif ($ordersCount > 0) {
                    $message .= "órdenes ($ordersCount) asociadas";
                } else {
                    $message .= "ventas ($salesCount) asociadas";
                }
                
                return redirect()->route('payment-methods.index')
                    ->with('error', $message);
            }

            $paymentMethod->delete();

            return redirect()->route('payment-methods.index')
                ->with('success', 'Método de pago eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('payment-methods.index')
                ->with('error', 'Error al eliminar el método de pago: ' . $e->getMessage());
        }
    }
}
