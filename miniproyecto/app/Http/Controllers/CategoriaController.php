<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;

use Illuminate\Routing\Controller;

class CategoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categoria::withCount('products')->get();
        return view('categories.index', compact('categories'));
    }

   
    public function create()
    {
        return view('categories.create');
    }

    public function store(StoreCategoriaRequest $request)
    {
        Categoria::create($request->validated());
        return redirect()->route('categories.index')
            ->with('success', 'Categoría creada exitosamente');
    }

    
    public function show(Categoria $categoria)
    {
        $products = $categoria->products()->paginate(12);
        return view('categories.show', compact('category', 'products'));
    }

   
    public function edit(Categoria $categoria)
    {
        return view('categories.edit', compact('category'));
    }

    
    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        $categoria->update($request->validated());
        return redirect()->route('categories.index')
            ->with('success', 'Categoría actualizada exitosamente');
    }

    
    public function destroy(Categoria $categoria)
    {
        if ($categoria->products()->exists()) {
            return redirect()->route('categories.index')
                ->with('error', 'No se puede eliminar una categoría con productos asociados');
        }

        $categoria->delete();
        return redirect()->route('categories.index')
            ->with('success', 'Categoría eliminada exitosamente');
    }
}
