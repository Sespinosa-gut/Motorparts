<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('marcas.index', compact('brands'));
    }

    public function create()
    {
        return view('marcas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:marcas,nombre',
        ]);

        Brand::create($validated);

        return redirect()->route('brands.index')
            ->with('success', 'Marca creada exitosamente');
    }

    public function show(Brand $brand)
    {
        return view('marcas.show', compact('brand'));
    }

    public function edit(Brand $brand)
    {
        return view('marcas.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:marcas,nombre,' . $brand->id,
        ]);

        $brand->update($validated);

        return redirect()->route('brands.index')
            ->with('success', 'Marca actualizada exitosamente');
    }

    public function destroy(Brand $brand)
    {
        try {
            if ($brand->products()->count() > 0) {
                return redirect()->route('brands.index')
                    ->with('error', 'No se puede eliminar la marca porque tiene productos asociados');
            }

            $brand->delete();

            return redirect()->route('brands.index')
                ->with('success', 'Marca eliminada exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('brands.index')
                ->with('error', 'Error al eliminar la marca: ' . $e->getMessage());
        }
    }
}
