<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtiene el usuario autenticado
        $user = Auth::user();

        // Obtiene los productos del usuario autenticado
        $products = Product::where('user_id', $user->id)->paginate(5);

        // dd($products);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'quantity' => 'nullable|integer',
            // 'price' => 'numeric',
        ]);

        $product = new Product($validatedData);
        $product->user_id = auth()->user()->id;
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'quantity' => 'nullable|integer',
            // 'price' => 'numeric',
        ]);

        $product = Product::find($id);
        $product->update($validatedData);

        return redirect()->route('products.index')->with('success', 'product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::withTrashed()->findOrFail($id);

        // Verifica si el producto ya está eliminado suavemente
        if ($product->trashed()) {
            // Si ya está eliminado suavemente, restaura el producto
            $product->restore();
        } else {
            // Si no está eliminado suavemente, marca el producto como eliminado suavemente
            $product->delete();
        }

        return redirect()->route('products.index')->with('success', 'Product action was successful');
    }
}
