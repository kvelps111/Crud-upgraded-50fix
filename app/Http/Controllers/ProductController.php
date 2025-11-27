<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Tag;

class ProductController extends Controller
{
    public function index() {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create() {
        return view('products.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:products,name',
            'quantity' => 'required|integer',
            'description' => 'required',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
        ]);

        $product = Product::create($validated);

        if ($request->has('tags')) {
            $tagIds = [];
            foreach ($request->tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $product->tags()->sync($tagIds);
        }

        return redirect()
            ->route('products.show', $product)
            ->with('message', "Product created successfully");
    }

    public function show(Product $product) {
        $tags = Tag::all();
        return view('products.show', [
            'product' => $product,
            'tags' => $tags,
        ]);
    }

    public function destroy(Product $product) {
        $product->delete();
        return redirect()
            ->route('products.index')
            ->with('message', "Product deleted successfully");
    }

    public function edit(Product $product) {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product) {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:products,name,' . $product->id,
            'quantity' => 'required|integer',
            'description' => 'required',
            'tags' => 'nullable|string',
        ]);

        $product->update($validated);

        $tagNames = $request->input('tags', '');
        $tagIds = [];

        if (!empty($tagNames)) {
            $tagNames = array_filter(explode(',', $tagNames));
            foreach ($tagNames as $name) {
                $tag = Tag::firstOrCreate(['name' => trim($name)]);
                $tagIds[] = $tag->id;
            }
        }

        $product->tags()->sync($tagIds);

        return redirect()
            ->route('products.show', $product)
            ->with('message', "Product updated successfully");
    }

    public function decreaseQuantity(Request $request, Product $product) {
        $request->validate([
            'amount' => 'required|integer|min:1',
        ]);

        if ($product->decreaseQuantity($request->amount)) {
            return redirect()
                ->route('products.show', $product)
                ->with('message', "Product quantity decreased successfully");
        }

        return redirect()
            ->route('products.show', $product)
            ->withErrors(['amount' => 'Not enough stock to decrease quantity.']);
    }

    public function addTag(Request $request, Product $product) {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $tag = Tag::firstOrCreate(['name' => $request->name]);

        $product->tags()->syncWithoutDetaching([$tag->id]);

        return response()->json([
            'tag' => $tag,
            'message' => 'Birka saglabāta!',
        ]);
    }
}
