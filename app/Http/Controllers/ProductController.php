<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Tag;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:products|max:255',
            'quantity' => 'required|integer',
            'description' => 'required',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
        ]);

        $product = Product::create($validated);

        return redirect()
            ->route('products.show', [$product]) // vai ['product' => $product]
            ->with('message', "Product created successfully");
    }

    public function show(Product $product) {
<<<<<<< HEAD
   
=======

>>>>>>> new-branch-niks
        return view('products.show', compact('product'));
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()
            ->route('products.index')
            ->with('message', "Product deleted successfully");
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

<<<<<<< HEAD
   public function update(Request $request, Product $product) {
=======
    public function update(Request $request, Product $product)
    {
>>>>>>> new-branch-niks
        $validated = $request->validate([
            'name' => 'required|unique:products|max:255',
            'quantity' => 'required|integer',
            'description' => 'required',
            'tags' => 'nullable|string',
        ]);

        $product->update($validated);
        return redirect()
            ->route('products.show', [$product])
            ->with('message', "Product updated successfully");
    }

    public function decreaseQuantity(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($product->decreaseQuantity($request->amount)) {
            return redirect()
                ->route('products.show', [$product])
                ->with('message', "Product quantity decreased successfully");
        } else {
            return redirect()
                ->route('products.show', [$product])
                ->withErrors(['amount' => 'Not enough stock to decrease quantity.']);
        }
    }

    
public function updateQuantity(Request $request, $id)
{
    $product = Product::findOrFail($id);
    $product->quantity = $request->quantity;
    $product->save();

    return response()->json(['success' => true, 'quantity' => $product->quantity]);
}

}
