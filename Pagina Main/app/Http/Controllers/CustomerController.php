<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('clientes.index', compact('customers'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'documento' => 'required|string|max:255|unique:clientes,documento',
            'nombre' => 'required|string|max:255',
            'correo' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:30',
            'direccion' => 'nullable|string|max:500',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Cliente creado exitosamente');
    }

    public function show(Customer $customer)
    {
        return view('clientes.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('clientes.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'documento' => 'required|string|max:255|unique:clientes,documento,' . $customer->id,
            'nombre' => 'required|string|max:255',
            'correo' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:30',
            'direccion' => 'nullable|string|max:500',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Cliente actualizado exitosamente');
    }

    public function destroy(Customer $customer)
    {
        try {
            if ($customer->sales()->count() > 0) {
                return redirect()->route('customers.index')
                    ->with('error', 'No se puede eliminar el cliente porque tiene ventas asociadas. El cliente tiene historial de ventas.');
            }

            $customer->delete();

            return redirect()->route('customers.index')
                ->with('success', 'Cliente eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('customers.index')
                ->with('error', 'Error al eliminar el cliente: ' . $e->getMessage());
        }
    }
}
